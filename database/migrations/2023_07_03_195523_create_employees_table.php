<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('foreign_name')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            //first tab personal information
            //general
            $table->text('father_name')->nullable();
            $table->text('mother_name')->nullable();
            $table->text('gender')->nullable();
            $table->text('nationality')->nullable();
            $table->text('birth_place')->nullable();
            $table->text('birth_date')->nullable();
            $table->text('blood_type')->nullable();
            $table->integer('id_card_no')->nullable();
            $table->text('id_card_issued_by')->nullable();
            $table->text('diagnostics')->nullable();
            $table->integer('registration_no')->nullable();
            $table->boolean('is_smoker')->nullable();
            $table->text('marital_status')->nullable();
            //family information
            $table->integer('children_no')->nullable();
            $table->text('partner_name')->nullable();
            $table->text('partner_work')->nullable();
            $table->text('father_work')->nullable();
            $table->text('mother_work')->nullable();
            //contact information
            $table->text('telephone')->nullable();
            $table->text('mobile1')->nullable();
            $table->text('mobile2')->nullable();
            $table->text('email')->nullable();
            $table->text('address')->nullable();
            $table->text('photo')->nullable();
            $table->text('notes')->nullable();
            //second tab certificates and skills
            //education
            $table->text('education_level')->nullable();
            $table->text('specialization')->nullable();
            $table->text('degree')->nullable();
            $table->text('issued_by')->nullable();
            $table->text('issued_date')->nullable();
            //other certificates
            $table->text('certificate1')->nullable();
            $table->text('date1')->nullable();
            $table->text('certificate2')->nullable();
            $table->text('date2')->nullable();
            $table->text('certificate3')->nullable();
            $table->text('date3')->nullable();
            //previous work
            $table->text('work')->nullable();
            $table->text('leave_reason')->nullable();
            $table->text('leave_date')->nullable();
            //skills
            $table->text('skill1')->nullable();
            $table->text('skill2')->nullable();
            $table->text('skill3')->nullable();
            $table->text('skill4')->nullable();
            $table->text('skill5')->nullable();
            $table->text('skill6')->nullable();
            //third tab identity cards
            //passport
      
            $table->text('passport_number')->nullable();
            $table->text('passport_issued_by')->nullable();
            $table->text('passport_issued_date')->nullable();
            $table->text('passport_expired_date')->nullable();
            //driver license
            $table->text('driver_license_number')->nullable();
            $table->text('driver_license_issued_by')->nullable();
            $table->text('driver_license_issued_date')->nullable();
            $table->text('driver_license_expired_date')->nullable();
            //residence
            $table->text('residence_number')->nullable();
            $table->text('residence_issued_by')->nullable();
            $table->text('residence_issued_date')->nullable();
            $table->text('residence_expired_date')->nullable();
            //health insurance
            $table->text('health_insurance_number')->nullable();
            $table->text('health_insurance_company')->nullable();
            $table->text('health_insurance_type')->nullable();
            $table->text('health_insurance_issued_by')->nullable();
            $table->text('health_insurance_issued_date')->nullable();
            //visa
            $table->text('visa_munber')->nullable();
            $table->text('visa_entry_port')->nullable();
            $table->text('visa_issued_by')->nullable();
            $table->boolean('is_root')->default(false);

            $table->text('visa_issued_date')->nullable();
            $table->text('visa_expired_date')->nullable();
            $table->text('visa_entry_date')->nullable();


            $table->string('flag')->nullable()->default('employee');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
