<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('code')->default(null)->nullable();
            $table->string('name')->default(null)->nullable();
            $table->string('foreign_name')->default(null)->nullable();

            $table->string('photo')->nullable();
            $table->float('discount_ratio')->nullable();
            $table->unsignedBigInteger('discount_account_id')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->string('notes_client')->nullable();
            $table->unsignedBigInteger('price_id')->nullable();
            $table->integer('payment')->default('0');
            $table->boolean('is_customer')->default(0)->nullable();
            $table->boolean('is_vendor')->default(0)->nullable();
            $table->boolean('is_both_client')->default(0)->nullable();
            $table->integer('gender')->default(0);
            $table->string('nationality')->nullable();
            $table->string('work')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('record_date')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->timestamps();
//            $table->foreign('account_id')->references('id')->on('accounts');
//            $table->foreign('discount_account_id')->references('id')->on('accounts');

        });
    }
    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
