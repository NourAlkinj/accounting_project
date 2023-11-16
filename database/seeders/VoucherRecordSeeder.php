<?php

namespace Database\Seeders;

use App\Models\VoucherRecord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherRecordSeeder extends Seeder
{

    public function run()
    {
        $voucherRecord1 = VoucherRecord::create([
            'index' => 1,
            'account_id' => 1,
            'debit' => 34.7,
            'credit' => 34.7,
            'relative_debit' => 34.7,
            'relative_credit' => 34.7,
            'notes' => 'notes',
            'cost_center_id' => 1,
            'currency_id' => 1,
            'parity' => 1,
            'equivalent' => 1,
            'contra_account_id' => 1,
            'current_balance' => 37,
            'final_balance' => 0,
            'voucher_id' => 1,
            'id2' => 1
        ]);
        $voucherRecord2 = VoucherRecord::create([
            'index' => 2,
            'account_id' => 1,
            'debit' => 34.7,
            'credit' => 34.7,
            'relative_debit' => 34.7,
            'relative_credit' => 34.7,
            'notes' => 'notes',
            'cost_center_id' => 1,
            'currency_id' => 1,
            'parity' => 1,
            'equivalent' => 1,
            'contra_account_id' => 1,
            'current_balance' => 37,
            'final_balance' => 0,
            'voucher_id' => 1,
            'id2' => 2
        ]);
        $voucherRecord3 = VoucherRecord::create([
            'index' => 3,
            'account_id' => 1,
            'debit' => 34.7,
            'credit' => 34.7,
            'relative_debit' => 34.7,
            'relative_credit' => 34.7,
            'notes' => 'notes',
            'cost_center_id' => 1,
            'currency_id' => 1,
            'parity' => 1,
            'equivalent' => 1,
            'contra_account_id' => 1,
            'current_balance' => 37,
            'final_balance' => 0,
            'voucher_id' => 1,
            'id2' => 3
        ]);
        $voucherRecord4 = VoucherRecord::create([
            'index' => 4,
            'account_id' => 1,
            'debit' => 34.7,
            'credit' => 34.7,
            'relative_debit' => 34.7,
            'relative_credit' => 34.7,
            'notes' => 'notes',
            'cost_center_id' => 1,
            'currency_id' => 1,
            'parity' => 1,
            'equivalent' => 1,
            'contra_account_id' => 1,
            'current_balance' => 37,
            'final_balance' => 0,
            'voucher_id' => 2,

            'id2' => 4




        ]);
        $voucherRecord5 = VoucherRecord::create([
            'index' => 5,
            'account_id' => 1,
            'debit' => 34.7,
            'credit' => 34.7,
            'relative_debit' => 34.7,
            'relative_credit' => 34.7,
            'notes' => 'notes',
            'cost_center_id' => 2,
            'currency_id' => 1,
            'parity' => 1,
            'equivalent' => 1,
            'contra_account_id' => 1,
            'current_balance' => 37,
            'final_balance' => 0,
            'voucher_id' => 2,
            'id2' => 5
        ]);
        $voucherRecord6 = VoucherRecord::create([
            'index' => 6,
            'account_id' => 1,
            'debit' => 34.7,
            'credit' => 34.7,
            'relative_debit' => 34.7,
            'relative_credit' => 34.7,
            'notes' => 'notes',
            'cost_center_id' => 1,
            'currency_id' => 1,
            'parity' => 1,
            'equivalent' => 1,
            'contra_account_id' => 1,
            'current_balance' => 37,
            'final_balance' => 0,
            'voucher_id' => 3,
            'id2' => 6
        ]);
    }
}
