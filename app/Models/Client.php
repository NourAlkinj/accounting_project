<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'code',
            'name',
            'foreign_name',
            'photo',
            'discount_ratio',
            'discount_account_id',
            'account_id', // ورقة
            'notes_client',
            'price_id',
            'payment',//0:Cash, 1: Oncredit
            'is_customer',
            'is_vendor',
            'is_both_client',

            //personal information
            'gender', //0:male, 1: female
            'nationality', // الجنسية
            'work',
            'birth_place',
            'birthday' ,
            'record_date',

            //Other information
            'address',
            'zip_code', //  رمز البريد الإلكتروني
            'phone',
            'mobile',
            'fax',
            'email',
        ];

    protected $hidden =['created_at' , 'updated_at'];

    public function account()
    {
        return $this->hasOne(Account::class, 'account_id');
    }

}
