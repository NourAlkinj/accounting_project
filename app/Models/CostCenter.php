<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'foreign_name',
        'card_type',
        'is_normal',
        'is_assembly',
        'cost_center_id',
        'assembly_normal_ids',
        'balance',
        'credit',
        'debit',
        'flag',
        'notes',
    ];
    protected $hidden =['created_at' , 'updated_at'];

    public function costCenters()
    {
        return $this->hasMany(CostCenter::class, 'cost_center_id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }

    public function children()
    {
        return $this->hasMany(CostCenter::class, 'cost_center_id')
            ->with('children')
            ->select('id', 'name', 'code', 'cost_center_id');
    }

    public function internalModels()
    {
        return $this->hasMany(CostCenter::class, 'cost_center_id')->with('internalModels')->select('id' ,'name','code','cost_center_id');
    }


    protected $casts = [
        'assembly_normal_ids' => 'array'
    ];

}
