<?php

namespace Database\Seeders;

use App\Models\BillAdditionAndDiscount;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillAdditionAndDiscountSeeder extends Seeder
{

    public function run()
    {
        $bill_addition_and_discount1 =  BillAdditionAndDiscount::Create([
            'discount'  => 11.1,
            'discount_ratio'  => 11,
            'addition'  => 11,
            'addition_ratio'  => 11,
            'account_id'   => 1,
            'currency_id'  => 1,
            'bill_id' => 2,
            'parity'  => 21,
            'equivalent'  => 21,
            'cost_center_id' => 3
        ]);

        $bill_addition_and_discount2 =  BillAdditionAndDiscount::Create([
            'discount'  => 22.1,
            'discount_ratio'  => 22,
            'addition'  => 22,
            'addition_ratio'  => 22,
            'account_id'   => 1,
            'currency_id'  => 1,
            'parity'  => 5,
            'equivalent'  => 1,
            'cost_center_id' => 2,
            'bill_id' => 2,
        ]);
        $bill_addition_and_discount3 =  BillAdditionAndDiscount::Create([
            'discount'  => 33.1,
            'discount_ratio'  => 33,
            'addition'  => 33,
            'addition_ratio'  => 33,
            'account_id'   => 1,
            'currency_id'  => 1,
            'parity'  => 21,
            'equivalent'  => 44,
            'bill_id' => 2,
            'cost_center_id' => 1
        ]);
    }
}
