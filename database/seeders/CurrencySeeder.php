<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{

    public function run()
    {
//        $normalCurrency1 = Currency::create([
//            'name' => 'ين ياباني',
//            'foreign_name' => 'Japanese Yen',
//            'code' => '¥',
//            'parity' => 1,
//            'equivalent' => 1,
//            'is_default' => true,
//            'proportion' => 10,
//            'part_name' => 'ين',
//            'foreign_part_name' => 'Yen',
//            'is_currency_reminder_active' =>true
//        ]);
///////////////////////////////////////////////test///////////////
      $Currency1 = Currency::create([
        'name' => 'دولار',
        'foreign_name' => 'dolar',
        'code' => '$',
        'parity' => 1,
        'equivalent' => 1,
        'is_default' => true
      ]);
      $Currency2 = Currency::create([
        'name' => 'ليرة',
        'foreign_name' => 'ssss',
        'code' => 'SP',
        'parity' => 13000,
        'equivalent' => 0.00007692307692307693,
        'is_default' => false
      ]);
      $Currency3 = Currency::create([
        'name' => 'درهم',
        'foreign_name' => 'UUU',
        'code' => 'UAE',
        'parity' => 10000,
        'equivalent' => 0.0001,
        'is_default' => false
      ]);
    }
}
