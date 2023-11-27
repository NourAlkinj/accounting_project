<?php

namespace App\Http\Controllers;

use App\Events\StoresUpdated;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Bill;
use App\Models\BillRecord;
use App\Models\BillTemplate;
use App\Models\Quantity;
use App\Models\ReturnedBill;
use App\Models\ReturnedBillRecord;
use App\Models\Store;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;


class StoreController extends Controller
{
  use  ActivityLog, CommonTrait;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()
  {

    $normalStores = Store::whereNull('store_id')->where('is_normal', true)->with('children')->select('id', 'code', 'name', 'store_id')->get();
    $assemblyStores = Store::where('is_assembly', true)->select('id', 'code', 'name', 'assembly_normal_ids')->get();

    $dataTree = ['normalStores' => $normalStores, 'assemblyStores' => $assemblyStores];
    return response()->json($dataTree, 200);
  }

  public function store(StoreStoreRequest $request)
  {
    $lang = $request->header('lang');
    $store = Store::create($request->all());

    $this->validateCardType($store->id, Store::class, $request);
    $result = $this->activityParameters($lang, 'store', 'store', $store,   'pc_name', null);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('store', $table, $parameters);
    event(new StoresUpdated([...Store::all()]));
    return response()->json([
//            'message' => __('common.store'),
      'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
            'id' => $store->id,
            'store_id' => $store->store_id,
            'card_type' =>$store->card_type,
        ], 200);
    }

  public function show($id)
  {

    $store = Store::find($id);

    return response()->json($store, 200);
  }

  public function all()
  {

    return Store::all();
  }

  public function update(UpdateStoreRequest $request, $id)
  {
    $lang = $request->header('lang');
    $old_data = Store::find($id)->toJson();

    $store = Store::find($id);
    $store->update($request->all());
    $result = $this->activityParameters($lang, 'update', 'store', $store,   'pc_name', $old_data);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('update', $table, $parameters);
    event(new StoresUpdated([...Store::all()]));
    return response()->json([
      'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
            'id' => $store->id,
            'store_id' => $store->store_id,
            'card_type' =>$store->card_type,
        ], 200);
    }

  public function delete($id)
  {
    $lang = app('request')->header('lang');;

    $store = Store::find($id);
    if ($this->numOfSubModels(Store::class, $id, 'store_id') > 0) {

      $errors = ['store' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
            return response()->json(['errors' => $errors], 400);
        }
    if ($this->isExistNormalInModel($id, Store::class, 'assembly_normal_ids', 'is_assembly') > 0) {

      $errors = ['store' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
            return response()->json(['errors' => $errors], 400);
        }
    if ($this->isUseStore($id)) {
      $errors = ['store' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }
    $store->delete();
    $result = $this->activityParameters($lang, 'delete', 'store', $store,   'pc_name', null);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('delete', $table, $parameters);
    event(new StoresUpdated([...Store::all()]));
    return response()->json([
      'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang) ,
          "card_type" => $store->card_type ], 200);
    }

  public function callAutoComplete($id)
  {
    return $this->AutoComplete($id, Store::class, 'store_id', false, 'internalModels', 'is_normal', true);
  }

  public function callGenerateCodes($id)
  {
    return $this->generateCodes($id, Store::class, Store::class, 'store_id');
  }

  public function getNormalsInAssembly($id)
  {
    return $this->getNormalsInModel($id, Store::class, 'assembly_normal_ids');
  }

  public function getAllNormals()
  {
    return $this->getAllModelsWithCondition(Store::class, 'is_normal', true);
  }

  public function getAllLeafNormal()
  {
    return $this->getAllLeafModelsWithCondition(Store::class, 'store_id', 'is_normal', true);
  }

  public function isUseStore($store_id)
  {
    //store related to bill
    $bill = Bill::where(function ($query) use ($store_id) {
      $query->where('store_id', $store_id)->orWhere('input_store_id', $store_id);
    })->first();
    if ($bill != null)
      return true;
//      return ['billId' => $bill->id, 'table' => 'bills'];

    //store related to bill record
    $billRecord = BillRecord::where(function ($query) use ($store_id) {
      $query->where('store_id', $store_id)->orWhere('input_store_id', $store_id);
    })->first();
    if ($billRecord != null)
      return true;
//      return ['billRecordId' => $billRecord->id, 'table' => 'bill_records'];

    //store related to bill template
    $billTemplate = BillTemplate::where(function ($query) use ($store_id) {
      $query->where('store_id', $store_id)->orWhere('input_store_id', $store_id);
    })->first();
    if ($billTemplate != null)
      return true;
//      return ['billTemplateId' => $billTemplate->id, 'table' => 'bill_templates'];

    //store related to quantity
    $quantity = Quantity::where(function ($query) use ($store_id) {
      $query->where('store_id', $store_id);
    })->first();
    if ($quantity != null)
      return true;
//      return ['quantityId' => $quantity->id, 'table' => 'quantities'];

    //store related to return bill
    // $returnedBill = ReturnedBill::where(function ($query) use ($store_id) {
    //   $query->where('store_id', $store_id);
    // })->first();
    // if ($returnedBill != null)
    //   return true;
//      return ['returnedBillId' => $returnedBill->id, 'table' => 'returned_bills'];

    //store related to return bill record
    // $returnedBillRecord = ReturnedBillRecord::where(function ($query) use ($store_id) {
    //   $query->where('store_id', $store_id);
    // })->first();
    // if ($returnedBillRecord != null)
    //   return true;
    //      return ['returnedBillReordId' => $returnedBillRecord->id, 'table' => 'returned_bill_records'];

    //store related to store
    $store = Store::where(function ($query) use ($store_id) {
      $query->where('store_id', $store_id);
    })->first();
    if ($store != null)
      return true;
    //      return ['storeId' => $store->id, 'table' => 'stores'];


//    return ['id' => null, 'table' => null];
    return false;

  }

}
