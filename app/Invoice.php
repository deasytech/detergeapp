<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  protected $fillable = [
    'invoice_no',
    'invoice_date',
    'due_date',
    'title',
    'customer_id',
    'vendor_id',
    'sub_total',
    'discount',
    'grand_total',
    'address'
  ];

  public function services() {
    return $this->hasMany(InvoiceService::class);
  }

  public function customer() {
    return $this->belongsTo(Customer::class, 'customer_id');
  }

  public function technician() {
    return $this->belongsTo(Vendor::class, 'vendor_id');
  }
}
