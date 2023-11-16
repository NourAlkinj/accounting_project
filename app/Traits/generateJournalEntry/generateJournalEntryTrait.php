<?php

namespace App\Traits\generateJournalEntry;

use App\Models\JournalEntry;
use App\Models\JournalEntryRecord;
use App\Models\Voucher;
use App\Models\VoucherTemplate;

trait  generateJournalEntryTrait
{


  public function generateJournalEntryFromVoucher($request, $source_id, $voucher_template_id) // افتتاحي
  {
    $source = [
      'source_id' => $source_id,
      'has_source' => true,
      'source_name' => 'voucher'
    ];
    $generatredJournalEntry = JournalEntry::create(
      [
        'date' => $request['date'],
        'time' => $request['time'],
        'receipt_number' => $request['receipt_number'],
        'currency_id' => $request['currency_id'],
        'account_id' => $request['account_id'],
        'parity' => $request['parity'],
        'security_level' => $request['security_level'],
        'debit_total' => $request['debit_total'],
        'credit_total' => $request['credit_total'],
        'branch_id' => $request['branch_id'],
        'notes' => $request['notes'],
        'is_post_to_account' => $request['is_post_to_account'],
        'source' => $source

      ]
    );
    $generatredJournalEntry['source'] = $source;
    $generatredJournalEntry->save();

    $voucher = Voucher::find($source_id);
    $voucher['generated_entry_id'] = $generatredJournalEntry->id;
    $voucher->save();


    $voucher_template = VoucherTemplate::find($voucher_template_id);


    // Entry
    if ($voucher_template['is_entry'] == true) {
      $this->generateJournalEntryRecordFromEntryVoucher($request, $generatredJournalEntry->id);
    }
    // Receipt
    if ($voucher_template['is_receipt'] == true) {
      $this->generateJournalEntryRecordFromReceiptVoucher($request, $generatredJournalEntry->id);

    }
    // Payment
    if ($voucher_template['is_payment'] == true) {
      $this->generateJournalEntryRecordFromPaymentVoucher($request, $generatredJournalEntry->id);
    }
    // Daily
    if ($voucher_template['is_daily'] == true) {
      $this->generateJournalEntryRecordFromDailyVoucher($request, $generatredJournalEntry->id);
    }
  }

  public function generateJournalEntryRecordFromEntryVoucher($request, $journal_entry_id)
  {
    $Journal_entry_records = $request->records;
    foreach ($Journal_entry_records as $Journal_entry_record) {
      $Journal_entry_record['journal_entry_id'] = $journal_entry_id;
      $new_journal_entry_record = JournalEntryRecord::create($Journal_entry_record);
      if ($Journal_entry_record['tax_account'] && $Journal_entry_record['tax_value']) {
        $tax_journal_entry_record = JournalEntryRecord::create($Journal_entry_record);
        $tax_journal_entry_record['credit'] = 0;
        $tax_journal_entry_record['debit'] = $Journal_entry_record['tax_value'];
        $acc_journal_entry_record = JournalEntryRecord::create($Journal_entry_record);
        $acc_journal_entry_record['debit'] = 0;
        $acc_journal_entry_record['credit'] = $Journal_entry_record['tax_value'];
        $acc_journal_entry_record['contra_account_id'] = $tax_journal_entry_record->id;
        $acc_journal_entry_record->save();
        $tax_journal_entry_record['contra_account_id'] = $acc_journal_entry_record->id;
        $tax_journal_entry_record->save();
      }
    }
  }


  public function generateJournalEntryRecordFromReceiptVoucher($request, $journal_entry_id)
  {
    $Journal_entry_records = $request->records;
    foreach ($Journal_entry_records as $Journal_entry_record) {
      $Journal_entry_record['journal_entry_id'] = $journal_entry_id;
      $new_journal_entry_record = JournalEntryRecord::create($Journal_entry_record);
      $new_journal_entry_record['contra_account_id'] = $request['account_id'];
      $new_journal_entry_record->save();
      $cash_journal_entry_record = JournalEntryRecord::create($Journal_entry_record);
      $cash_journal_entry_record['contra_account_id'] = $new_journal_entry_record->id;
      $cash_journal_entry_record['debit'] = $new_journal_entry_record['credit'];
      $cash_journal_entry_record['credit'] = 0;
      $cash_journal_entry_record->save();
      if ($Journal_entry_record['tax_account'] && $Journal_entry_record['tax_value']) {
        $this->taxCount($Journal_entry_record['tax_value'], $Journal_entry_record['credit'], null, $Journal_entry_record);
      }
    }
  }


  public function generateJournalEntryRecordFromPaymentVoucher($request, $journal_entry_id)
  {
    $Journal_entry_records = $request->records;
    foreach ($Journal_entry_records as $Journal_entry_record) {
      $Journal_entry_record['journal_entry_id'] = $journal_entry_id;
      $new_journal_entry_record = JournalEntryRecord::create($Journal_entry_record);
      $new_journal_entry_record['contra_account_id'] = $request['account_id'];
      $new_journal_entry_record->save();
      $cash_journal_entry_record = JournalEntryRecord::create($Journal_entry_record);
      $cash_journal_entry_record['contra_account_id'] = $new_journal_entry_record->id;
      $cash_journal_entry_record['credit'] = $new_journal_entry_record['debit'];
      $cash_journal_entry_record['debit'] = 0;
      $cash_journal_entry_record->save();
      if ($Journal_entry_record['tax_account'] && $Journal_entry_record['tax_value']) {
        $this->taxCount($Journal_entry_record['tax_value'], null, $Journal_entry_record['debit'], $Journal_entry_record);
      }
    }
  }


  public function generateJournalEntryRecordFromDailyVoucher($request, $journal_entry_id)
  {
    if ($request['credit']) {
      $this->generateJournalEntryRecordFromReceiptVoucher($request, $journal_entry_id);
    }
    if ($request['debit']) {
      $this->generateJournalEntryRecordFromPaymentVoucher($request, $journal_entry_id);
    }

  }


  public function taxCount($tax_value, $credit, $debit, $Journal_entry_record)
  {
    if ($credit) {
      $tax_journal_entry_record = JournalEntryRecord::create($Journal_entry_record);
      $tax_journal_entry_record['credit'] = 0;
      $tax_journal_entry_record['debit'] = $tax_value;
      $acc_journal_entry_record = JournalEntryRecord::create($Journal_entry_record);
      $acc_journal_entry_record['debit'] = 0;
      $acc_journal_entry_record['credit'] = $tax_value;
      $acc_journal_entry_record['contra_account_id'] = $tax_journal_entry_record->id;
      $acc_journal_entry_record->save();
      $tax_journal_entry_record['contra_account_id'] = $acc_journal_entry_record->id;
      $tax_journal_entry_record->save();
    }
    if ($debit) {
      $tax_journal_entry_record = JournalEntryRecord::create($Journal_entry_record);
      $tax_journal_entry_record['debit'] = 0;
      $tax_journal_entry_record['credit'] = $tax_value;
      $acc_journal_entry_record = JournalEntryRecord::create($Journal_entry_record);
      $acc_journal_entry_record['credit'] = 0;
      $acc_journal_entry_record['debit'] = $tax_value;
      $acc_journal_entry_record['contra_account_id'] = $tax_journal_entry_record->id;
      $acc_journal_entry_record->save();
      $tax_journal_entry_record['contra_account_id'] = $acc_journal_entry_record->id;
      $tax_journal_entry_record->save();
    }
  }


}
