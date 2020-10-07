<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class InvoiceExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;

    public function __construct($type, $start_date, $end_date)
    {
        $this->type = $type;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        return Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->join('vendors', 'invoices.vendor_id', 'vendors.id')
            ->whereBetween('invoice_date', [$this->start_date, $this->end_date])
            ->where('payment_status', $this->type)
            ->select(
                'customers.name as customer_name',
                'vendors.name as technician_name',
                'invoice_date',
                'due_date',
                'grand_total',
                'payment_status'
            )
            ->get();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }

    public function headings(): array
    {
        return [
            'Customer Name',
            'Technician Name',
            'Invoice Date',
            'Invoice Due Date',
            'Service Cost',
            'Payment Status'
        ];
    }
}
