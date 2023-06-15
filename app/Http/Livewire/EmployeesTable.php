<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Employee;

class EmployeesTable extends DataTableComponent
{
    protected $model = Employee::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Employee::find($id)->delete();
        Flash::success('Employee deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Mobile", "mobile")
                ->sortable()
                ->searchable(),
            Column::make("Role", "role")
                ->sortable()
                ->searchable(),
            Column::make("Image", "image")
                ->sortable()
                ->searchable()
                ->format(
                    fn($value) => view('common.livewire-tables.image')->withValue($value)
                ),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('employees.show', $row->id),
                        'editUrl' => route('employees.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}
