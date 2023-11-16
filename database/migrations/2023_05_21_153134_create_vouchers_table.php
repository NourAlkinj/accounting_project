<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('receipt_number')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->integer('parity')->nullable();
            $table->integer('security_level')->nullable();
            $table->unsignedBigInteger('voucher_template_id');
            $table->double('debit_total')->nullable();
            $table->double('credit_total')->nullable();
            $table->double('total_balance')->nullable();
            $table->unsignedBigInteger('branch_id');
          $table->unsignedBigInteger('cost_center_id')->nullable();
          $table->string('notes')->nullable();
            $table->double('account_current_cash')->nullable();
            $table->double('account_final_cash')->nullable();
            $table->integer('relative_account_current_cash')->nullable();
            $table->integer('relative_account_final_cash')->nullable();
            $table->integer('generated_entry_id')->nullable();

            $table->string('post_to_account_date')->nullable();
            $table->boolean('is_post_to_account')->nullable();

             $table->softDeletes();
            $table->timestamps();
        });
    }


     public function down()
    {
        Schema::dropIfExists('vouchers');
    }
};
