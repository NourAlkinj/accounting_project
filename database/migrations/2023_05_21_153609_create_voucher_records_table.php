<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

     public function up()
    {
        Schema::create('voucher_records', function (Blueprint $table) {
            $table->id();
            $table->integer('index')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->double('credit')->nullable();
            $table->double('debit')->nullable();
            $table->double('relative_debit')->nullable();
            $table->double('relative_credit')->nullable();
            $table->string('post_to_account_date')->nullable();
            $table->boolean('is_post_to_account')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('cost_center_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable()->default(null);
            $table->integer('parity')->nullable()->default(null);
            $table->integer('today_parity')->nullable();
            $table->integer('equivalent')->nullable();
            $table->double('contra_account_id')->nullable();
            $table->double('current_balance')->nullable();
            $table->string('final_balance')->nullable();
            $table->integer('relative_current_balance')->nullable();
            $table->integer('relative_final_balance')->nullable();
            $table->integer('id2')->nullable();

            $table->unsignedBigInteger('tax_account')->nullable();

            $table->double('tax_ratio')->nullable();

            $table->double('tax_value')->nullable();

            $table->softDeletes();
            $table->unsignedBigInteger('voucher_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('voucher_records');
    }
};
