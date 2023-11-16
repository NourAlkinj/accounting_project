<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskState extends Model
{
  use HasFactory;
  protected $fillable = [
    'name',
    'pattern',
    'color'
  ];

  public function tasks()
  {
    return $this->hasMany(Task::class, 'status_id');
  }
}
