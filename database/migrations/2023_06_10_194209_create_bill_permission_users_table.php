<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('bill_permission_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->json('show_setting');
            $table->json('print_setting');
            $table->unsignedBigInteger('bill_template_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bill_permission_users');
    }
};
