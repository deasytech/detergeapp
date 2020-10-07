<?php

namespace App\Http\Controllers;

use App\DataTables\VendorDataTable;
use App\DataTables\VendorOrderDataTable;
use App\Vendor;
use Illuminate\Http\Request;
use Validator;
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
  public function index(VendorDataTable $dataTable)
  {
    return $dataTable->render('pages.vendors.index');
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

  public function orders(VendorOrderDataTable $dataTable)
  {
    return $dataTable->render('pages.vendors.vendor-orders');
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
