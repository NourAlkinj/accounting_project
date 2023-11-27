<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
  use HasFactory;

  protected $fillable = [
    'branch_id',
    'user_id',
    'table',
    'table_id',
    'table_name',
    'operation_ar',
    'operation_en',
    'description',
    'description_ar',
    'description_en',
    'mac',
    'pc_name',
    'old_data',

  ];
  protected $casts = [
    'old_data' => 'array',
  ];
}
