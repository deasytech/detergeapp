<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
  protected $fillable = ['name', 'status'];
}
