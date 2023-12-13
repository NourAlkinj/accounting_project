<?php

namespace Database\Seeders;

use App\Models\CurrencyActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencyActivitySeeder extends Seeder
{

    public function run()
    {
      /////////////////////////////////////////////test///////////////

      $currencyActivity1 = CurrencyActivity::create([
        'currency_id'=>  1,
        'parity'=>  '1',
        'date'=>  '2020-1-1',
      ]);
      $currencyActivity2 = CurrencyActivity::create([
        'currency_id'=>  2,
        'parity'=>  '10000',
        'date'=>  '2020-1-3',
      ]);
      $currencyActivity3 = CurrencyActivity::create([
        'currency_id'=>  2,
        'parity'=>  '12000',
        'date'=>  '2020-1-5',
      ]);
      $currencyActivity4 = CurrencyActivity::create([
        'currency_id'=>  3,
        'parity'=>  '10000',
        'date'=>  '2020-1-7',
      ]);
      $currencyActivity5 = CurrencyActivity::create([
        'currency_id'=>  2,
        'parity'=>  '13000',
        'date'=>  '2020-1-9',
      ]);

    }
}
