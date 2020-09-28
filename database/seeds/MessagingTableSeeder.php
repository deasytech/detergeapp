<?php

use Illuminate\Database\Seeder;
use App\Messaging;

class MessagingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $method = new Messaging();
      $method->from_email = 'info@detergenigeria.com';
      $method->from_name = 'Deterge Nigeria';
      $method->save();
    }
}
