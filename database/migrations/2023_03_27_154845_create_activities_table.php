<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('table')->nullable();
            $table->string('table_name')->nullable();
            $table->longText('description_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->string('operation_ar')->nullable();
            $table->string('operation_en')->nullable();
            $table->string('mac')->nullable();
            $table->string('ip')->nullable();
            $table->string('pc_name')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->index('user_id');
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
