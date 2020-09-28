<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'label',
        'description',
        'public_key',
        'secret_key',
        'payment_url',
        'merchant_email',
        'status'
    ];
}
