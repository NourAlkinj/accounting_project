<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table = "branches";

    protected $fillable = [
        'code',
        'name',
        'branch_id',
        'responsibility',
        'address',
        'website',
        'email',
        'phone',
        'mobile',
        'is_active',
        'foreign_name',
        'notes',
        'flag',
        'is_root'
    ];
    // protected $hidden =[ 'branch_id',];

    protected $casts = [
        'is_root' => 'boolean',
        'is_active' => 'boolean',
    ];



    public function branches()
    {
        return $this->hasMany(Branch::class, 'branch_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->with('branch')->select('id',   'branch_id');

        // return $this->belongsTo(Branch::class, 'branch_id')->select('id' ,  'branch_id');
    }
    public function children()
    {
        return $this->hasMany(Branch::class, 'branch_id')->with('children', 'users');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'branch_id');
    }
    public function internalModels() //for child, only branch into branch
    {
        return $this->hasMany(Branch::class, 'branch_id')->with('internalModels')->select('id', 'branch_id', 'name', 'code', 'is_active', 'flag');
    }

    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class, 'branch_id');
    }

 
}
