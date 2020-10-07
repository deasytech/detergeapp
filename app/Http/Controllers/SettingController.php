<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Validator;
use yajra\Datatables\Datatables;
use Gate;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    return view('pages.settings.settings.index');
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('pages.settings.settings.create');
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
      'display_name' => 'required|max:255',
      'key' => 'required|alpha_dash|max:255|unique:settings',
      'value' => 'required',
      'type' => 'required',
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    if ($request->hasFile('value')) {
      $image = $request->file('value');
      $imageName = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
      $request->file('value')->storeAs('public/settings', $imageName);
      $data['value'] = $imageName;
    }
    Setting::create($data);
    session()->flash('success', 'Settings added successfully!');
    return redirect()->route('setting.index');
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Setting  $setting
  * @return \Illuminate\Http\Response
  */
  public function show(Setting $setting)
  {
    return view('pages.settings.settings.show', compact('setting'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Setting  $setting
  * @return \Illuminate\Http\Response
  */
  public function edit(Setting $setting)
  {
    if (Gate::denies('manage.settings')) {
      session()->flash('warning', 'You do not have permission to edit this setting');
      return redirect()->back();
    }
    return view('pages.settings.settings.edit', compact('setting'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Setting  $setting
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Setting $setting)
  {
    $data = $request->all();
    $key = $data['key'] == $setting->key ? 'required|alpha_dash|max:255' : 'required|alpha_dash|max:255|unique:settings';
    $validator = Validator::make($data, [
      'display_name' => 'required|max:255',
      'key' => $key,
      'value' => 'sometimes',
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    if ($request->hasFile('value')) {
      Storage::disk('public')->delete("settings/" . $setting->value);
      $image = $request->file('value');
      $imageName = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
      $request->file('value')->storeAs('public/settings', $imageName);
      $data['value'] = $imageName;
    }
    $setting->update($data);
    session()->flash('success', 'Settings updated successfully!');
    return redirect()->route('setting.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Setting  $setting
  * @return \Illuminate\Http\Response
  */
  public function destroy(Setting $setting)
  {
    if (Gate::denies('manage.settings')) {
      session()->flash('warning', 'You do not have permission to delete this setting');
      return redirect()->back();
    }
    if(Storage::exists('/public/settings/'.$setting->value)) {
      Storage::disk('public')->delete("settings/" . $setting->value);
    }
    $setting->delete();
    session()->flash('success', 'Setting Deleted');
    return redirect()->route('setting.index');
  }

  public function ajaxLoad()
  {
    $setting = Setting::query()->orderBy('display_name');
    return Datatables::of($setting)
    ->editColumn('type', function($setting) {
      return ucwords($setting->type);
    })
    ->editColumn('value', function($setting) {
      if(Storage::exists('/public/settings/'.$setting->value)) {
        $url=asset("/storage/settings/$setting->value");
        return '<img src='.$url.' border="0" height="40" class="img-rounded" align="center" />';
      }
      return $setting->value;
    })
    ->addColumn('action', function ($setting) {
      return '<a href="'.route('setting.show',$setting).'" class="btn btn-warning btn-xs" data-toggle="tooltip" title="View"><i class="mdi mdi-eye"></i></a>
      <a href="'.route('setting.edit',$setting).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>
      <form method="POST" action="'.route('setting.destroy', $setting).'" style="display: inline-block;">
      <input type="hidden" name="_token" value="'.csrf_token().'">
      <input type="hidden" name="_method" value="DELETE">
      <a href="#" class="btn btn-danger btn-xs" onclick="var c = confirm(\'Are you sure you want to delete this record?\'); if(c == false) return false; else this.parentNode.submit();" class="text-decoration-none p2 display-block on-hover-no-decoration" data-toggle="tooltip" title="Delete" data-toggle="tooltip" title="Delete">
      <i class="mdi mdi-delete"></i>
      </a>
      </form>';
    })
    ->rawColumns(['value', 'action'])
    ->make(true);
  }
}
