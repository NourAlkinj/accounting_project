<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up()
  {
    Schema::create('images', function (Blueprint $table) {
      $table->id();
      $table->string('file_name');
      $table->integer('imageable_id')->nullable();
      $table->string('imageable_type')->nullable();
      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('images');
  }
};
