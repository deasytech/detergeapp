<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
  protected $fillable = ['name', 'status'];

  public function orders() {
    return $this->hasMany(Order::class);
  }
}
