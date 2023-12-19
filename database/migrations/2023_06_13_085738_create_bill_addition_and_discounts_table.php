<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('bill_addition_and_discounts', function (Blueprint $table) {
            $table->id();
            $table->integer('addition_index')->nullable();
            $table->double('discount')->nullable();
            $table->double('discount_ratio')->nullable();
            $table->double('addition')->nullable();
            $table->double('addition_ratio')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->double('parity')->nullable();
            $table->double('equivalent')->nullable();
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->index('bill_id');
            $table->unsignedBigInteger('cost_center_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('bill_addition_and_discounts');
    }
};
