<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();

            $table->string('type')->nullable();
            $table->string('file_name');
            $table->integer('attachmentable_id')->nullable();
            $table->index('attachmentable_id');
            $table->string('attachmentable_type')->nullable();
            $table->string('src');
            $table->string('extension')->nullable();
            $table->string('title')->nullable();
            $table->string('color')->nullable();


            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('attachments');
    }
};
