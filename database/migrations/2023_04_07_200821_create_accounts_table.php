<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up()
  {
    Schema::create('accounts', function (Blueprint $table) {
      $table->id();
      $table->string('code')->unique();
      $table->string('name')->unique();
      $table->string('foreign_name')->unique()->default(null)->nullable();
      $table->integer('card_type')->default(0);
      $table->string('flag')->nullable()->default('normal');




      $table->unsignedBigInteger('account_id')->nullable()->default(null);
      $table->unsignedBigInteger('result_account_id')->nullable()->default(null);
      $table->unsignedBigInteger('final_account_id')->nullable()->default(null);
      $table->unsignedBigInteger('currency_id')->default(null)->nullable();

      $table->float('ratio')->default(null)->nullable();
      $table->double('parity')->default(null)->nullable();
      $table->string('notes')->default(null)->nullable();
      $table->float('amount')->default(null)->nullable();
      $table->boolean('is_warning_when_pass_max_limit')->default(0);

      $table->boolean('is_client')->default(0)->nullable();
      $table->boolean('is_assembly')->default(0)->nullable();
      $table->boolean('is_distributive')->default(0)->nullable();
      $table->boolean('is_final')->default(0)->nullable();
      $table->boolean('is_normal')->default(0)->nullable();

      $table->boolean('is_credit')->default(0)->nullable();
      $table->boolean('is_debit')->default(0)->nullable();
      $table->boolean('is_both')->default(0)->nullable();

      $table->boolean('is_max_limit_credit')->default(0)->nullable();
      $table->boolean('is_max_limit_debit')->default(0)->nullable();
      $table->boolean('is_max_limit_both')->default(0)->nullable();

      $table->json('assembly_normal_ids')->default(null)->nullable();;
      $table->json('distributive_normal_ids')->default(null)->nullable();

      $table->unsignedBigInteger('tax_account_id')->nullable();
      $table->double('tax_ratio')->nullable();

      $table->boolean('fixed_tax')->nullable();
      $table->boolean('enable_tax')->nullable();

      $table->timestamps();

//      $table->foreign('account_id')->references('id')->on('accounts');
//      $table->foreign('result_account_id')->references('id')->on('accounts');
//            $table->foreign('final_account_id')->references('id')->on('accounts');
//      $table->foreign('currency_id')->references('id')->on('currencies');

    });
  }


  public function down()
  {
    Schema::dropIfExists('accounts');
  }
};
