<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = [
        'unit_name',
        'unit_foreign_name',
        'is_default',
        'item_id',

        'prices',
        'unit_number',
        'relative_unit',
        'conversion_factor'

    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function barcodes()
    {
        return $this->hasMany(Barcode::class, 'unit_id');
    }
    public function units()
    {
        return $this->hasMany(Unit::class, 'unit_id');
    }

    protected $casts = [
//        'prices' => 'array',
      'prices' => 'json',
        'is_default'=>'boolean'
    ];
}
