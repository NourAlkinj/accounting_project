<?php

namespace App\Http\Controllers;

use App\Events\EmployeesUpdated;
use App\Http\Exceptions\CustomException;
use App\Http\Exceptions\NotFoundException;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeTask;
use App\Models\JournalEntryRecord;
use App\Models\Notification;
use App\Models\TaskActivity;
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

        $employees = Employee::all();
        return response()->json($employees, 200);
    }


    public function all()
    {

        $employees = Employee::all();

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
            $result = $this->activityParameters($lang, 'store', 'employee', $employee, null);
            $parameters = $result['parameters'];
            $table = $result['table'];
            $this->callActivityMethod('store', $table, $parameters);

            event(new EmployeesUpdated([...Employee::all()]));
            return response()->json([
                'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),

            'id' => $employee->id,
            'department_id' => $employee->department_id,
        ], 200);
    } catch (NotFoundException $exc) {
            $errors = ['message' => [$exc->message]];
            return response()->json(['errors' => $errors], $exc->code);
        } catch (CustomException $exc) {
            $errors = ['message' => [$exc->message]];
            return response()->json(['errors' => $errors], $exc->code);
        }
    }


    public function show($id)
    {

        $employee = Employee::find($id);

        return response()->json($employee, 200);
    }


    public function update(UpdateEmployeeRequest $request, $id)
    {
        try {
            $lang = $request->header('lang');
            $old_data = Employee::find($id)->toJson();

            $employee = Employee::find($id);

            if ($request['department_id'] == null || !Department::find($request['department_id'])) {
                throw new NotFoundException('Department');
            }

            $employee->update($request->all());
            $result = $this->activityParameters($lang, 'update', 'employee', $employee, $old_data);
            $parameters = $result['parameters'];
            $table = $result['table'];
            $this->callActivityMethod('update', $table, $parameters);

            event(new EmployeesUpdated([...Employee::all()]));
            $data = $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang);

        return response()->json([
            'message' => $data,
            'id' => $employee->id,
            'department_id' => $employee->department_id,
        ], 200);
    } catch (NotFoundException $exc) {
            $errors = ['message' => [$exc->message]];
            return response()->json(['errors' => $errors], $exc->code);
        } catch (CustomException $exc) {
            $errors = ['message' => [$exc->message]];
            return response()->json(['errors' => $errors], $exc->code);
        }
    }

    public function delete($id)
    {
        try {
            $lang = app('request')->header('lang');

      $employee = Employee::find($id);

        if($this->isUseEmployee($id)) {
            $errors = ['employee' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }

        $employee->delete();
      $result = $this->activityParameters($lang, 'delete', 'employee', $employee,     null);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('delete', $table, $parameters);
      event(new EmployeesUpdated([...Employee::all()]));
            $employee = Employee::find($id);
            $employee->delete();
            $result = $this->activityParameters($lang, 'delete', 'employee', $employee, null);
            $parameters = $result['parameters'];
            $table = $result['table'];
            $this->callActivityMethod('delete', $table, $parameters);
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

    public function isUseEmployee($employee_id)
    {
        //employee related to employee
        $employee = Employee::where(function ($query) use ($employee_id) {
            $query->where('employee_id', $employee_id);
        })->first();
        if ($employee != null)
            return true;
//      return ['employeeId' => $employee->id, 'table' => 'employees'];

        //account related to employeeTask
        $employeeTask = EmployeeTask::where(function ($query) use ($employee_id) {
            $query->where('employee_id', $employee_id);
        })->first();
        if ($employeeTask != null)
            return true;
//      return ['employeeTaskId' => $employeeTask->id, 'table' => 'employee_tasks'];

        //account related to journalEntryRecord
        $journalEntryRecord = JournalEntryRecord::where(function ($query) use ($employee_id) {
            $query->where('employee_id', $employee_id);
        })->first();
        if ($journalEntryRecord != null)
            return true;
//      return ['journalEntryRecordId' => $journalEntryRecord->id, 'table' => 'journal_entry_records'];

        //account related to notification
        $notification = Notification::where(function ($query) use ($employee_id) {
            $query->where('to_employee_id', $employee_id);
        })->first();
        if ($notification != null)
            return true;
//      return ['notificationId' => $notification->id, 'table' => 'notifications'];

        //account related to taskActivity
        $taskActivity = TaskActivity::where(function ($query) use ($employee_id) {
            $query->where('old_employee_ids', $employee_id)->orWhere('new_employee_ids', $employee_id);
        })->first();
        if ($taskActivity != null)
            return true;
//      return ['taskActivityId' => $taskActivity->id, 'table' => 'task_activities'];

//    return ['id' => null, 'table' => null];
        return false;
    }
}


