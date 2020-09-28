<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Invoice;
use App\Order;
use Illuminate\Http\Request;
use Validator;
use yajra\Datatables\Datatables;
use Gate;

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
  public function index()
  {
    return view('pages.customers.index');
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
    return view('pages.customers.show')->with(compact('customer'));
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
    // dd($customer->invoices);
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

  public function ajaxLoad()
  {
    $customer = Customer::with('customerType')->where('status','=',1)->orderBy('created_at','desc');
    return Datatables::of($customer)
    ->editColumn('status', function($customer) {
      return $customer->status == 1 ? 'Active' : 'Inactive';
    })
    ->editColumn('customer_type_id', function($customer) {
      return $customer->customerType->name;
    })
    ->addColumn('action', function ($customer) {
      return '<a href="'.route('customer.show',$customer->id).'" class="btn btn-warning btn-xs" data-toggle="tooltip" title="View"><i class="mdi mdi-eye"></i></a>
      <a href="'.route('customer.edit',$customer->id).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>
      <form method="POST" action="'.route('customer.destroy', $customer->id).'" style="display: inline-block;">
      <input type="hidden" name="_token" value="'.csrf_token().'">
      <input type="hidden" name="_method" value="DELETE">
      <a href="#" class="btn btn-danger btn-xs" onclick="var c = confirm(\'Are you sure you want to delete this record?\'); if(c == false) return false; else this.parentNode.submit();" class="text-decoration-none p2 display-block on-hover-no-decoration" data-toggle="tooltip" title="Delete" data-toggle="tooltip" title="Delete">
      <i class="mdi mdi-delete"></i>
      </a>
      </form>
      <a href="'.route('order.placement',$customer).'" class="btn btn-dark btn-xs" data-toggle="tooltip" title="Place Order"><i class="mdi mdi-cart"></i></a>';
    })
    ->rawColumns(['action'])
    ->addIndexColumn()
    ->make(true);
  }

  public function newCustomers()
  {
    $customer = Customer::with('customerType')->where('status','=',0)->orderBy('created_at','desc');
    return Datatables::of($customer)
    ->editColumn('status', function($customer) {
      return $customer->status == 1 ? 'Active' : 'Inactive';
    })
    ->editColumn('customer_type_id', function($customer) {
      return $customer->customerType->name;
    })
    ->addColumn('action', function ($customer) {
      return '<a href="'.route('customer.show',$customer->id).'" class="btn btn-warning btn-xs" data-toggle="tooltip" title="View"><i class="mdi mdi-eye"></i></a>
      <a href="'.route('customer.edit',$customer->id).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>
      <form method="POST" action="'.route('customer.destroy', $customer->id).'" style="display: inline-block;">
      <input type="hidden" name="_token" value="'.csrf_token().'">
      <input type="hidden" name="_method" value="DELETE">
      <a href="#" class="btn btn-danger btn-xs" onclick="var c = confirm(\'Are you sure you want to delete this record?\'); if(c == false) return false; else this.parentNode.submit();" class="text-decoration-none p2 display-block on-hover-no-decoration" data-toggle="tooltip" title="Delete" data-toggle="tooltip" title="Delete">
      <i class="mdi mdi-delete"></i>
      </a>
      </form>
      <a href="'.route('order.placement',$customer).'" class="btn btn-dark btn-xs" data-toggle="tooltip" title="Place Order"><i class="mdi mdi-cart"></i></a>';
    })
    ->rawColumns(['action'])
    ->addIndexColumn()
    ->make(true);
  }
}
