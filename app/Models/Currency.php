<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'foreign_name',
        'parity', // مكافئ
        'equivalent', // تعادل
        'proportion', // نسبة من 10 - 100 -1000
        'is_default',
        'part_name',
        'foreign_part_name',
        'is_currency_reminder_active',
        'decimal_places',
        'reminder_of_exchange_rates_changing_daily'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
      'is_currency_reminder_active' => 'boolean',
      'is_default'=>'boolean',
      'reminder_of_exchange_rates_changing_daily'=> 'boolean'
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'currency_id');
    }
    public function currencyActivities()
    {
      return $this->hasMany(CurrencyActivity::class, 'currency_id');
    }




    // public function journalEntries()
    // {
    //     return $this->hasMany(JournalEntry::class, 'currency_id');
    // }

}
