<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('trashes', function (Blueprint $table) {
            $table->id();
            $table->string("table")->nullable();
            $table->integer("table_id")->nullable();
            $table->integer("user_id")->nullable();
            $table->timestamps();
        });
    }

 
    public function down()
    {
        Schema::dropIfExists('trashes');
    }
};
