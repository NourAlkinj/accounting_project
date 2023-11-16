<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillAdditionAndDiscount extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'addition_index',
        'discount',
        'discount_ratio',
        'addition',
        'addition_ratio',
        'account_id',
        'currency_id',
        'parity',
        'equivalent',
        'cost_center_id',
        'bill_id'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }
}
