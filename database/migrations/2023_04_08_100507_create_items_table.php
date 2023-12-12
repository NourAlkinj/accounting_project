<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('location')->nullable()->default(null);
            $table->string('manuf_company')->nullable()->default(null);
            $table->string('country_of_origin')->nullable()->default(null);
            $table->string('source')->nullable()->default(null);
            $table->string('caliber')->nullable()->default(null);
            $table->string('chemical_composition')->nullable()->default(null);
            $table->string('foreign_name')->nullable()->default(null);
            $table->unsignedBigInteger('category_id');
            $table->index('category_id');
            $table->string('weight')->nullable()->default(null);
            $table->string('size')->nullable()->default(null);
            $table->string('item_type');
            $table->string('notes')->nullable()->default(null);
            $table->string('photo')->nullable()->default(null);
            $table->string('flag')->nullable()->default('item');
            $table->double('parity')->nullable() ;
            $table->unsignedBigInteger('currency_id')->nullable()->default(null);
            $table->double('auto_discount_on_salse')->nullable()->default(0.0);
            $table->double('added_value_tax')->nullable()->default(0.0);
            $table->boolean('auto_counting_for_prices')->nullable()->default(null);
            $table->boolean('expired_date')->nullable()->default(null);
            $table->boolean('serial_number')->nullable()->default(null);
            $table->boolean('production_date')->nullable()->default(null);
            $table->boolean('should_alert')->nullable()->default(null);
            $table->double('days_before_alert')->nullable()->default(null);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('items');
    }
};
