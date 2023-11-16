<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('table')->nullable();
            $table->string('operation')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->unsignedBigInteger('table_id')->nullable()->default(null);
            $table->json('old_data')->nullable()->default(null);
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('activities');
    }
};
