<?php

namespace App\Http\Controllers;

use App\Events\DepartmentUpdated;
use App\Http\Exceptions\CustomException;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

//use App\Traits\CommonNour\CommonNourTrait;

class DepartmentController extends Controller
{
  use  ActivityLog, CommonTrait;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()
  {
    $parameters = ['id' => null];
    $DepartmentsAndEmployeesTree = Department::whereNull('department_id')->with('children', 'employees')->get();
    $this->callActivityMethod('departments', 'Main Tree', $parameters);
    return response()->json($DepartmentsAndEmployeesTree, 200);
  }

  public function all()
  {
    $parameters = ['id' => null];
    $departments = Department::with('employees')->get();
    $this->callActivityMethod('departments', 'all', $parameters);
    return response()->json($departments, 200);
  }

  public function store(StoreDepartmentRequest $request)
  {
    try {
      $lang = $request->header('lang');

      $department = Department::create($request->all());
      if ($this->getCountRawsInModel(Department::class) == 1) {
        $this->updateValueInDB($department->id, Department::class, 'is_root', true);
      }
      $parameters = ['request' => $request, 'id' => $department->id];
      $this->callActivityMethod('departments', 'store', $parameters);
      event(new DepartmentUpdated([...Department::all()]));

      return response()->json([
//      'message' => __('common.store'),
        'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
      'id' => $department->id,
      'department_id' => $department->department_id,
    ], 200);
  } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }

  public function show($id)
  {
    $parameters = ['id' => $id];
    $department = Department::with('employees.tasks')->find($id);
    $this->callActivityMethod('departments', 'show', $parameters);
    return response()->json($department, 200);
  }

  public function update(UpdateDepartmentRequest $request, $id)
  {
    try {
      $lang = $request->header('lang');
      $old_data = Department::find($id)->toJson();
      $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
      $department = Department::find($id);

      $department->update($request->all());
      $this->callActivityMethod('departments', 'update', $parameters);
      event(new DepartmentUpdated([...Department::all()]));
      return response()->json([
         'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
        'id' => $department->id,
        'department_id' => $department->department_id
    ], 200);
  } catch (CustomException $exc) {
      $errors = ['message' =>[ $exc->message]];
      return response()->json(['errors'=> $errors], $exc->code);
    }
  }

  public function delete($id)
  {
    try {
      $lang = app('request')->header('lang');
      $parameters = ['id' => $id];
      $department = Department::find($id);
      if ($department->is_root == true) {
        $errors = ['message' => [
           $this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang),
      ]];
      return response()->json(['errors' => $errors], 400);
    }
      if ($this->numOfSubChilds(Department::class, Employee::class, $id, 'department_id') > 0) {
        $errors = ['message' => [
          $this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang),
      ]];
      return response()->json(['errors' => $errors], 400);
    }
      $department->delete();
      $this->callActivityMethod('departments', 'delete', $parameters);
      event(new DepartmentUpdated([...Department::all()]));
      return response()->json([

        'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang),
    ], 200);
  } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }

  public function callAutoComplete($id)
  {
    return $this->AutoCompleteCategory($id, Department::class, 'department_id', 'id', '!=', null, false, null, null);

   }

  public function callGenerateCodes($id)
  {
    return $this->generateCodes($id, Department::class, Department::class, 'department_id');
  }


}
