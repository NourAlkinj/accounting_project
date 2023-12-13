<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('currency_activities', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('currency_id')->default(null)->nullable();
          $table->float('parity',20,10)->nullable();
          $table->date('date')->default(null)->nullable();
          $table->timestamps();

//          $table->foreign('currency_id')->references('id')->on('currencies');

        });
    }


    public function down()
    {
        Schema::dropIfExists('currency_activities');
    }
};
