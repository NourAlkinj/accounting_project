<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\CustomException;
use App\Http\Exceptions\NotFoundException;
use App\Http\Requests\BillRequest;
use App\Models\Bill;
use App\Models\BillRecord;
use App\Models\BillReturnedBill;
use App\Models\BillTemplate;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Bill\BillEquasionTrait;
use App\Traits\Bill\BillRecordTrait;
use App\Traits\Bill\SerialsTrait;
use App\Traits\Common\CommonTrait;
use Illuminate\Support\Facades\DB;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;


class BillController extends Controller
{

  use SerialsTrait, BillEquasionTrait, CommonTrait, ActivityLog, BillRecordTrait;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()
  {
    $parameters = ['id' => null];
    $pagination = Bill::with('branch', 'currency')->with('billTemplate')->select('id', 'branch_id', 'date', 'currency_id')->get();
    $this->callActivityMethod('bills', 'Get All bills (Index)', $parameters);
    $data = ['pagination' => $pagination,];
    return response()->json([$data], 200);
  }

  public function all()
  {
    $parameters = ['id' => null];
    $bills = Bill::with('records', 'branch', 'currency', 'account', 'store', 'costCenter')->get();
    // $bills = BillRecord::with('bill','item',   'store', 'category')->get();
    $this->callActivityMethod('bills', 'Get All bills (All) ', $parameters);
    return response()->json($bills, 200);
  }

  public function billsAccordingToTemplate($id)
  {
    $parameters = ['id' => null];
    $pagination = Bill::with('branch', 'currency', 'account')->where('bill_template_id', '=', $id)->select('id', 'branch_id', 'date', 'currency_id', 'account_id')->get();
    $this->callActivityMethod('bills', 'Get All bills According to Template', $parameters);
    $data = ['pagination' => $pagination,];
    return response()->json([$data], 200);
  }

  public function store(BillRequest $request)
  {
    $lang = $request->header('lang');


    try {
      if ($request['source_bill_id'] && !Bill::find($request['source_bill_id'])) {
        throw new NotFoundException('Bill');
      }
      // Returned Bill
      $bill = Bill::create($request->all());
      if ($request['source_bill_id']) {
        $source_bill_id = $request['source_bill_id'];
        $source_bill = Bill::find($source_bill_id);
        $source_bill->update(['has_returned_bill' => true]);
        $bill->update(['has_source' => true]);
        BillReturnedBill::create(
          [
            'bill_id' => $source_bill->id,
            'returned_bill_id' => $bill->id
          ]
        );
      }

      $template = BillTemplate::find($request['bill_template_id']);
      $records = $this->applyGeneralAdditionAndDiscountsOnRecords($bill, $request->records, $template);
      foreach ($records as $record) {
        $savedRecord = $bill->records()->create($record);
        $record['id'] = $savedRecord['id'];
        $this->saveSerialState($bill, $record);
      }
      foreach ($request->additions_and_discounts as $row) {
        $row['bill_id'] = $bill->id;
      }
      $bill->AdditionsAndDiscounts()->createMany([...$request->additions_and_discounts]);
      if ($template->is_generate_entry) {
        $this->generateJournalEntry($bill);
      }
      $parameters = ['request' => $request, 'id' => $bill->id];
      $this->callActivityMethod('bills', 'store', $parameters);
      $this->applyBillAffect($request->records, $request->storing_type);

      return response()->json([
        'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
      'id' => $bill->id
    ], 200);
  } catch (NotFoundException $exc) {
      return response()->json(
        [
          'errors' => ['message' => [$exc->message]]
        ],
        $exc->code
      );
    }

  }

  public function show($id)
  {
    $parameters = ['id' => $id];
    $bill = Bill::with('records', 'additionsAndDiscounts', 'bills')->find($id);
//    $bill = Bill::find($id)->records->serialNumberBillRecord;
    if ($bill) {
      $this->callActivityMethod('bills', 'show', $parameters);
      $bill->records->each(function ($record) {
        $record['serials'] = DB::table('serial_number_bill_records')
          ->join('serials', 'serial_number_bill_records.serial_id', '=', 'serials.id')
          ->where('serial_number_bill_records.bill_record_id', $record->id)
          ->select('serials.id', 'serials.code', 'serials.item_id', 'serials.serial_index', 'serials.manufacture_year',
            'serials.color', 'serials.notes')
          ->get();
      });
      return $bill;
    }
  }

  public function update(BillRequest $request, $id)
  {
    $lang = $request->header('lang');
    $old_data = Bill::find($id)->toJson();
    $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
    $bill = Bill::find($id);
    try {
      $this->reverseBillAffect($bill->records, $request->storing_type);
      $bill->update($request->all()
//        [
//        'date' => $request['date'],
//        'time' => $request['time'],
//        'receipt_number' => $request['receipt_number'],
//        'storing_type' => $request['storing_type'],
//        'currency_id' => $request['currency_id'],
//        'account_id' => $request['account_id'],
//        'parity' => $request['parity'],
//        'security_level' => $request['security_level'],
//        'client_id' => $request['client_id'],
//        'bill_price_id' => $request['bill_price_id'],
//        'branch_id' => $request['branch_id'],
//        'notes' => $request['notes'],
//        'cost_center_id' => $request['cost_center_id'],
//        'store_id' => $request['store_id'],
//        'input_store_id' => $request['input_store_id'],
//        'bill_template_id' => $request['bill_template_id'],
//        'discount_value' => $request['discount_value'],
//        'addition_value' => $request['addition_value'],
//        'best_choice_for_addition_discount' => $request['best_choice_for_addition_discount'],
//        'bill_value' => $request['bill_value'],
//        'first_pay' => $request['first_pay'],
//        'first_pay_rest' => $request['first_pay_rest'],
//        'is_input' => $request['is_input'],
//        'is_output' => $request['is_output'],
//        'total_item_addition' => $request['total_item_addition'],
//        'total_item_discount' => $request['total_item_discount'],
//        'total_items_net' => $request['total_items_net'],
//        'total_items' => $request['total_items'],
//        'items_account_id' => $request['items_account_id'],
//        'cash_account_id' => $request['cash_account_id'],
//        'payment_type' => $request['payment_type'],
//        'has_returned_bill' => $request['has_returned_bill']
//      ]
      );
      $this->saveBillRecord($request, $bill->id);
      $this->saveBillAdditionAndDiscount($request, $bill->id);
      $this->callActivityMethod('bills', 'update', $parameters);
      $this->applyBillAffect($request->records, $request->storing_type);
      //------------------OR----------------------//
      $returnedBills = $bill->bills;
      foreach ($returnedBills as $returnedBill) {
        $returnedBill->update(['source_bill_id' => null]);
      }
      // -------OR BY M-M TABLE --------------
      BillReturnedBill::where('bill_id', $id)->delete();

      return response()->json([

        'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
      'id' => $bill->id,
    ], 200);
  } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }

  public function delete($id)
  {
    $lang = app('request')->header('lang');
    $parameters = ['id' => $id];
    $bill = Bill::find($id);
    try {
      $bill_Records = $bill->records;
      foreach ($bill_Records as $bill_Record) {
        $bill_Record->delete();
      }
      if (!$bill) {
        $errors = [

          'message' => $this->commonMessage->t(CommonWordsEnum::bill_not_found->name, $lang)
        ];
      return response()->json(['errors' => $errors], 404);
    }
      $returnedBills = $bill->bills;
      foreach ($returnedBills as $returnedBill) {
        $returnedBill->update(['source_bill_id' => null]);
      }

      // -------OR BY M M TABLE --------------
      BillReturnedBill::where('bill_id', $id)->delete();
      $bill->delete();
      $this->callActivityMethod('bills', 'delete', $parameters);
      $this->reverseBillAffect($bill_Records, $bill->storing_type);
      return response()->json([

        'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)
       ], 200);
  } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }

  public function forceDelete($id)
  {
    $lang = app('request')->header('lang');
    $parameters = ['id' => $id];
    $bill = Bill::find($id);
    try {
      $bill_Records = $bill->records;
      foreach ($bill_Records as $bill_Record) {
        $bill_Record->forceDelete();
      }
      if (!$bill) {
        $errors = [
          'message' => $this->commonMessage->t(CommonWordsEnum::bill_not_found->name, $lang)
        ];
      return response()->json(['errors' => $errors], 404);
    }
      $returnedBills = $bill->returnedBills;
      foreach ($returnedBills as $returnedBill) {
        $returnedBill->update(['bill_id' => null]);
      }
      $bill->forceDelete();
      $this->callActivityMethod('bills', 'delete', $parameters);
      return response()->json([
//      'message' => __('common.delete'),
        'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang) ], 200);
  } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }

  public function restoreBillRecords($id)
  {
    $lang = app('request')->header('lang');

    $bill = Bill::withTrashed()->find($id);
    $bill_Records = BillRecord::withTrashed()->where('bill_id', $id);
    if ($bill && $bill_Records) {
      $bill->restore();
      $bill_Records->restore();
      return response()->json([
//        'message' => __('common.restore')
        'message' => $this->commonMessage->t(CommonWordsEnum::RESTORE->name, $lang)  ], 200);
    } else {
      return response()->json([
//        'message' => __('common.error_restore')
        'message' => $this->commonMessage->t(CommonWordsEnum::ERROR_RESTORE->name, $lang),
      ], 404);
    }
  }

  public function restoreAll()
  {
    Bill::onlyTrashed()->restore();
  }
}