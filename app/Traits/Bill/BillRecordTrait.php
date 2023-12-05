<?php

namespace App\Traits\Bill;


use App\Http\Requests\BillRequest;
use App\Models\Bill;
use App\Models\BillAdditionAndDiscount;
use App\Models\BillPermissionUser;
use App\Models\BillRecord;
use App\Models\JournalEntry;
use App\Models\JournalEntryRecord;
use App\Models\Serial;
use App\Models\SerialNumberBillRecord;
use App\Models\User;
use Illuminate\Database\QueryException;
use App\Traits\Quantity\QuantityTrait;
use Illuminate\Support\Facades\DB;


trait  BillRecordTrait
{

  use QuantityTrait;


  public function getAllReturnedBills()
  {
    return Bill::where('has_returned_bill', false)->get();
  }

  public function getBillReturnedBills($id)
  {
    return Bill::find($id)->bills;
  }


  public function getCurrentStoreExistQuantity($item_id, $store_id)
  {
    return DB::table('quantities')->where('item_id', $item_id)->where('store_id', $store_id)->sum('quantity');
  }

  public function getCurrentExistQuantity($item_id)
  {
    return DB::table('quantities')->where('item_id', $item_id)->sum('quantity');
  }





    public function updateBillRecord(BillRequest $request, $bill_id)
    {
        $bill = Bill::find($bill_id);
        $bill_Recordss = $bill->records->toArray();
        $records_in_request = $request->records;
        $recordsToCreate = array_diff(array_column($records_in_request, 'index'), array_column($bill_Recordss, 'index'));
        foreach ($recordsToCreate as $record) {
            $recordData = $request->records[array_search($record, array_column($request->records, 'index'))];
            $recordData['bill_id'] = $bill_id;
            BillRecord::create($recordData);
        }
        $recordsToDelete = array_diff(array_column($bill_Recordss, 'index'), array_column($records_in_request, 'index'));
        foreach ($recordsToDelete as $record) {
            $record = BillRecord::where('bill_id', $bill_id)->where('index', $record)->first();
            $record->forceDelete();
        }
        $recordsToUpdate = array_intersect(array_column($records_in_request, 'index'), array_column($bill_Recordss, 'index'));
        foreach ($recordsToUpdate as $record) {
            $recordData = $request->records[array_search($record, array_column($request->records, 'index'))];
            $record = BillRecord::where('bill_id', $bill_id)->where('index', $record)->first();
            $record->update($recordData);
        }
    }
  
  
  
  
  
  
  public function saveBillRecord(BillRequest $request, $bill_id)
  {
    $bill_records = Bill::find($bill_id)->records;
    if ($bill_records) {
      foreach ($bill_records as $bill_record) {
        $bill_record->forceDelete();
      }
    }
    foreach ($request->records as $bill_record) {

      $bill_record['bill_id'] = $bill_id;
      $bill_record['parity'] = $request['parity'];
      $bill_record['date'] = $request['date'];
      $bill_record['currency_id'] = $request['currency_id'];
      $bill_record['security_level'] = $request['security_level'];

      $new_bill_record = BillRecord::create(
        $bill_record
      );
      if (array_key_exists('serials', $bill_record)) {
        $this->saveBillRecordSerials($request, $bill_record['serials'], $new_bill_record['item_id'], $new_bill_record->id, $bill_id);
      }
    }
  }

  public function saveBillRecordSerials(BillRequest $request, $Serials, $item_id, $bill_record_id, $bill_id)
  {
    $serials_ids = [];

    $bill_record = BillRecord::find($bill_record_id);
    if ($bill_record) {
      if ($bill_record->serialNumberBillRecord) {
        foreach ($bill_record->serialNumberBillRecord as $serialNumberBillRecord) {
          $serials_ids[] = $serialNumberBillRecord->serial_id;
          Serial::where('id', $serials_ids)->delete();
          SerialNumberBillRecord::where('serial_id', $serials_ids)
            ->where('bill_record_id', $bill_record_id)
            ->where('item_Id', $item_id)
            ->where('bill_id', $bill_id)
            ->delete();
        }
      }
    }

    if ($request->storing_type == 'OUT') {
      foreach ($Serials as $serial) {
        $serial['item_id'] = $item_id;
        $serial = Serial::create($serial
        );
        SerialNumberBillRecord::create([
          'serial_id' => $serial->id,
          'bill_record_id' => $bill_record_id,
          'bill_id' => $bill_id,
          'item_Id' => $item_id,
          'is_input' => false,
          'is_output' => true,
          'input_date' => null,
          'output_date' => $request['date']
        ]);
      }
    }
    if ($request->storing_type == 'IN') {
      foreach ($Serials as $serial) {
        $serial['item_id'] = $item_id;
        $serial = Serial::create($serial
        );
        SerialNumberBillRecord::create([
          'serial_id' => $serial->id,
          'bill_record_id' => $bill_record_id,
          'bill_id' => $bill_id,
          'item_Id' => $item_id,
          'is_input' => true,
          'is_output' => false,
          'input_date' => $request['date'],
          'output_date' => null
        ]);
      }
    }
    if ($request->storing_type == 'EXCHANGE') {
      foreach ($Serials as $serial) {
        $serial['item_id'] = $item_id;
        $serial = Serial::create($serial
        );
      }
    }
  }


  public function saveBillAdditionAndDiscount(BillRequest $request, $bill_id)
  {
    $bill_additions_and_discounts = Bill::find($bill_id)->additionsAndDiscounts;
    if ($bill_additions_and_discounts) {
      foreach ($bill_additions_and_discounts as $bill_addition_and_discount) {
        $bill_addition_and_discount->forceDelete();
      }
    }

    foreach ($request->additions_and_discounts as $bill_addition_and_discount) {
      $bill_addition_and_discount['bill_id'] = $bill_id;
      BillAdditionAndDiscount::create(
        $bill_addition_and_discount

      );
    }
  }


  public function userBillOptions($bill_template_id)
  {
    $id = auth('sanctum')->user()->id;
    return BillPermissionUser::where('user_id', $id)->where('bill_template_id', $bill_template_id)->get();
  }


  public function setBillPermissionUser($bill_template_id)
  {
    $show_setting = [];
    $print_setting = [];


    $users = User::all();
    foreach ($users as $user) {
      BillPermissionUser::create(
        [
          'show_setting' => $show_setting,
          'print_setting' => $print_setting,
          'user_id' => $user->id,
          'bill_template_id' => $bill_template_id
        ]
      );
    }
  }


  public function generateJournalEntry($request)
  {

    $source = [
      'source_id' => $request['id'],
      'source_template_id' => $request['bill_template_id'],
      'has_source' => true,
      'source_name' => 'bill'
    ];
    $journalEntry = JournalEntry::create([
      'source' => $source,
      'branch_id' => $request['branch_id']
    ]);

    $this->generateJournalEntryRecords($request, $journalEntry->id);

    return $journalEntry->id;
  }

  public function generateJournalEntryRecords($request, $journal_entry_id)
  {
    if ($request['bill_type'] == 'sales') { // 0 sales

      JournalEntryRecord::create([
        'account_id' => $request['cash_account_id'],
        'debit' => $request['total_items'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['items_account_id'],
        'credit' => $request['total_items'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['cash_account_id'],
        'credit' => $request['discount_value'],
        'journal_entry_id' => $journal_entry_id
      ]);

      JournalEntryRecord::create([
        'account_id' => $request['discount_account_id'],
        'debit' => $request['discount_value'],
        'journal_entry_id' => $journal_entry_id
      ]);

      JournalEntryRecord::create([
        'account_id' => $request['addition_account_id'],
        'credit' => $request['addition_value'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['cash_account_id'],
        'debit' => $request['addition_value'],
        'journal_entry_id' => $journal_entry_id
      ]);


      foreach ($request->additionsAndDiscounts as $r) {
        if ($r['discount']) {
          JournalEntryRecord::create([
            'account_id' => $r['account_id'],
            'debit' => $r['discount'],
            'journal_entry_id' => $journal_entry_id
          ]);
          JournalEntryRecord::create([
            'contra_account_id' => $request['cash_account_id'],
            'credit' => $r['discount'],
            'journal_entry_id' => $journal_entry_id
          ]);
        }
        if ($r['addition']) {
          JournalEntryRecord::create([
            'account_id' => $r['account_id'],
            'credit' => $r['addition'],
            'journal_entry_id' => $journal_entry_id
          ]);
          JournalEntryRecord::create([
            'contra_account_id' => $request['cash_account_id'],
            'debit' => $r['addition'],
            'journal_entry_id' => $journal_entry_id
          ]);
        }
      }
    }


    if ($request['bill_type'] == 'purchases') { // purchases
      JournalEntryRecord::create([
        'account_id' => $request['cash_account_id'],
        'credit' => $request['total_items'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['items_account_id'],
        'debit' => $request['total_items'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['discount_account_id'],
        'credit' => $request['discount_value'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['cash_account_id'],
        'debit' => $request['discount_value'],
        'journal_entry_id' => $journal_entry_id
      ]);

      JournalEntryRecord::create([
        'account_id' => $request['addition_account_id'],
        'debit' => $request['addition_value'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['cash_account_id'],
        'credit' => $request['addition_value'],
        'journal_entry_id' => $journal_entry_id
      ]);
      foreach ($request->additionsAndDiscounts as $r) {
        if ($r['discount']) {
          JournalEntryRecord::create([
            'account_id' => $r['account_id'],
            'credit' => $r['discount'],
            'journal_entry_id' => $journal_entry_id
          ]);
          JournalEntryRecord::create([
            'contra_account_id' => $request['cash_account_id'],
            'debit' => $r['discount'],
            'journal_entry_id' => $journal_entry_id
          ]);
        }
        if ($r['addition']) {
          JournalEntryRecord::create([
            'account_id' => $r['account_id'],
            'debit' => $r['addition'],
            'journal_entry_id' => $journal_entry_id
          ]);
          JournalEntryRecord::create([
            'contra_account_id' => $request['cash_account_id'],
            'credit' => $r['addition'],
            'journal_entry_id' => $journal_entry_id
          ]);
        }
      }
    }


    if ($request['bill_type'] == 'exchange') { // 3 exchange

      JournalEntryRecord::create([
        'account_id' => $request['cash_account_id'],
        'debit' => $request['total_items'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['items_account_id'],
        'credit' => $request['total_items'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['cash_account_id'],
        'credit' => $request['discount_value'],
        'journal_entry_id' => $journal_entry_id
      ]);

      JournalEntryRecord::create([
        'account_id' => $request['discount_account_id'],
        'debit' => $request['discount_value'],
        'journal_entry_id' => $journal_entry_id
      ]);

      JournalEntryRecord::create([
        'account_id' => $request['addition_account_id'],
        'credit' => $request['addition_value'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['cash_account_id'],
        'debit' => $request['addition_value'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['cash_account_id'],
        'credit' => $request['total_items'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['items_account_id'],
        'debit' => $request['total_items'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['discount_account_id'],
        'credit' => $request['discount_value'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['cash_account_id'],
        'debit' => $request['discount_value'],
        'journal_entry_id' => $journal_entry_id
      ]);

      JournalEntryRecord::create([
        'account_id' => $request['addition_account_id'],
        'debit' => $request['addition_value'],
        'journal_entry_id' => $journal_entry_id
      ]);
      JournalEntryRecord::create([
        'account_id' => $request['cash_account_id'],
        'credit' => $request['addition_value'],
        'journal_entry_id' => $journal_entry_id
      ]);

    }
  }




  public function getRecordsWithMaxQuantities($bill_id)
  {
    $bill = Bill::with('additionsAndDiscounts')->find($bill_id);

    $source = count($this->getLatestReturnedBill($bill_id)) > 0 ? array_map(function ($record) {
      $record['quantity'] = $record['left_bill_quantity'];
      return $record;
    }, $this->getLatestReturnedBill($bill_id)) :
      $bill->records;
    $result = [];

    for ($i = 0; $i < count($source); $i++) {
      $r = $source[$i];
      $r['max_bill_quantity'] = $r['quantity'];
      $result[$i] = $r;
    }

    $bill->records = $result;

    return $bill;
  }


  public function getLatestReturnedBill($bill_id)
  {
    try {
      $returned_bills = Bill::with('bills.records')->find($bill_id)->bills;

      if ($returned_bills->isNotEmpty()) {
        $latest_returned_bill = $returned_bills->last();
        return optional($latest_returned_bill->records)->toArray() ?? [];
      } else {
        return [];
      }
    } catch (QueryException $exc) {
      return [];
    }
  }















  // Go To Cost Trait
//  public function getCost($item_id  , $currency_id , $store_id = null)
//  {
////    $item_id = $request->item_id;
////    $store_id = $request->store_id;
////    $currency_id = $request->currency_id;
//
//    if ($store_id != null) {
//      $records = BillRecord::where('item_id', $item_id)->where('store_id', $store_id)->where('is_affects_cost_price', true)->get();
//    } else {
//      $records = BillRecord::where('item_id', $item_id)->where('is_affects_cost_price', true)->get();
//    }
//    $addition = 0;
//    $discount = 0;
//    $total = 0;
//    $quantity_conversion_factor = 0;
//    $gift_quantity_conversion_factor = 0;
//    foreach ($records as $record) {
//      if ($record['is_discounts_affects_cost_price'] && $record['is_additions_affects_cost_price']) {
//        $addition += $record['item_addition'] + $record['general_additions'];
//        $discount += $record['item_discount'] + $record['general_discount'];
//      }
////      $bill = Bill::where('id', $record['bill_id'])->first();
//      $user = auth('sanctum')->user();
//      if ($record['storing_type'] == 'IN' && $record['security_level'] <= $user['security_level']) {
//        $total += $record['quantity'] * $record['conversion_factor'] * $record['cost_price'];
//        $quantity_conversion_factor += $record['quantity'] * $record['conversion_factor'];
//        $gift_quantity_conversion_factor += $record['gift_quantity'] * $record['gift_conversion_factor'];
//      }
//      if ($currency_id == $record['currency_id']) {
//        $record_result = $total - $discount + $addition;
//      } elseif ($currency_id == $this->getDefaultCurrencyID()) {
//        $record_result = ($total - $discount + $addition) * $record['parity'];
//      } else {
//        $record_result = ($total - $discount + $addition) * ($record['parity'] / $this->logParity($currency_id, $record['date']));
//      }
//    }
//
//    $sumQuantity = $quantity_conversion_factor + $gift_quantity_conversion_factor;
//    return $record_result / $sumQuantity;
//  }
//

//  public function getDefaultCurrencyID()
//  {
//    $defaultCurrency = Currency::where('is_default', true)->first();
//    return $defaultCurrency->id;
//  }


}
