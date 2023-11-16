<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'foreign_name',
        'asset_group_id',
        'notes',

    ];
    protected $hidden =['created_at' , 'updated_at'];

}
