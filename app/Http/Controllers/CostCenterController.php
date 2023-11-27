<?php

namespace App\Http\Controllers;

use App\Events\CostCentersUpdated;
use App\Models\Bill;
use App\Models\BillAdditionAndDiscount;
use App\Models\BillRecord;
use App\Models\BillTemplate;
use App\Models\CostCenter;
use App\Http\Requests\StoreCostCenterRequest;
use App\Http\Requests\UpdateCostCenterRequest;
use App\Models\JournalEntryRecord;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use App\Models\VoucherTemplate;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use Illuminate\Http\Request;
use Lang\Locales\CommonWords;
use Lang\Translate;
use Lang\Locales\CommonWordsEnum;


class CostCenterController extends Controller
{
    use  ActivityLog, CommonTrait;

      public  $commonMessage;

      function __construct()
      {
        $this->commonMessage = new Translate(new CommonWords());
      }

    public function index()
    {

        $normalCostCenters = CostCenter::whereNull('cost_center_id')->where('is_normal', true)->with('children')->select('id', 'name', 'code', 'cost_center_id')->get();
        $assemblyCostCenters = CostCenter::where('is_assembly', true)->select('id', 'name', 'code')->get();


        $dataTree=['normalCostCenters'=> $normalCostCenters, 'assemblyCostCenters'=>$assemblyCostCenters];
        return response()->json( $dataTree, 200);
    }

    public function all()
    {

      return CostCenter::all();
    }

    public function store(StoreCostCenterRequest $request)
    {
      $lang = $request->header('lang');
        $costCenter = CostCenter::create($request->all());

        $this->validateCardType($costCenter->id,CostCenter::class, $request);

      $result = $this->activityParameters($lang, 'store', 'costCenter', $costCenter,  'pc_name' , null);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('store', $table, $parameters);

      event(new CostCentersUpdated([...CostCenter::all()]));
      return response()->json([
//            'message' => __('common.store'),
        'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
            'id' => $costCenter->id,
            'cost_center_id' => $costCenter->cost_center_id,
            'card_type' =>$costCenter->card_type,
        ], 200);
    }

    public function show($id)
    {

        $costCenter = CostCenter::find($id);

        return response()->json( $costCenter, 200);
    }


    public function update(UpdateCostCenterRequest $request, $id)
    {
        $lang = $request->header('lang') ;
        $old_data = CostCenter::find($id)->toJson();

        $costCenter = CostCenter::find($id);
        $costCenter->update($request->all());

      $result = $this->activityParameters($lang, 'update', 'costCenter', $costCenter,  'pc_name' , $old_data);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('update', $table, $parameters);

      event(new CostCentersUpdated([...CostCenter::all()]));
      return response()->json([
//            'message' => __('common.update'),
            'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
            'id' => $costCenter->id,
            'cost_center_id' => $costCenter->cost_center_id,
            'card_type' =>$costCenter->card_type,
        ], 200);
    }

    public function delete($id)
    {
      $lang  =   app('request')->header('lang');;

        $costCenter = CostCenter::find($id);
        if ($this->numOfSubModels(CostCenter::class, $id, 'cost_center_id') > 0) {
//            $errors = ['costCenter' => [__('common.delete error')]];
          $errors = ['costCenter' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
            return  response()->json(['errors' => $errors], 400);
        }
        if ($this->isExistNormalInModel($id, CostCenter::class, 'assembly_normal_ids', 'is_assembly') > 0) {
//            $errors = ['costCenter' => [__('common.delete error')]];
          $errors = ['costCenter' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
            return  response()->json(['errors' => $errors], 400);
        }

      if($this->isUseCostCenter($id)) {
        $errors = ['costCenter' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }
        $costCenter->delete();
      $result = $this->activityParameters($lang, 'delete', 'costCenter', $costCenter,  'pc_name' , $old_data);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('delete', $table, $parameters);

      event(new CostCentersUpdated([...CostCenter::all()]));
      $data= $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang) ;
        return response()->json(['message' => $data], 200);
    }

    public function callAutoComplete($id)
    {
        return $this->AutoComplete($id, CostCenter::class, 'cost_center_id',false,'internalModels','is_normal', true);
    }

    public function callGenerateCodes($id)
    {
        return $this->generateCodes($id, CostCenter::class, CostCenter::class, 'cost_center_id');
    }

    public function getNormalsInAssembly($id)
    {
        return $this->getNormalsInModel($id, CostCenter::class, 'assembly_normal_ids');
    }

    public function getAllNormals()
    {
        return $this->getAllModelsWithCondition(CostCenter::class,'is_normal',true);
    }

    public function getAllLeafNormal()
    {
        return $this->getAllLeafModelsWithCondition(CostCenter::class, 'cost_center_id' ,'is_normal',true);
    }

    public function callGetCurrentBalance($id,$requiredCurrencyId)
    {
        return $this->callGetCredit($id,$requiredCurrencyId) - $this->callGetDebit($id,$requiredCurrencyId);
    }
    public function callGetCredit($id,$requiredCurrencyId)
    {
        $costCenter = CostCenter::find($id);
        if ($costCenter->is_normal == true && $costCenter['internalModels']->isEmpty())
          {
            $dealCurrencies = JournalEntryRecord::whereIN('cost_center_id', [$costCenter->id])->where('is_post_to_account', true)->get();
            return $this->getCredit($dealCurrencies, $requiredCurrencyId);
          }
        if ($costCenter->is_normal == true && !($costCenter['internalModels']->isEmpty()))
          {
            $leafModel = $this->getLeafId($costCenter);
            $dealCurrencies = JournalEntryRecord::whereIN('cost_center_id', $leafModel)->where('is_post_to_account', true)->get();
            return $this->getCredit($dealCurrencies, $requiredCurrencyId);
          }
        if ($costCenter->is_assembly == true && ($costCenter['assembly_normal_ids'] != null))
          {
            $dealCurrencies = JournalEntryRecord::whereIN('cost_center_id', $costCenter['assembly_normal_ids'])->where('is_post_to_account', true)->get();
            return $this->getCredit($dealCurrencies, $requiredCurrencyId);
          }
    }
    public function callGetDebit($id,$requiredCurrencyId)
    {
      $costCenter = CostCenter::find($id);
      if ($costCenter->is_normal == true && $costCenter['internalModels']->isEmpty())
      {
        $dealCurrencies = JournalEntryRecord::whereIN('cost_center_id', [$costCenter->id])->where('is_post_to_account', true)->get();
        return $this->getDebit($dealCurrencies, $requiredCurrencyId);
      }
      if ($costCenter->is_normal == true && !($costCenter['internalModels']->isEmpty()))
      {
        $leafModel = $this->getLeafId($costCenter);
        $dealCurrencies = JournalEntryRecord::whereIN('cost_center_id', $leafModel)->where('is_post_to_account', true)->get();
        return $this->getDebit($dealCurrencies, $requiredCurrencyId);
      }
      if ($costCenter->is_assembly == true && ($costCenter['assembly_normal_ids'] != null))
      {
        $dealCurrencies = JournalEntryRecord::whereIN('cost_center_id', $costCenter['assembly_normal_ids'])->where('is_post_to_account', true)->get();
        return $this->getDebit($dealCurrencies, $requiredCurrencyId);
      }
    }


  public function isUseCostCenter($cost_center_id)
  {
    //costCenter related to bill
    $bill = Bill::where(function ($query) use ($cost_center_id) {
      $query->where('cost_center_id', $cost_center_id);
    })->first();
    if ($bill != null)
      return true;
//    return ['billId' => $bill->id, 'table' => 'bills'];

    //costCenter related to bill addition and discount
    $billAdditionAndDiscount = BillAdditionAndDiscount::where(function ($query) use ($cost_center_id) {
      $query->where('cost_center_id', $cost_center_id);
    })->first();
    if ($billAdditionAndDiscount != null)
      return true;
//    return ['billAdditionAndDiscountId' => $billAdditionAndDiscount->id, 'table' => 'bill_addition_and_discounts'];

    //costCenter related to bill record
    $billRecord = BillRecord::where(function ($query) use ($cost_center_id) {
      $query->where('cost_center_id', $cost_center_id);
    })->first();
    if ($billRecord != null)
      return true;
//    return ['billRecordId' => $billRecord->id, 'table' => 'bill_records'];

    //costCenter related to bill template
    $billTemplate = BillTemplate::where(function ($query) use ($cost_center_id) {
      $query->where('cost_center_id', $cost_center_id);
    })->first();
    if ($billTemplate != null)
      return true;
//    return ['billTemplateId' => $billTemplate->id, 'table' => 'bill_templates'];


    //costCenter related to cost center
    $CostCenter = CostCenter::where(function ($query) use ($cost_center_id) {
      $query->where('cost_center_id', $cost_center_id);
    })->first();
    if ($CostCenter != null)
      return true;
//    return ['costCenterId' => $CostCenter->id, 'table' => 'cost_centers'];

    //costCenter related to JournalEntryRecord
    $journalEntryRecord = JournalEntryRecord::where(function ($query) use ($cost_center_id) {
      $query->where('cost_center_id', $cost_center_id);
    })->first();
    if ($journalEntryRecord != null)
      return true;
//    return ['journalEntryRecordId' => $journalEntryRecord->id, 'table' => 'journal_entry_records'];

    //costCenter related to voucher
    $voucher = Voucher::where(function ($query) use ($cost_center_id) {
      $query->where('cost_center_id', $cost_center_id);
    })->first();
    if ($voucher != null)
      return true;
//    return ['voucherId' => $voucher->id, 'table' => 'vouchers'];

    //costCenter related to voucher record
    $voucherRecord = VoucherRecord::where(function ($query) use ($cost_center_id) {
      $query->where('cost_center_id', $cost_center_id);
    })->first();
    if ($voucherRecord != null)
      return true;
//    return ['voucherRecordId' => $voucherRecord->id, 'table' => 'voucher_records'];

    //costCenter related to voucher template
    $vochrTemplate = VoucherTemplate::where(function ($query) use ($cost_center_id) {
      $query->where('cost_center_id', $cost_center_id);
    })->first();
    if ($vochrTemplate != null)
      return true;
//    return ['vochrTemplateId' => $vochrTemplate->id, 'table' => 'voucher_templates'];


//    return ['id' => null, 'table' => null];
    return false;
  }

    }
