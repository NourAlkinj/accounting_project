<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;
    protected $fillable = [
        'barcode_name',
        'item_id',
        'unit_id',
        'notes'
    ];

    protected $hidden = ['created_at', 'updated_at'];

   protected $casts = [
        'name' => 'array'
    ];
}
