<?php

namespace App\Http\Controllers;

use App\ServiceType;
use Illuminate\Http\Request;
use Validator;
use yajra\Datatables\Datatables;
use Gate;

class ServicesController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    return view('pages.settings.services-type.index');
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    if (Gate::denies('service.create')) {
      session()->flash('warning', 'You do not have permission to create a service');
      return redirect()->back();
    }
    return view('pages.settings.services-type.create');
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
      'status' => 'required',
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    ServiceType::create($data);
    session()->flash('success', 'Services added successfully!');
    return redirect()->route('service.index');
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\ServiceType  $serviceType
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $serviceType = ServiceType::findOrFail($id);
    return view('pages.settings.services-type.show', compact('serviceType'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\ServiceType  $serviceType
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    if (Gate::denies('service.update',ServiceType::findOrFail($id))) {
      session()->flash('warning', 'You do not have permission to edit a service');
      return redirect()->back();
    }
    $serviceType = ServiceType::findOrFail($id);
    return view('pages.settings.services-type.edit', compact('serviceType'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\ServiceType  $serviceType
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    $data = $request->all();
    $validator = Validator::make($data, [
      'name' => 'required',
      'status' => 'required',
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    $service = ServiceType::findOrFail($id);
    $service->update($data);
    session()->flash('success', 'Service updated successfully!');
    return redirect()->route('service.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\ServiceType  $serviceType
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    if (Gate::denies('service.delete',ServiceType::findOrFail($id))) {
      session()->flash('warning', 'You do not have permission to edit a service');
      return redirect()->back();
    }
    $service = ServiceType::where('id', $id)->first();
    $service->delete();
    session()->flash('success', 'Service Deleted');
    return redirect()->route('service.index');
  }

  public function ajaxLoad()
  {
    $services = ServiceType::query()->orderBy('name');
    return Datatables::of($services)
    ->editColumn('created_at', function($services) {
      return $services->created_at->diffForHumans();
    })
    ->editColumn('status', function($services) {
      return $services->status == 1 ? 'Enabled' : 'Disabled';
    })
    ->addColumn('action', function ($services) {
      return '<a href="'.route('service.show',$services->id).'" class="btn btn-warning btn-xs" data-toggle="tooltip" title="View"><i class="mdi mdi-eye"></i></a>
      <a href="'.route('service.edit',$services->id).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>
      <form method="POST" action="'.route('service.destroy', $services->id).'" style="display: inline-block;">
      <input type="hidden" name="_token" value="'.csrf_token().'">
      <input type="hidden" name="_method" value="DELETE">
      <a href="#" class="btn btn-danger btn-xs" onclick="var c = confirm(\'Are you sure you want to delete this record?\'); if(c == false) return false; else this.parentNode.submit();" class="text-decoration-none p2 display-block on-hover-no-decoration" data-toggle="tooltip" title="Delete" data-toggle="tooltip" title="Delete">
      <i class="mdi mdi-delete"></i>
      </a>
      </form>';
    })
    ->make(true);
  }
}
