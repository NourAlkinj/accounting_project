<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default(null)->nullable();
            $table->string('code')->default(null)->nullable();
            $table->string('foreign_name')->default(null)->nullable();
            $table->float('parity',20,10)->nullable();
            $table->float('equivalent',20,10)->nullable();
            $table->integer('proportion')->default(0)->nullable();
            $table->boolean('is_default')->default(false);
            $table->integer('decimal_places')->default(0)->nullable();
            $table->boolean('reminder_of_exchange_rates_changing_daily')->default(false)->nullable();
            $table->boolean('is_currency_reminder_active')->default(false);
            $table->string('part_name')->default(null)->nullable();
            $table->string('foreign_part_name')->default(null)->nullable();
            $table->timestamps();


        });
    }
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
};
