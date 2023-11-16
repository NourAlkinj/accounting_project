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

    $parameters = ['id' => null];
    $fistJournalEntry = JournalEntry::with('records')->first();
    $pagination = JournalEntry::with('branch', 'currency')->select('id', 'branch_id', 'date', 'currency_id')->get();
    $this->callActivityMethod('journal_entries', 'Get All Journal Entries', $parameters);
    $data = [
      'first_joirnal_entry' => $fistJournalEntry,
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
//        'date' => $request['date'],
//        'time' => $request['time'],
//        'receipt_number' => $request['receipt_number'],
//        'currency_id' => $request['currency_id'],
//        'parity' => $request['parity'],
//        'security_level' => $request['security_level'],
//        'debit_total' => $request['debit_total'],
//        'credit_total' => $request['credit_total'],
//        'branch_id' => $request['branch_id'],
//        'notes' => $request['notes'],
//        'source' => $request['source'],
      );
      $this->saveJournalEntryRecord($request, $journalEntry->id);
      $parameters = ['request' => $request, 'id' => $journalEntry->id];
      $this->callActivityMethod('journal_entries', 'store', $parameters);

      return response()->json([
//      'message' => __('common.store')
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
    $parameters = ['id' => $id];
    $journalEntry = JournalEntry::with('records')->find($id);
    if ($journalEntry) {
      $this->callActivityMethod('journal_entries', 'show', $parameters);
      return $journalEntry;
    }
  }


  public function update(JournalEntriesRequest $request, $id)
  {
    try {
      $lang = $request->header('lang');
      $old_data = JournalEntry::find($id)->toJson();
      $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
      $journalEntry = JournalEntry::find($id);
      $journalEntry->update(
       $request->all()
//        [
//          'date' => $request['date'],
//          'time' => $request['time'],
//          'receipt_number' => $request['receipt_number'],
//          'currency_id' => $request['currency_id'],
//          'parity' => $request['parity'],
//          'security_level' => $request['security_level'],
//          'debit_total' => $request['debit_total'],
//          'credit_total' => $request['credit_total'],
//          'branch_id' => $request['branch_id'],
//          'notes' => $request['notes'],
//        ]
      );
      $this->saveJournalEntryRecord($request, $journalEntry->id);
      $this->callActivityMethod('journal_entries', 'update', $parameters);
      return response()->json([
//      'message' => __('common.update'), 'type' => 'Success',
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
      $parameters = ['id' => $id];
      $journalEntry = JournalEntry::find($id);
      $JournalEntry_Records = $journalEntry->records;
      foreach ($JournalEntry_Records as $JournalEntry_Record) {
        $JournalEntry_Record->delete();
      }
      if (!$journalEntry) {
        $errors = ['message' => [
//        __("journalEntry.journalEntry_not_found")
          $this->commonMessage->t(CommonWordsEnum::journalEntry_not_found->name, $lang),

      ]];
      return response()->json(['errors' => $errors], 404);
    }
      $journalEntry->delete();
      $this->callActivityMethod('journal_entries', 'delete', $parameters);
      return response()->json([
//      'message' => __('common.delete')
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
        return response()->json(['message' =>
//        __('common.restore')
        [  $this->commonMessage->t(CommonWordsEnum::RESTORE->name, $lang)]
      ], 200);
    } else {
        return response()->json(['message' =>
//        __('common.error_restore')
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
      $parameters = ['id' => $id];
      $journalEntry = JournalEntry::find($id);
      $JournalEntry_Records = $journalEntry->records;
      foreach ($JournalEntry_Records as $JournalEntry_Record) {
        $JournalEntry_Record->forceDelete();
      }
      if (!$journalEntry) {
        $errors = ['message' => [
//        __("journalEntry.journalEntry_not_found")
          $this->commonMessage->t(CommonWordsEnum::journalEntry_not_found->name, $lang)

      ]];
      return response()->json(['errors' => $errors], 404);
    }
      $journalEntry->forceDelete();
      $this->callActivityMethod('journal_entries', 'delete', $parameters);
      return response()->json(['message' =>
//      __('common.delete'), 'type' => 'Success'
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

//      $this->store($request);
      $journalEntry = JournalEntry::create([
//         $request->all()
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
