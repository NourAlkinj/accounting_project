<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('serials', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->index('item_id');
            $table->string('manufacture_year')->nullable();
            $table->string('color')->nullable();
            $table->integer('serial_index')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('serials');
    }
};
