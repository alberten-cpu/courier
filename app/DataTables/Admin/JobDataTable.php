<?php

/**
 * PHP Version 7.4.25
 * Laravel Framework 8.83.18
 *
 * @category DataTable
 *
 * @package Laravel
 *
 * @author CWSPS154 <codewithsps154@gmail.com>
 *
 * @license MIT License https://opensource.org/licenses/MIT
 *
 * @link https://github.com/CWSPS154
 *
 * Date 28/08/22
 * */

namespace App\DataTables\Admin;

use App\Models\Job;
use App\Models\JobAssign;
use App\Models\JobStatus;
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
    public function dataTable($query): DataTableAbstract
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('#', function ($query) {
                if ($query->status_id == JobStatus::ORDER_PLACED || $query->status_id == JobStatus::DELIVERY_REJECTED) {
                    return '<input type="checkbox" name="job_no" class="form-control mass-assign-checkbox" value="' . $query->id . '">';
                } else {
                    return '<input type="checkbox" name="job_no" class="form-control mass-assign-checkbox" value="' . $query->id . '" disabled>';
                }
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
            ->addColumn('assigned_to', function ($query) {
                if (isset($query->jobAssign->status)) {
                    if ($query->jobAssign->status == JobAssign::ASSIGNED) {
                        return '<span class="text-info">' . $query->jobAssign->user->name . '</span>';
                    } elseif ($query->jobAssign->status == JobAssign::NOT_ASSIGNED) {
                        return '<span class="text-secondary">' . $query->jobAssign->user->name . '</span>';
                    } elseif ($query->jobAssign->status == JobAssign::JOB_ACCEPTED) {
                        return '<span class="text-success">' . $query->jobAssign->user->name . '</span>';
                    } else {
                        return '<span class="text-danger">' . $query->jobAssign->user->name . '</span>';
                    }
                } else {
                    return '<span class="text-warning">Not Assigned</span>';
                }
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
                if ($query->status_id == JobStatus::ORDER_PLACED || $query->status_id == JobStatus::DELIVERY_REJECTED) {
                    return view(
                        'components.admin.datatable.button',
                        ['edit' => Helper::getRoute('job.edit', $query->id),
                            'delete' => Helper::getRoute('job.destroy', $query->id), 'id' => $query->id,
                            'assign' => Helper::getRoute('job.destroy', $query->id), 'id' => $query->id]
                    );
                } else {
                    return view(
                        'components.admin.datatable.button',
                        ['edit' => Helper::getRoute('job.edit', $query->id),
                            'delete' => Helper::getRoute('job.destroy', $query->id), 'id' => $query->id]
                    );
                }
            })
            ->rawColumns(['#', 'assigned_to', 'van_hire', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Job $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Job $model): \Illuminate\Database\Eloquent\Builder
    {
        return $model->with('user:name,id', 'user.customer:company_name,id,user_id,customer_id', 'fromArea:area,id', 'toArea:area,id', 'timeFrame:time_frame,id', 'status:status,id', 'creator:name,id', 'editor:name,id', 'dailyJob:job_number,id,job_id', 'jobAssign:job_id,user_id,id,status', 'jobAssign.user:name,id')
            ->select('*')->orderBy('jobs.created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html(): Builder
    {
        return $this->builder()
            ->setTableId('id')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive()
            ->orderBy(1)
            ->pagingType('numbers')
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
                    'className' => 'bg-success mb-lg-0 mb-3 disabled mass-assign'
                ], [
                    'text' => 'Notify Drivers',
                    'className' => 'bg-info mb-lg-0 mb-3',
                    'action' => 'function( e, dt, button, config){
                         window.location = "' . Helper::getRoute('job.show', 'notify') . '";
                     }'
                ]]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            '#',
            'job_increment_id' => new Column(
                ['title' => 'Increment ID',
                    'data' => 'job_increment_id',
                    'name' => 'job_increment_id',
                    'searchable' => true]
            ),
            'daily_job_number' => new Column(
                ['title' => 'Job Number',
                    'data' => 'daily_job_number',
                    'name' => 'dailyJob.job_number',
                    'searchable' => true]
            ),
            'user_id' => new Column(
                ['title' => 'Customer',
                    'data' => 'user_id',
                    'name' => 'user.name',
                    'searchable' => true]
            ),
            'from_area_id' => new Column(
                ['title' => 'From',
                    'data' => 'from_area_id',
                    'name' => 'fromArea.area',
                    'searchable' => true]
            ),
            'to_area_id' => new Column(
                ['title' => 'To',
                    'data' => 'to_area_id',
                    'name' => 'toArea.area',
                    'searchable' => true]
            ),
            'van_hire',
            'number_box',
            'status_id' => new Column(
                ['title' => 'Status',
                    'data' => 'status_id',
                    'name' => 'status.status',
                    'searchable' => true]
            ),
            'assigned_to' => new Column(
                ['title' => 'Assigned To',
                    'data' => 'assigned_to',
                    'name' => 'jobAssign.user.name',
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
    protected function filename(): string
    {
        return 'Admin/Job_' . date('YmdHis');
    }
}
