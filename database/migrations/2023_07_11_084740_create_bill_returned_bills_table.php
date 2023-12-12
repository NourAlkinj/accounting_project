<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('bill_returned_bills', function (Blueprint $table) {
            // $table->integer('storing_type');
            $table->id();
            $table->integer('bill_id')->nullable();
            $table->index('bill_id');
            $table->integer('returned_bill_id')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('bill_returned_bills');
    }
};
