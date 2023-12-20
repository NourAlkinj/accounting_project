<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('voucher_permission_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->index('user_id');
            $table->json('show_setting')->nullable();
//            $table->json('print_setting')->nullable();
            $table->unsignedBigInteger('voucher_template_id');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('voucher_permission_users');
    }
};
