<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
  protected $fillable = [
    'prospect_id',
    'details'
  ];

  function prospect() {
    return $this->belongsTo(Prospect::class, 'prospect_id');
  }
}
