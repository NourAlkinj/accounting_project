<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'foreign_name',
        'department_id',
        'branch_id',
        'notes',
        'flag',
        'is_root'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function departments()
    {
        return $this->hasMany(Department::class, 'department_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id')->with('department')->select('id',   'department_id');
    }
    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }
    public function children()
    {
        return $this->hasMany(Department::class, 'department_id')->with('children', 'employees');
    }

    public function internalModels()
    {
        return $this->hasMany(Department::class, 'department_id')->with('internalModels')->select('id', 'department_id', 'name', 'code' , 'flag');
    }
}
