<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillRecord extends Model
{
  use HasFactory;

  protected $fillable = [

    'store_id',
    'input_store_id',
    'gift_price',
    'index',
    'count',
    'total',
    'bill_price',

    'unit_price',
    'unit_id',
    'quantity',
    'net',
    'net_without_tax',
    'category_id',
    'item_id',
    'cost_center_id',

    'bill_id',
    'item_discount',
    'item_discount_ratio',
    'tax',
    'tax_ratio',
    'item_addition',
    'item_addition_ratio',
    'is_input',
    'is_output',
    'current_store_exist_quantity',
    'current_exist_quantity',
    'barcode',
    'production_date',
    'expired_date',
    'conversion_factor',
    'final_store_quantity',
    'final_quantity',

    'gift',
    'gift_unit_id',
    'gift_conversion_factor',

    'notes',
    'is_affects_cost_price',
    'is_discounts_affects_cost_price',
    'is_additions_affects_cost_price',
    'general_discount',
    'general_additions',

    'currency_id',
    'date',
    'parity',
    'storing_type',
    'security_level',


    'max_bill_quantity',
    'left_bill_quantity',




  ];

  public function bill()
  {
    return $this->belongsTo(Bill::class, 'bill_id');
  }

  public function CostCenter()
  {
    return $this->belongsTo(CostCenter::class, 'cost_center_id');
  }

  public function item()
  {
    return $this->belongsTo(Item::class, 'item_id');
  }

  public function store()
  {
    return $this->belongsTo(Store::class, 'cost_center_id');
  }

  public function category()
  {
    return $this->belongsTo(Category::class, 'cost_center_id');
  }

  public function serialNumberBillRecord()
  {
    return $this->hasMany(SerialNumberBillRecord::class, 'bill_record_id');
  }
//  public function serials()
//  {
//    return $this->hasMany(Serial::class, 'bill_record_id');
//  }


  protected $casts = [
    'is_input' => 'boolean',
    'is_output' => 'boolean',

    'is_returned' => 'boolean',


    'is_affects_cost_price' => 'boolean',
    'is_discounts_affects_cost_price' => 'boolean',
    'is_additions_affects_cost_price' => 'boolean',
  ];
}
