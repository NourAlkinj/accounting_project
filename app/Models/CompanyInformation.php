<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInformation extends Model
{
    use HasFactory;
    protected $fillable=[
      'name' ,
       'foreign_name',
      'address',
      'work' ,
      'tel_1',
      'tel_2' ,
      'mobile' ,
      'fax' ,
      'email',
      'tax_number' ,
      'commercial_certificate',
      'manufactured_certificate',
      'notes',
      'image',
      'photo'
    ];

  public function image()
  {
    return $this->morphOne(Image::class, 'imageable');
  }
}
