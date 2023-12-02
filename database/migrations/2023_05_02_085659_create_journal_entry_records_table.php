<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up()
  {
    Schema::create('journal_entry_records', function (Blueprint $table) {
      $table->id();
      $table->integer('index')->nullable();
      $table->string('date')->nullable();
      $table->unsignedBigInteger('account_id')->nullable();
      $table->double('credit')->nullable();
      $table->double('debit')->nullable();
      $table->double('relative_debit')->nullable();
      $table->double('relative_credit')->nullable();
      $table->string('notes')->nullable();
      $table->unsignedBigInteger('cost_center_id')->nullable();
      $table->unsignedBigInteger('currency_id')->nullable()->default(null);
      $table->integer('parity')->nullable()->default(null);
      $table->integer('today_parity')->nullable();
      $table->integer('equivalent')->nullable();
      $table->unsignedBigInteger('contra_account_id')->nullable();
      $table->unsignedBigInteger('journal_entry_id')->nullable();
      $table->double('current_balance')->nullable();
      $table->double('final_balance')->nullable();
      $table->boolean('is_post_to_account')->nullable();
      $table->string('post_to_account_date')->nullable();

      $table->integer('relative_final_balance')->nullable();
      $table->integer('relative_current_balance')->nullable();
      $table->string('source_name')->nullable();
      $table->integer('source_template_id')->nullable();
      $table->integer('source_id')->nullable();





      $table->integer('branch_id')->nullable()->default(null);
      $table->integer('user_id')->nullable()->default(null);
      $table->integer('client_id')->nullable()->default(null);
      $table->integer('item_id')->nullable()->default(null);
      $table->integer('employee_id')->nullable()->default(null);
      $table->integer('asset_id')->nullable()->default(null);
      $table->integer('category_id')->nullable()->default(null);

//      $table->string('branch_name')->nullable()->computed('select name from branches where id = branch_id');
//
//      $table->string('user_name')->nullable()->computed('select name from users where id = user_id');
//      $table->string('client_name')->nullable()->computed('select name from clients where id = client_id');
//      $table->string('contra_account_name')->nullable()->computed('select name from accounts where id = contra_account_id');
//      $table->string('employee_name')->nullable()->computed('select name from employees where id = employee_id');
//      $table->string('asset_name')->nullable()->computed('select name from assets where id = asset_id');
//      $table->string('cost_center_name')->nullable()->computed('select name from cost_centers where id = cost_center_id');
//      $table->string('item_name')->nullable()->computed('select name from items where id = item_id');
//      $table->string('category_name')->nullable()->computed('select name from categories where id = category_id');



      $table->softDeletes();
      $table->timestamps();
    });
  }


  public function down()
  {
    Schema::dropIfExists('journal_entry_records');
  }
};
