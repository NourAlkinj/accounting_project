<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherTemplatePermissionUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id' ,
        'voucher_permission_id',
        'voucher_template_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function voucherTemplate()
    {
        return $this->belongsTo(VoucherTemplate::class, 'voucher_template_id');
    }

    public function voucherPermission()
    {
        return $this->belongsTo(VoucherPermission::class, 'voucher_permission_id');
    }

}
