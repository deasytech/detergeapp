<?php

namespace App\DataTables;

use App\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
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
            ->editColumn('vendor_id', function ($query) {
                return $query->vendor->name;
            })
            ->editColumn('customer_id', function ($query) {
                return $query->customer->name;
            })
            ->editColumn('telephone', function ($query) {
                return $query->customer->telephone;
            })
            ->editColumn('service_day', function ($query) {
                return ucfirst($query->service_day);
            })
            ->editColumn('status', function ($query) {
                return $query->status == 1 ? 'Active' : 'Inactive';
            })
            ->editColumn('cost', function ($query) {
                return presentPrice($query->cost);
            })
            ->editColumn('other_cost', function ($query) {
                return presentPrice($query->other_cost);
            })
            ->addColumn('action', function ($query) {
                return '<a href="' . route('order.show', $query->id) . '" class="btn btn-warning btn-xs" data-toggle="tooltip" title="View"><i class="mdi mdi-eye"></i></a>
                <a href="' . route('order.edit', $query->id) . '" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>
                <form method="POST" action="' . route('order.destroy', $query->id) . '" style="display: inline-block;">
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
     * @param \App\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        return $model->select()
            ->with(['customer', 'vendor', 'periodicServiceCategory'])
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
            ->setTableId('order-table')
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
            Column::make('DT_RowIndex')
                ->searchable(false)
                ->title('S/N'),
            Column::make('customer_id')
                ->searchable(false)
                ->title('Customer Name'),
            Column::make('telephone')
                ->searchable(false),
            Column::make('service_location'),
            Column::make('vendor_id'),
            Column::make('actual_service_date')
                ->title('Service Date'),
            Column::make('periodic_service_date')
                ->title('Next Service Date'),
            Column::make('cost'),
            Column::make('other_cost')->title('Expenses'),
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
        return 'Order_' . date('YmdHis');
    }
}
