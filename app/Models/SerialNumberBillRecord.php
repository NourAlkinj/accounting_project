<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialNumberBillRecord extends Model
{
  use HasFactory;

  protected $fillable = [
    'serial_id',
    'bill_record_id',
    'bill_id',
    'item_Id',
    'is_input',
    'is_output',
    'input_date',
    'output_date',
    'deleted_at'
  ];

  public function BillRecord()
  {
    return $this->belongsTo(BillRecord::class, 'bill_record_id');
  }

  public function ReturnedBillRecord()
  {
    return $this->belongsTo(ReturnedBillRecord::class, 'bill_record_id');
  }
  public function serial()
  {
    return $this->belongsTo(Serial::class, 'serial_id');
  }
}
