<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up()
  {
    Schema::create('task_states', function (Blueprint $table) {
      $table->id();

      $table->string('name')->nullable();
      $table->string('color')->nullable();
      $table->string('pattern')->nullable();
      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('task_states');
  }
};
