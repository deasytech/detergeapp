<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User, Role};
use Validator;
use Gate;
use yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
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
    return view('pages.staff.index');
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('pages.staff.create');
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
      'password' => 'required|confirmed|min:6',
      'password_confirmation' => 'required|min:6'
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    $data['password'] = Hash::make($data['password']);
    $user = User::create($data);
    $user->roles()->sync($data['roles']);
    session()->flash('success', 'Staff added successfully!');
    return redirect()->route('staff.index');
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $staff = User::findOrFail($id);
    return view('pages.staff.show')->with(compact('staff'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit(User $staff)
  {
    if (Gate::denies('edit-staff')) {
      session()->flash('warning', 'You do not have permission to edit this staff');
      return redirect(route('staff.index'));
    }
    return view('pages.staff.edit')->with(compact('staff'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, User $staff)
  {
    $data = $request->all();
    $validator = Validator::make($data, [
      'name' => 'required',
      'telephone' => 'required',
      'location' => 'required',
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    $staff->update($data);
    $staff->roles()->sync($data['roles']);
    session()->flash('success', 'Staff updated successfully!');
    return redirect()->route('staff.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy(User $staff)
  {
    if (Gate::denies('delete-staff')) {
      session()->flash('warning', 'You do not have permission to delete this staff');
      return redirect(route('staff.index'));
    }
    $staff->roles()->detach();
    $staff->delete();
    session()->flash('success', 'Staff Deleted');
    return redirect()->route('staff.index');
  }

  public function ajaxLoad()
  {
    $staff = User::with('roles');
    return Datatables::of($staff)
    ->editColumn('birthday', function($staff) {
      return date('jS M', strtotime($staff->birthday));
    })
    ->editColumn('status', function($staff) {
      return $staff->status == 1 ? 'Active' : 'Inactive';
    })
    ->editColumn('roles', function($staff) {
      $roleArr = $staff->roles()->get()->pluck('name')->toArray();
      return ucwords(implode(' | ',$roleArr));
    })
    ->addColumn('action', function ($staff) {
      $show = '<a href="'.route('staff.show',$staff).'" class="btn btn-warning btn-xs" data-toggle="tooltip" title="View"><i class="mdi mdi-eye"></i></a>';

      $edit = '<a href="'.route('staff.edit',$staff->id).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>';

      $delete = '<form method="POST" action="'.route('staff.destroy', $staff).'" style="display: inline-block;">
      <input type="hidden" name="_token" value="'.csrf_token().'">
      <input type="hidden" name="_method" value="DELETE">
      <a href="#" class="btn btn-danger btn-xs" onclick="var c = confirm(\'Are you sure you want to delete this record?\'); if(c == false) return false; else this.parentNode.submit();" class="text-decoration-none p2 display-block on-hover-no-decoration" data-toggle="tooltip" title="Delete" data-toggle="tooltip" title="Delete">
      <i class="mdi mdi-delete"></i>
      </a>
      </form>';
      if (Gate::denies('edit-staff')) {
        $edit = '';
      }
      if (Gate::denies('delete-staff')) {
        $delete = '';
      }
      return $show . ' ' . $edit . ' ' . $delete;
    })
    ->orderColumn('created_at', '-created_at $1')
    ->make(true);
  }
}
