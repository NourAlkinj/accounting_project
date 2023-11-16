<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'foreign_name',
        'card_type', //Normal=0,Assembly=1
        'store_id',
        'assembly_normal_ids',
        'address',
        'store_keeper',
        'storage_capacity',
        'is_normal',
        'is_assembly',
        'flag',
        'notes',
    ];
    protected $hidden =['created_at' , 'updated_at'];


    public function stores()
    {
        return $this->hasMany(Store::class, 'store_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public  function children()
    {
        return $this->hasMany(Store::class, 'store_id')->select('id', 'code', 'name', 'store_id')->with('children');
    }

    public function internalModels()
    {
        return $this->hasMany(Store::class, 'store_id')->with('internalModels')->select('id' ,'store_id','name','code');
    }

    protected $casts = [
        'assembly_normal_ids' => 'array'
    ];
}

