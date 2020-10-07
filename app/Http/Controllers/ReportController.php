<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Exports\InvoiceExport;
use App\Exports\VendorsExport;
use App\Invoice;
use App\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.settings.reports.index');
    }
    
    public function exportInvoice($type,$from,$to)
    {
        $format = $from . '_' . $to . '_' . $type;
        return (new InvoiceExport($type, $from, $to))->download("invoice_$format.xlsx");
    }
    
    public function exportCustomers($from,$to)
    {
        $format = $from . '_' . $to;
        return (new CustomersExport($from, $to))->download("customer_$format.xlsx");
    }
    
    public function exportVendors($from,$to,$name)
    {
        $format = $from . '_' . $to . '_' . $name;
        return (new VendorsExport($from, $to, $name))->download("technician_$format.xlsx");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $results = [];
        if ($request->type == 'invoices_report') {
            $results = Invoice::with(['customer', 'technician'])->where('payment_status','=',$request->payment_status)->whereBetween('invoice_date',[$request->date_start,$request->date_end])->get();
        } 
        if ($request->type == 'customer_order_report') {
            $results = Order::with(['customer', 'vendor', 'service'])->whereBetween('actual_service_date',[$request->date_start,$request->date_end])->get();
        } 
        if ($request->type == 'vendor_report') {
            $results = Order::with(['customer', 'vendor', 'service'])->where('vendor_id','=',$request->technician)->whereBetween('actual_service_date',[$request->date_start,$request->date_end])->get();
        } 
        return view('pages.settings.reports.index', compact('results'));
    }
}
