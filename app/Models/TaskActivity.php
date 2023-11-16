<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskActivity extends Model
{
  use HasFactory;
  protected $fillable = [

    'task_id',
    'old_employee_ids',
    'new_employee_ids',
    'old_task_status_id',
    'new_task_status_id',
    'operation'
  ];

  public function tasks()
  {
    return $this->hasMany(Task::class, 'task_id');
  }

  protected $casts = [
    'old_employee_ids' => 'array',
    'new_employee_ids' => 'array',

];
}
