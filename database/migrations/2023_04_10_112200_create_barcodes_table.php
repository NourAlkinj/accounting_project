<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('barcodes', function (Blueprint $table) {
            $table->id();
            $table->string('barcode_name')->unique();
            $table->integer('item_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('notes')->default(null)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barcodes');
    }
};
