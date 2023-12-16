<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillTemplatePermissionUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id' ,
        'voucher_permission_id',
        'voucher_template_id',

    ];
}
