<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('report_templates', function (Blueprint $table) {
            $table->id();
            $table->json('settings')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('report_templates');
    }
};
