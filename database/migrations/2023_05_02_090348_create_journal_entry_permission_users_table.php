<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('journal_entry_permission_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->json('show_setting')->nullable();
            $table->json('print_setting')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('journal_entry_permission_users');
    }
};
