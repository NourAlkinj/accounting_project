<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up()
  {
    Schema::create('bill_records', function (Blueprint $table) {
      $table->id();
      $table->integer('index')->nullable();
      $table->double('total')->nullable();

      $table->double('unit_price')->nullable();
      $table->unsignedBigInteger('category_id')->nullable();
      $table->unsignedBigInteger('item_id')->nullable();
      $table->double('gift_price')->nullable();
      $table->double('bill_price')->nullable();
      $table->unsignedBigInteger('cost_center_id')->nullable();
      $table->unsignedBigInteger('bill_id');

      $table->unsignedBigInteger('currency_id')->nullable();
      $table->string('date')->nullable();
      $table->double('parity', 200, 7)->nullable();
      $table->integer('security_level')->nullable();


      $table->string('storing_type')->nullable();
      $table->boolean('is_affects_cost_price')->default(true)->nullable();
      $table->boolean('is_discounts_affects_cost_price')->default(true)->nullable();
      $table->boolean('is_additions_affects_cost_price')->default(true)->nullable();
      $table->double('general_discount')->nullable();
      $table->double('general_addition')->nullable();


      $table->string('gift')->nullable();
      $table->string('gift_unit_id')->nullable();
      $table->double('gift_conversion_factor')->nullable();

      $table->unsignedBigInteger('store_id')->nullable();
      $table->unsignedBigInteger('input_store_id')->nullable();


      $table->double('quantity')->nullable();
      $table->double('net')->nullable();
      $table->double('net_without_tax')->nullable();
      $table->double('item_discount')->nullable();
      $table->double('item_discount_ratio')->nullable();
      $table->double('item_addition')->nullable();
      $table->double('item_addition_ratio')->nullable();
      $table->double('tax')->nullable();
      $table->double('tax_ratio')->nullable();
      $table->boolean('is_input')->nullable();
      $table->boolean('is_output')->nullable();
      $table->double('count')->nullable();
      $table->string('notes')->nullable();
      $table->double('final_quantity')->nullable();
      $table->double('final_store_quantity')->nullable();
      $table->double('conversion_factor')->nullable();
      $table->string('expired_date')->nullable();
      $table->string('production_date')->nullable();
      $table->double('current_exist_quantity')->nullable();
      $table->double('current_store_exist_quantity')->nullable();
      $table->string('barcode')->nullable();
      $table->integer('unit_id')->nullable();
      $table->double('left_bill_quantity')->nullable();
      $table->double('max_bill_quantity')->nullable();
      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('bill_records');
  }
};
