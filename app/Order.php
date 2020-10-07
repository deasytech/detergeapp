<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $guarded = ['id'];

  public function customer() {
    return $this->belongsTo(Customer::class,'customer_id');
  }

  public function vendor() {
    return $this->belongsTo(Vendor::class,'vendor_id');
  }

  public function service() {
    return $this->belongsTo(ServiceType::class,'service_type_id');
  }

  public function periodicServiceCategory() {
    return $this->belongsTo(PeriodicServiceCategory::class,'periodic_service_category_id');
  }
}
