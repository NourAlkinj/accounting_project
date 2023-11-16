<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyActivity extends Model
{
    use HasFactory;
  protected $fillable = [
    'currency_id',
    'parity',
    'last_update_date'
  ];

  protected $hidden = ['created_at', 'updated_at'];

      public function currency()
      {
        return $this->belongsTo(Currency::class, 'currency_id');
      }
}
