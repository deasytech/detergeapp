<?php

namespace App\Http\Controllers;

use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use yajra\Datatables\Datatables;
use App\Order;

class VendorController extends Controller
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
    return view('pages.vendors.index');
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('pages.vendors.create');
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
      'address' => 'required'
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    Vendor::create($data);
    session()->flash('success', 'Technician added successfully!');
    return redirect()->route('technician.index');
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Vendor  $vendor
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $technician = Vendor::findOrFail($id);
    return view('pages.vendors.show')->with(compact('technician'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Vendor  $vendor
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $technician = Vendor::findOrFail($id);
    return view('pages.vendors.edit')->with(compact('technician'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Vendor  $vendor
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
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    $vendor = Vendor::findOrFail($id);
    $vendor->update($data);
    session()->flash('success', 'Technician updated successfully!');
    return redirect()->route('technician.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Vendor  $vendor
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $vendor = Vendor::where('id', $id)->first();
    $vendor->delete();
    session()->flash('success', 'Technician Deleted');
    return redirect()->route('technician.index');
  }

  public function ajaxLoad()
  {
    $vendor = Vendor::query();
    return Datatables::of($vendor)
    ->editColumn('status', function($vendor) {
      return $vendor->status == 1 ? 'Active' : 'Inactive';
    })
    ->addColumn('action', function ($vendor) {
      return '<a href="'.route('technician.show',$vendor->id).'" class="btn btn-warning btn-xs" data-toggle="tooltip" title="View"><i class="mdi mdi-eye"></i></a>
      <a href="'.route('technician.edit',$vendor->id).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>
      <form method="POST" action="'.route('technician.destroy', $vendor->id).'" style="display: inline-block;">
      <input type="hidden" name="_token" value="'.csrf_token().'">
      <input type="hidden" name="_method" value="DELETE">
      <a href="#" class="btn btn-danger btn-xs" onclick="var c = confirm(\'Are you sure you want to delete this record?\'); if(c == false) return false; else this.parentNode.submit();" class="text-decoration-none p2 display-block on-hover-no-decoration" data-toggle="tooltip" title="Delete" data-toggle="tooltip" title="Delete">
      <i class="mdi mdi-delete"></i>
      </a>
      </form>';
    })
    ->orderColumn('created_at', '-created_at $1')
    ->make(true);
  }

  public function orders()
  {
    $orders = Order::with(['customer','vendor','service'])->where('vendor_id','=',auth()->user()->id)->orderBy('actual_service_date','desc');
    return Datatables::of($orders)
    ->editColumn('vendor_id', function($order) {
      return $order->vendor->name;
    })
    ->editColumn('customer_id', function($order) {
      return $order->customer->name;
    })
    ->editColumn('telephone', function($order) {
      return $order->customer->telephone;
    })
    ->editColumn('service_type_id', function($order) {
      return $order->service->name;
    })
    ->editColumn('status', function($order) {
      return Str::title($order->status);
    })
    ->addColumn('action', function ($order) {
      return '<a href="#" class="btn btn-warning btn-xs" data-id="'.$order->id.'" data-status="'.$order->status.'" data-toggle="modal" data-target="#changeStatus"><i class="mdi mdi-eye"></i></a>';
    })
    ->make(true);
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
    $order = Order::findOrFail($data['id']);
    $order->status = $data['status'];
    $order->save();
    session()->flash('success', 'Technician request updated successfully!');
    return redirect()->route('technician.orders');
  }
}
