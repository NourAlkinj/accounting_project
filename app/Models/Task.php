<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'employees_ids',
    'description',
    'color',
    'start_date',
    'start_time',
    'end_date',
    'end_time',
    'status_id',
    'attachments',
    'notes',
    'is_active',
    'priority',
    'supervisor_id',
    'remind_date',
    'remind_time',
    'remind_message',
    'is_terminated',
    'terminate_date',
    'terminate_reason',
    'font_color',
    'icon',
    'tags'
  ];


  public function employees()
  {
    return $this->belongsToMany(Employee::class, 'employee_tasks', 'task_id', 'employee_id');
  }

  public function status()
  {
    return $this->belongsTo(TaskState::class, 'status_id');
  }

  public function attachment()
  {

    return $this->morphMany(Attachment::class, 'attachmentable');

  }


  protected $casts = [
    'employees_ids' => 'array',
    'tags' => 'array'
    ,
    'attachments'=>'array'
  ];

}
