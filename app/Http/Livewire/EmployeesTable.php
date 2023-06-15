<?php

namespace App\Http\Livewire;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\StatusEnum;
use App\Traits\WithDeleteConfirm;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Employee;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;


class EmployeesTable extends DataTableComponent
{

    use AuthorizesRequests;
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
        $this->setPrimaryKey('id')

        ->setSingleSortingDisabled()
        ->setFilterLayoutSlideDown()
        ->setSecondaryHeaderTrAttributes(function($rows) {
            return ['class' => 'bg-gray-100'];
        })
        ->setSecondaryHeaderTdAttributes(function(Column $column, $rows) {
            if ($column->isField('id')) {
                return ['class' => 'text-red-500'];
            }

            return ['default' => true];
        })
        ->setTableRowUrl(function($row) {
            return route('employees.show', $row);
        });
        
        



    }

    public function columns(): array
    {
        return [
            Column::make('id', 'id')
            ->sortable()
            ->searchable()
            ->collapseOnTablet()
            ->unclickable()
            ->format(
                fn( $value, $row, Column $column) => '<span data-id="' . $row->id . '">' . $row->id . '</span>'
            )
            ->html(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable()
                ,
            Column::make("Mobile", "mobile")
                ->sortable()
                ->searchable()
                ->unclickable(),
            Column::make("Role", "role")
                ->sortable()
                ->searchable()
                ->unclickable(),
            Column::make("Image", "image")
                ->sortable()
                ->searchable()
                ->format(
                    fn($value) => view('common.livewire-tables.image')->withValue($value)
                ),
                Column::make('Created At', 'created_at')
                ->sortable(),
           
          
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

   
public function filters(): array
{
    return [
        'start_date' => DateFilter::make('Start Date'),
        'end_date' => DateFilter::make('End Date'),
    ];
}

    public function query()
    {
        $this->authorize('viewAny', Employee::class);

        $query = Employee::query()
                        ->when($this->getFilter('start_date'), fn ($query, $start_date) => $query->where('created_at', '>=', $start_date ." 00:00:00"))
                        ->when($this->getFilter('end_date'), fn ($query, $end_date) => $query->where('created_at', '<=', $end_date ." 23:59:59"));

        return $query;
    }
    
    public function rowView(): string
    {
        return 'livewire.employee.table';
    }
}
