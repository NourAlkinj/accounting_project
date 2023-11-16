<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('employee_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('employee_tasks');
    }
};
