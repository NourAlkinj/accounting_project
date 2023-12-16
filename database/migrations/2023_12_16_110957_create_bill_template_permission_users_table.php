<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('bill_template_permission_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('voucher_permission_id');
            $table->unsignedBigInteger('voucher_template_id');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('bill_template_permission_users');
    }
};
