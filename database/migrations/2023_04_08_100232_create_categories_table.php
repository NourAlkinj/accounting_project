<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('foreign_name')->nullable()->default(null);
            $table->string('flag')->nullable()->default('category');
            $table->unsignedBigInteger('category_id')->nullable()->default(null);
            $table->index('category_id') ;
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }


    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
