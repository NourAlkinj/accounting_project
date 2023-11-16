<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('foreign_name')->unique()->default(null)->nullable();
            $table->integer('card_type')->default(0);
            $table->unsignedBigInteger('store_id')->default(null)->nullable();
            $table->json('assembly_normal_ids')->default(null)->nullable();
            $table->string('address')->default(null)->nullable();
            $table->string('store_keeper')->default(null)->nullable();
            $table->integer('storage_capacity')->default(null)->nullable();
            $table->boolean('is_normal')->default(0);
            $table->boolean('is_assembly')->default(0);
            $table->string('notes')->default(null)->nullable();
            $table->string('flag')->nullable()->default('normal');
            $table->timestamps();
//            $table->foreign('store_id')->references('id')->on('stores');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
