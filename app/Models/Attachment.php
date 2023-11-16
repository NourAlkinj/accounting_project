<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
  use HasFactory;


  protected $fillable = [
    'type',
    'file_name',
    'attachmentable_id',
    'attachmentable_type',
    'src',
    'extension' ,
    'title',
    'color'
  ];

  public function attachmentable()
  {
    return $this->morphTo();

  }
}
