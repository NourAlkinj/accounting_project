<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('quantities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->double('quantity')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('quantities');
    }
};
