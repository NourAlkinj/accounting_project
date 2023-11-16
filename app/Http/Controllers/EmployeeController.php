<?php

namespace App\Http\Controllers;

use App\Events\EmployeesUpdated;
use App\Http\Exceptions\CustomException;
use App\Http\Exceptions\NotFoundException;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class EmployeeController extends Controller
{

  use CommonTrait, ActivityLog;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()
  {
    $parameters = ['id' => null];
    $employees = Employee::all();
    $this->callActivityMethod('employees', 'index', $parameters);
    return response()->json($employees, 200);
  }


  public function all()
  {
    $parameters = ['id' => null];
    $employees = Employee::all();
    $this->callActivityMethod('employees', 'allEmployees', $parameters);
    return response()->json($employees, 200);
  }


  public function store(StoreEmployeeRequest $request)
  {
    try {
      $lang = $request->header('lang');

      if ($request['department_id'] == null || !Department::find($request['department_id'])) {
        throw new NotFoundException('Department ');
      }

      $employee = Employee::create($request->all());
      $parameters = ['request' => $request, 'id' => $employee->id];
      $this->callActivityMethod('employees', 'store', $parameters);
      event(new EmployeesUpdated([...Employee::all()]));
      return response()->json([
        'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),

            'id' => $employee->id,
            'department_id' => $employee->department_id,
        ], 200);
    } catch (NotFoundException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors'=> $errors], $exc->code);
    }
    catch (CustomException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors'=> $errors], $exc->code);
    }
  }


  public function show($id)
  {
    $parameters = ['id' => $id];
    $employee = Employee::find($id);
    $this->callActivityMethod('employees', 'show', $parameters);
    return response()->json($employee, 200);
  }


  public function update(UpdateEmployeeRequest $request, $id)
  {
    try {
      $lang = $request->header('lang');
      $old_data = Employee::find($id)->toJson();
      $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
      $employee = Employee::find($id);

      if ($request['department_id'] == null || !Department::find($request['department_id'])) {
        throw new NotFoundException('Department');
      }

      $employee->update($request->all());
      $this->callActivityMethod('employees', 'update', $parameters);
      event(new EmployeesUpdated([...Employee::all()]));
      $data = $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang);

        return response()->json([
          'message' => $data,
          'id' => $employee->id,
          'department_id' => $employee->department_id,
        ], 200);
    } catch (NotFoundException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors'=> $errors], $exc->code);
    }
    catch (CustomException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors'=> $errors], $exc->code);
    }
  }

  public function delete($id)
  {
    try {
      $lang = app('request')->header('lang');
      $parameters = ['id' => $id];
      $employee = Employee::find($id);
      $employee->delete();
      $this->callActivityMethod('employees', 'delete', $parameters);
      event(new EmployeesUpdated([...Employee::all()]));

      return response()->json(['message' =>

        $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)
        ], 200);
    } catch (CustomException $exc) {

      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }


  public function callGenerateCodes($id)
  {
    return $this->generateCodes($id, Department::class, Employee::class, 'department_id');
  }



}
