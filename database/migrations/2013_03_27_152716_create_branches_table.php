<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('foreign_name')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->index('branch_id');
            $table->string('responsibility')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->string('website')->nullable()->default(null);
            $table->string('email')->nullable()->default(null)->unique();
            $table->string('phone')->nullable()->default(null);
            $table->string('mobile')->nullable()->default(null);
            $table->string('notes')->nullable()->default(null);
            $table->string('flag')->nullable()->default('branch');
            $table->boolean('is_root')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branches');
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
