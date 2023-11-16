<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntryPermissionUser extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'show_setting',
        'print_setting',
     ];
    protected $casts = [
        'show_setting' => 'array',
        'print_setting' => 'array',
    ];

    // public function journalEntry()
    // {
    //     return $this->belongsTo(JournalEntry::class, 'journal_entry_id');
    // }


    
    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }
}
