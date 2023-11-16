<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('foreign_name')->default(null)->nullable();
            $table->unsignedBigInteger('department_id')->default(null)->nullable();
            $table->unsignedBigInteger('branch_id')->default(null)->nullable();
            $table->string('flag')->nullable()->default('department');
            $table->boolean('is_root')->default(false);

            $table->string('notes')->default(null)->nullable();
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('branch_id')->references('id')->on('branches');
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
