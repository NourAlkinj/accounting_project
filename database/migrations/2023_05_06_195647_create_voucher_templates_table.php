<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_templates', function (Blueprint $table) {
            $table->id();
            $table->string('abbreviation')->unique();
            $table->string('name')->unique();
            $table->integer('voucher_type')->default(0);
            $table->string('foreign_name')->default(null)->unique()->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_entry')->default(0);
            $table->boolean('is_receipt')->default(0);
            $table->boolean('is_payment')->default(0);
            $table->boolean('is_daily')->default(0);
            $table->unsignedBigInteger('account_id')->default(null)->nullable();
            $table->boolean('is_account_lock')->default(0);
            $table->unsignedBigInteger('branch_id')->default(null)->nullable();
            $table->boolean('is_branch_lock')->default(0);
            $table->boolean('is_branch_show')->default(0);
            $table->unsignedBigInteger('currency_id')->default(null)->nullable();
            $table->boolean('is_currency_lock')->default(0);
            $table->unsignedBigInteger('cost_center_id')->default(null)->nullable();
            $table->boolean('is_cost_center_lock')->default(0);
            $table->boolean('is_cost_center_show')->default(0);
            $table->date('date')->default(null)->nullable();
            $table->boolean('is_date_lock')->default(0);
            $table->boolean('is_date_show')->default(0);
            $table->time('time')->default(null)->nullable();
            $table->boolean('is_time_lock')->default(0);
            $table->boolean('is_time_show')->default(0);
            $table->string('notes')->default(null)->nullable();
            $table->boolean('is_accepts_distributive_accounts')->default(0);
            $table->boolean('is_generates_entry_for_each_item')->default(0);
            $table->boolean('is_auto_posting_to_accounts')->default(0);
            $table->boolean('is_print_duplicated_copy')->default(0);
            $table->boolean('is_enforce_cost_center')->default(0);
            $table->boolean('is_enforce_receipt_number')->default(0);


          $table->string('uses_vat_tax_system')->nullable();
          $table->string('uses_ttc_tax_system')->nullable();

//            $table->foreign('account_id')->references('id')->on('accounts');
//            $table->foreign('branch_id')->references('id')->on('branches');
//            $table->foreign('currency_id')->references('id')->on('currencies');
//            $table->foreign('cost_center_id')->references('id')->on('cost_centers');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('voucher_templates');
    }
};
