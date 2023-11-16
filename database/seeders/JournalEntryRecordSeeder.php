<?php

namespace Database\Seeders;

use App\Models\JournalEntryRecord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JournalEntryRecordSeeder extends Seeder
{

  public function run()
  {
//      $JournalEntryRecord1 = JournalEntryRecord::create([
//        'index' => 1,
//        'account_id' => 1,
//        'debit' => 432,
//        'credit' => 432,
//        'relative_debit' => 432,
//        'relative_credit' => 432,
//        'notes' => 'notes',
//        'cost_center_id' => 1,
//        'currency_id' => 1,
//        'parity' => '1',
//        'equivalent' => '1',
//        'contra_account_id' => 1,
//        'current_balance' => 345,
//        'final_balance' => 45,
//        'journal_entry_id' => 1,
//        'is_post_to_account' => true,
//        'post_to_account_date'=>45,
//        'relative_final_balance'=>4.5,
//        'relative_current_balance'=>34.7
//      ]);
//      $JournalEntryRecord2 = JournalEntryRecord::create([
//        'index' => 2,
//        'account_id' => 1,
//        'debit' => 432,
//        'credit' => 432,
//        'relative_debit' => 432,
//        'relative_credit' => 432,
//        'notes' => 'notes',
//        'cost_center_id' => 1,
//        'currency_id' => 1,
//        'parity' => '1',
//        'equivalent' => '1',
//        'contra_account_id' => 1,
//        'current_balance' => 345,
//        'final_balance' => 45,
//        'journal_entry_id' => 1,
//        'is_post_to_account' => true,
//        'post_to_account_date'=>45,
//        'relative_final_balance'=>4.5,
//        'relative_current_balance'=>34.7
//      ]);
//      $JournalEntryRecord3 = JournalEntryRecord::create([
//        'index' => 3,
//        'account_id' => 1,
//        'debit' => 432,
//        'credit' => 432,
//        'relative_debit' => 432,
//        'relative_credit' => 432,
//        'notes' => 'notes',
//        'cost_center_id' => 1,
//        'currency_id' => 1,
//        'parity' => '1',
//        'equivalent' => '1',
//        'contra_account_id' => 1,
//        'current_balance' => 345,
//        'final_balance' => 45,
//        'journal_entry_id' => 1,
//        'is_post_to_account' => true,
//        'post_to_account_date'=>45,
//        'relative_final_balance'=>4.5,
//        'relative_current_balance'=>34.7
//      ]);
//      $JournalEntryRecord4 = JournalEntryRecord::create([
//        'index' => 4,
//        'account_id' => 1,
//        'debit' => 432,
//        'credit' => 432,
//        'relative_debit' => 432,
//        'relative_credit' => 432,
//        'notes' => 'notes',
//        'cost_center_id' => 1,
//        'currency_id' => 1,
//        'parity' => '1',
//        'equivalent' => '1',
//        'contra_account_id' => 1,
//        'current_balance' => 345,
//        'final_balance' => 45,
//        'journal_entry_id' => 2,
//        'is_post_to_account' => true,
//        'post_to_account_date'=>45,
//        'relative_final_balance'=>4.5,
//        'relative_current_balance'=>34.7
//      ]);
//      $JournalEntryRecord5 = JournalEntryRecord::create([
//        'index' => 5,
//        'account_id' => 1,
//        'debit' => 432,
//        'credit' => 432,
//        'relative_debit' => 432,
//        'relative_credit' => 432,
//        'notes' => 'notes',
//        'cost_center_id' => 2,
//        'currency_id' => 1,
//        'parity' => '1',
//        'equivalent' => '1',
//        'contra_account_id' => 1,
//        'current_balance' => 345,
//        'final_balance' => 45,
//        'journal_entry_id' => 2,
//        'is_post_to_account' => true,
//        'post_to_account_date'=>45,
//        'relative_final_balance'=>4.5,
//        'relative_current_balance'=>34.7
//      ]);
//      $JournalEntryRecord6 = JournalEntryRecord::create([
//        'index' => 6,
//        'account_id' => 1,
//        'debit' => 432,
//        'credit' => 432,
//        'relative_debit' => 432,
//        'relative_credit' => 432,
//
//        'notes' => 'notes',
//        'cost_center_id' => 1,
//        'currency_id' => 1,
//        'parity' => '1',
//        'equivalent' => '1',
//        'contra_account_id' => 1,
//        'current_balance' => 345,
//        'final_balance' => 45,
//        'journal_entry_id' => 1,
//        'is_post_to_account' => true,
//        'post_to_account_date'=>45,
//        'relative_final_balance'=>4.5,
//        'relative_current_balance'=>34.7
//      ]);


    /////////////////////////////////////////////////////////test///////////

    $JournalEntryRecord1 = JournalEntryRecord::create([
      'currency_id' => 1,
      'parity' => '1',
      'debit' => 5000,
      'date' => '2020-1-1',
      'journal_entry_id' => 1,
      'account_id' => 1,
      'credit' => 5000,
      'cost_center_id' => 1,
      'is_post_to_account' => 1,
      'source_name' => 'Bill',
      'source_id' => 1,


    ]);
    $JournalEntryRecord2 = JournalEntryRecord::create([
      'currency_id' => 1,
      'parity' => '1',
      'debit' => 5000,
      'date' => '2020-1-2',
      'journal_entry_id' => 1,
      'account_id' => 1,
      'credit' => 5000,
      'cost_center_id' => 1,
      'is_post_to_account' => 1,
      'source_name' => 'Bill',
      'source_id' => 2,


    ]);
    $JournalEntryRecord3 = JournalEntryRecord::create([
      'currency_id' => 2,
      'parity' => '7000',
      'debit' => 5,
      'date' => '2020-1-3',
      'journal_entry_id' => 1,
      'account_id' => 1,
      'credit' => 5,
      'cost_center_id' => 1,
      'is_post_to_account' => 1,
      'source_name' => 'Voucher',
      'source_id' => 1,

    ]);
    $JournalEntryRecord4 = JournalEntryRecord::create([
      'currency_id' => 1,
      'parity' => '1',
      'debit' => 10000,
      'date' => '2020-1-3',
      'journal_entry_id' => 1,
      'account_id' => 1,
      'credit' => 10000,
      'cost_center_id' => 1,
      'is_post_to_account' => 1,
      'source_name' => 'Voucher',
      'source_id' => 4,


    ]);
    $JournalEntryRecord5 = JournalEntryRecord::create([
      'currency_id' => 2,
      'parity' => '10000',
      'debit' => 10,
      'date' => '2020-1-4',
      'journal_entry_id' => 1,
      'account_id' => 1,
      'credit' => 10,
      'cost_center_id' => 1,
      'is_post_to_account' => 1,
      'source_name' => 'Bill',
      'source_id' => 1,

    ]);
    $JournalEntryRecord6 = JournalEntryRecord::create([
      'currency_id' => 2,
      'parity' => '12000',
      'debit' => 10,
      'date' => '2020-1-5',
      'journal_entry_id' => 1,
      'account_id' => 1,
      'credit' => 10,
      'final_balance' => 123,
      'cost_center_id' => 1,
      'is_post_to_account' => 1,
      'source_name' => 'Bill',
      'source_id' => 3,
    ]);
    $JournalEntryRecord7 = JournalEntryRecord::create([
      'currency_id' => 2,
      'parity' => '13000',
      'debit' => 5,
      'date' => '2020-1-6',
      'journal_entry_id' => 1,
      'account_id' => 1,
      'final_balance' => 123,
      'credit' => 5,
      'cost_center_id' => 1,
      'is_post_to_account' => 1,
      'source_name' => 'Bill',
      'source_id' => 4,
    ]);
    $JournalEntryRecord8 = JournalEntryRecord::create([
      'currency_id' => 2,
      'parity' => '13000',
      'debit' => 10,
      'date' => '2020-1-7',
      'journal_entry_id' => 1,
      'final_balance' => 123,
      'account_id' => 1,
      'credit' => 10,
      'cost_center_id' => 1,
      'is_post_to_account' => 1,
      'source_name' => 'Bill',
      'source_id' => 1,
    ]);
    $JournalEntryRecord8 = JournalEntryRecord::create([
      'currency_id' => 2,
      'parity' => '12000',
      'debit' => 10,
      'date' => '2020-1-8',
      'final_balance' => 123,
      'journal_entry_id' => 1,
      'account_id' => 1,
      'credit' => 10,
      'cost_center_id' => 1,
      'is_post_to_account' => 1,
      'source_name' => 'Voucher',
      'source_id' => 1,
    ]);
    $JournalEntryRecord9 = JournalEntryRecord::create([
      'currency_id' => 3,
      'parity' => '10000',
      'debit' => 7,
      'date' => '2020-1-9',
      'journal_entry_id' => 1,
      'account_id' => 1,
      'credit' => 7,
      'cost_center_id' => 1,
      'is_post_to_account' => 1,
      'source_name' => 'Bill',
      'source_id' => 2,
    ]);


    /////////////////////////////////////////////////////////test///////////
  }
}
