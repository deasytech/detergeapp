<?php

namespace App\DataTables;

use App\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorOrderDataTable extends DataTable
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
            ->editColumn('vendor_id', function ($order) {
                return $order->vendor->name;
            })
            ->editColumn('customer_id', function ($order) {
                return $order->customer->name;
            })
            ->editColumn('telephone', function ($order) {
                return $order->customer->telephone;
            })
            ->editColumn('service_type_id', function ($order) {
                return $order->service->name;
            })
            ->editColumn('status', function ($order) {
                return ucfirst($order->status);
            })
            ->addColumn('action', function ($order) {
                return '<a href="#" class="btn btn-warning btn-xs" data-id="' . $order->id . '" data-status="' . $order->status . '" data-toggle="modal" data-target="#changeStatus"><i class="mdi mdi-eye"></i></a>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        return $model->select()
            ->with(['customer', 'vendor', 'service'])
            ->where('vendor_id', '=', auth()->user()->id)
            ->orderBy('actual_service_date', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('order-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('excel'),
                Button::make('csv'),
                Button::make('print'),
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
            Column::make('vendor_id')
                ->searchable(false)
                ->title('Vendor'),
            Column::make('customer_id')
                ->searchable(false)
                ->title('Customer Name'),
            Column::make('telephone'),
            Column::make('service_location'),
            Column::make('service_type_id'),
            Column::make('actual_service_date')
                ->title('Service Date'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
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
        return 'VendorOrder_' . date('YmdHis');
    }
}
