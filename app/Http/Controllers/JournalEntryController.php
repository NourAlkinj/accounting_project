<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\CustomException;
use App\Http\Requests\JournalEntriesRequest;
use App\Models\Account;
use App\Models\CostCenter;
use App\Models\JournalEntry;
use App\Models\JournalEntryRecord;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use App\Traits\JournalEntry\JournalEntryRecordTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class JournalEntryController extends Controller
{
  use CommonTrait, ActivityLog, JournalEntryRecordTrait;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function init()
  {
    $data = [
      'leafNormalAccounts' => $this->getAllLeafModelsWithCondition(Account::class, 'account_id', 'is_normal', true),
      'leafNormalCostCenters' => $this->getAllLeafModelsWithCondition(CostCenter::class, 'cost_center_id', 'is_normal', true),
    ];
    return response()->json($data, 200);
  }

  public function index()
  {


    $fistJournalEntry = JournalEntry::with('records')->first();
    $pagination = JournalEntry::with('branch', 'currency')->select('id', 'branch_id', 'date', 'currency_id')->get();

    $data = [
      'first_journal_entry' => $fistJournalEntry,
      'pagination' => $pagination
    ];
    return response()->json([
      $data
    ], 200);
  }


  public function store(JournalEntriesRequest $request)
  {

    try {
      $lang = $request->header('lang');
      $journalEntry = JournalEntry::create(
         $request->all()

      );
      $this->saveJournalEntryRecord($request, $journalEntry->id);

      $result = $this->activityParameters($lang, 'store', 'journalEntry', $journalEntry,   'pc_name', null);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('store', $table, $parameters);

      return response()->json([

        'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
        'type' => 'Success',
        'id' => $journalEntry->id,
      ], 200);

  } catch (CustomException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors'=> $errors], $exc->code);
    }

  }


  public function show($id)
  {

    $journalEntry = JournalEntry::with('records')->find($id);
    if ($journalEntry) {

      return $journalEntry;
    }
  }


  public function update(JournalEntriesRequest $request, $id)
  {
    try {
      $lang = $request->header('lang');
      $old_data = JournalEntry::find($id)->toJson();

      $journalEntry = JournalEntry::find($id);
      $journalEntry->update(
       $request->all()

      );
      $this->saveJournalEntryRecord($request, $journalEntry->id);

      $result = $this->activityParameters($lang, 'update', 'journalEntry', $journalEntry,   'pc_name', $old_data);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('update', $table, $parameters);

      return response()->json([

        'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
      'id' => $journalEntry->id,
    ], 200);
  } catch (CustomException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors'=> $errors], $exc->code);
    }
  }

  public function delete($id)
  {
    try {
      $lang = app('request')->header('lang');

      $journalEntry = JournalEntry::find($id);
      $JournalEntry_Records = $journalEntry->records;
      foreach ($JournalEntry_Records as $JournalEntry_Record) {
        $JournalEntry_Record->delete();
      }
      if (!$journalEntry) {
        $errors = ['message' => [

          $this->commonMessage->t(CommonWordsEnum::journalEntry_not_found->name, $lang),

      ]];
      return response()->json(['errors' => $errors], 404);
    }
      $journalEntry->delete();
      $result = $this->activityParameters($lang, 'delete', 'journalEntry', $journalEntry,   'pc_name', null);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('delete', $table, $parameters);
      return response()->json([

        'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)], 200);
  } catch (CustomException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors'=> $errors], $exc->code);
    }
  }


  public function restoreJournalEntryRecords($id)
  {
    try {
      $lang = app('request')->header('lang');
      $journalEntry = JournalEntry::withTrashed()->find($id);
      $JournalEntry_Records = JournalEntryRecord::withTrashed()->where('journal_entry_id', $id);
      if ($journalEntry && $JournalEntry_Records) {
        $journalEntry->restore();
        $JournalEntry_Records->restore();

        $result = $this->activityParameters($lang, 'restore', 'journalEntry', $journalEntry,   'pc_name', null);
        $parameters = $result['parameters'];
        $table = $result['table'];
        $this->callActivityMethod('restore', $table, $parameters);

        return response()->json(['message' =>

        [  $this->commonMessage->t(CommonWordsEnum::RESTORE->name, $lang)]
      ], 200);
    } else {
        return response()->json(['message' =>

         [ $this->commonMessage->t(CommonWordsEnum::ERROR_RESTORE->name, $lang)]
      ], 404);
    }
    } catch (CustomException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors'=> $errors], $exc->code);
    }
  }


  public function forceDelete($id)
  {
    try {
      $lang = app('request')->header('lang');

      $journalEntry = JournalEntry::find($id);
      $JournalEntry_Records = $journalEntry->records;
      foreach ($JournalEntry_Records as $JournalEntry_Record) {
        $JournalEntry_Record->forceDelete();
      }
      if (!$journalEntry) {
        $errors = ['message' => [

          $this->commonMessage->t(CommonWordsEnum::journalEntry_not_found->name, $lang)

      ]];
      return response()->json(['errors' => $errors], 404);
    }
      $journalEntry->forceDelete();
      $result = $this->activityParameters($lang, 'forceDelete', 'journalEntry', $journalEntry,   'pc_name', null);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('forceDelete', $table, $parameters);
      return response()->json(['message' =>

        $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)
      ], 200);
  } catch (CustomException $exc) {
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors'=> $errors], $exc->code);
    }
  }

  public function restoreAll()
  {
    JournalEntry::onlyTrashed()->restore();
  }

  // public function forceDelete($id)
  // {
  //     JournalEntry::find($id)->withTrashed()->forceDelete();
  // }
  // public function restoreJournalEntry($id)
  // {

  //     JournalEntry::withTrashed()->find($id)->restore();
  // }


  public function save5000row(JournalEntriesRequest $request)
  {
    $i = 0;
    while ($i < 5000) {


      $journalEntry = JournalEntry::create([

        'date' => $request['date'],
        'time' => $request['time'],
        'receipt_number' => $request['receipt_number'],
        'currency_id' => $request['currency_id'],
        'parity' => $request['parity'],
        'security_level' => $request['security_level'],
        'debit_total' => $request['debit_total'],
        'credit_total' => $request['credit_total'],
        'branch_id' => $request['branch_id'],
        'notes' => $request['notes'],
      ]);
      $i++;

    }
    return 'ok';
  }
}
