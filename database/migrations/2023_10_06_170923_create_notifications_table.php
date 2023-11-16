<?php

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {

            $table->id();
            $table->timestamps();


            $table->string('source_id')->nullable();
            $table->string('type');
            $table->string('title');
            $table->string('message');
            $table->boolean('seen');
            $table->string('priority')->nullable();
            $table->string('send_date');
            $table->string('seen_date')->nullable();
            $table->json('attachment')->nullable();


            $table->foreignIdFor(User::class, 'from_user_id');
            $table->foreignIdFor(Employee::class, 'to_employee_id');
            $table->foreignIdFor(User::class, 'to_user_id')->nullable();

        });
    }


    public function down()
    {
        Schema::dropIfExists('notifications');
    }

};
