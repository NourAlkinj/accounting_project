<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('default_prices', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable()->default(null);
            $table->string('name_en')->nullable()->default(null);
            $table->string('caption_ar')->nullable()->default(null);
            $table->string('caption_en')->nullable()->default(null);
            $table->string('type')->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('default_prices');
    }
};
