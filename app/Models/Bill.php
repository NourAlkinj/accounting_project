<?php

namespace App\Models;

use App\Enums\billType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{

  use HasFactory, SoftDeletes;

  protected $fillable = [
    'input_store_id',
    'store_id',

    'storing_type',
    'bill_type',
    'date',
    'time',
    'receipt_number',
    'client_id',

    'currency_id',
    'account_id',
    'parity',
    'security_level',
    'bill_price_id',
    'branch_id',
    'cost_center_id',
    'bill_template_id',
    'notes',
    'discount_value',
    'addition_value',
    'best_choice_for_addition_discount',
    'bill_value',
    'first_pay',
    'first_pay_rest',

    'total_items',
    'total_item_addition',
    'total_item_discount',
    'total_items_net',
    'items_account_id',
    'cash_account_id',
    'payment_type',
    'has_returned_bill',
    'source_bill_id',
    'has_source',
    'is_input',
    'is_output',
    'max_quantity',
    'left_quantity',
  ];
  protected $casts = [
    'has_returned_bill' => 'boolean',
    'is_input' => 'boolean',
    'is_output' => 'boolean',
    'has_source' => 'boolean'
  ];


  // new
  public function bills()
  {
    return $this->hasMany(Bill::class, 'source_bill_id');
  }

  //

  public function records()
  {
    return $this->hasMany(BillRecord::class, 'bill_id');
  }

  public function billTemplate()
  {
    return $this->belongsTo(BillTemplate::class, 'bill_template_id')->select('id', 'name');
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

  public function store()
  {
    return $this->belongsTo(Store::class, 'store_id')->select('id', 'name');
  }

  public function costCenter()
  {
    return $this->belongsTo(Account::class, 'cost_center_id')->select('id', 'name');
  }

  public function additionsAndDiscounts()
  {
    return $this->hasMany(BillAdditionAndDiscount::class, 'bill_id');
  }

//  public function returnedBills()
//  {
//    return $this->belongsToMany(ReturnedBill::class, 'bill_returned_bills', 'bill_id', 'returned_bill_id');
//
//  }
}
