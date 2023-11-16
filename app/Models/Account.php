<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
  use HasFactory;

  protected $fillable = [

    //.... Main Information...........
    'code',
    'name',
    'foreign_name',
    'card_type',
    'flag',


    //.... Basic Information...........
    'account_id', //for normal
    'result_account_id', //for final //this final account related to other final account

    'final_account_id', //this normal account related to other final account

    'currency_id', //عملة

    'parity', // تكافؤ
    'notes', //ملاحظات
    'ratio',
    'amount',
    'is_warning_when_pass_max_limit',

    // Account type
    'is_credit', // دائن
    'is_debit', // مدين
    'is_both',

    // MaxLimit
    'is_max_limit_credit', // دائن
    'is_max_limit_debit', // مدين
    'is_max_limit_both',

    'assembly_normal_ids',      //مصفوفة تضم الحسابات العادية ضمن هذا الحساب التجميعي
    'distributive_normal_ids', //مصفوفة تضم الحسابات العادية ضمن هذا الحساب التوزيعي

    //Normal=0,Assembly=1,distributive=2,final=3
    'is_client', // عميل ؟
    'is_normal', // عادي
    'is_distributive', // توزيعي ؟
    'is_final', // ختامي ؟
    'is_assembly', // تجميعي ؟



    'tax_account_id',
    'tax_ratio' ,
    'enable_tax',
    'fixed_tax'

  ];
  protected $hidden = ['created_at', 'updated_at'];

  protected $casts = [
    'assembly_normal_ids' => 'array',
    'distributive_normal_ids' => 'array',
    'is_client' => 'boolean', // عميل ؟
    'is_normal' => 'boolean', // عادي
    'is_distributive' => 'boolean', // توزيعي ؟
    'is_final' => 'boolean', // ختامي ؟
    'is_assembly' => 'boolean', // تجميعي ؟
    'is_warning_when_pass_max_limit' => 'boolean',
    // Account type
    'is_credit' => 'boolean', // دائن
    'is_debit' => 'boolean', // مدين
    'is_both' => 'boolean',
    // MaxLimit
    'is_max_limit_credit' => 'boolean', // دائن
    'is_max_limit_debit' => 'boolean', // مدين
    'is_max_limit_both' => 'boolean',

    'enable_tax' => 'boolean',
    'fixed_tax' => 'boolean'

  ];


  public function normalAccounts()
  {
    return $this->hasMany(Account::class, 'account_id');
  }

  public function normalAccount()
  {
    return $this->belongsTo(Account::class, 'account_id');
  }

  public function finalAccounts()
  {
    return $this->hasMany(Account::class, 'result_account_id');
  }

  public function finalAccount()
  {
    return $this->belongsTo(Account::class, 'result_account_id');
  }

  public function normalAccountsTree()
  {
    return $this->hasMany(Account::class, 'account_id')
      ->where('is_normal', true)
      ->select('id', 'name', 'code', 'account_id', 'is_client', 'final_account_id', 'currency_id')
      ->with('normalAccountsTree');
  }

  public function finalAccountsTree()
  {
    return $this->hasMany(Account::class, 'result_account_id')
      ->select('id', 'name', 'code', 'result_account_id', 'is_client', 'final_account_id', 'currency_id')
      ->with('finalAccountsTree')
      ->where('is_final', true);
  }

  public function finalNormalAccounts()
  {
    return $this->hasMany(Account::class, 'final_account_id');
  }

  public function finalNormalAccount()
  {
    return $this->belongsTo(Account::class, 'final_account_id');
  }

  public function internalModels() //for autoComplete for normal
  {
    return $this->hasMany(Account::class, 'account_id')->with('internalModels')->select('id', 'account_id', 'name', 'code');
  }

  public function internalModelsForFinal() //for autoComplete for final
  {
    return $this->hasMany(Account::class, 'result_account_id')->with('internalModelsForFinal')->select('id', 'result_account_id', 'name', 'code');
  }

  public function client()
  {
    return $this->hasOne(Client::class, 'account_id');
  }

  public function currency()
  {
    return $this->belongsTo(Currency::class, 'currency_id');
  }
}
