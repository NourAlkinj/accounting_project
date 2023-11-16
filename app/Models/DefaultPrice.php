<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'caption_ar',
        'caption_en',
        'type'
    ];
}
