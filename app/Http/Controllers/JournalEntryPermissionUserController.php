<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\CustomException;
use App\Http\Requests\JournalEntriesRequest;
use App\Http\Requests\StoreJournalEntryPermissionUserRequest;
use App\Http\Requests\UpdateJournalEntryPermissionUserRequest;
use App\Models\JournalEntryPermissionUser;
use App\Models\User;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use App\Traits\JournalEntry\JournalEntryRecordTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;


class JournalEntryPermissionUserController extends Controller
{

  use CommonTrait, ActivityLog, JournalEntryRecordTrait;

  function __construct()
  {

    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()
  {
    $parameters = ['id' => null];
    $journalEnteryPermissionaUser = JournalEntryPermissionUser::all();
    $this->callActivityMethod('journal_entry_permission_users', 'index', $parameters);
    return response()->json($journalEnteryPermissionaUser, 200);
  }

  public function store(JournalEntriesRequest $request)
  {
    try {
      $lang = $request->header('lang');
      $id = auth('sanctum')->user()->id;
      $oldJournalEntryPermissionsUser = User::find($id)->journalEntryPermissionUser;
      if ($oldJournalEntryPermissionsUser) {
        $oldJournalEntryPermissionsUser->forceDelete();
      }
      JournalEntryPermissionUser::create(
        [
          'print_setting' => $request['print_setting'],
          'show_setting' => $request['show_setting'],
          'user_id' => $id,
        ]
      );
      return response()->json(['message' =>
//      __('common.update')
        $this->commonMessage->t(CommonWordsEnum::save->name, $lang)

      ], 200);
  } catch (CustomException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors' => $errors], $exc->code);
    }
  }

  public function show($id)
  {
    $parameters = ['id' => null];
    $journalEnteryPermissionaUser = JournalEntryPermissionUser::find($id);
    $this->callActivityMethod('journal_entry_permission_users', 'show', $parameters);
    return response()->json($journalEnteryPermissionaUser, 200);
  }


  public function update(JournalEntriesRequest $request, $id)
  {
    try {
      $lang = $request->header('lang');
      $old_data = JournalEntryPermissionUser::find($id)->toJson();
      $journalEnteryPermissionUser = JournalEntryPermissionUser::find($id);
      $journalEnteryPermissionUser->update($request->all());
      $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
      $this->callActivityMethod('journal_entry_permission_users', 'update', $parameters);
      return response()->json(['message' =>
//      __('common.update')
        $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang)

    ], 200);
  } catch (CustomException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors' => $errors], $exc->code);
    }
  }


  public function delete($id)
  {
    try {
      $lang = app('request')->header('lang');
      $parameters = ['id' => $id];
      $journalEnteryPermissionUser = JournalEntryPermissionUser::find($id);
      $journalEnteryPermissionUser->delete();
      $this->callActivityMethod('journal_entry_permission_users', 'delete', $parameters);
      return response()->json(['message' =>
//      __('common.delete')
        $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)

    ], 200);
  } catch (CustomException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors' => $errors], $exc->code);
    }
  }
}
