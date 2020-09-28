<?php

use Carbon\Carbon;
use Twilio\Rest\Client;
use App\Setting;
use Illuminate\Support\Facades\DB;

function presentPrice($price)
{
  return '₦' . number_format($price, 2);
}

function presentDate($date)
{
  return Carbon::parse($date)->format('M d, Y');
}

function presentStates() {
  return App\State::all();
}

function presentCustomers() {
  return App\Customer::all();
}

function presentVendors() {
  return App\Vendor::where('status','=',1)->get();
}

function presentServiceTypes() {
  return App\ServiceType::where('status','=',1)->get();
}

function presentCustomerTypes() {
  return App\CustomerType::all();
}

function presentOrders() {
  return App\Order::all();
}

function presentAllRoles() {
  return App\Role::all();
}

function periodicServices() {
  return App\PeriodicServiceCategory::where('status',1)->get();
}

function formatTelephone($number) {
  $countryCode = '+234';
  if (preg_match("~^0\d+$~", $number)) {
    $internationalNumber = preg_replace('/^0/', $countryCode, $number);
  } else {
    $internationalNumber = $countryCode.$number;
  }
  return $internationalNumber;
}

function sendMessage($message, $recipients) {
  $account_sid = getenv("TWILIO_SID");
  $auth_token = getenv("TWILIO_AUTH_TOKEN");
  $twilio_number = getenv("TWILIO_NUMBER");
  $client = new Client($account_sid, $auth_token);
  $client->messages->create(formatTelephone($recipients),
  ['from' => $twilio_number, 'body' => $message] );
}

function presentAvatar($user_id) {
  foreach(scandir(public_path() .'/storage/avatar/') as $key => $file) {
    if (preg_match('/[\s\S]+\.(png|jpg|jpeg|tiff|gif|bmp)/iu', $file)) {
      $arr = explode('.',$file);
      if ($arr[0] == $user_id) {
        return $file;
      }
    }
  }
}

function messagingStatus() {
  return Setting::where('key','=','messaging')->first();
}

function state() {
  return App\State::where('status',1)->get();
}

function totalSalesByService($type) {
  return App\InvoiceService::where('service_type_id',$type)->get()->sum('total');
}

function totalRevenueByLocation($location) {
  return DB::table('invoices')
  ->leftJoin('customers', 'customers.id', '=', 'invoices.customer_id')
  ->select('customers.location', DB::raw('SUM(invoices.grand_total) as total_sales'))
  ->where('customers.location','=',$location)
  ->groupBy('customers.location')
  ->first();
}
