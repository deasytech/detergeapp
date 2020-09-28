<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceService extends Model
{
  protected $fillable = [
    'invoice_id',
    'service_type_id',
    'quantity',
    'price',
    'total'
  ];

  public function invoice() {
    return $this->hasMany(Invoice::class);
  }

  public function serviceType() {
    return $this->belongsTo(ServiceType::class, 'service_type_id');
  }
}
