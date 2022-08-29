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

namespace App\DataTables\Customer;

use App\Models\AddressBook;
use Helper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AddressBookDataTable extends DataTable
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
            ->editColumn('set_as_default', function ($query) {
                if ($query->set_as_default) {
                    return '<span class="text-success">Default</span>';
                } else {
                    return '<span class="text-info"></span>';
                }
            })
            ->editColumn('status', function ($query) {
                if ($query->status) {
                    return '<span class="text-success">Active</span>';
                } else {
                    return '<span class="text-danger">Inactive</span>';
                }
            })
            ->addColumn('action', function ($query) {
                return view(
                    'components.admin.datatable.button',
                    ['edit' => Helper::getRoute('address_book.edit', $query->id),
                        'delete' => Helper::getRoute('address_book.destroy', $query->id), 'id' => $query->id]
                );
            })
            ->rawColumns(['set_as_default', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param AddressBook $model
     * @return Builder
     */
    public function query(AddressBook $model): Builder
    {
        return $model->select('*')->where('user_id', Auth::id())->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): \Yajra\DataTables\Html\Builder
    {
        return $this->builder()
            ->setTableId('id')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive()
            ->orderBy(1)
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => [[
                    'text' => 'New Address',
                    'className' => 'bg-primary mb-lg-0 mb-3',
                    'action' => 'function( e, dt, button, config){
                         window.location = "' . Helper::getRoute('address_book.create') . '";
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
            'company_name',
            'street_address',
            'street_address',
            'street_number',
            'suburb',
            'city',
            'state',
            'zip',
            'country',
            'set_as_default' => new Column(
                ['title' => 'Default',
                    'data' => 'set_as_default',
                    'name' => 'set_as_default',
                    'searchable' => true]
            ),
            'status' => new Column(
                ['title' => 'Status',
                    'data' => 'status',
                    'name' => 'status',
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
        return 'Customer/AddressBook_' . date('YmdHis');
    }
}
