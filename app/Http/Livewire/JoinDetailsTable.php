<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\JoinDetail;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
class JoinDetailsTable extends DataTableComponent
{
    protected $model = JoinDetail::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        JoinDetail::find($id)->delete();
        Flash::success('Join Detail deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        ->setTableRowUrl(function($row) {
            return route('employees.show', $row);
        });
    }

    public function columns(): array
    {
        return [
            Column::make("S-No", "id")
            ->sortable()
            ->searchable()
            ->unclickable()
            ->format(
                function($value,$row){
                    static $count = 0;
                    $count++;
                    return $count;
                }
            ),
            Column::make("Employee Name", "employee_id")
                ->sortable()
                ->searchable()
                ->format(
                    function($value,$row){
                        return $row['employee']['name'];  
                    }
                ),
            Column::make("Join Date", "join_date")
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
                        'showUrl' => route('joinDetails.show', $row->id),
                        'editUrl' => route('joinDetails.edit', $row->id),
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
            $this->authorize('viewAny', JoinDetail::class);
    
            $query = JoinDetail::query()
                            ->when($this->getFilter('start_date'), fn ($query, $start_date) => $query->where('created_at', '>=', $start_date ." 00:00:00"))
                            ->when($this->getFilter('end_date'), fn ($query, $end_date) => $query->where('created_at', '<=', $end_date ." 23:59:59"));
    
            return $query;
        }
        
        public function rowView(): string
        {
            return 'livewire.JoinDetail.table';
        }
    }
