<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Validator;
use yajra\Datatables\Datatables;
use Gate;
use App\Customer;
use App\DataTables\OrderDataTable;
use Carbon\Carbon;
use App\PeriodicServiceCategory;
use App\Invoice;
use App\InvoiceService;

class OrderController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(OrderDataTable $dataTable)
  {
    return $dataTable->render('pages.orders.index');
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    if (Gate::denies('order.create')) {
      session()->flash('warning', 'You do not have permission to create an order');
      return redirect()->back();
    }
    return view('pages.orders.create');
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $data = $request->all();
    $periodic_service_categories = PeriodicServiceCategory::where('id',$request->periodic_service_category_id)->first();
    $days = $periodic_service_categories->days;
    $data['periodic_service_date'] = date('Y-m-d', strtotime($data['actual_service_date']. "+$days days"));
    $customer = Customer::findOrFail($data['customer_id']);
    $validator = Validator::make($data, [
      'customer_id' => 'required',
      'vendor_id' => 'required',
      'service_location' => 'required',
      'dispenser_quantity' => 'required',
      'problem_description' => 'required',
      'service_type_id' => 'required',
      'periodic_service_category_id' => 'required',
    ]);

    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    Order::create($data);
    $customer->status = 1;
    $customer->save();

    $invoiceNumber = rand(1000,9000);
    $invoice = new Invoice();
    $invoice->invoice_no = $invoiceNumber;
    $invoice->invoice_date = date('Y-m-d');
    $invoice->due_date = date('Y-m-d', strtotime(date('Y-m-d'). "+3 days"));
    $invoice->title = "Service Invoice-$invoiceNumber";
    $invoice->customer_id = $request->customer_id;
    $invoice->vendor_id = $request->vendor_id;
    $invoice->sub_total = (float)$request->dispenser_quantity * (float)$request->cost;
    $invoice->discount = 0;
    $invoice->grand_total = (float)$request->dispenser_quantity * (float)$request->cost;
    $invoice->address = $customer->address;
    $invoice->save();

    $invoiceService = new InvoiceService();
    $invoiceService->invoice_id = $invoice->id;
    $invoiceService->service_type_id = $request->service_type_id;
    $invoiceService->quantity = $request->dispenser_quantity;
    $invoiceService->price = $request->cost;
    $invoiceService->total = $invoice->grand_total;
    $invoiceService->save();

    session()->flash('success', 'Order added successfully!');
    return redirect()->route('order.index');
  }

  /**
  * Show tht form to store a specified customer resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function placement(Customer $customer)
  {
    return view('pages.orders.create')->with(compact('customer'));
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $order = Order::findOrFail($id);
    return view('pages.orders.show')->with(compact('order'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $order = Order::findOrFail($id);
    return view('pages.orders.edit')->with(compact('order'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    $data = $request->all();
    $validator = Validator::make($data, [
      'customer_id' => 'required',
      'vendor_id' => 'required',
      'service_location' => 'required',
      'dispenser_quantity' => 'required',
      'problem_description' => 'required',
      'service_type_id' => 'required'
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    $order = Order::findOrFail($id);
    $order->update($data);
    session()->flash('success', 'Order updated successfully!');
    return redirect()->route('order.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $order = Order::where('id', $id)->first();
    $order->delete();
    session()->flash('success', 'Order Deleted');
    return redirect()->route('order.index');
  }
}
