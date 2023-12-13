<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up()
  {
    Schema::create('bill_records', function (Blueprint $table) {
      $table->id();
      $table->integer('index')->nullable()->default(null);
      $table->double('total')->nullable()->default(null);

      $table->double('unit_price')->nullable()->default(null);
      $table->unsignedBigInteger('category_id')->nullable()->default(null);
      $table->unsignedBigInteger('item_id')->nullable()->default(null);
      $table->double('gift_price')->nullable()->default(null);
      $table->double('bill_price')->nullable()->default(null);
      $table->unsignedBigInteger('cost_center_id')->nullable()->default(null);
      $table->unsignedBigInteger('bill_id')->default(null)->nullable();

      $table->unsignedBigInteger('currency_id')->nullable()->default(null);
      $table->string('date')->nullable()->default(null);
      $table->double('parity', 200, 7)->nullable()->default(null);
      $table->integer('security_level')->nullable()->default(null);


      $table->string('storing_type')->nullable()->default(null);
      $table->boolean('is_affects_cost_price')->default(true)->nullable();
      $table->boolean('is_discounts_affects_cost_price')->default(true)->nullable();
      $table->boolean('is_additions_affects_cost_price')->default(true)->nullable();
      $table->double('general_discount')->nullable()->default(null);
      $table->double('general_addition')->nullable()->default(null);


      $table->string('gift')->nullable()->default(null);
      $table->string('gift_unit_id')->nullable()->default(null);
      $table->double('gift_conversion_factor')->nullable()->default(null);

      $table->unsignedBigInteger('store_id')->nullable()->default(null);
      $table->unsignedBigInteger('input_store_id')->nullable()->default(null);


      $table->double('quantity')->nullable()->default(null);
      $table->double('net')->nullable()->default(null);
      $table->double('net_without_tax')->nullable()->default(null);
      $table->double('item_discount')->nullable()->default(null);
      $table->double('item_discount_ratio')->nullable()->default(null);
      $table->double('item_addition')->nullable()->default(null);
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
