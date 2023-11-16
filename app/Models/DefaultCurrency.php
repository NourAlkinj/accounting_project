<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultCurrency extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'code_ar',
        'code_en',
        'foreign_name',
        'proportion',
        'part_name_ar',
        'part_name_en',
        'foreign_part_name',
        'parity',
        'equivalent',
    ];
}
