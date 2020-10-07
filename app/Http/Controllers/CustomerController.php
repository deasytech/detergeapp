<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Validator;
use Gate;
use App\DataTables\CustomerDataTable;
use App\DataTables\NewCustomerDataTable;
use App\Order;

class CustomerController extends Controller
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
  public function index(CustomerDataTable $dataTable)
  {
    return $dataTable->render('pages.customers.index');
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('pages.customers.create');
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
    $validator = Validator::make($data, [
      'name' => 'required',
      'telephone' => 'required',
      'location' => 'required',
      'address' => 'required',
      'customer_type_id' => 'required'
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    Customer::create($data);
    session()->flash('success', 'Customer added successfully!');
    return redirect()->route('customer.index');
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Customer  $customer
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $customer = Customer::findOrFail($id);
    $services = Order::with('service','customer')->where('customer_id', $id)->get();
    return view('pages.customers.show')->with(compact('customer', 'services'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Customer  $customer
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $customer = Customer::findOrFail($id);
    if (Gate::denies('customer.update', $customer)) {
      session()->flash('warning', 'You do not have permission to edit this customer');
      return redirect(route('customer.index'));
    }
    return view('pages.customers.edit')->with(compact('customer'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Customer  $customer
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    $data = $request->all();
    $validator = Validator::make($data, [
      'name' => 'required',
      'telephone' => 'required',
      'location' => 'required',
      'address' => 'required',
      'customer_type_id' => 'required'
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    $customer = Customer::findOrFail($id);
    $customer->update($data);
    session()->flash('success', 'Customer updated successfully!');
    return redirect()->route('customer.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Customer  $customer
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $customer = Customer::where('id', $id)->first();
    if (Gate::denies('customer.delete', $customer)) {
      session()->flash('warning', 'You do not have permission to delete this customer');
      return redirect(route('customer.index'));
    }
    if ($customer->invoices->count() > 0) {
      $customer->invoices()->delete();
    }
    if ($customer->orders->count() > 0) {
      $customer->orders()->delete();
    }
    $customer->delete();
    session()->flash('success', 'Customer Deleted');
    return redirect()->route('customer.index');
  }

  public function newCustomers(NewCustomerDataTable $dataTable)
  {
    return $dataTable->render('pages.customers.new-customers');
  }
}
