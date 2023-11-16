<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('foreign_name')->nullable()->default(null);
      $table->string('national_number')->nullable()->default(null);
      $table->string('code');
      $table->string('email')->nullable()->default(null);
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password')->nullable()->default(null);
      $table->string('real_password')->nullable()->default(null);
      $table->string('hash')->nullable()->default(null);
//      $table->unsignedBigInteger('branch_id')->nullable()->default(1);
      $table->unsignedBigInteger('branch_id')->default(1);
      $table->string('first_name')->nullable()->default(null);
      $table->string('middle_name')->nullable()->default(null);
      $table->string('last_name')->nullable()->default(null);
      $table->string('phone')->nullable()->default(null);
      $table->foreignId('current_team_id')->nullable()->default(null);
      $table->text('profile_photo_path')->nullable();
      $table->string('mobile')->nullable()->default(null);
      $table->string('address')->nullable()->default(null);
//            $table->string('security_level')->nullable();
      $table->integer('security_level')->nullable();
      $table->string('notes')->nullable()->default(null);
      $table->string('id_number')->nullable()->default(null);
      // $table->integer('account_box_id')->nullable()->default(null);
      // $table->integer('store_id')->nullable()->default(null);
      $table->boolean('is_active')->default(true);
      $table->boolean('is_root')->default(false);
      $table->string('flag')->nullable()->default('user');
      $table->string('photo')->nullable();

      $table->json('databases')->default(json_encode([]));

      $table->rememberToken();
      $table->timestamps();
      $table->foreign('branch_id')->references('id')->on('branches');
    });
  }


  public function down()
  {
    Schema::dropIfExists('users');
  }
};
