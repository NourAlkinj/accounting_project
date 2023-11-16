<?php

namespace App\Traits\Task;

use App\Http\Requests\TaskRequest;
use App\Models\Attachment;
use App\Models\Employee;
use App\Models\EmployeeTask;
use App\Models\Task;
use App\Models\TaskActivity;
use App\Models\TaskState;
use Doctrine\DBAL\Exception\DatabaseObjectNotFoundException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\JsonException;


trait  TaskTrait
{


  public function taskActivity($activity)
  {

    TaskActivity::create([
      'task_id' => $activity['taskParameters']['id'],
      'old_employee_ids' => $activity['taskParameters']['old_employee_ids'],
      'new_employee_ids' => $activity['taskParameters']['new_employee_ids'],
      'old_task_status_id' => $activity['taskParameters']['old_task_status_id'],
      'new_task_status_id' => $activity['taskParameters']['new_task_status_id'],
      'operation' => $activity['operation']
    ]);
  }


  public function getTaskState($id)
  {
    return Task::find($id)->state;

  }

  public function getTaskSupervisor($id)
  {

    $supervisorId = Task::find($id)->supervisor_id;
//    return $supervisorId;
    return Employee::where('id', $supervisorId)->first();
  }

  public function getSupervisorTask($id)
  {
    return Task::where('supervisor_id', $id)->get();

  }


  public function getStateTasks($id)
  {
    return TaskState::find($id)->tasks;
  }

  public function getTaskEmployees($id)
  {
    return Task::find($id)->employees;

  }

  public function getEmployeesTasks()
  {
    return Employee::with('tasks')->get();
  }

  public function getEmployeeWithTasks($id)
  {
    return Employee::with('tasks')->find($id);
  }



  public function swapTask(TaskRequest $request)
  {
    EmployeeTask::where('task_id', $request->task_id)->delete();

    EmployeeTask::create([
      'task_id' => $request->task_id,
      'employee_id' => $request->to_emp_id
    ]);

    $task = Task::find($request->task_id);

    $newEmpIds = array_filter($task->employees_ids, function ($empId) use ($request) {
      return intval($empId) != intval($request->from_emp_id);
    });
    $newEmpIds[] = intval($request->to_emp_id);

    $task->employees_ids = $newEmpIds;

    $task->save();

    return response()->json([
      'message' => __('common.update')
    ], 200);

  }

  public function removeTaskFromEmployee(TaskRequest $request)
  {
    EmployeeTask::where("task_id", $request->task_id)->where('employee_id', $request->employee_id)->delete();

    $task = Task::find($request->task_id);

    $newEmpIds = array_filter($task->employees_ids, function ($empId) use ($request) {
      return intval($empId) != intval($request->employee_id);
    });

    $task->employees_ids = $newEmpIds;

    $task->save();

    return response()->json([
      'message' => __('common.delete')
    ], 200);
  }

  public function updateTasksState(TaskRequest $request)
  {

    try {

      foreach ($request->tasksStateMap as $stateId => $tasksIds) {
        foreach ($tasksIds as $taskId) {
          $task = Task::find($taskId);
          if (!isset($task->status_id)) throw new Exception('Status Not Found');
          $task->status_id = $stateId;
          $task->save();
        }
      }

      return response()->json([
        'message' => __('common.update')
      ], 200);


    } catch (DatabaseObjectNotFoundException $exc) {

      return response()->json([
        'message' => __('common.update error')
      ], 200);

    } catch (JsonException $exc) {

      return response()->json([
        'message' => __('common.update error')
      ], 200);

    } catch (Exception $exc) {

      return response()->json([
        'message' => $exc->getMessage()
      ], 200);

    }

  }



}
