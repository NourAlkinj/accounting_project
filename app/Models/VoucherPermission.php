<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherPermission extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' ,
        'caption_ar',
        'caption_en'
    ];

}
