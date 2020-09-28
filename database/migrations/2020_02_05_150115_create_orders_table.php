<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('customer_id');
      $table->bigInteger('vendor_id');
      $table->string('service_location');
      $table->string('dispenser_brand');
      $table->integer('dispenser_quantity');
      $table->integer('disinfect')->nullable();
      $table->longText('problem_description');
      $table->string('service_day');
      $table->date('actual_service_date')->nullable();
      $table->decimal('cost',20,2)->default(0);
      $table->string('payment_status')->default('pending');
      $table->timestamps();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('orders');
  }
}
