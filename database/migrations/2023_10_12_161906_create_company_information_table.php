<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up()
  {
    Schema::create('company_information', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('foreign_name')->nullable();
      $table->string('address')->nullable();

      $table->string('email')->nullable();
      $table->string('tel_1')->nullable();
      $table->string('tel_2')->nullable();
      $table->string('mobile')->nullable();
      $table->string('fax')->nullable();
      $table->string('work')->nullable();
      $table->integer('tax_number')->nullable();
      $table->string('commercial_certificate')->nullable();
      $table->string('manufactured_certificate')->nullable();
      $table->string('notes')->nullable();
      $table->string('photo')->nullable();

      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('company_information');
  }
};
