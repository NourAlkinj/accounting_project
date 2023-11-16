<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherPermissionUser extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'show_setting',
        'print_setting',
        'voucher_template_id'
     ];
    protected $casts = [
        'show_setting' => 'array',
        'print_setting' => 'array',
    ];

   
    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }

    public function voucherTemplate()
    {
        return $this->belongsTo(VocherTemplate::class, 'voucher_template_id');
    }
}
