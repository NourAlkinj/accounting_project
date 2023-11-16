<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

  public function up()
  {
    Schema::create('task_activities', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('task_id')->nullable();

      $table->json('old_employee_ids')->nullable();
      $table->json('new_employee_ids')->nullable();
      $table->string('operation')->nullable();

      $table->integer('old_task_status_id')->nullable();
      $table->integer('new_task_status_id')->nullable();

      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('task_activities');
  }
};
