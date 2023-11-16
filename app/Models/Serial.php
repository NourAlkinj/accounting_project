<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serial extends Model
{
    use HasFactory;
    protected $fillable = [

        'code',
        'item_id',
        'serial_index',
        'manufacture_year',
        'color',
        'notes'
    ];
    public function Item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
  public function serialNumber()
  {
    return $this->belongsTo(SerialNumberBillRecord::class, 'serial_id');
  }
}
