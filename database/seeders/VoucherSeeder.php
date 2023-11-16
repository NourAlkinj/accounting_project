<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{

    public function run()
    {
        $voucher1 = Voucher::create([
            'date' =>  '2020-4-4',
            'time' => "",
            'receipt_number' => "1",
            'currency_id' => 1,
            'account_id' => 1,
            'parity' => 1,
            'security_level' => 1,
            'debit_total' => 567,
            'credit_total' => 4567,
            'branch_id' => 1,
            'notes' => 'notes',
            'account_current_cash' => 23,
            'account_final_cash' => 0,
            'voucher_template_id' => 3

        ]);
        $voucher2 = Voucher::create([
          'date' =>  '2020-4-4',
            'time' => "",
            'receipt_number' => "2",
            'currency_id' => 1,
            'account_id' => 1,
            'parity' => 1,
            'security_level' => 2,
            'debit_total' => 0,
            'credit_total' => 0,
            'branch_id' => 2,
            'notes' => 'notes',
            'account_current_cash' => 0,
            'account_final_cash' => 0,
            'voucher_template_id' => 1

        ]);
        $voucher3 = Voucher::create([
          'date' =>  '2020-4-4',
            'time' => "",
            'receipt_number' => "3",
            'currency_id' => 1,
            'account_id' => 1,
            'parity' => 1,
            'security_level' => 3,
            'debit_total' =>0,
            'credit_total' => 0,
            'branch_id' => 2,
            'notes' => 'notes',
            'account_current_cash' =>0,
            'account_final_cash' => 0,
            'voucher_template_id' => 2


        ]);
    }
}
