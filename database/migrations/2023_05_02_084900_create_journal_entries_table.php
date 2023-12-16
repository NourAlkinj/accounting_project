<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up()
  {
    Schema::create('journal_entries', function (Blueprint $table) {
      $table->id();
      $table->string('date')->nullable();
      $table->string('time')->nullable();
      $table->string('receipt_number')->nullable();
      $table->unsignedBigInteger('currency_id')->nullable();
      $table->index('currency_id') ;
      $table->double('parity')->nullable();
      $table->integer('security_level')->nullable();
      $table->string('debit_total')->nullable();
      $table->boolean('is_post_to_account')->nullable();
      $table->boolean( 'is_exchange')->default(false);
      $table->string('post_to_account_date')->nullable();
      $table->string('credit_total')->nullable();
      $table->unsignedBigInteger('branch_id');
      $table->string('notes')->nullable();
      $table->json('source');
//            $table->boolean('is_post_to_account');
//            $table->string('source_name')->nullable();
//            $table->unsignedBigInteger('source_template_id')->nullable();
//            $table->unsignedBigInteger('source_id')->nullable();
//            $table->unsignedBigInteger('is_has_source')->nullable();
//            $table->foreign('currency_id')->references('id')->on('currencies');
//            $table->foreign('branch_id')->references('id')->on('branches');
      $table->softDeletes();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('journal_entries');
  }
};
