<?php

namespace App\Http\Controllers;

use App\Events\BranchesUpdated;
use App\Events\DeleteUser;
use App\Events\UserInformation;
use App\Events\UsersUpdated;
use App\Http\Exceptions\CustomException;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Activity;
use App\Models\AppSetting;
use App\Models\BillPermissionUser;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\JournalEntryPermissionUser;
use App\Models\JournalEntryRecord;
use App\Models\Language;
use App\Models\Notification;
use App\Models\ReportSetting;
use App\Models\Setting;
use App\Models\Trash;
use App\Models\User;
use App\Models\UserSetting;
use App\Models\VoucherPermissionUser;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use App\Traits\Image\ImageTrait;
use App\Traits\User\UserTrait;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt as FacadesCrypt;
use Illuminate\Support\Facades\DB;
use Lang\Locales\AuthWords;
use Lang\Locales\AuthWordsEnum;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Locales\UserWords;
use Lang\Locales\UserWordsEnum;
use Lang\Translate;


class UserController extends Controller
{
  use  ImageTrait, ActivityLog, CommonTrait, UserTrait;


  public $authMessage, $commonMessage, $userMessage;

  function __construct()
  {
    $this->userMessage = new Translate(new UserWords());
    $this->authMessage = new Translate(new AuthWords());
    $this->commonMessage = new Translate(new CommonWords());
  }


  public function login(Request $request)
  {

    $lang = $request->header('lang');
    $user = User::where('email', $request->email)
      ->orWhere('name', $request->email)
      ->first();
    if ($user && FacadesCrypt::decryptString($user->password) == $request->password) {
      $token = $user->createToken('user-token')->plainTextToken;

      $result = $this->activityParameters($lang, 'login', 'user', $user, null);

      $parameters = $result['parameters'];
      $table = $result['table'];


       $this->callActivityMethod('login', $table, $parameters);

      $data = [
        'token' => $token,
        'branch_id' => $user->branch_id,
        'id' => $user->id
      ];
      return response()->json($data, 200);

    } else {
      $errors = [
        'message' => [$this->authMessage->t(AuthWordsEnum::Invalid_login_details->name, $lang)]
      ];
      return response()->json(['errors' => $errors,
        'email' => $request->email,
        'password' => $request->password
      ], 401);
    }
  }

  public function index()
  {
    $user = User::select('id', 'name', 'code', 'is_active')->get();
    return $user;
  }

  public function all()
  {

    $users = User::all();
    foreach ($users as $user) {
      $user->password = FacadesCrypt::decryptString($user->password);
    }
    return $users;
  }

  public function store(StoreUserRequest $request)
  {
    $lang = $request->header('lang');

    DB::beginTransaction();
    try {
      $request['password'] = FacadesCrypt::encryptString($request->password);
      $request['is_active'] = true;
      $user = User::create($request->all());
      if ($this->getCountRawsInModel(User::class) == 1) {
        $this->updateValueInDB($user->id, User::class, 'is_root', true);
      }
      $parameters = ['request' => $request, 'id' => $user->id];
      $this->setUserRole($user, $request);
      $this->setUserPermissions($user, $request);
      $this->setJournalEntryPermissionUser($user->id);
      $this->setUserHomeSetting($user->id);
      $this->saveImage($request, 'photo', 'users', 'upload_image', $user->id, 'App\Models\User');


      $result = $this->activityParameters($lang, 'store', 'user', $user, null);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('store', $table, $parameters);


      event(new BranchesUpdated([...Branch::with('users')->get()]));

      event(new UsersUpdated([...User::all()]));

      DB::commit();
      return [
        'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
        'id' => $user->id,
        'branch_id' => $user->branch_id,
    ];
        } catch (CustomException $exc) {
      DB::rollback();
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
    $lang = app('request')->header('lang');
    $parameters = ['id' => $id];
    $user = User::with('permissions', 'roles')->find($id);

    if ($user) {

      $user->password = FacadesCrypt::decryptString($user->password);
      $user['role'] = $user->getRoleNames()[0] ?? "";

      return response([
        'User' => $user
      ], 200);

    } else {
      $errors = [
        'message' => [$this->userMessage->t(UserWordsEnum::user_not_found->name, $lang)]
      ];
        return response()->json(['errors' => $errors], 404);

    }
  }

  public function update(UpdateUserRequest $request, $id)
  {
    $lang = $request->header('lang');
    $old_data = User::find($id)->toJson();
    $user = User::find($id);

    DB::beginTransaction();
    try {
      $this->removeAllRolesFromUser($user);
      $this->setUserRole($user, $request);
      $this->setUserPermissions($user, $request);
      if ($user->image) {
        $this->deleteImage('upload_image', 'users/' . $user->image->file_name, $user->id);
      }
      $this->saveImage($request, 'photo', 'users', 'upload_image', $user->id, 'App\Models\User');
      $request['password'] = FacadesCrypt::encryptString($request->password);
      $user->update($request->all());
      $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
      event(new UsersUpdated([...User::all()]));
      $user->load('roles', 'permissions'); //$user->with('roles', 'permissions')->get()
      event(new BranchesUpdated([...Branch::with('users')->get()]));
      broadcast(new UserInformation($user))->toOthers();


      $result = $this->activityParameters($lang, 'update', 'user', $user, $old_data);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('update', $table, $parameters);


      DB::commit();
      return [
        'user' => $user,

        'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
        'type' => 'Success',
        'id' => $user->id,
        'branch_id' => $user->branch_id
    ];
    } catch (CustomException $exc) {
      DB::rollback();
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }


  public function delete($id)
  {
    $lang = app('request')->header('lang');

    $user = User::find($id);


    if ($user['is_root'] == true) {
      $errors = [
        'message' => [$this->userMessage->t(UserWordsEnum::admin_can_not_be_deleted->name, $lang)]
      ];
      return response()->json(['errors' => $errors], 404);
    }

    DB::beginTransaction();
    try {
      broadcast(new DeleteUser($user))->toOthers();
      if ($user->image) {
        $this->deleteImage('upload_image', 'users/' . $user->image->file_name, $user->id);
      }

      if ($this->isUseUser($id)) {
        $errors = ['user' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }

      $result = $this->activityParameters($lang, 'delete', 'user', $user, null);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('delete', $table, $parameters);


      $user->delete();
      event(new BranchesUpdated([...Branch::with('users')->get()]));
      event(new UsersUpdated([...User::all()]));
      DB::commit();
      return response()->json([

        'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)

    ], 200);
  } catch (CustomException $exc) {
      DB::rollback();
      return response()->json(
        [
          'errors' => ['message' => [$exc->message]]
        ],
        $exc->code
      );
    }
  }


  public function callGenerateCodes($id)
  {
    return $this->generateCodes($id, Branch::class, User::class, 'branch_id');
  }

  public function callGetAllCodesAndNames()
  {
    return $this->getAllCodesAndNames(User::class);
  }

  public function callGetAllIDs()
  {
    return $this->getAllIDs(User::class);
  }

  public function callGetObjectByValue($code)
  {
    return $this->getObjectByValue(User::class, $code, 'code');
  }

  public function callGetCountRawsInModel()
  {
    return $this->getCountRawsInModel(User::class);
  }

  public function lastId()
  {

    return $this->generateModelID(User::class) - 1;
  }

  public function callGetParentName($id)
  {
    return $this->getParentName(User::class, $id);
  }


  public function callRoot()
  {
    return $this->rootModel(User::class);
  }


  public function callNotRoot()
  {
    return $this->notRootModel(User::class);
  }


  public function isUseUser($user_id)
  {
      //user related to activity
      $activity = Activity::where(function ($query) use ($user_id) {
      $query->where('user_id', $user_id);
    })->first();
    if ($activity != null)
      return true;
//      return ['activityId' => $activity->id, 'table' => 'activities'];

//    $appSetting = AppSetting::where(function ($query) use ($user_id) {
//      $query->where('user_id', $user_id);
//    })->first();
//    if ($appSetting != null)
//      return true;
////      return ['appSettingId' => $appSetting->id, 'table' => 'app_settings'];

//       //user related to bill permission user
//        $billPermissionUser = BillPermissionUser::where(function ($query) use ($user_id) {
//            $query->where('user_id', $user_id);
//        })->first();
//      if ($billPermissionUser != null)
//          return true;
////      return ['billPermissionUserId' => $billPermissionUser->id, 'table' => 'bill_permission_users'];

    //user related to employee
    $employee = Employee::where(function ($query) use ($user_id) {
      $query->where('user_id', $user_id);
    })->first();
    if ($employee != null)
      return true;
//      return ['employeeId' => $employee->id, 'table' => 'employees'];

//    //user related to journal entry permission user
//    $journalEntryPermissionUser = JournalEntryPermissionUser::where(function ($query) use ($user_id) {
//      $query->where('user_id', $user_id);
//    })->first();
//    if ($journalEntryPermissionUser != null)
//      return true;
////      return ['journalEntryPermissionUserId' => $journalEntryPermissionUser->id, 'table' => 'journal_entry_permission_users'];

//    //user related to journal entry record
//    $journalEntryRecord = JournalEntryRecord::where(function ($query) use ($user_id) {
//      $query->where('user_id', $user_id);
//    })->first();
//    if ($journalEntryRecord != null)
//      return true;
////      return ['journalEntryRecordId' => $journalEntryRecord->id, 'table' => 'journal_entry_records'];


//    //user related to notification
//    $notification = Notification::where(function ($query) use ($user_id) {
//      $query->where('from_user_id', $user_id)->orWhere('to_user_id', $user_id);
//    })->first();
//    if ($notification != null)
//      return true;
////      return ['notificationId' => $notification->id, 'table' => 'notifications'];

    //user related to report setting
    $reportSetting = ReportSetting::where(function ($query) use ($user_id) {
      $query->where('user_id', $user_id);
    })->first();
    if ($reportSetting != null)
      return true;
//      return ['reportSettingId' => $reportSetting->id, 'table' => 'report_settings'];

//    //user related to setting
//    $setting = Setting::where(function ($query) use ($user_id) {
//      $query->where('user_id', $user_id);
//    })->first();
//    if ($setting != null)
//      return true;
////      return ['settingId' => $setting->id, 'table' => 'settings'];

//    //user related to Trash
//    $trash = Trash::where(function ($query) use ($user_id) {
//      $query->where('user_id', $user_id);
//    })->first();
//    if ($trash != null)
//      return true;
////      return ['trashId' => $trash->id, 'table' => 'trashes'];

//    //user related to user setting
//    $userSetting = UserSetting::where(function ($query) use ($user_id) {
//      $query->where('user_id', $user_id);
//    })->first();
//    if ($userSetting != null)
//      return true;
////      return ['userSettingId' => $userSetting->id, 'table' => 'user_settings'];

//    //user related to voucher permission user
//    $voucherPermissionUser = VoucherPermissionUser::where(function ($query) use ($user_id) {
//      $query->where('user_id', $user_id);
//    })->first();
//    if ($voucherPermissionUser != null)
//      return true;
////      return ['voucherPermissionUserId' => $voucherPermissionUser->id, 'table' => 'voucher_permission_users'];


//    return ['id' => null, 'table' => null];
    return false;
  }


}
