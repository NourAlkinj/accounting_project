<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherTemplate extends Model
{
  use HasFactory;

  protected $fillable = [
    'abbreviation',
    'name',
    'voucher_type', //entry=0,receipt=1,payment=2,daily=3
    'is_entry',
    'is_receipt',
    'is_payment',
    'is_daily',
    'foreign_name',
    'is_active',
    'account_id',
    'is_account_lock',
    'branch_id',
    'is_branch_lock',
    'is_branch_show',
    'currency_id',
    'is_currency_lock',
    'cost_center_id',
    'is_cost_center_lock',
    'is_cost_center_show',
    'date',
    'is_date_lock',
    'is_date_show',
    'time',
    'is_time_lock',
    'is_time_show',
    'notes',
    'is_accepts_distributive_accounts',
    'is_generates_entry_for_each_item',
    'is_auto_posting_to_accounts',
    'is_print_duplicated_copy',
    'is_enforce_cost_center',
    'is_enforce_receipt_number',
    'uses_vat_tax_system',
    'uses_ttc_tax_system'
  ];
  protected $hidden = ['created_at', 'updated_at'];
  protected $casts = [
    'is_active' => 'boolean',
    'is_entry' => 'boolean',
    'is_receipt' => 'boolean',
    'is_payment' => 'boolean',
    'is_daily' => 'boolean',
    'is_account_lock' => 'boolean',
    'is_branch_lock' => 'boolean',
    'is_branch_show' => 'boolean',
    'is_enforce_receipt_number' => 'boolean',
    'is_enforce_cost_center' => 'boolean',
    'is_print_duplicated_copy' => 'boolean',
    'is_auto_posting_to_accounts' => 'boolean',
    'is_generates_entry_for_each_item' => 'boolean',
    'is_accepts_distributive_accounts' => 'boolean',
    'is_time_show' => 'boolean',
    'is_time_lock' => 'boolean',
    'is_date_show' => 'boolean',
    'is_date_lock' => 'boolean',
    'is_cost_center_show' => 'boolean',
    'is_cost_center_lock' => 'boolean',
    'is_currency_lock' => 'boolean',
    'uses_vat_tax_system' => 'boolean',
    'uses_ttc_tax_system'=> 'boolean'

  ];


  public function vouchers()
  {
    return $this->hasMany(Voucher::class, 'voucher_template_id');
  }


    public function voucherTemplatePermissionUser()
    {
        return $this->hasMany(VoucherTemplatePermissionUser::class, 'voucher_template_id');
    }


  // public function voucherPermissions()
  // {
  //     return $this->hasMany(VoucherPermissionUser::class, 'voucher_template_id');
  // }

}
