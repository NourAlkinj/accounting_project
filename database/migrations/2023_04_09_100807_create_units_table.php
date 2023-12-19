<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_name')->default(null)->nullable();
            $table->string('unit_foreign_name')->default(null)->nullable();
            $table->string('is_default')->nullable()->default(false);
            $table->unsignedBigInteger('item_id');
            $table->index('item_id');
            $table->integer('relative_unit')->default(null)->nullable();
            $table->double('conversion_factor')->default(null)->nullable();
            $table->integer('unit_number')->default(null)->nullable();
            $table->json('prices')->default(null)->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('units');
    }
};
