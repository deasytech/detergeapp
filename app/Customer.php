<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $fillable = [
    'name',
    'email',
    'telephone',
    'location',
    'address',
    'status',
    'customer_type_id'
  ];

  public function customerType() {
    return $this->belongsTo(CustomerType::class);
  }

  public function invoices() {
    return $this->hasMany(Invoice::class);
  }

  public function orders() {
    return $this->hasMany(Order::class);
  }
}
