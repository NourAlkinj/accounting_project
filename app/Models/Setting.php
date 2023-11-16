<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

  protected $fillable = [
    'settings',
    'user_id'
  ];

  public function user()
  {
    return $this->belongsToMany(User::class, 'user_settings' , 'user_id' , 'setting_id');
  }
  protected $hidden =['created_at' , 'updated_at'];

  protected $casts = [
    'settings' => 'array'
  ];
}
