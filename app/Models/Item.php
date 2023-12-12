<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        // Basic Information
        'code',
        'name',
        'foreign_name',
        'category_id',
        'location',
        'manuf_company',
        'country_of_origin',
        'source',
        'caliber',
        'chemical_composition',
        'weight',
        'size',
        'item_type',
        'photo',
        'notes',
        'flag',
        'currency_id',
        'parity',

        'auto_discount_on_salse',
        'added_value_tax',
        'auto_counting_for_prices',


        'expired_date',
        'serial_number',
        'production_date',
        'should_alert',
        'days_before_alert',

        'unit'
    ];

    public function setUnitsAttribute($value)
    {
        $this->attributes['units'] = json_encode($value);
    }

    public function getUnitsAttribute($value)
    {
        return json_decode($value, true);
    }

    protected $hidden = ['created_at', 'updated_at'];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->select('id', 'category_id', 'code', 'name', 'flag');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'item_id');
    }

    public function quantities()
    {
        return $this->hasMany(Quantity::class, 'item_id');
    }

    public function serials()
    {
        return $this->hasMany(Serial::class, 'item_id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    protected $casts = [
        'auto_counting_for_prices' => 'boolean',
        'expired_date' => 'boolean',
        'serial_number' => 'boolean',
        'production_date' => 'boolean',
        'should_alert' => 'boolean',
        'unit' => 'array',
    ];
}
