<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceService;
use App\{Customer, Vendor};
use Illuminate\Http\Request;
use Validator;
use yajra\Datatables\Datatables;
use App\DataTables\InvoiceDataTable;
use App\DataTables\DueInvoiceDataTable;

class InvoiceController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(InvoiceDataTable $dataTable)
  {
    return $dataTable->render('pages.accounts.index');
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('pages.accounts.create');
  }

  public function overdue(DueInvoiceDataTable $dataTable)
  {
    return $dataTable->render('pages.accounts.overdue');
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $request['discount'] = $request->discount == "" ? 0 : $request->discount;
    $request['invoice_no'] = str_replace(' ', '', $request->invoice_no);
    $messageStatus = messagingStatus();
    $this->validate($request, [
      'invoice_no' => 'required|alpha_dash|unique:invoices',
      'customer_id' => 'required',
      'vendor_id' => 'required',
      'address' => 'required|max:255',
      'title' => 'required|max:255',
      'invoice_date' => 'required|date_format:Y-m-d',
      'due_date' => 'required|date_format:Y-m-d',
      'discount' => 'required|numeric|min:0',
    ]);
    $customer = Customer::findOrFail($request->customer_id);
    $vendor = Vendor::findOrFail($request->vendor_id);

    if(count($request->service_type_id) == 0) {
      session()->flash('warning', 'One or more Service is required.');
      return redirect()->back()->withInput();
    }

    $data = $request->all();
    $data['sub_total'] = (float)$request->sub_total;
    $data['discount'] = (float)$request->discount;
    $data['grand_total'] = $request->sub_total - $request->discount;

    $invoice = Invoice::create($data);

    for ($i=0; $i < count($request->service_type_id); $i++) {
      $invoiceServ = new InvoiceService();
      $invoiceServ->invoice_id = $invoice->id;
      $invoiceServ->service_type_id = $request->service_type_id[$i];
      $invoiceServ->quantity = $request->quantity[$i];
      $invoiceServ->price = $request->price[$i];
      $invoiceServ->total = $request->quantity[$i] * $request->price[$i];
      $invoiceServ->save();
    }

    if ($messageStatus->value == 1) {
      if ($request->customer_id) {
        $total = presentPrice($data['grand_total']);
        $date = presentDate($request->invoice_date);
        $message = "Your service from Deterge is scheduled for {$date} with invoice #{$request->invoice_no}, {$total} to be paid to GTB: Deterge Nigeria Limited - 0115931331.";
        sendMessage($message, $customer->telephone);
      }
      if ($request->vendor_id) {
        $total = presentPrice($data['grand_total']);
        $date = presentDate($request->invoice_date);
        $message = "You've got a service from Deterge, scheduled for {$date} with invoice #{$request->invoice_no}, {$total} Customer mobile: $customer->telephone.";
        sendMessage($message, $vendor->telephone);
      }
    }

    session()->flash('success', 'Invoice generated successfully!');
    return redirect()->route('account.index');
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Invoice  $invoice
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $invoice = Invoice::findOrFail($id);
    $last_serviced_cost = Invoice::where([['customer_id','=',$invoice->customer_id],['invoice_date','<',$invoice->invoice_date]])->orderBy('invoice_date', 'desc')->first();
    return view('pages.accounts.show', compact('invoice','last_serviced_cost'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Invoice  $invoice
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $invoice = Invoice::with('services')->findOrFail($id);
    return view('pages.accounts.edit', compact('invoice'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Invoice  $invoice
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    $request['service_type_id'] = array_filter($request->service_type_id);
    $request['price'] = array_filter($request->price);
    $request['quantity'] = array_filter($request->quantity);
    $this->validate($request, [
      'invoice_no' => 'required|alpha_dash|unique:invoices,invoice_no,'.$id.',id',
      'customer_id' => 'required',
      'vendor_id' => 'required',
      'address' => 'required|max:255',
      'title' => 'required|max:255',
      'invoice_date' => 'required|date_format:Y-m-d',
      'due_date' => 'required|date_format:Y-m-d',
      'discount' => 'required|numeric|min:0'
    ]);

    if(count($request->service_type_id) == 0) {
      session()->flash('warning', 'One or more Service is required.');
      return redirect()->back()->withInput();
    }

    $invoice = Invoice::findOrFail($id);

    $data = $request->all();
    $data['sub_total'] = (float)$request->sub_total;
    $data['discount'] = (float)$request->discount;
    $data['grand_total'] = $request->sub_total - $request->discount;

    $invoice->update($data);

    InvoiceService::where('invoice_id', $invoice->id)->delete();

    for ($i=0; $i < count($request->service_type_id); $i++) {
      $invoiceServ = new InvoiceService();
      $invoiceServ->invoice_id = $invoice->id;
      $invoiceServ->service_type_id = $request->service_type_id[$i];
      $invoiceServ->quantity = $request->quantity[$i];
      $invoiceServ->price = $request->price[$i];
      $invoiceServ->total = $request->quantity[$i] * $request->price[$i];
      $invoiceServ->save();
    }

    session()->flash('success', 'Invoice updated successfully!');
    return redirect()->route('account.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Invoice  $invoice
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $invoice = Invoice::findOrFail($id);

    InvoiceService::where('invoice_id', $invoice->id)->delete();

    $invoice->delete();

    return redirect()->route('account.index');
  }

  public function updateStatus(Request $request)
  {
    $data = $request->all();
    $validator = Validator::make($data, [
      'status' => 'required',
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    $pay = Invoice::findOrFail($data['id']);
    $pay->payment_status = $data['status'];
    $pay->save();
    session()->flash('success', 'Payment status updated successfully!');
    return redirect()->route('account.index');
  }
}
