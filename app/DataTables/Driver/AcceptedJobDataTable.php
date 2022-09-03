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

namespace App\DataTables\Driver;

use App\Models\Job;
use App\Models\JobAssign;
use Helper;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Auth;

class AcceptedJobDataTable extends DataTable
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
            ->editColumn('user.id', function ($query) {
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
            ->editColumn('status', function ($query) {
                return $query->status->status;
            })
            ->addColumn('action', function ($query) {
                return view(
                    'components.admin.datatable.view_button',
                    ['view' => Helper::getRoute('myjob.show', $query->id)]
                );
            })
            ->rawColumns(['van_hire', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Job $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Job $model): \Illuminate\Database\Eloquent\Builder
    {
        return $model->with('user:name,id', 'fromArea:area,id', 'toArea:area,id', 'timeFrame:time_frame,id', 'status:status,id')
            ->whereHas('jobAssign', function ($q) {
                $q->where('user_id', Auth::id())->where('status', JobAssign::JOB_ACCEPTED);
            })->select('jobs.*')->orderBy('jobs.created_at', 'desc');
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
            ->searching(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            'job_increment_id' => new Column(
                ['title' => 'Increment ID',
                    'data' => 'job_increment_id',
                    'name' => 'job_increment_id',
                    'searchable' => true]
            ),
            'user_id' => new Column(
                ['title' => 'Customer',
                    'data' => 'user.id',
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
                    'data' => 'status',
                    'name' => 'status.status',
                    'searchable' => true]
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
        return 'Driver/AcceptedJob__' . date('YmdHis');
    }
}
