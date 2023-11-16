<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
  use HasFactory, SoftDeletes;
  protected $fillable = [
    'date',
    'time',
    'receipt_number',
    'currency_id',
    'account_id',
    'parity',
    'security_level',
    'debit_total',
    'credit_total',
    'total_balance',
    'branch_id',
    'notes',
    'account_current_cash',
    'account_final_cash',
    'relative_account_current_cash',
    'relative_account_final_cash',
    'voucher_template_id',
    'generated_entry_id',
    'cost_center_id'
  ];


  public function records()
  {
    return $this->hasMany(VoucherRecord::class, 'voucher_id');
  }
  public function voucherTemplate()
  {
    return $this->belongsTo(VoucherTemplate::class, 'voucher_template_id');
  }

  public function branch()
  {
    return $this->belongsTo(Branch::class, 'branch_id')->select('id', 'code', 'name');
  }


  public function currency()
  {
    return $this->belongsTo(Currency::class, 'currency_id')->select('id', 'name');
  }

  public function account()
  {
    return $this->belongsTo(Account::class, 'account_id')->select('id', 'name');
  }
}
