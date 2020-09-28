<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
  protected $fillable = [
    'organisation',
    'physical_address',
    'nature_of_business',
    'contact_email',
    'contact_phone_number'
  ];

  function notes() {
    return $this->hasMany(Note::class,'prospect_id');
  }
}
