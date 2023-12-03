<?php

namespace App\Http\Controllers;

use App\Events\BillTemplateUpdated;
use App\Http\Requests\StoreBillTemplateRequest;
use App\Http\Requests\UpdateBillTemplateRequest;
use App\Models\Bill;
use App\Models\BillPermissionUser;
use App\Models\BillTemplate;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Bill\BillRecordTrait;
use App\Traits\Common\CommonTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class BillTemplateController extends Controller
{

    use  ActivityLog, CommonTrait, BillRecordTrait;

    public $commonMessage;

    function __construct()
    {
        $this->commonMessage = new Translate(new CommonWords());
    }

    public function index()
    {
        $parameters = ['id' => null];
        $salesBillTemplate = BillTemplate::where('is_sales', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'bill_type')->get();
        $purchasesBillTemplate = BillTemplate::where('is_purchases', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'bill_type')->get();
        $salesRetuenBillTemplate = BillTemplate::where('is_sales_return', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'bill_type')->get();
        $purchasingReturnBillTemplate = BillTemplate::where('is_purchasing_return', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'bill_type')->get();
        $exchangeBillTemplate = BillTemplate::where('is_exchange', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'bill_type')->get();
        $outputStoreBillTemplate = BillTemplate::where('is_output_store', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'bill_type')->get();
        $inputStoreBillTemplate = BillTemplate::where('is_input_store', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'bill_type')->get();
        $beginningInventoryBillTemplate = BillTemplate::where('is_beginning_inventory', true)->select('id', 'abbreviation', 'name', 'foreign_name', 'is_active', 'bill_type')->get();

        $this->callActivityMethod('bill_templates', 'mainTree', $parameters);
        $dataTree = [
            'salesBillTemplate' => $salesBillTemplate,
            'purchasesBillTemplate' => $purchasesBillTemplate,
            'salesRetuenBillTemplate' => $salesRetuenBillTemplate,
            'purchasingReturnBillTemplate' => $purchasingReturnBillTemplate,
            'exchangeBillTemplate' => $exchangeBillTemplate,
            'outputStoreBillTemplate' => $outputStoreBillTemplate,
            'inputStoreBillTemplate' => $inputStoreBillTemplate,
            'beginningInventoryBillTemplate' => $beginningInventoryBillTemplate,
        ];
        return response()->json($dataTree, 200);
    }

    public function store(StoreBillTemplateRequest $request)
    {
        $lang = $request->header('lang');
        $billTemplate = BillTemplate::create($request->all());
        $parameters = ['request' => $request, 'id' => $billTemplate->id];
        $this->validateBillType($billTemplate->id, BillTemplate::class, $request);
        $this->setBillPermissionUser($billTemplate->id);


        $result = $this->activityParameters($lang, 'store', 'bill_template', $billTemplate, null);
        $parameters = $result['parameters'];
        $table = $result['table'];
        $this->callActivityMethod('store', $table, $parameters);

        event(new BillTemplateUpdated([...BillTemplate::all()]));

//      $this->callActivityMethod('bill_templates', 'store', $parameters ,'Bill Template' . ' ' . $billTemplate->name . ' ' . 'Created');
        return response()->json([
            'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
            'id' => $billTemplate->id,
            'bill_type' => $billTemplate->bill_type,
        ], 200);
    }


    public function show($id)
    {

        $billTemplate = BillTemplate::find($id);

        return response()->json($billTemplate, 200);
    }

    public function update(UpdateBillTemplateRequest $request, $id)
    {
        $lang = $request->header('lang');
        $old_data = BillTemplate::find($id)->toJson();
//        $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];

        $billTemplate = BillTemplate::find($id);
        $billTemplate->update($request->all());

        $result = $this->activityParameters($lang, 'update', 'bill_templates', $billTemplate, null);
        $parameters = $result['parameters'];
        $table = $result['table'];
        $this->callActivityMethod('update', $table, $parameters);
        event(new BillTemplateUpdated([...BillTemplate::all()]));

//        $this->callActivityMethod('bill_templates', 'update', $parameters);
        return response()->json([
            'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
            'id' => $billTemplate->id,
            'bill_type' => $billTemplate->bill_type,
        ], 200);
    }

    public function delete($id)
    {
        $lang = app('request')->header('lang');;

        $billTemplate = BillTemplate::find($id);
        if ($this->isUseBillTemplate($id)) {
            $errors = ['billTemplate' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }
        $billTemplate->delete();

        $result = $this->activityParameters($lang, 'delete', 'bill_templates', $billTemplate, null);
        $parameters = $result['parameters'];
        $table = $result['table'];
        $this->callActivityMethod('delete', $table, $parameters);
        event(new BillTemplateUpdated([...BillTemplate::all()]));

//      $this->callActivityMethod('bill_templates', 'delete', $parameters);
        return response()->json([
            'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang),
        ], 200);
    }

    public function all()
    {
        $billTemplate = BillTemplate::all();
        return response()->json($billTemplate, 200);
    }

    public function isUseBillTemplate($bill_template_id)
    {
        //bill template related to bill
        $bill = Bill::where(function ($query) use ($bill_template_id) {
            $query->where('bill_template_id', $bill_template_id);
        })->first();
        if ($bill != null)
            return true;
//      return ['billId' => $bill->id, 'table' => 'bills'];

        //bill template related to bill permission user
        $billPermissionUser = BillPermissionUser::where(function ($query) use ($bill_template_id) {
            $query->where('bill_template_id', $bill_template_id);
        })->first();
        if ($billPermissionUser != null)
            return true;
//      return ['billPermissionUserId' => $billPermissionUser->id, 'table' => 'bill_permission_users'];

//    return ['id' => null, 'table' => null];
        return false;
    }


}
