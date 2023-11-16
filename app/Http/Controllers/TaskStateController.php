<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\CustomException;
use App\Http\Requests\TaskStateRequest;
use App\Models\EmployeeTask;
use App\Models\Task;
use App\Models\TaskState;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use Illuminate\Http\Request;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class TaskStateController extends Controller
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
    $taskStates = TaskState::with('tasks')->get();;
    $this->callActivityMethod('task-states', 'index', $parameters);
    return response()->json($taskStates, 200);
  }

  public function StatesUpdate(Request $request)
  {
    try {
      $allStates = TaskState::all();
      foreach ($allStates as $state) {
        $tasks = $state->tasks;
      }
      foreach ($tasks as $task) {
        $task->delete();
      }
      TaskState::with('tasks')->delete();
      foreach ($request->status as $State) {
        $state = TaskState::create([
          'name' => $State['name'],
          'color' => $State['color'],
        ]);
        foreach ($State['tasks'] as $task) {
          $state->tasks()->create([
//        Task::create([
            'name' => $task['name'],
            'employees_ids' => $task['employees_ids'],
            'description' => $task['description'],
            'color' => $task['color'],
            'start_date' => $task['start_date'],
            'start_time' => $task['start_time'],
            'end_date' => $task['end_date'],
            'end_time' => $task['end_time'],
            'status_id' => $state->id,
            'attachment_id' => $task['attachment_id'],
            'notes' => $task['notes'],
            'is_active' => $task['is_active'],
            'priority' => $task['priority'],
            'supervisor_id' => $task['supervisor_id'],
            'remind_date' => $task['remind_date'],
            'remind_time' => $task['remind_time'],
            'remind_message' => $task['remind_message'],
            'is_terminated' => $task['is_terminated'],
            'terminate_date' => $task['terminate_date'],
            'terminate_reason' => $task['terminate_reason'],
            'font_color' => $task['font_color'],
            'icon' => $task['icon'],
          ]);
        }
      }
    } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }

  public function transferTask(Request $request)
  {
    $task = Task::find($request->task_id);
    EmployeeTask::where('task_id', $task->id)->delete();
    $new_employee_ids = $request->new_employee_id;
    $newIDS = [];
    foreach ($new_employee_ids as $new_id) {
      $newIDS[] = $new_id;
      EmployeeTask::create([
        'task_id' => $task->id,
        'employee_id' => $new_id
      ]);
    }
    $task['employees_ids'] = $newIDS;
    $task->save();

  }


  public function updateTaskState(Request $request)
  {
    try {
      $task = Task::find($request->task_id);
      $new_status_id = $request->new_status_id;
      $task['status_id'] = $new_status_id;
      $task->save();
    } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }

  public function store(TaskStateRequest $request)
  {
    try {
      $lang = $request->header('lang');
      $taskState = TaskState::create($request->all());
      $parameters = ['request' => $request, 'id' => $taskState->id];
      $this->callActivityMethod('tasks-state', 'store', $parameters);
      return response()->json([
//      'message' => __('common.store'),
        'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
      'id' => $taskState->id,
    ], 200);
  } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }


  public function show($id)
  {
    $parameters = ['id' => $id];
    $taskState = TaskState::with('tasks')->find($id);
    $this->callActivityMethod('task-states', 'show', $parameters);
    return response()->json($taskState, 200);
  }


  public function update(TaskStateRequest $request, $id)
  {
    try {
      $lang = $request->header('lang');
      $old_data = TaskState::find($id)->toJson();
      $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
      $taskState = TaskState::find($id);
      $taskState->update($request->all());
      $this->callActivityMethod('tsaks', 'update', $parameters);
//    $data = __('common.update');
      return response()->json([
        'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
      'id' => $taskState->id
    ], 200);
  } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }

  public function delete($id)
  {
    try {
      $lang = app('request')->header('lang');
      $parameters = ['id' => $id];
      $taskState = TaskState::find($id);
      if ($taskState == 'In Progress' || $taskState == 'Finished') {
        return __('task.task_state_can_not_be_deleted');
      }
      $taskState->delete();
      $this->callActivityMethod('task-states', 'delete', $parameters);
      return response()->json(['message' =>
//      __('common.delete')
        $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)
    ], 200);
  } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }

}
