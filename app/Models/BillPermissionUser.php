<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillPermissionUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'show_setting',
        'print_setting',
        'bill_template_id'
    ];
    protected $casts = [
        'show_setting' => 'json',
        'print_setting' => 'json',
    ];


    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }

    public function billTemplate()
    {
        return $this->belongsTo(BillTemplate::class, 'bill_template_id');
    }
}
