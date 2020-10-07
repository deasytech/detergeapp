<?php

namespace App\DataTables;

use App\Invoice;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvoiceDataTable extends DataTable
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
            ->editColumn('grand_total', function ($query) {
                return presentPrice($query->grand_total);
            })
            ->editColumn('customer_id', function ($query) {
                return $query->customer->name;
            })
            ->editColumn('vendor_id', function ($query) {
                return $query->technician->name;
            })
            ->editColumn('payment_status', function ($query) {
                if ($query->payment_status == 'transfer') {
                    $transfer = 'Bank ' . $query->payment_status;
                    return ucwords($transfer);
                }
                if ($query->payment_status == 'online') {
                    $online = $query->payment_status . ' Payment';
                    return ucwords($online);
                }
                if ($query->payment_status == 'paid') {
                    $paid = $query->payment_status . ' Cash';
                    return ucwords($paid);
                }
                return ucwords($query->payment_status);
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->diffForHumans();
            })
            ->addColumn('action', function ($query) {
                return '<a href="' . route('account.show', $query->id) . '" class="btn btn-warning btn-xs" data-toggle="tooltip" title="View"><i class="mdi mdi-eye"></i></a>
                <a href="' . route('account.edit', $query) . '" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>
                <a href="#" data-id="' . $query->id . '" data-status="' . $query->payment_status . '" class="btn btn-dark btn-xs" data-toggle="modal" data-target="#pay" title="Pay"><i class="mdi mdi-cash"></i></a>
                <form method="POST" action="' . route('account.destroy', $query) . '" style="display: inline-block;">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <input type="hidden" name="_method" value="DELETE">
                <a href="#" class="btn btn-danger btn-xs" onclick="var c = confirm(\'Are you sure you want to delete this record?\'); if(c == false) return false; else this.parentNode.submit();" class="text-decoration-none p2 display-block on-hover-no-decoration" data-toggle="tooltip" title="Delete" data-toggle="tooltip" title="Delete">
                <i class="mdi mdi-delete"></i>
                </a>
                </form>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Invoice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Invoice $model)
    {
        return $model->select()
            ->with(['services', 'customer', 'technician'])
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
            ->setTableId('invoice-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create')->addClass('bg-success text-light'),
                Button::make('excel'),
                Button::make('csv'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
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
            Column::make('invoice_no'),
            Column::make('grand_total')
                ->title('Service Cost'),
            Column::make('customer_id')
                ->title('Customer Name'),
            Column::make('vendor_id')
                ->title('Technician'),
            Column::make('due_date')
                ->title('Invoice Due Date'),
            Column::make('payment_status'),
            Column::make('created_at'),
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
        return 'Invoice_' . date('YmdHis');
    }
}
