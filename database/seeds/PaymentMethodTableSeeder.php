<?php

use Illuminate\Database\Seeder;
use App\PaymentMethod;

class PaymentMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $method = new PaymentMethod();
      $method->label = 'Paystack';
      $method->description = 'Pay via credit or debit card.';
      $method->public_key = 'pk_test_8a92f90ceeedb6e63754213ecfd1f90ebacde350';
      $method->secret_key = 'sk_test_e2b98ffa0b1f04bb90a02252a2dba2c47db67322';
      $method->payment_url = 'https://api.paystack.co';
      $method->merchant_email = 'info@detergenigeria.com';
      $method->save();
    }
}
