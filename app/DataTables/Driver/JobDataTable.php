<?php

namespace App\DataTables\Driver;

use App\Models\Job;
use Helper;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Auth;

class JobDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('user.id', function ($query) {
                return $query->user->name;
            })
            ->editColumn('from_area', function ($query) {
                return $query->fromArea->area;
            })
            ->editColumn('to_area', function ($query) {
                return $query->toArea->area;
            })
            ->editColumn('time_frame', function ($query) {
                return $query->timeFrame->time_frame;
            })
            ->editColumn('van_hire', function ($query) {
                if ($query->van_hire) {
                    return '<span class="text-success">Yes</span>';
                } else {
                    return '<span class="text-danger">No</span>';
                }
            })
            ->editColumn('status', function ($query) {
                return $query->status->status;
            })
            ->addColumn('action', function ($query) {
                return view(
                    'components.admin.datatable.accept_reject_button',
                    ['accept' => Helper::getRoute('myjob.edit', $query->id),
                        'reject' => Helper::getRoute('myjob.destroy', $query->id), 'id' => $query->id]
                );
            })
            ->rawColumns(['van_hire', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Job $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Job $model)
    {
        return $model->with('user:name,id', 'fromArea:area,id', 'toArea:area,id', 'timeFrame:time_frame,id')->whereHas('jobAssign', function ($q) {
            $q->where('user_id', Auth::id())->where('status', false);
        })->select('jobs.*')->orderBy('jobs.created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('id')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->searching(false)
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => [[
                    'text' => 'Accepted Jobs',
                    'className' => 'bg-primary mb-lg-0 mb-3',
                    'action' => 'function( e, dt, button, config){
                         window.location = "' . Helper::getRoute('myjob.create') . '";
                     }'
                ],]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'job_increment_id',
            'user_id' => new Column(
                ['title' => 'Customer',
                    'data' => 'user.id',
                    'name' => 'user.id',
                    'searchable' => false]
            ),
            'from_area_id' => new Column(
                ['title' => 'From Area',
                    'data' => 'from_area',
                    'name' => 'from_area',
                    'searchable' => false]
            ),
            'to_area_id' => new Column(
                ['title' => 'To Area',
                    'data' => 'to_area',
                    'name' => 'to_area',
                    'searchable' => false]
            ),
            'timeframe_id' => new Column(
                ['title' => 'Time Frame',
                    'data' => 'time_frame',
                    'name' => 'time_frame',
                    'searchable' => false]
            ),
            'van_hire',
            'number_box',
            'status_id' => new Column(
                ['title' => 'Status',
                    'data' => 'status',
                    'name' => 'status',
                    'searchable' => false]
            ),
            'action'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Driver/Job_' . date('YmdHis');
    }
}
