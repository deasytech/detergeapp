<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Invoice;
use App\User;
use App\Customer;
use Hash;
use Storage;

class DashboardController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index()
  {
    $latest_orders = Order::orderBy('created_at','desc')->take(6)->get();
    $sales = Invoice::where('payment_status','=','paid')->get()->sum('grand_total');
    $top_customers = Invoice::with('customer')->where('payment_status','!=','pending')->orderBy('grand_total','desc')->take(8)->get();
    return view('admin-dashboard', compact('latest_orders','sales','top_customers'));
  }

  public function generalDashboard()
  {
    $latest_orders = Order::orderBy('created_at','desc')->take(8)->get();
    return view('user-dashboard', compact('latest_orders'));
  }

  public function profile()
  {
    return view('user-profile');
  }

  public function avatar(Request $request) {
    if ($request->hasFile('avatar')) {
      $image = $request->file('avatar');
      $imageName = auth()->user()->id . "." . $image->getClientOriginalExtension();
      Storage::disk('public')->delete("avatar/" . $imageName);
      $request->file('avatar')->storeAs('public/avatar', $imageName);
      return response(['success' => 'Avatar Uploaded']);
    }
  }

  public function updateProfile(Request $request, $id) {
    $this->validate($request, [
      'name' => 'required|max:255',
      'email' => 'required|max:255',
      'telephone' => 'required|max:11',
      'location' => 'required|max:255'
    ]);
    $data = $request->all();
    if ($request->current_password) {
      $this->validate($request, [
        'current_password' => ['required', function ($attribute, $value, $fail) {
          if (!\Hash::check($value, auth()->user()->password)) {
            return $fail(__('The current password is incorrect.'));
          }
        }]
      ]);
      $data['password'] = Hash::make($data['password']);
    } else {
      unset($data['password']);
      unset($data['current_password']);
    }
    $user = User::findOrFail($id);
    $user->update($data);
    session()->flash('success', 'Profile updated successfully!');
    return redirect()->route('user.profile');
  }
}
