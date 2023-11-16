<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillReturnedBill extends Model
{
    use HasFactory;
    protected $fillable =[
        'bill_id',
        'returned_bill_id'
    ];
}
