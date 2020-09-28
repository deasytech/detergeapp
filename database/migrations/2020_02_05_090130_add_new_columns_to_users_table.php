<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToUsersTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->string('address')->nullable()->after('email');
      $table->string('location')->nullable()->after('address');
      $table->string('telephone')->nullable()->after('location');
      $table->date('birthday')->nullable()->after('telephone');
      $table->tinyInteger('status')->default(1)->after('birthday');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('address');
      $table->dropColumn('location');
      $table->dropColumn('telephone');
      $table->dropColumn('birthday');
      $table->dropColumn('status');
    });
  }
}
