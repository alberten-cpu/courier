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

namespace App\DataTables\Admin\User;

use App\Models\Role;
use App\Models\User;
use Helper;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DriverDataTable extends DataTable
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
            ->editColumn('email', function ($query) {
                return '<a href="mailto:' . $query->email . '">' . $query->email . '</a> ';
            })
            ->editColumn('mobile', function ($query) {
                return '<a href="tel:' . $query->mobile . '">' . $query->mobile . '</a>';
            })
            ->editColumn('driver.driver_id', function ($query) {
                return $query->driver->driver_id;
            })
            ->editColumn('is_active', function ($query) {
                if ($query->is_active) {
                    return '<span class="text-success">Active</span>';
                } else {
                    return '<span class="text-danger">Inactive</span>';
                }
            })
            ->addColumn('action', function ($query) {
                return view(
                    'components.admin.datatable.button',
                    ['edit' => Helper::getRoute('driver.edit', $query->id),
                        'delete' => Helper::getRoute('driver.destroy', $query->id), 'id' => $query->id]
                );
            })
            ->rawColumns(['email', 'mobile', 'is_active', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): \Illuminate\Database\Eloquent\Builder
    {
        return $model->with('driver:user_id,driver_id')->where('role_id', Role::DRIVER)->orderBy('created_at', 'desc');
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
                    'text' => 'New Driver',
                    'className' => 'bg-primary mb-lg-0 mb-3',
                    'action' => 'function( e, dt, button, config){
                         window.location = "' . Helper::getRoute('driver.create') . '";
                     }'
                ],]
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
            'DID' => new Column(
                ['title' => 'DID',
                    'data' => 'driver.driver_id',
                    'name' => 'driver.driver_id',
                    'searchable' => true]
            ),
            'first_name',
            'last_name',
            'email',
            'mobile',
            'status' => new Column(
                ['title' => 'Status',
                    'data' => 'is_active',
                    'name' => 'is_active',
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
        return 'User/Driver_' . date('YmdHis');
    }
}
