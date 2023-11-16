<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cost_centers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('foreign_name')->unique()->default(null)->nullable();
            $table->integer('card_type')->default(0);
            $table->boolean('is_normal')->default(0);
            $table->boolean('is_assembly')->default(0);;
            $table->string('notes')->nullable()->default(null);
            $table->unsignedBigInteger('cost_center_id')->nullable()->default(null);
            $table->json('assembly_normal_ids')->default(null)->nullable();
            $table->integer('balance')->nullable()->default(0);
            $table->string('credit')->nullable()->default(null);
            $table->string('debit')->nullable()->default(null);
            $table->string('flag')->nullable()->default('normal');
            $table->timestamps();
//            $table->foreign('cost_center_id')->references('id')->on('cost_centers');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cost_centers');
    }
};
