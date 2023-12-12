<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->json('employees_ids')->nullable();
            $table->string('description')->nullable();
            $table->string('color')->nullable();
            $table->string('start_date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_date')->nullable();
            $table->string('end_time')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->index('status_id');
            $table->json('attachments')->nullable();
            $table->string('notes')->nullable();
            $table->string('is_active')->nullable();
            $table->string('priority')->nullable();
            $table->integer('supervisor_id')->nullable();
            $table->string('remind_date')->nullable();
            $table->string('remind_time')->nullable();
            $table->string('remind_message')->nullable();
            $table->string('is_terminated')->nullable();
            $table->string('terminate_date')->nullable();
            $table->string('terminate_reason')->nullable();
            $table->string('font_color')->nullable();
            $table->string('icon')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('task_states');

        });
    }


    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
