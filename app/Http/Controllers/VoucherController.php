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
    use CommonTrait, ActivityLog, VoucherRecordTrait, generateJournalEntryTrait;

    public $commonMessage;

    function __construct()
    {
        $this->commonMessage = new Translate(new CommonWords());
    }

    public function index()
    {

        $pagination = Voucher::with('branch', 'currency')->with('voucherTemplate')->select('id', 'branch_id', 'date', 'currency_id')->get();
        $data = ['pagination' => $pagination,];
        return response()->json([$data], 200);
    }

    public function vouchersAccordingToTemplate($id)
    {

        $pagination = Voucher::with('branch', 'currency', 'account')->where('voucher_template_id', '=', $id)->select('id', 'branch_id', 'date', 'currency_id', 'account_id')->get();

        $data = ['pagination' => $pagination,];
        return response()->json([$data], 200);
    }

    public function store(VoucherRequest $request)
    {
        try {
            $lang = $request->header('lang');
            $voucher = Voucher::create($request->all());
            $this->saveVoucherRecord($request, $voucher->id);

//      $this->generateJournalEntry($request, $voucher->id, $voucher->voucher_template_id);
            $this->generateJournalEntryFromVoucher($request, $voucher->id, $voucher->voucher_template_id);

            $result = $this->activityParameters($lang, 'store', 'voucher', $voucher, null);
            $parameters = $result['parameters'];
            $table = $result['table'];
            $this->callActivityMethod('store', $table, $parameters);
            return response()->json([

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

        $voucher = Voucher::with('records')->find($id);
        if ($voucher) {

            return $voucher;
        }
    }


    public function update(VoucherRequest $request, $id)
    {
        try {
            $lang = $request->header('lang');
            $old_data = Voucher::find($id)->toJson();

            $voucher = Voucher::find($id);
            $voucher->update($request->all()
//        [
//        'date' => $request['date'],
//        'time' => $request['time'],
//        'receipt_number' => $request['receipt_number'],
//        'currency_id' => $request['currency_id'],
//        'parity' => $request['parity'],
//        'security_level' => $request['security_level'],
//        'debit_total' => $request['debit_total'],
//        'credit_total' => $request['credit_total'],
//        'branch_id' => $request['branch_id'],
//        'notes' => $request['notes'],
//        'voucher_template_id' => $request['voucher_template_id'],
//      ]
            );
            $this->saveVoucherRecord($request, $voucher->id);
            $result = $this->activityParameters($lang, 'update', 'voucher', $voucher, $old_data);
            $parameters = $result['parameters'];
            $table = $result['table'];
            $this->callActivityMethod('update', $table, $parameters);
            return response()->json([
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
            $result = $this->activityParameters($lang, 'delete', 'voucher', $voucher, null);
            $parameters = $result['parameters'];
            $table = $result['table'];
            $this->callActivityMethod('delete', $table, $parameters);
            return response()->json(['message' =>
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
        $voucher = Voucher::find($id);
        $voucher_Records = $voucher->records;
        foreach ($voucher_Records as $voucher_Record) {
            $voucher_Record->forceDelete();
        }
        if (!$voucher) {
            $errors = ['message' => [
                $this->commonMessage->t(CommonWordsEnum::voucher_not_found->name, $lang),
      ]];
      return response()->json(['errors' => $errors], 404);
    }
        $voucher->forceDelete();
        $result = $this->activityParameters($lang, 'forceDelete', 'voucher', $voucher, null);
        $parameters = $result['parameters'];
        $table = $result['table'];
        $this->callActivityMethod('forceDelete', $table, $parameters);
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
            $result = $this->activityParameters($lang, 'restore', 'voucher', $voucher, null);
            $parameters = $result['parameters'];
            $table = $result['table'];
            $this->callActivityMethod('restore', $table, $parameters);
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
