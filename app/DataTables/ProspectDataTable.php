<?php

namespace App\DataTables;

use App\Prospect;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProspectDataTable extends DataTable
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
            ->addColumn('action', function ($query) {
                return '<a href="#" class="btn btn-primary btn-xs" data-id="' . $query->id . '" data-toggle="modal" data-target="#feedback" title="Update Feedback"><i class="mdi mdi-comment-alert"></i></a>
                <a href="' . route('prospect.show', $query->id) . '" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="View"><i class="mdi mdi-eye"></i></a>
                <a href="' . route('prospect.edit', $query->id) . '" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>
                <form method="POST" action="' . route('prospect.destroy', $query->id) . '" style="display: inline-block;">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <input type="hidden" name="_method" value="DELETE">
                <a href="#" class="btn btn-danger btn-xs" onclick="var c = confirm(\'Are you sure you want to delete this record?\'); if(c == false) return false; else this.parentNode.submit();" class="text-decoration-none p2 display-block on-hover-no-decoration" data-toggle="tooltip" title="Delete" data-toggle="tooltip" title="Delete">
                <i class="mdi mdi-delete"></i>
                </a>
                </form>
                <a href="' . route('prospect.confirmed', $query) . '" class="btn btn-success btn-xs" data-toggle="tooltip" title="Verified Customer"><i class="mdi mdi-account-check"></i></a>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Prospect $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Prospect $model)
    {
        return $model->select()
            ->with('notes')
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
            ->setTableId('prospect-table')
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
            Column::make('organisation'),
            Column::make('nature_of_business'),
            Column::make('contact_phone_number')
                ->title('Telephone'),
            Column::make('contact_email')
                ->title('Email'),
            Column::make('physical_address')
                ->title('Address'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width('15%')
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
        return 'Prospect_' . date('YmdHis');
    }
}
