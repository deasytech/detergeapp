<?php

namespace App\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class VendorsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;

    public function __construct($start_date, $end_date, $name)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->name = $name;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::join('customers', 'orders.customer_id', '=', 'customers.id')
        ->join('vendors', 'orders.vendor_id', 'vendors.id')
        ->join('service_types', 'orders.service_type_id', 'service_types.id')
        ->whereBetween('actual_service_date', [$this->start_date, $this->end_date])
        ->where('vendor_id','=',$this->name)
        ->select(
            'customers.name as customer_name',
            'vendors.name as technician_name',
            'actual_service_date',
            'periodic_service_date',
            'cost',
            'other_cost',
            'service_types.name as service_type',
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
            'Service Date',
            'Next Service Date',
            'Service Cost',
            'Expenses',
            'Service Type',
            'Payment Status'
        ];
    }
}
