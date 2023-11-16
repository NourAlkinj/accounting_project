<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('foreign_name')->unique()->default(null)->nullable();
            $table->unsignedBigInteger('asset_group_id')->default(null)->nullable();

            $table->string('size')->default(null)->nullable();
            $table->string('model')->default(null)->nullable();
            $table->string('weight')->default(null)->nullable();
            $table->string('chasseh_no')->default(null)->nullable();
            $table->string('country_of')->default(null)->nullable();
            $table->string('color')->default(null)->nullable();
            $table->string('barcode')->default(null)->nullable();
            $table->string('photo')->default(null)->nullable();
            $table->string('notes')->default(null)->nullable();
            $table->boolean('is_serial_number')->default(0);
            $table->boolean('is_multi_quantities')->default(0);

            $table->date('manufac_date')->default(null)->nullable();
            $table->string('contract_no')->default(null)->nullable();
            $table->string('customs')->default(null)->nullable();
            $table->string('shipment_no')->default(null)->nullable();
            $table->string('shipment_method')->default(null)->nullable();
            $table->string('import_license_no')->default(null)->nullable();
            $table->string('arrival_place')->default(null)->nullable();
            $table->string('warranty_no')->default(null)->nullable();
            $table->date('receipt_date')->default(null)->nullable();

            $table->date('purchase_date')->default(null)->nullable();
            $table->date('contract_date')->default(null)->nullable();
            $table->date('customs_declaration')->default(null)->nullable();
            $table->date('shipment_date')->default(null)->nullable();
            $table->date('arrival_date')->default(null)->nullable();
            $table->date('warranty_begining')->default(null)->nullable();
            $table->date('warranty_ending')->default(null)->nullable();


            $table->boolean('is_not_subject_to_reappraisal')->default(0);
            $table->boolean('is_not_subject_to_depreciation')->default(0);
            $table->integer('depreciation_method')->default(0);
            $table->float('default_age_value')->default(0.0);
            $table->integer('default_age')->default(0);
            $table->integer('annual_depreciation')->default(0);
            $table->date('begining_data_of')->default(null)->nullable();
            $table->integer('scrap_value')->default(0);


            $table->unsignedBigInteger('asset_account_id')->default(null)->nullable();
            $table->unsignedBigInteger('depreciation_account_id')->default(null)->nullable();
            $table->unsignedBigInteger('accumulated_account_id')->default(null)->nullable();
            $table->unsignedBigInteger('expenses_account_id')->default(null)->nullable();
            $table->unsignedBigInteger('captial_gains_account_id')->default(null)->nullable();
            $table->unsignedBigInteger('captial_losses_account_id')->default(null)->nullable();
            $table->unsignedBigInteger('surplus_of_reappraisal_account_id')->default(null)->nullable();
            $table->unsignedBigInteger('deficit_of_reappraisal_account_id')->default(null)->nullable();


            $table->foreign('asset_account_id')->references('id')->on('accounts');
            $table->foreign('depreciation_account_id')->references('id')->on('accounts');
            $table->foreign('accumulated_account_id')->references('id')->on('accounts');
            $table->foreign('expenses_account_id')->references('id')->on('accounts');
            $table->foreign('captial_gains_account_id')->references('id')->on('accounts');
            $table->foreign('captial_losses_account_id')->references('id')->on('accounts');
            $table->foreign('surplus_of_reappraisal_account_id')->references('id')->on('accounts');
            $table->foreign('deficit_of_reappraisal_account_id')->references('id')->on('accounts');
            $table->foreign('asset_group_id')->references('id')->on('asset_groups');

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('assets');
    }
};
