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

    $journalEntryPermissionUser = JournalEntryPermissionUser::all();

    return response()->json($journalEntryPermissionUser, 200);
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

        $this->commonMessage->t(CommonWordsEnum::save->name, $lang)

      ], 200);
  } catch (CustomException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors' => $errors], $exc->code);
    }
  }

  public function show($id)
  {

    $journalEntryPermissionUser = JournalEntryPermissionUser::find($id);

    return response()->json($journalEntryPermissionUser, 200);
  }


  public function update(JournalEntriesRequest $request, $id)
  {
    try {
      $lang = $request->header('lang');

      $journalEntryPermissionUser = JournalEntryPermissionUser::find($id);
      $journalEntryPermissionUser->update($request->all());


      return response()->json(['message' =>

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

      $journalEntryPermissionUser = JournalEntryPermissionUser::find($id);
      $journalEntryPermissionUser->delete();

      return response()->json(['message' =>

        $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)

    ], 200);
  } catch (CustomException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors' => $errors], $exc->code);
    }
  }
}
