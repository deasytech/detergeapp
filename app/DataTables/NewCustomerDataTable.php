<?php

namespace App\DataTables;

use App\Customer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NewCustomerDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('status', function ($query) {
                return $query->status == 1 ? 'Active' : 'Inactive';
            })
            ->editColumn('customer_type_id', function ($query) {
                return $query->customerType->name;
            })
            ->addColumn('action', function ($query) {
                return '<a href="' . route('customer.show', $query->id) . '" class="btn btn-warning btn-xs" data-toggle="tooltip" title="View"><i class="mdi mdi-eye"></i></a>
                <a href="' . route('customer.edit', $query->id) . '" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>
                <form method="POST" action="' . route('customer.destroy', $query->id) . '" style="display: inline-block;">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <input type="hidden" name="_method" value="DELETE">
                <a href="#" class="btn btn-danger btn-xs" onclick="var c = confirm(\'Are you sure you want to delete this record?\'); if(c == false) return false; else this.parentNode.submit();" class="text-decoration-none p2 display-block on-hover-no-decoration" data-toggle="tooltip" title="Delete" data-toggle="tooltip" title="Delete">
                <i class="mdi mdi-delete"></i>
                </a>
                </form>
                <a href="' . route('order.placement', $query) . '" class="btn btn-dark btn-xs" data-toggle="tooltip" title="Place Order"><i class="mdi mdi-cart"></i></a>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\NewCustomer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Customer $model)
    {
        return $model->select()
        ->with('customerType:id,name')
        ->where('status', '=', 0)
        ->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('excel'),
                Button::make('csv')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')
                ->searchable(false)
                ->title('S/N'),
            Column::make('name'),
            Column::make('telephone'),
            Column::make('email'),
            Column::make('location'),
            Column::make('customer_type_id')
                ->searchable(false)
                ->title('Customer Type'),
            Column::make('status')
                ->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width('12%')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'NewCustomer_' . date('YmdHis');
    }
}
