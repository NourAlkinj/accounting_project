<?php

namespace App\Http\Controllers;

use App\Events\NotificationCreated;
use App\Events\TasksUpdated;
use App\Http\Exceptions\CustomException;
use App\Http\Exceptions\NotFoundException;
use App\Http\Requests\TaskRequest;
use App\Models\Attachment;
use App\Models\Employee;
use App\Models\EmployeeTask;
use App\Models\Notification;
use App\Models\Task;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Attachment\AttachmentTrait;
use App\Traits\Common\CommonTrait;
use App\Traits\Task\TaskTrait;
use Illuminate\Support\Facades\Date;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class TaskController extends Controller
{
  use CommonTrait, ActivityLog, AttachmentTrait, TaskTrait;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }


  public function index()
  {
    $parameters = ['id' => null];
    $tasksWithEmployees = Task::with('employees', 'status')->get();
    $this->callActivityMethod('tasks', 'index', $parameters);
    return response()->json($tasksWithEmployees, 200);
  }

  public function all()
  {
    $parameters = ['id' => null];
    $tasksWithEmployees = Task::with('employees', 'status')->get();
    $this->callActivityMethod('tasks', 'allTasks', $parameters);
    return response()->json($tasksWithEmployees, 200);
  }

  public function store(TaskRequest $request)
  {
    $lang = $request->header('lang');

    try {
      $task = Task::create($request->all());

      $employeesIds = $request->employees_ids;
      foreach ($employeesIds as $employeeId) {

        EmployeeTask::create([
          'task_id' => $task->id,
          'employee_id' => $employeeId
        ]);
        if (!Employee::find($employeeId)) {
          throw new NotFoundException('Employee');
        }

        if ($request['attachments']) {
          foreach ($request['attachments'] as $attachment) {
            $tasAttachment = Attachment::find($attachment['id']);
            $tasAttachment['attachmentable_id'] = $task->id;
            $tasAttachment['attachmentable_type'] = "App\Models\Task";
//          $tasAttachment['attachmentable_type'] = $attachment['type'] ;
            $tasAttachment->save();
          }
        }


//        return $task->attachment;
        $tasAttachments = [];
        if ($task->attachment) {
          foreach ($task->attachment as $attachment) {
            $tasAttachments[] = [
              'name' => $attachment->file_name,
              'type' => $attachment->type,
              'src' => $attachment->src,
              'file_name' => $attachment->file_name
            ];

          }
        }
        $attachment_details = $task->attachment ?
          $tasAttachments
          : [
            'name' => null,
            'type' => null,
            'src' => null,
            'file_name' => null
          ];

        $task_notification = Notification::create(
          [
            'title' => 'Task From Me',
            'message' => 'do this task',
            'type' => 'task',
            'source_id' => auth('sanctum')->user()->id,
            'from_user_id' => auth('sanctum')->user()->id,
            'to_user_id' => Employee::find($employeeId)->first()->toArray()['user_id'],
            'to_employee_id' => $employeeId,
            'send_date' => Date::now('GMT'),
            'seen' => false,
            'attachment' => $task->attachment ? $attachment_details : '',
          ]
        );
//        return $task_notification->attachment;
        event(new NotificationCreated($task_notification));

      }

      $taskParameters = [
        'id' => $task->id,
        'new_employee_ids' => [],
        'old_employee_ids' => [],
        'old_task_status_id' => null,
        'new_task_status_id' => null,
      ];

      $parameters = ['request' => $request, 'id' => $task->id];

      event(new TasksUpdated([...Task::all()]));

      $this->callActivityMethod('tasks', 'store', $parameters);
      $this->callTaskActivityMethod('store', $taskParameters);

      return response()->json([
        'id' => $task->id,
        'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
      ], 200);

    } catch (CustomException $exc) {
      return response()->json(
        [
          'errors' => ['message' => [$exc->message]]
        ],
        $exc->code
      );
    } catch (NotFoundException $exc) {
      return response()->json(
        [
          'errors' => ['message' => [$exc->message]]
        ],
        $exc->code
      );
    }


  }


  public function show($id)
  {
    $parameters = ['id' => $id];
    $task = Task::with('status', 'employees', 'attachment')->find($id);
    $this->callActivityMethod('tasks', 'show', $parameters);
    return response()->json($task, 200);
  }


  public function update(TaskRequest $request, $id)
  {
    $lang = $request->header('lang');
    try {

      $old_data = Task::find($id)->toJson();
      $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
      $task = Task::find($id);

//      if ($request->has('attachments') && $task->attachment) {
//        if ($task->attachment->type === 'file') {
//          $disk = 'upload_file';
//        }
//        if ($task->attachment->type === 'Image') {
//          $disk = 'upload_image';
//        }
//        $this->deleteAttachment($disk, 'tasks/' . $task->attachment->file_name, $task->id);
//        $this->uploadAttachment($request, 'attachments', 'tasks', 'App\Models\Task', $task->id);
//
//      }


      EmployeeTask::where('task_id', $id)->delete();
      $employeesIds = $request->employees_ids;
      foreach ($employeesIds as $employeeId) {

        EmployeeTask::create([
          'task_id' => $task->id,
          'employee_id' => $employeeId
        ]);

        if (!Employee::find($employeeId)) {
          throw new NotFoundException('Employee');
        }

//        if (!Employee::find($employeeId)->first()->toArray()['user_id']) {
//          throw new CustomException('Related User Not Found', 404);
//        }


        $tasAttachments = [];
        if ($task->attachment) {
          foreach ($task->attachment as $attachment) {
            $tasAttachments[] = [
              'name' => $attachment->file_name,
              'type' => $attachment->type,
              'src' => $attachment->src,
              'file_name' => $attachment->file_name
            ];

          }
        }
        $attachment_details = $task->attachment ?
          $tasAttachments
          : [
            'name' => null,
            'type' => null,
            'src' => null,
            'file_name' => null
          ];

        $task_notification = Notification::create(
          [
            'title' => 'Task From Me',
            'message' => 'do this task',
            'type' => 'task',
            'source_id' => auth('sanctum')->user()->id,
            'from_user_id' => auth('sanctum')->user()->id,
            'to_user_id' => Employee::find($employeeId)->first()->toArray()['user_id'],
            'to_employee_id' => $employeeId,
            'send_date' => Date::now('GMT'),
            'seen' => false,
            'attachment' => $task->attachment ? $attachment_details : '',
          ]
        );
//        return $task_notification->attachment;
        event(new NotificationCreated($task_notification));


      }

      $oldTaskEmployee = [];
      $old_employees = $task->employees;
      if ($old_employees) {
        foreach ($old_employees as $old_employee) {
          $oldTaskEmployee[] = $old_employee->id;
        }
      }

      $oldTaskStatusId = null;
      $old_status = $task->status;
      if ($old_status) {
        $oldTaskStatusId = $old_status->id;
      }
      $oldTaskEmployees = $oldTaskEmployee;


      $taskParameters = [
        'id' => $task->id,
        'new_employee_ids' => $request->employees_ids,
        'old_employee_ids' => $oldTaskEmployees,
        'old_task_status_id' => $oldTaskStatusId,
        'new_task_status_id' => $request->status_id,
      ];


      $task->update($request->all());


      $this->callActivityMethod('tsaks', 'update', $parameters);
      $this->callTaskActivityMethod('update', $taskParameters);

      $data = $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang);


    event(new TasksUpdated([...Task::all()]));


    return response()->json([
      'message' => $data,
      'id' => $task->id
    ], 200);
 } catch (CustomException $exc) {
      return response()->json(
        [
          'errors' => ['message' => [$exc->message]]
        ],
        $exc->code
      );
    } catch (NotFoundException $exc) {
      return response()->json(
        [
          'errors' => ['message' => [$exc->message]]
        ],
        $exc->code
      );
    }
  }

  public function delete($id)
  {
    try {
      $lang = app('request')->header('lang');
      $parameters = ['id' => $id];
      $task = Task::find($id);
//      $task_employees_ids = $task->employees_ids;
//      foreach ($task_employees_ids as $task_employees_id) {
//        if (Employee::find($task_employees_id)) {
//          return response()->json(['message' =>
//            $this->commonMessage->t(CommonWordsEnum::this_task_is_in_use->name, $lang)
//
//    ], 200);
//        }
//      }
      if ($task->attachment) {
//        if ($task->attachment->type === 'file') {
//          $disk = 'upload_file';
//        }
//        if ($task->attachment->type === 'Image') {
//          $disk = 'upload_image';
//        }

        foreach ($task->attachment as $attachment) {
          $this->deleteAttachment('upload_file', 'tasks/' . $attachment->file_name, $task->id);
        }
      }
      $task->delete();
      $this->callActivityMethod('tasks', 'delete', $parameters);
      event(new TasksUpdated([...Task::all()]));
      return response()->json(['message' =>

        $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)

    ], 200);
  } catch (CustomException $exc) {
      return response()->json(
        [
          'errors' => ['message' => [$exc->message]]
        ],
        $exc->code
      );
    }
  }
}
