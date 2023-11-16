<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalEntry extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'date',
    'time',
    'receipt_number',
    'currency_id',
    'parity',
    'security_level',
    'debit_total',
    'credit_total',
    'branch_id',
    'notes',
    'source',
    // 'is_post_to_account'
    'is_post_to_account',
    'post_to_account_date',
  ];

  protected $attributes = [
    'source' => '{
            "source_name": "",
            "source_template_id": "",
            "source_id" : "",
            "has_source" : false
        }'
  ];

  protected $casts = [
    'source' => 'array',
    'is_post_to_account' => 'boolean'
  ];


  // public function JournalEntryRecords()
  // {
  //     return $this->hasMany(JournalEntryRecord::class, 'journal_entry_id');
  // }
  public function records()
  {
    return $this->hasMany(JournalEntryRecord::class, 'journal_entry_id');
  }

  public function branch()
  {
    return $this->belongsTo(Branch::class, 'branch_id')->select('id', 'code', 'name');
  }


  public function currency()
  {
    return $this->belongsTo(Currency::class, 'currency_id')->select('id', 'name');
  }
}
