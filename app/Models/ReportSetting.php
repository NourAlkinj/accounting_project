<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSetting extends Model
{
  use HasFactory;

  protected $fillable = [
    'settings',
    'user_id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  protected $hidden = ['created_at', 'updated_at'];

  protected $casts = [
    'settings' => 'array'
  ];
}
