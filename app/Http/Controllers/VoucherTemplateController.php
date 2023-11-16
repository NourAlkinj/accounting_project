<?php

namespace App\Http\Controllers;

use App\Events\VoucherTemplatesUpdated;
use App\Models\Account;
use App\Models\JournalEntryRecord;
use App\Models\Voucher;
use App\Models\VoucherTemplate;
use App\Http\Requests\StoreVoucherTemplateRequest;
use App\Http\Requests\UpdateVoucherTemplateRequest;
use App\Models\User;
use App\Models\VoucherPermissionUser;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use App\Traits\Voucher\VoucherRecordTrait;
use Lang\Locales\CommonWords;
use Lang\Translate;
use Lang\Locales\CommonWordsEnum;
use Illuminate\Http\Request;

class VoucherTemplateController extends Controller
{
    use  ActivityLog, CommonTrait, VoucherRecordTrait;

  public  $commonMessage;

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
        $parameters = ['id' => null];
        $entryVoucherTemplate = VoucherTemplate::where('is_entry', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
        $receiptVoucherTemplate = VoucherTemplate::where('is_receipt', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
        $paymentVoucherTemplate = VoucherTemplate::where('is_payment', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
        $dailyVoucherTemplate = VoucherTemplate::where('is_daily', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
        $this->callActivityMethod('voucher_templates', 'mainTree', $parameters);
        $dataTree = ['entryVoucherTemplate' => $entryVoucherTemplate, 'receiptVoucherTemplate' => $receiptVoucherTemplate, 'paymentVoucherTemplate' => $paymentVoucherTemplate, 'dailyVoucherTemplate' => $dailyVoucherTemplate];
        return response()->json($dataTree, 200);
    }

    public function store(StoreVoucherTemplateRequest $request)
    {
      $lang = $request->header('lang');
      $voucherTemplate = VoucherTemplate::create($request->all());
        $parameters = ['request' => $request, 'id' => $voucherTemplate->id];
        $this->validateVoucherType($voucherTemplate->id, VoucherTemplate::class, $request);
        $this->setVoucherPermissionUser($voucherTemplate->id);
        $this->callActivityMethod('voucher_templates', 'store', $parameters);
        event(new VoucherTemplatesUpdated([...VoucherTemplate::all()]));
        return response()->json([
//            'message' => __('common.store'),
            'message'  => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
            'id' => $voucherTemplate->id,
            'voucher_type' => $voucherTemplate->voucher_type,
        ], 200);
    }

    public function show($id)
    {
        $parameters = ['id' => $id];
        $voucherTemplate = VoucherTemplate::find($id);
        $this->callActivityMethod('voucher_templates', 'show', $parameters);
        return response()->json($voucherTemplate, 200);
    }

    public function update(UpdateVoucherTemplateRequest $request, $id)
    {
      $lang = $request->header('lang');
      $old_data = VoucherTemplate::find($id)->toJson();
        $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
        $voucherTemplate = VoucherTemplate::find($id);
//        if ($result = $this->validateAbbreviationNameAndForignname($id, $request,$lang))
//            return  $result;
        $voucherTemplate->update($request->all());
        $this->callActivityMethod('voucher_templates', 'update', $parameters);
        event(new VoucherTemplatesUpdated([...VoucherTemplate::all()]));
        return response()->json([
            'message' =>  $this->commonMessage->t(CommonWordsEnum::UPDATE->name,$lang),
            'id' => $voucherTemplate->id,
            'voucher_type' => $voucherTemplate->voucher_type,
        ], 200);
    }

    public function delete($id)
    {
      $lang  =   app('request')->header('lang');;
      $parameters = ['id' => $id];
      $voucherTemplate = VoucherTemplate::find($id);
      if($this->isUseVoucherTemplate($id)) {
        $errors = ['voucherTemplate' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }
      $voucherTemplate->delete();
      $this->callActivityMethod('voucher_templates', 'delete', $parameters);
      event(new VoucherTemplatesUpdated([...VoucherTemplate::all()]));
      return response()->json(['message' =>$this->commonMessage->t(CommonWordsEnum::DELETE->name,$lang)], 200);
    }

    public function navTree()
    {
        $parameters = ['id' => null];
        $entryVoucherTemplate = VoucherTemplate::where('is_entry', true)->where('is_active', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
        $recieptVoucherTemplate = VoucherTemplate::where('is_receipt', true)->where('is_active', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
        $paymentVoucherTemplate = VoucherTemplate::where('is_payment', true)->where('is_active', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
        $dailyVoucherTemplate = VoucherTemplate::where('is_daily', true)->where('is_active', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'voucher_type')->get();
        $this->callActivityMethod('voucher_templates', 'navTree', $parameters);
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
