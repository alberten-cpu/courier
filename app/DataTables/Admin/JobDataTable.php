<?php

namespace App\DataTables\Admin;

use App\Models\Job;
use Helper;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

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
            ->addColumn('#', function () {
                return '<input type="checkbox" name="job_no" class="form-control">';
            })
            ->addColumn('daily_job_number', function ($query) {
                return $query->dailyJob->job_number;
            })
            ->editColumn('user_id', function ($query) {
                return $query->user->customer->company_name . ', ' . $query->user->customer->customer_id . ' - ' . $query->user->name;
            })
            ->editColumn('from_area_id', function ($query) {
                return $query->fromArea->area;
            })
            ->editColumn('to_area_id', function ($query) {
                return $query->toArea->area;
            })
            ->editColumn('van_hire', function ($query) {
                if ($query->van_hire) {
                    return '<span class="text-success">Yes</span>';
                } else {
                    return '<span class="text-danger">No</span>';
                }
            })
            ->editColumn('status_id', function ($query) {
                return $query->status->status;
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->diffForHumans();
            })
            ->editColumn('creator.name', function ($query) {
                return $query->creator->name;
            })
            ->editColumn('updated_at', function ($query) {
                return $query->updated_at->diffForHumans();
            })
            ->editColumn('editor.name', function ($query) {
                return $query->editor->name;
            })
            ->addColumn('action', function ($query) {
                return view(
                    'components.admin.datatable.button',
                    ['edit' => Helper::getRoute('job.edit', $query->id),
                        'delete' => Helper::getRoute('job.destroy', $query->id), 'id' => $query->id,
                        'assign' => Helper::getRoute('job.destroy', $query->id), 'id' => $query->id]
                );
            })
            ->rawColumns(['#', 'van_hire', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Job $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Job $model)
    {
        return $model->with('user:name,id', 'user.customer:company_name,id,user_id,customer_id', 'fromArea:area,id', 'toArea:area,id', 'timeFrame:time_frame,id', 'status:status,id', 'creator:name,id', 'editor:name,id', 'dailyJob:job_number,id,job_id')->select('*')->orderBy('jobs.created_at', 'desc');
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
            ->dom('Bfrtip')
            ->orderBy(1)
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['excel', 'csv', 'pdf', 'print', [
                    'text' => 'New Job',
                    'className' => 'bg-primary mb-lg-0 mb-3',
                    'action' => 'function( e, dt, button, config){
                         window.location = "' . Helper::getRoute('job.create') . '";
                     }'
                ], [
                    'text' => 'Mass Assign',
                    'className' => 'bg-success mb-lg-0 mb-3 disabled',
                    'action' => '#'
                ], [
                    'text' => 'Notify Drivers',
                    'className' => 'bg-info mb-lg-0 mb-3',
                    'action' => '#'
                ]]
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
            '#',
            'job_increment_id',
            'daily_job_number',
            'user_id' => new Column(
                ['title' => 'Customer',
                    'data' => 'user_id',
                    'name' => 'user_id',
                    'searchable' => true]
            ),
            'from_area_id' => new Column(
                ['title' => 'From',
                    'data' => 'from_area_id',
                    'name' => 'from_area_id',
                    'searchable' => true]
            ),
            'to_area_id' => new Column(
                ['title' => 'To',
                    'data' => 'to_area_id',
                    'name' => 'to_area_id',
                    'searchable' => true]
            ),
            'van_hire',
            'number_box',
            'status_id' => new Column(
                ['title' => 'Status',
                    'data' => 'status_id',
                    'name' => 'status_id',
                    'searchable' => true]
            ),
            'created_at',
            'created_by' => new Column(
                ['title' => 'Created By',
                    'data' => 'creator.name',
                    'name' => 'creator.name',
                    'searchable' => false]
            ),
            'updated_at',
            'updated_by' => new Column(
                ['title' => 'Updated By',
                    'data' => 'editor.name',
                    'name' => 'editor.name',
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
        return 'Admin/Job_' . date('YmdHis');
    }
}
