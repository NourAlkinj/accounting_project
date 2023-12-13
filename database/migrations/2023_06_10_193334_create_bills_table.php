<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('bills', function (Blueprint $table) {
      $table->id();
      $table->string('storing_type')->default(null)->nullable();
      $table->string('bill_type')->default(null)->nullable();
      $table->string('date')->nullable()->default(null);
      $table->string('time')->nullable()->default(null);
      $table->integer('receipt_number')->nullable()->default(null);
      $table->unsignedBigInteger('account_id')->nullable()->default(null);
      $table->unsignedBigInteger('currency_id')->nullable()->default(null);
      $table->double('parity', 200, 7)->nullable()->default(null);
      $table->integer('bill_price_id')->nullable()->default(null);
//      $table->string('security_level')->nullable();
      $table->integer('security_level')->nullable()->default(null);

      $table->unsignedBigInteger('bill_template_id')->nullable()->default(null);
      $table->unsignedBigInteger('cost_center_id')->nullable()->default(null);

      $table->unsignedBigInteger('input_store_id')->nullable()->default(null);
      $table->unsignedBigInteger('store_id')->nullable()->default(null);

      $table->unsignedBigInteger('branch_id')->nullable()->default(null);
      $table->string('notes')->nullable()->default(null);
      $table->unsignedBigInteger('client_id')->nullable()->default(null);
      $table->double('discount_value')->nullable()->default(null);
      $table->double('addition_value')->nullable()->default(null);
      $table->double('best_choice_for_addition_discount')->nullable()->default(null);
      $table->double('bill_value')->nullable()->default(null);
      $table->string('first_pay')->nullable()->default(null);
      $table->double('first_pay_rest')->nullable()->default(null);

      $table->unsignedBigInteger('items_account_id')->nullable()->default(null);
      $table->unsignedBigInteger('cash_account_id')->nullable()->default(null);
      $table->double('payment_type')->nullable()->default(null);
      $table->double('total_items')->nullable()->default(null);
      $table->double('total_item_addition')->nullable()->default(null);
      $table->double('total_item_discount')->nullable()->default(null);
      $table->double('total_items_net')->nullable()->default(null);
      $table->boolean('has_returned_bill')->default(false)->nullable();

      $table->integer('source_bill_id')->nullable()->default(null);
      $table->string('has_source')->default(false)->nullable();
      $table->double('max_quantity')->nullable()->default(null);
      $table->double('left_quantity')->nullable()->default(null);

      $table->boolean('is_input')->nullable()->default(false);
      $table->boolean('is_output')->nullable()->default(false);


      $table->softDeletes();
      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('bills');
  }
};
