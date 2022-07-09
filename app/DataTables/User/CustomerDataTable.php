<?php

namespace App\DataTables\User;

use App\Models\Role;
use App\Models\User;
use Helper;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
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
            ->editColumn('customer_id', function ($query) {
                return $query->customer->customer_id;
            })
            ->addColumn('action', function ($query) {
                return view(
                    'components.admin.datatable.button',
                    ['edit' => Helper::getRoute('customer.edit', $query->id),
                        'delete' => Helper::getRoute('customer.destroy', $query->id), 'id' => $query->id]
                );
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->with('customer')->where('role_id', Role::CUSTOMER);
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
            ->responsive()
            ->orderBy(1)
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['excel', 'csv', 'pdf', 'print', [
                    'text' => 'New Customer',
                    'className' => 'mb-lg-0 mb-3',
                    'action' => 'function( e, dt, button, config){
                         window.location = "/user/customer/create";
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
            ['name' => 'customer_id', 'title' => 'CID', 'data' => 'customer.customer_id'],
            'first_name',
            'last_name',
            'email',
            'mobile',
            'action'
        ];
    }

    public function myCustomAction()
    {
        //...your code here.
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User/Customer_' . date('YmdHis');
    }
}
