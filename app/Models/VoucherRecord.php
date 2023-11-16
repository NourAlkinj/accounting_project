<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherRecord extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'index',
        'account_id',
        'debit',
        'credit',
        'relative_debit',
        'relative_credit',
        'credit',
        'notes',
        'cost_center_id',
        'currency_id',
        'parity',
        'today_parity',
        'equivalent',
        'contra_account_id',
        'current_balance',
        'final_balance',
        'voucher_id',
        'is_post_to_account',
        'post_to_account_date',

        'id2', // for update function
        'relative_current_balance',
        'relative_final_balance',

        'tax_account',
        'tax_ratio' ,
        'tax_value'

    ];
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
    public function CostCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }

}
