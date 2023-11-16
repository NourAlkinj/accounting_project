<?php

namespace App\Traits\Common;

use App\Http\Controllers\StoreController;
use App\Http\Requests\StoreUnitRequest;
use App\Models\BillTemplate;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\CurrencyActivity;
use App\Models\JournalEntryRecord;
use App\Models\User;
use App\Models\VoucherTemplate;
use App\Traits\Currency\ActivityCurrencyTrait;
 use App\Traits\Currency\CurrencyTrait;
 use COM;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;

use Lang\Translate;


trait  CommonTrait
{

  public  $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }


//  use ActivityCurrencyTrait;

  public function logParity($requiredCurrencyId, $journalAccordingDate)
  {
    $journalAccordingDate = date('Y-m-d', strtotime($journalAccordingDate));

    //3.1
    $CurrencyAccordingSameDate = CurrencyActivity::where('currency_id', $requiredCurrencyId)->where('last_update_date', $journalAccordingDate)->latest()->get()->last();
    if ($CurrencyAccordingSameDate != null)
      return $CurrencyAccordingSameDate->parity;
    //3.2
    $CurrencyAccordingBeforeDate = CurrencyActivity::where('currency_id', $requiredCurrencyId)->where('last_update_date', '<', $journalAccordingDate)
      ->orderBy('last_update_date', 'asc')
      ->latest()->get()->last();
    if ($CurrencyAccordingBeforeDate != null)
      return $CurrencyAccordingBeforeDate->parity;
    //3.3
    $CurrencyAccordingAfterDate = CurrencyActivity::where('currency_id', $requiredCurrencyId)->where('last_update_date', '>', $journalAccordingDate)
      ->orderBy('last_update_date', 'asc')
      ->first();
    if ($CurrencyAccordingAfterDate != null)
      return $CurrencyAccordingAfterDate->parity;
  }


  public function getAllConnectedPrinters()
  {
    $wmi = new COM("winmgmts:{impersonationLevel=impersonate}!\\\\.\\root\\cimv2");
    $printers = $wmi->ExecQuery("SELECT * FROM Win32_Printer");

    $printerNames = [];
    foreach ($printers as $printer) {
      $printerNames[] = utf8_encode($printer->Name);
    }
    return $printerNames;
  }


  public function generateModelID($Model)
  {
    if ($this->getCountRawsInModel($Model) == 0)
      $id = 1;
    else
      $id = $Model::orderBy('id', 'desc')->first()->id + 1;
    return $id;
  }


  public function DataOfModels($myModel, $id, $value)
  {
    $dataOfModels = [];
    $models = $myModel::all();
    foreach ($models as $model) {
      $dataOfModels[] = $model->$value;
    }
    $model = $myModel::find($id);
    $valueOfModelArr = array();
    $valueOfModel = $model->$value;
    array_push($valueOfModelArr, $valueOfModel);
    $valuessExceptValue = array_diff($dataOfModels, $valueOfModelArr);
    return array_filter($valuessExceptValue);
  }

  public function numOfSubModels($myModel, $id, $foreignKey, $condition = null, $value = null)
  {
    $SubModels = $myModel::where($condition, $value)->where($foreignKey, $id)->get();
    return count($SubModels);
  }

  public function callActivityMethod($table, $method, $parameters)
  {
    $this->makeActivity([
      'table' => $table,
      'operation' => $method,
      'parameters' => $parameters
    ]);
  }

  public function callTaskActivityMethod($operation, $taskParameters)
  {
    $this->taskActivity([
      'operation' => $operation,
      'taskParameters' => $taskParameters
    ]);
  }


  public function getCountRawsInModel($Model)
  {
    return $Model::count();
  }

  public function numOfSubChilds($myModel1, $myModel2, $id, $foreignKey)
  {
    $SubMyModels1 = $myModel1::where($foreignKey, $id)->get();
    $SubMyModels2 = $myModel2::where($foreignKey, $id)->get();
    $SubMyModels1Count = count($SubMyModels1);
    $SubMyModels2Count = count($SubMyModels2);
    return $SubMyModels1Count + $SubMyModels2Count;
  }

  public function codes($str)
  {
    for ($i = 0; $i <= strlen($str); $i++) {
      preg_match_all('!\d+!', $str, $matches);
      $len = count($matches[0]);
      $num = $matches['0'][$len - 1];
      $character = substr($str, 0, -strlen($num));
      $zeros = "";
      for ($i = 0; $i <= strlen($num) - 1; $i++) {
        if ($num[$i] == 0)
          $zeros .= '0';
        else
          break;
      }
      $nonZeros = substr($num, strlen($zeros));
      $nines = "";
      for ($i = 0; $i <= strlen($nonZeros) - 1; $i++) {
        if ($nonZeros[$i] == 9)
          $nines .= '9';
        else
          break;
      }
      if ($nonZeros == $nines) {
        $zeros = substr_replace($zeros, "", -1);
        $nonZeros = $nonZeros + 1;
      } else
        $nonZeros = $nonZeros + 1;

      $newlastChildCode = $character . $zeros . $nonZeros;
      return $newlastChildCode;
    }
  }

  public function generateCodes($id, $myModel1, $myModel2, $foreignKey)
  {
    $parentModel = $myModel1::find($id);
    $parentCode = $myModel1::find($id)->code;
    $SubModels = $myModel2::where($foreignKey, $id)->get();

    if (count($SubModels) == 0)
      return null;
    $lastChildCode = $SubModels->last()->code;
    //from Start : lastChildCodeExceptParentCodeLenght
    $result1 = substr($lastChildCode, 0, strlen($parentCode));
    //from end : lastChildCodeExceptParentCodeLenght
    $result2 = substr($lastChildCode, strlen($parentCode));
    //                return $result2;

    $newlastChildCode = "";
    if ($parentCode == $result1) {
      $result = $this->codes($result2);
      $result = $parentCode . $result;
      return $result;
    } else {
      $result = $this->codes($lastChildCode);
      return $result;
    }
  }


  public function helpAutoComplete($id, $myModel, $foreignKey, $c, $relationName)
  {
    $model = $myModel::find($id);
    $child_models = $model->$relationName;
    $child_models_IDs = [];
    $child_models_IDs2 = [];
    foreach ($child_models as $child_model) {
      if ($c) {
        if ($child_model->is_active == true) {
          $child_models_IDs[] = $child_model->id;
          if ($this->numOfSubModels($myModel, $child_model->id, $foreignKey) > 0) {
            $child_models_IDs2 = $this->helpAutoComplete($child_model->id, $myModel, $foreignKey, $c, $relationName);
          }
        }
      } else {
        $child_models_IDs[] = $child_model->id;
        if ($this->numOfSubModels($myModel, $child_model->id, $foreignKey) > 0) {
          $child_models_IDs2 = $this->helpAutoComplete($child_model->id, $myModel, $foreignKey, $c, $relationName);
        }
      }
    }
    $allinternalModels_IDs = [...$child_models_IDs, ...$child_models_IDs2];
    return $allinternalModels_IDs;
  }



  //$value and $c are parameters for difference between branch and athor cards
  //$value in branch  for get active branches,but in athor cards for get normal model
  //$c
  public function AutoComplete($id, $myModel, $foreignKey, $c, $relationName, $condition1 = null, $valueCodition1 = null, $condition2 = null, $valueCodition2 = null)
  {
    $all_models = $myModel::where($condition1, $valueCodition1)->where($condition2, $valueCodition2)->get();

    foreach ($all_models as $model) {
      $all_models_IDs[] = $model->id;
    }
    $allinternalModels_IDs = $this->helpAutoComplete($id, $myModel, $foreignKey, $c, $relationName);
    $differenceArray = array_diff($all_models_IDs, $allinternalModels_IDs);
    $arrId = array();
    array_push($arrId, $id);
    $difference = array_diff($differenceArray, $arrId);
//    $idParentModel = $this->getIdParentOfModel($id, $myModel, $foreignKey);
//    array_push($difference, $idParentModel);
    $results = $myModel::whereIn('id', $difference)->select('id', 'name', 'code')->get();
    return response()->json($results, 200);
  }


  public function AutoCompleteCategory($id, $myModel, $foreignKey, $table, $operation, $value, $c, $condition1 = null, $condition2 = null)
  {
    $all_models = $myModel::where($table, $operation, $value)->get();
    foreach ($all_models as $model) {
      $all_models_IDs[] = $model->id;
    }
    $allinternalModels_IDs = $this->helpAutoComplete($id, $myModel, $foreignKey, $c, 'internalModels');
    $differenceArray = array_diff($all_models_IDs, $allinternalModels_IDs);
    $arrId = array();
    array_push($arrId, $id);
    $difference = array_diff($differenceArray, $arrId);
    $idParentModel = $this->getIdParentOfModel($id, $myModel, $foreignKey);
    array_push($difference, $idParentModel);
    $results = $myModel::whereIn('id', $difference)->where($condition1, $condition2)->select('id', 'name', 'code')->get();
    return response()->json($results, 200);
  }


  public function getValueFromModelWithCondition($Model, $condition, $value)
  {
    $models = $Model::where($condition, true)->get();
    $values = [];
    foreach ($models as $model) {
      $values[] = $model->$value;
    }
    return $values;
  }


  public function getIdParentOfModel($id, $myModel, $foreignKey)
  {
    $model = $myModel::find($id);
    return $model->$foreignKey;
  }

  public function getNameAndCode($id, $myModel)
  {
    $model = $myModel::find($id);
    return $model->code . ' - ' . $model->name;
  }

  public function isExistValueInArray($val, array $array, $key = 'id')
  {
    foreach ($array as $a1)
      if ($val == $a1[$key])
        return 1;
    return 0;
  }

  public function isExistNormalInModel($id, $myModel, $value, $condition)
  {
    $normalModelIdArr=[];
    $models = $myModel::where($condition, true)->get();
    foreach ($models as $model) {
      $normalModelIdArr = $model->$value;
      if ($this->isExistValueInArray($id, $normalModelIdArr, 'id'))
        return 1;
    }
    return 0;
  }

  public function getAssemblyOfModel($id, $myModel, $value, $condition)
  {
    $models = $myModel::where($condition, true)->get();
    $result = [];
    foreach ($models as $model) {
      $normalModelIdArr = $model->$value;
      if ($this->isExistValueInArray($id, $normalModelIdArr, 'id'))
        $result[] = $model;
    }
    return $result;
  }

  public function validateCardType($id, $Model, $request)
  {
    if ($request->card_type == 0) {
      $this->updateValueInDB($id, $Model, 'is_normal', true);
    }
    if ($request->card_type == 1) {
      $this->updateValueInDB($id, $Model, 'is_assembly', true);
      $this->updateValueInDB($id, $Model, 'flag', 'assembly');
    }
    if ($request->card_type == 2) {
      $this->updateValueInDB($id, $Model, 'is_distributive', true);
      $this->updateValueInDB($id, $Model, 'flag', 'distributive');
    }
    if ($request->card_type == 3) {
      $this->updateValueInDB($id, $Model, 'is_final', true);
      $this->updateValueInDB($id, $Model, 'flag', 'final');

    }
  }

  public function validateVoucherType($id, $Model, $request)
  {
    if ($request->voucher_type == 0)
      $this->updateValueInDB($id, $Model, 'is_entry', true);
    if ($request->voucher_type == 1)
      $this->updateValueInDB($id, $Model, 'is_receipt', true);
    if ($request->voucher_type == 2)
      $this->updateValueInDB($id, $Model, 'is_payment', true);
    if ($request->voucher_type == 3)
      $this->updateValueInDB($id, $Model, 'is_daily', true);
  }

  public function validateBillType($id, $Model, $request)
  {
    if ($request->bill_type == 0)
      $this->updateValueInDB($id, $Model, 'is_sales', true);
    if ($request->bill_type == 1)
      $this->updateValueInDB($id, $Model, 'is_purchases', true);
    if ($request->bill_type == 2)
      $this->updateValueInDB($id, $Model, 'is_sales_return', true);
    if ($request->bill_type == 3)
      $this->updateValueInDB($id, $Model, 'is_purchasing_return', true);
    if ($request->bill_type == 4)
      $this->updateValueInDB($id, $Model, 'is_exchange', true);
    if ($request->bill_type == 5)
      $this->updateValueInDB($id, $Model, 'is_output_store', true);
    if ($request->bill_type == 6)
      $this->updateValueInDB($id, $Model, 'is_input_store', true);
    if ($request->bill_type == 7)
      $this->updateValueInDB($id, $Model, 'is_beginning_inventory', true);

  }


  public function getNormalsInModel($id, $myModel, $value)
  {
    $model = $myModel::find($id);
    $normalObjects = $model->$value;
    foreach ($normalObjects as $normalObject) {
      $result[] = $normalObject['id'];
    }
    $normalIDs = $myModel::whereIn('id', $result)->select('id')->get();
    return $normalIDs;
  }

  public function getAllNormalsExceptInModel($id, $myModel, $value)
  {
    $normalsInModel = $this->getNormalsInModel($id, $myModel, $value);
    $allModels = $myModel::all();
    foreach ($allModels as $model) {
      $modelsIDS[] = $model->id;
    }
    $diffIDS = array_diff($modelsIDS, $normalsInModel);
    $result = $myModel::whereIn('id', $diffIDS)->select('id', 'name', 'code')->get();
    return $result;
  }

  public function getAllCodesAndNames($Model)
  {
    $models = $Model::select('id', 'name', 'code')->get();
    $allCodesAndNames = [];
    foreach ($models as $model) {
      $allCodesAndNames[] = $model;
    }
    return $allCodesAndNames;
  }

  public function getValueOfModelExceptSpecificModel($values, $table, $firstValueOfCondition, $secondValueOfCondition)
  {
    return $this->queryEqual($values, $table, $firstValueOfCondition, $secondValueOfCondition);
  }


  public function getAllIDs($Model)
  {
    $models = $Model::all();
    $allIDs = [];
    foreach ($models as $model) {
      $allIDs[] = $model->id;
    }
    return $allIDs;
  }


  public function getObjectByCodeDB($table, $code)
  {
    $model = DB::select("select * from $table where code = '$code'");
    if ($model)
      return $model;
    $model = DB::select("select * from $table where code like '$code%' limit 1 ");
    return $model;
  }

  public function getObjectByValue($Model, $value, $column)
  {
    return $model = $Model::where($column, 'like', $value . '%')->orderBy($column, 'asc')->first();
  }

  public function getObjectByValueAccordingLang($Model, $value, $column)
  {
    return $model = $Model::where($column . '_' . Config::get('app.locale'), 'like', $value . '%')->orderBy($column . '_' . Config::get('app.locale'), 'asc')->first();
  }

  public function queryEqual(array $values, $table, $firstValueOfCondition, $secondValueOfCondition)
  {
    $column = ' ';
    foreach ($values as $value) {
      $column .= $value . ",";
    }
    $column = substr($column, 0, strlen($column) - 1);
    $query = DB::select("select $column from $table where($firstValueOfCondition = $secondValueOfCondition )");
    return $query;
  }

  public function columnTranslate($column)
  {
    $result = $column . '_' . Config::get('app.locale');
    return $result;
  }

  public function getRootCode($myModel)
  {
    $model = $myModel::find(1);
    return $model->code;
  }

  public function getModelData($myModel, $id, $value)
  {
    $model = $myModel::find($id);
    $valueOfModel = $model->$value;
    return $valueOfModel;
  }

  public function getAllModelsWithCondition($myModel, $condition1, $value1, $condition2 = null, $value2 = null)
  {
    $Models = $myModel::where($condition1, $value1)->where($condition2, $value2)->select('id', 'code', 'name')->get();
    return $Models;
  }

  public function getAllLeafModelsWithCondition($myModel, $foreignKey, $condition, $value)
  {
    $allNormalModels = $myModel::where($condition, $value)->select('id', 'code', 'name')->get();
    $leafNormalModels = [];
    foreach ($allNormalModels as $normalModel) {
      if ($this->isLeaf($myModel, $foreignKey, $normalModel->id)) {
        $leafNormalModels[] = $normalModel;
      }
    }
    return $leafNormalModels;
  }


  public function isLeaf($model, $foreignKey, $id)
  {

    if ($this->numOfSubModels($model, $id, $foreignKey) == 0)
      return true;
  }

  public function getAllActiveModelsWithCondition($myModel, $condition, $value)
  {
    $normalModels = $myModel::where('$condition', $value)->where('is_active', true)->get();
    return $normalModels;
  }


  public function activateChildren($myModel, $id, $foreignKey, $relationShip)
  {
    $model = $myModel::find($id);
    $inertialChildren = $model->$relationShip;
    foreach ($inertialChildren as $inertialChild) {
      $this->updateValueInDB($inertialChild->id, $myModel, 'is_active', true);
      if ($this->numOfSubModels($myModel, $inertialChild->id, $foreignKey) > 0) {
        $this->activateChildren($myModel, $inertialChild->id, $foreignKey, $relationShip);
      }
    }
    return $inertialChildren;
  }

  public function deActivateChildren($myModel, $id, $foreignKey, $relationShip)
  {
    $model = $myModel::find($id);
    $inertialChildren = $model->$relationShip;
    foreach ($inertialChildren as $inertialChild) {
      $this->updateValueInDB($inertialChild->id, $myModel, 'is_active', false);
      if ($this->numOfSubModels($myModel, $inertialChild->id, $foreignKey) > 0) {
        $this->deActivateChildren($myModel, $inertialChild->id, $foreignKey, $relationShip);
      }
    }
    return $inertialChildren;
  }


  public function getParent($id)
  {

    return Branch::with('branch')->select('id', 'branch_id')->find($id);
  }


  public function getParentName($Model, $id)
  {

    $branch = $Model::find($id);
    return $parent = Branch::where('id', $branch->branch_id)->select('name')->get();
  }


  public function ActivateDeActivate($request, $id, $model, $foreignKey)
  {
    if ($request->is_active == 0 && $this->numOfSubModels($model, $id, $foreignKey) > 0)
      $this->callDeActivateChildren($id);
    if ($request->is_active == 1 && $this->numOfSubModels($model, $id, $foreignKey) > 0)
      $this->callActivateChildren($id);
  }


  public function DeActivateBranchChildren($id)
  {
    $SubBranches = Branch::where('branch_id', $id)->get();
    foreach ($SubBranches as $SubBranch) {
      $this->updateValueInDB($SubBranch->id, Branch::class, 'is_active', false);
    }
    $SubUsers = User::where('branch_id', $id)->get();
    foreach ($SubUsers as $SubUser) {
      $this->updateValueInDB($SubUser->id, User::class, 'is_active', false);
    }
    if (count($SubBranches) > 0) {
      foreach ($SubBranches as $SubBranch) {
        $this->DeActivateBranchChildren($SubBranch->id);
      }
    }
  }


  public function updateValueInDB($id, $Model, $key, $value)
  {
    $model = $Model::find($id);
    $model->$key = $value;
    $model->save();
  }


  public function ActivateBranchChildren($id)
  {
    $SubBranches = Branch::where('branch_id', $id)->get();
    foreach ($SubBranches as $SubBranch) {
      $this->updateValueInDB($SubBranch->id, Branch::class, 'is_active', true);
    }
    $SubUsers = User::where('branch_id', $id)->get();
    foreach ($SubUsers as $SubUser) {
      $this->updateValueInDB($SubUser->id, User::class, 'is_active', true);
    }
    if (count($SubBranches) > 0) {
      foreach ($SubBranches as $SubBranch) {
        $this->ActivateBranchChildren($SubBranch->id);
      }
    }
  }

  public function ActivateDeActivateBranch($id)
  {
    $this->DeActivateBranchChildren($id);
    $this->ActivateBranchChildren($id);
  }


// for calculating credit
  public function getCredit($dealCurrencies, $requiredCurrencyId)
  {
    // dealCurrency :there is in journalEntryRecord
    // requiredCurrency: there is in account or costCenter
    $TotalCredit = 0;
    $requiredCurrency = Currency::find($requiredCurrencyId);
    if ($dealCurrencies) {
      foreach ($dealCurrencies as $dealCurrency) {
        $journalAccordingDate = $dealCurrency['date'];
        if ($dealCurrency['credit'] != null) {
          //1.
          // test if dealCurrency equal requiredCurrency
          if ($dealCurrency['currency_id'] == $requiredCurrencyId) {
            $result = $dealCurrency['credit'];
            $TotalCredit += $result;
            continue;
          }
          //2.
          // test if requiredCurrency is default currency
          if ($requiredCurrency['is_default']) {
            $result = $dealCurrency['credit'] * $dealCurrency['parity'];
            $TotalCredit += $result;
            continue;
          }
          //3.
          $result = ($dealCurrency['credit'] * $dealCurrency['parity']) / $this->logParity($requiredCurrencyId, $journalAccordingDate);
          $TotalCredit += $result;
        }
      }
    }
    return $TotalCredit;
  }

  // for calculating debit
  public function getDebit($dealCurrencies, $requiredCurrencyId)
  {
    // dealCurrency :there is in journalEntryRecord
    // requiredCurrency: there is in account or costCenter
    $TotalDebit = 0;
    $requiredCurrency = Currency::find($requiredCurrencyId);
    if ($dealCurrencies) {
      foreach ($dealCurrencies as $dealCurrency) {
        $journalAccordingDate = $dealCurrency['date'];
        if ($dealCurrency['debit'] != null) {
          //1.
          // test if dealCurrency equal requiredCurrency
          if ($dealCurrency['currency_id'] == $requiredCurrencyId) {
            $result = $dealCurrency['debit'];
            $TotalDebit += $result;
            continue;
          }
          //2.
          // test if requiredCurrency is default currency
          if ($requiredCurrency['is_default']) {
            $result = $dealCurrency['debit'] * $dealCurrency['parity'];
            $TotalDebit += $result;
            continue;
          }
          //3.
          $result = ($dealCurrency['debit'] * $dealCurrency['parity']) / $this->logParity($requiredCurrencyId, $journalAccordingDate);
          $TotalDebit += $result;
        }
      }
    }
    return $TotalDebit;
  }

  public function getId($model, $lm = null)
  {
    $model1 = $lm;
    foreach ($model['internalModels'] as $modelValue) {
      $model1[] = $modelValue;
      $model1 = $this->getId($modelValue, $model1);
    }
    return $model1;

  }

  public function getLeafId($model)
  {
    $result = [];
    $arr = $this->getId($model);
    if ($arr != null) {
      foreach ($arr as $a) {
        if ($a['internalModels']->isEmpty())
          $result[] = $a->id;
      }
    }
    return $result;
  }


}
