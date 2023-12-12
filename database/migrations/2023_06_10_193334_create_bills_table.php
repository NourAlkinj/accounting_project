<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('storing_type');
            $table->string('bill_type');
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->integer('receipt_number')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->index('account_id');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->double('parity', 200, 7)->nullable();
            $table->integer('bill_price_id')->nullable();
//      $table->string('security_level')->nullable();
            $table->integer('security_level')->nullable();
            $table->unsignedBigInteger('bill_template_id')->nullable();
            $table->unsignedBigInteger('cost_center_id')->nullable();
            $table->unsignedBigInteger('input_store_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->double('discount_value')->nullable();
            $table->double('addition_value')->nullable();
            $table->double('best_choice_for_addition_discount')->nullable();
            $table->double('bill_value')->nullable();
            $table->string('first_pay')->nullable();
            $table->double('first_pay_rest')->nullable();
            $table->unsignedBigInteger('items_account_id')->nullable();
            $table->unsignedBigInteger('cash_account_id')->nullable();
            $table->double('payment_type')->nullable();
            $table->double('total_items')->nullable();
            $table->double('total_item_addition')->nullable();
            $table->double('total_item_discount')->nullable();
            $table->double('total_items_net')->nullable();
            $table->boolean('has_returned_bill')->default(false)->nullable();
            $table->integer('source_bill_id')->nullable()->default(null);
            $table->string('has_source')->default(false);
            $table->double('max_quantity')->nullable();
            $table->double('left_quantity')->nullable();
            $table->boolean('is_input')->nullable();
            $table->boolean('is_output')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('bills');
    }
};
