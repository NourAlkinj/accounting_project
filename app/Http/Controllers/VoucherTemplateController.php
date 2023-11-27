<?php

namespace App\Http\Controllers;

use App\Events\VoucherTemplatesUpdated;
use App\Http\Requests\StoreVoucherTemplateRequest;
use App\Http\Requests\UpdateVoucherTemplateRequest;
use App\Models\Voucher;
use App\Models\VoucherPermissionUser;
use App\Models\VoucherTemplate;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use App\Traits\Voucher\VoucherRecordTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class VoucherTemplateController extends Controller
{
  use  ActivityLog, CommonTrait, VoucherRecordTrait;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function all()
  {
    $parameters = ['id' => null];
    $this->callActivityMethod('voucher_templates', 'index', $parameters);
    $voucherTemplates = VoucherTemplate::all();
    return $voucherTemplates;
  }

  public function index()
  {

    $entryVoucherTemplate = VoucherTemplate::where('is_entry', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
    $receiptVoucherTemplate = VoucherTemplate::where('is_receipt', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
    $paymentVoucherTemplate = VoucherTemplate::where('is_payment', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
    $dailyVoucherTemplate = VoucherTemplate::where('is_daily', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();

    $dataTree = ['entryVoucherTemplate' => $entryVoucherTemplate, 'receiptVoucherTemplate' => $receiptVoucherTemplate, 'paymentVoucherTemplate' => $paymentVoucherTemplate, 'dailyVoucherTemplate' => $dailyVoucherTemplate];
    return response()->json($dataTree, 200);
  }

  public function store(StoreVoucherTemplateRequest $request)
  {
    $lang = $request->header('lang');
    $voucherTemplate = VoucherTemplate::create($request->all());

    $this->validateVoucherType($voucherTemplate->id, VoucherTemplate::class, $request);
    $this->setVoucherPermissionUser($voucherTemplate->id);

    $result = $this->activityParameters($lang, 'store', 'voucherTemplate', $voucherTemplate, 'pc_name', null);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('store', $table, $parameters);

    event(new VoucherTemplatesUpdated([...VoucherTemplate::all()]));
    return response()->json([

      'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
            'id' => $voucherTemplate->id,
            'voucher_type' => $voucherTemplate->voucher_type,
        ], 200);
    }

  public function show($id)
  {

    $voucherTemplate = VoucherTemplate::find($id);

    return response()->json($voucherTemplate, 200);
  }

  public function update(UpdateVoucherTemplateRequest $request, $id)
  {
    $lang = $request->header('lang');
    $old_data = VoucherTemplate::find($id)->toJson();

    $voucherTemplate = VoucherTemplate::find($id);

    $voucherTemplate->update($request->all());
    $result = $this->activityParameters($lang, 'update', 'voucherTemplate', $voucherTemplate, 'pc_name', $old_data);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('update', $table, $parameters);
    event(new VoucherTemplatesUpdated([...VoucherTemplate::all()]));
    return response()->json([
      'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
            'id' => $voucherTemplate->id,
            'voucher_type' => $voucherTemplate->voucher_type,
        ], 200);
    }

  public function delete($id)
  {
    $lang = app('request')->header('lang');;

    $voucherTemplate = VoucherTemplate::find($id);
    if ($this->isUseVoucherTemplate($id)) {
      $errors = ['voucherTemplate' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }
    $voucherTemplate->delete();
    $result = $this->activityParameters($lang, 'delete', 'voucherTemplate', $voucherTemplate, 'pc_name', null);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('delete', $table, $parameters);
    event(new VoucherTemplatesUpdated([...VoucherTemplate::all()]));
    return response()->json(['message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)], 200);
    }

  public function navTree()
  {

    $entryVoucherTemplate = VoucherTemplate::where('is_entry', true)->where('is_active', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
    $recieptVoucherTemplate = VoucherTemplate::where('is_receipt', true)->where('is_active', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
    $paymentVoucherTemplate = VoucherTemplate::where('is_payment', true)->where('is_active', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
    $dailyVoucherTemplate = VoucherTemplate::where('is_daily', true)->where('is_active', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();

    $dataTree = ['entryVoucherTemplate' => $entryVoucherTemplate, 'recieptVoucherTemplate' => $recieptVoucherTemplate, 'paymentVoucherTemplate' => $paymentVoucherTemplate, 'dailyVoucherTemplate' => $dailyVoucherTemplate];
    return response()->json($dataTree, 200);
  }

  public function isUseVoucherTemplate($voucher_template_id)
  {
    //voucher template related to voucher
    $voucher = Voucher::where(function ($query) use ($voucher_template_id) {
      $query->where('voucher_template_id', $voucher_template_id);
    })->first();
    if ($voucher != null)
      return true;
//      return ['voucherId' => $voucher->id, 'table' => 'vouchers'];

    //voucher template related to voucher permission user
    $voucherPermissionUser = VoucherPermissionUser::where(function ($query) use ($voucher_template_id) {
      $query->where('voucher_template_id', $voucher_template_id);
    })->first();
    if ($voucherPermissionUser != null)
      return true;
//      return ['voucherPermissionUserId' => $voucherPermissionUser->id, 'table' => 'voucher_permission_users'];

//    return ['id' => null, 'table' => null];
    return false;
  }
}
