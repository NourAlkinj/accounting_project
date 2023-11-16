<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('asset_groups', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('foreign_name')->unique()->default(null)->nullable();
            $table->unsignedBigInteger('asset_group_id')->default(null)->nullable();
            $table->string('notes')->default(null)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_groups');
    }
};
