<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('default_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable()->default(null);
            $table->string('name_en')->nullable()->default(null);
            $table->string('code_ar')->nullable()->default(null);
            $table->string('code_en')->nullable()->default(null);
            $table->string('foreign_name')->unique()->nullable()->default(null);
            $table->integer('proportion')->nullable()->default(null);
            $table->float('parity',20,10)->nullable()->default(1);
            $table->float('equivalent',20,10)->nullable();
            $table->string('part_name_ar')->nullable()->default(null);
            $table->string('part_name_en')->nullable()->default(null);
            $table->string('foreign_part_name')->nullable()->default(null);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('default_currencies');
    }
};
