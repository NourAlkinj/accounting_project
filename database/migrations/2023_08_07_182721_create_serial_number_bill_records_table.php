<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('serial_number_bill_records', function (Blueprint $table) {
            $table->id();
            $table->integer('serial_id')->nullable();
            $table->index('serial_id');
            $table->integer('bill_record_id')->nullable();
            $table->integer('bill_id')->nullable();
            $table->integer('item_Id')->nullable();
            $table->boolean('is_input')->nullable();
            $table->integer('is_output')->nullable();
            $table->string('input_date')->nullable();
            $table->string('output_date')->nullable();
            $table->timestamp('deleted_at');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('serial_number_bill_records');
    }
};
