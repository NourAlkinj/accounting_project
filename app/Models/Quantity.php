<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
  use HasFactory;

  protected $fillable = [
    'store_id',
    'item_id',
    'quantity'
  ];

  public function item()
  {
    return $this->belongsTo(Item::class, 'item_id');
  }

  public function store()
  {
    return $this->belongsTo(Store::class, 'store_id');
  }


}
