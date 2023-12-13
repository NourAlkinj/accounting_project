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

    $DepartmentsAndEmployeesTree = Department::whereNull('department_id')->with('children', 'employees')->get();

    return response()->json($DepartmentsAndEmployeesTree, 200);
  }

  public function all()
  {

    $departments = Department::with('employees')->get();

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

      $result = $this->activityParameters($lang, 'store', 'department', $department,     null);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('store', $table, $parameters);      event(new DepartmentUpdated([...Department::all()]));

      return response()->json([

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

    $department = Department::with('employees.tasks')->find($id);

    return response()->json($department, 200);
  }

  public function update(UpdateDepartmentRequest $request, $id)
  {
    try {
      $lang = $request->header('lang');
      $old_data = Department::find($id)->toJson();

      $department = Department::find($id);

      $department->update($request->all());

      $result = $this->activityParameters($lang, 'update', 'department', $department,     $old_data);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('update', $table, $parameters);      event(new DepartmentUpdated([...Department::all()]));

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

        if($this->isUseDepartment($id)) {
            $errors = ['department' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }

      $department->delete();
      $result = $this->activityParameters($lang, 'delete', 'department', $department,     null);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('delete', $table, $parameters);
//      event(new DepartmentUpdated([...Department::all()]));

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

    public function isUseDepartment($department_id)
    {
        //department related to department
        $department = Department::where(function ($query) use ($department_id) {
            $query->where('department_id', $department_id);})->first();
        if ($department != null)
            return true;
//      return ['departmentId' => $department->id, 'table' => 'departments'];

        //department related to employee
        $employee = Employee::where(function ($query) use ($department_id) {
            $query->where('department_id', $department_id);})->first();
        if ($employee != null)
            return true;
//      return ['employeeId' => $employee->id, 'table' => 'employees'];


//    return ['id' => null, 'table' => null];
        return false;

    }


}
