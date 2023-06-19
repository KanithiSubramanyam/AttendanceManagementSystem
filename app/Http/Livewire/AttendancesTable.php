<?php

namespace App\Http\Livewire;
use App\Models\User;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Illuminate\Database\Eloquent\Builder;
use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Attendance;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class AttendancesTable extends DataTableComponent
{
    protected $model = Attendance::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];
    public $myParam = 'Default';
    public string $tableName = 'users1';
    public array $users1 = [];
    
    public $columnSearch = [
        'name' => null,
        'email' => null,
    ];
    public function deleteRecord($id)
    {
        $attendance = Attendance::find($id);
        $attendance->delete();
        Attendance::where('s_no', '>', $attendance->s_no)
        ->decrement('s_no');
        Attendance::where('sort', '>', $attendance->sort)
        ->decrement('sort');
        Flash::success('Attendance deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setReorderEnabled()
            ->setHideReorderColumnUnlessReorderingEnabled()
            ->setSecondaryHeaderTrAttributes(function($rows) {
                return ['class' => 'bg-gray-100'];
            })
            ->setSecondaryHeaderTdAttributes(function(Column $column, $rows) {
                if ($column->isField('id')) {
                    return ['class' => 'text-red-500'];
                }

                return ['default' => true];
            })
            ->setFooterTrAttributes(function($rows) {
                return ['class' => 'bg-gray-100'];
            })
            ->setFooterTdAttributes(function(Column $column, $rows) {
                if ($column->isField('name')) {
                    return ['class' => 'text-green-500'];
                }

                return ['default' => true];
            })
            ->setHideBulkActionsWhenEmptyEnabled();
        $this->setTableRowUrl(function($row) {
            return route('attendances.show', $row);
        });
        
        $this->setTableRowUrlTarget(function($row) {
            return '_blank';
        });
        $this->setAdditionalSelects(['attendances.id as id']);
        $this->setReorderMethod('changeOrder');

        
    }
   
    public function columns(): array
    {
        return [
            Column::make('Order', 'sort')
                ->sortable()
                ->unclickable()
                ->collapseOnMobile()
                ->excludeFromColumnSelect(),
            Column::make("S-No", "s_no")
                ->sortable()
                ->searchable()
                ->unclickable()
                ,
            Column::make("Name", "name")
                ->sortable()
                ->searchable()
                
                ->format(
                    function($value,$row){
                        return $row['employee']['name'];  
                    }
                    )
                    ->secondaryHeader(function() {
                        return view('tables.cells.input-search', ['field' => 'name', 'columnSearch' => $this->columnSearch]);
                    })
                    ->footer(function($rows) {
                        return '<strong>Name Footer</strong>';
                    })
                    ->html(),
                
            Column::make("Attendance", "attendance")
                ->sortable()
                ->searchable()
                ->format(
                    function($value,$row){
                        return $row->attendance;  
                    }
                )
                ->unclickable(),
           
            Column::make("Date", "date")
                ->sortable()
                ->searchable()
                ->unclickable()
                ->format(
                    function($value,$row){
                        return date('d/m/Y',strtotime( $value));
                    }
                ),
            Column::make("Actions", 'id')
            ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('attendances.show', $row->id),
                        'editUrl' => route('attendances.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                    )
                    ->unclickable()
        ];
    }
    
    public function filters(): array
    {
        return [

            SelectFilter::make("Attendance", "attendance")
                ->options([
                    '' => 'All',
                    'present' => 'Present',
                    'absent' => 'Absent',
                ])
                ->filter(function(Builder $builder, string $value) {
                    
                    if ($value === 'present') {
                        $builder->where('attendance', 'present');
                    } elseif ($value === 'absent') {
                        $builder->where('attendance', 'absent');
                    }
    }),
    DateFilter::make('Edit From')
    ->config([
        'min' => '2020-01-01',
        'max' => '2050-12-31',
    ])
    ->filter(function(Builder $builder, string $value) {
        $builder->where('date', '>=', $value);
    }),
    DateFilter::make('Edit To')
    ->config([
        'min' => '2020-01-01',
        'max' => '2050-12-31',
    ])
    ->filter(function(Builder $builder, string $value) {
        $builder->where('date', '<=', $value);
    }),
        ];
    }

    public function builder(): Builder
    {
        return Attendance::query()
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('attendances.name', 'like', '%' . $name . '%'));
    }
    public function bulkActions(): array
    {
        return [
            'export' => 'Export',
        ];
    }
    
    public function export()
    {
        $attendance = $this->getSelected();
    
        $this->clearSelected();
        return Excel::download(new UsersExport, 'Attendance.csv', \Maatwebsite\Excel\Excel::XLSX);

    }
    public function reorder($items): void
    {
        foreach ($items as $item) {
            Attendance::find((int)$item['value'])->update(['sort' => (int)$item['order']]);
        }
    }
    
    
}
