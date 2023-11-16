<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
      'settings',
      'name'
  ];

  protected $hidden =['created_at' , 'updated_at'];

  public function image()
  {
    return $this->morphOne(Image::class, 'imageable');
  }

  protected $casts = [
    'settings' => 'array'
  ];
}
