<?php

namespace App\Http\Livewire;
use Illuminate\Database\Eloquent\Builder;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Attendance;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
class AttendancesTable extends DataTableComponent
{
    protected $model = Attendance::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Attendance::find($id)->delete();
        Flash::success('Attendance deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        ->setFiltersEnabled()
        ->setSingleSortingEnabled()
        ->setHideReorderColumnUnlessReorderingEnabled()
        ->setFilterLayoutSlideDown()
        ->setRememberColumnSelectionDisabled()
        ->setSecondaryHeaderTrAttributes(function($rows) {
            return ['class' => 'bg-gray-200 dark:bg-gray-800'];
        })
        ->setSecondaryHeaderTdAttributes(function(Column $column, $rows) {
            if ($column->isField('name')) {
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
        ->setUseHeaderAsFooterEnabled()
        ->setBulkActionsEnabled();
//        $this->setDebugEnabled();
        $this->setDefaultReorderSort('id', 'desc');
        $this->setReorderEnabled();

        $this->setReorderMethod('changeOrder');    
        $this->setPrimaryKey('id')
        ->setTableRowUrl(function($row) {
            return route('attendances.show', $row);
        });
        
    }
   
    public function columns(): array
    {
        return [
            
            Column::make("S-No", "s_no")
                ->sortable()
                ->searchable()
                ->unclickable()
                
            ->secondaryHeader(function($rows) {
                return 'Total: ' . $rows->count();
                })
                ->format(
                    function($value,$row){
                        if ($value=== null) {
                            static $count = 1;
                            $value = $count;
                            $count++;
                        }
                        return $value;  
                    }
                ),
            Column::make("Name", "name")
                ->sortable()
                ->searchable()
                ->secondaryHeader(function($rows) {
                    return 'Total Employees: ' . $rows->count();
                    })
                ->format(
                    function($value,$row){
                        return $row['employee']['name'];  
                    }
                ),
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

    public function bulkActions(): array
    {
        return [
            'export' => 'Export',
        ];
    }
    
    public function export()
    {
        $users = $this->getSelected();
    
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
