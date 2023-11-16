<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [

        'source_id',
        'title',
        'message',
        'type',
        'attachment',
        'priority',
        'send_date',
        'seen_date',
        'seen',

        'from_user_id',
        'to_user_id',
        'to_employee_id'

    ];

    protected $casts = [
        'attachment' => 'json',
        'seen' => 'boolean'
    ];

}
