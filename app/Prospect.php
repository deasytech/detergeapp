<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
  protected $guarded = ['id'];

  function notes() {
    return $this->hasMany(Note::class,'prospect_id');
  }
}
