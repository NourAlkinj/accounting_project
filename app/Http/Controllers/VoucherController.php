<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\CustomException;
use App\Http\Requests\VoucherRequest;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use App\Traits\generateJournalEntry\generateJournalEntryTrait;
use App\Traits\Voucher\VoucherRecordTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class VoucherController extends Controller
{
  use CommonTrait, ActivityLog, VoucherRecordTrait , generateJournalEntryTrait;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()
  {
    $parameters = ['id' => null];
    $pagination = Voucher::with('branch', 'currency')->with('voucherTemplate')->select('id', 'branch_id', 'date', 'currency_id')->get();
    $this->callActivityMethod('vouchers', 'Get All Vouchers ', $parameters);
    $data = ['pagination' => $pagination,];
    return response()->json([$data], 200);
  }

  public function vouchersAccordingToTemplate($id)
  {
    $parameters = ['id' => null];
    $pagination = Voucher::with('branch', 'currency', 'account')->where('voucher_template_id', '=', $id)->select('id', 'branch_id', 'date', 'currency_id', 'account_id')->get();
    $this->callActivityMethod('vouchers', 'Get All Vouchers According to Template', $parameters);
    $data = ['pagination' => $pagination,];
    return response()->json([$data], 200);
  }

  public function store(VoucherRequest $request)
  {
    try {
      $lang = $request->header('lang');
      $voucher = Voucher::create([
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
        'account_final_cash' => $request['account_final_cash'],
        'account_current_cash' => $request['account_current_cash'],
        'voucher_template_id' => $request['voucher_template_id'],
      ]);
      $this->saveVoucherRecord($request, $voucher->id);

//      $this->generateJournalEntry($request, $voucher->id, $voucher->voucher_template_id);
      $this->generateJournalEntryFromVoucher($request, $voucher->id, $voucher->voucher_template_id);

      $parameters = ['request' => $request, 'id' => $voucher->id];
      $this->callActivityMethod('vouchers', 'store', $parameters);
      return response()->json([
//      'message' => __('common.store'), 'type' => 'Success',
        'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),

      'id' => $voucher->id,
    ], 200);
  } catch (CustomException $exc) {
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
    $voucher = Voucher::with('records')->find($id);
    if ($voucher) {
      $this->callActivityMethod('vouchers', 'show', $parameters);
      return $voucher;
    }
  }


  public function update(VoucherRequest $request, $id)
  {
    try {
      $lang = $request->header('lang');
      $old_data = Voucher::find($id)->toJson();
      $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
      $voucher = Voucher::find($id);
      $voucher->update([
        'date' => $request['date'],
        'time' => $request['time'],
        'receipt_number' => $request['receipt_number'],
        'currency_id' => $request['currency_id'],
        'parity' => $request['parity'],
        'security_level' => $request['security_level'],
        'debit_total' => $request['debit_total'],
        'credit_total' => $request['credit_total'],
        'branch_id' => $request['branch_id'],
        'notes' => $request['notes'],
        'voucher_template_id' => $request['voucher_template_id'],
      ]);
      $this->saveVoucherRecord($request, $voucher->id);
      $this->callActivityMethod('vouchers', 'update', $parameters);
      return response()->json([
//      'message' => __('common.update'), 'type' => 'Success',
        'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),

      'id' => $voucher->id,

    ], 200);
  } catch (CustomException $exc) {
      return response()->json(
        [
          'errors' => ['message' => [$exc->message]]
        ],
        $exc->code
      );
    }
  }

  public function delete($id)
  {
    try {
      $lang = app('request')->header('lang');
      $parameters = ['id' => $id];
      $voucher = Voucher::find($id);
      $voucher_Records = $voucher->records;
      foreach ($voucher_Records as $voucher_Record) {
        $voucher_Record->delete();
      }
      if (!$voucher) {
        $errors = ['message' => [__("voucher.voucher_not_found")]];
        return response()->json(['errors' => $errors], 404);
      }
      $voucher->delete();
      $this->callActivityMethod('vouchers', 'delete', $parameters);
      return response()->json(['message' =>
//      __('common.delete')
        $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)

      ], 200);
  } catch (CustomException $exc) {
      return response()->json(
        [
          'errors' => ['message' => [$exc->message]]
        ],
        $exc->code
      );
    }
  }


  public function forceDelete($id)
  {
    $lang = app('request')->header('lang');
    $parameters = ['id' => $id];
    $voucher = Voucher::find($id);
    $voucher_Records = $voucher->records;
    foreach ($voucher_Records as $voucher_Record) {
      $voucher_Record->forceDelete();
    }
    if (!$voucher) {
      $errors = ['message' => [
//        __("voucher.voucher_not_found")
        $this->commonMessage->t(CommonWordsEnum::voucher_not_found->name, $lang),

      ]];
      return response()->json(['errors' => $errors], 404);
    }
    $voucher->forceDelete();
    $this->callActivityMethod('vouchers', 'delete', $parameters);
    return response()->json(['message' =>
      $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)
      , 'type' => 'Success',], 200);
  }

  public function restoreVoucherRecords($id)
  {
    $lang = app('request')->header('lang');
    $voucher = Voucher::withTrashed()->find($id);
    $voucher_Records = VoucherRecord::withTrashed()->where('voucher_id', $id);
    if ($voucher && $voucher_Records) {
      $voucher->restore();
      $voucher_Records->restore();
      return response()->json(['message' => __('common.restore')], 200);
    } else {
      return response()->json(['message' => __('common.error_restore')], 404);
    }
  }

  public function restoreAll()
  {
    Voucher::onlyTrashed()->restore();
  }
}