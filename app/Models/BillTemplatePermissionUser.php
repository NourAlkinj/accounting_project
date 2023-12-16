<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillTemplatePermissionUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bill_permission_id',
        'bill_template_id',

    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function billTemplate()
    {
        return $this->belongsTo(BillTemplate::class, 'bill_template_id');
    }

    public function billPermission()
    {
        return $this->belongsTo(BillPermission::class, 'bill_permission_id');
    }
}
