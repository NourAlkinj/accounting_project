<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalEntryRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'index',
        'account_id',
        'debit',
        'credit',
        'relative_debit',
        'relative_credit',
        'is_exchange',
        'notes',
//    'cost_center_id',
        'currency_id',
        'parity',
        'today_parity',
        'equivalent',
        'contra_account_id',
        'current_balance',
        'final_balance',
        'journal_entry_id',
        'is_post_to_account',
        'post_to_account_date',
        'relative_final_balance',
        'relative_current_balance',
        'date',
        'time',

        'source_name',
        'source_template_id',
        'source_id',
        'has_source',


        'branch_id',

        'user_id',
        'client_id',
//    'contra_account_id',
        'employee_id',
        'asset_id',
        'cost_center_id',
        'item_id',
        'category_id',

        'branch_name',
        'user_name',
        'client_name',
        'contra_account_name',
        'employee_name',
        'asset_name',
        'cost_center_name',
        'item_name',
        'category_name',


    ];

    protected $casts = [
        'is_post_to_account' => 'boolean',


    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function contraAccount()
    {
        return $this->belongsTo(Account::class, 'contra_account_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntry::class, 'journal_entry_id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }
}
