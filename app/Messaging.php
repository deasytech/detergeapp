<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messaging extends Model
{
    protected $fillable = [
        'from_email',
        'from_name',
        'host',
        'port',
        'username',
        'password',
        'encryption'
    ];
}
