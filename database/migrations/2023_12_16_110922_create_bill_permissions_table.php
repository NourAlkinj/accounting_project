<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('bill_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('caption_ar');
            $table->string('caption_en');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bill_permissions');
    }
};
