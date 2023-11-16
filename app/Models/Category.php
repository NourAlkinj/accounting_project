<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'foreign_name',
        'category_id',
        // 'branch_id',
        'flag'
    ];
    protected $hidden = ['created_at', 'updated_at'];


    public function categories()
    {
        return $this->hasMany(Category::class, 'category_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->select('id', 'category_id', 'code', 'name', 'flag');
    }
    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'category_id')->with('children', 'items');
    }

    public function internalModels() //for child, only category into category
    {
        return $this->hasMany(Category::class, 'category_id')->with('internalModels')->select('id', 'name', 'code', 'category_id', 'flag');
    }
}
