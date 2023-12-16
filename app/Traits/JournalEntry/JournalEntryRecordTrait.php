<?php

namespace App\Traits\JournalEntry;

use App\Http\Requests\JournalEntriesRequest;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryPermissionUser;
use App\Models\JournalEntryRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait  JournalEntryRecordTrait
{


  public function getJournalRecords()
  {
    return JournalEntry::find(1)->records;
  }

    public function updateJournalEntryRecord(JournalEntriesRequest $request, $journal_entry_id)
    {
        $journal_entry = JournalEntry::find($journal_entry_id);
        $journal_entry_records = $journal_entry->records->toArray();
        $records_in_request = $request->records;
        $recordsToCreate = array_diff(array_column($records_in_request, 'index'), array_column($journal_entry_records, 'index'));
        foreach ($recordsToCreate as $record) {
            $recordData = $request->records[array_search($record, array_column($request->records, 'index'))];
            $recordData['journal_entry_id'] = $journal_entry_id;
            $JournalEntryRecord = JournalEntryRecord::create($recordData);
            $JournalEntryRecord['journal_entry_id'] = $journal_entry_id;
            $JournalEntryRecord['source_name'] = $request['source']['source_name'];
            $JournalEntryRecord['source_template_id'] = $request['source']['source_template_id'];
            $JournalEntryRecord['source_id'] = $request['source']['source_id'];
            $JournalEntryRecord['branch_id'] = $request['branch_id'];
            $JournalEntryRecord['date'] = $request['date'];
            $JournalEntryRecord['time'] = $request['time'];
            $JournalEntryRecord['index'] = abs($recordData['index']);
            $JournalEntryRecord->save();
        }
        $recordsToDelete = array_diff(array_column($journal_entry_records, 'index'), array_column($records_in_request, 'index'));
        foreach ($recordsToDelete as $record) {
            $record = JournalEntryRecord::where('journal_entry_id', $journal_entry_id)->where('index', $record)->first();
            $record->forceDelete();
        }
        $recordsToUpdate = array_intersect(array_column($records_in_request, 'index'), array_column($journal_entry_records, 'index'));
        foreach ($recordsToUpdate as $record) {
            $recordData = $request->records[array_search($record, array_column($request->records, 'index'))];
            $record = JournalEntryRecord::where('journal_entry_id', $journal_entry_id)->where('index', $record)->first();
            $record->update($recordData);
            $record['journal_entry_id'] = $journal_entry_id;
            $record['source_name'] = $request['source']['source_name'];
            $record['source_template_id'] = $request['source']['source_template_id'];
            $record['source_id'] = $request['source']['source_id'];
            $record['branch_id'] = $request['branch_id'];
            $record['date'] = $request['date'];
            $record['time'] = $request['time'];
            $record['index'] = abs($recordData['index']);
            $record->save();
        }
    }

  public function saveJournalEntryRecord(JournalEntriesRequest $request, $journal_entry_id)
  {
    $JournalEntry_Records = JournalEntry::find($journal_entry_id)->records;
    foreach ($JournalEntry_Records as $JournalEntry_Record) {
      $JournalEntry_Record->forceDelete();
    }
    $JournalEntryRecords = $request->records;
    foreach ($JournalEntryRecords as $JournalEntryRecord) {
      $JournalEntryRecord['journal_entry_id'] = $journal_entry_id;
      $JournalEntryRecord['source_name'] = $request['source']['source_name'];
      $JournalEntryRecord['source_template_id'] = $request['source']['source_template_id'];
      $JournalEntryRecord['source_id'] = $request['source']['source_id'];
      $JournalEntryRecord['branch_id'] = $request['branch_id'];
      $JournalEntryRecord['is_post_to_account'] = $request['is_post_to_account'];
      $JournalEntryRecord['post_to_account_date'] = $request['post_to_account_date'];
      $JournalEntryRecord['date'] = $request['date'];
      $JournalEntryRecord['time'] = $request['time'];
      $JournalEntryRecord['index'] = abs($JournalEntryRecord['index']);
      $user_id = optional($JournalEntryRecord)->user_id;
      $client_id = optional($JournalEntryRecord)->client_id;
      $item_id = optional($JournalEntryRecord)->item_id;
      $employee_id = optional($JournalEntryRecord)->employee_id;
      $asset_id = optional($JournalEntryRecord)->asset_id;
      $category_id = optional($JournalEntryRecord)->category_id;
//      $user_id = isset($JournalEntryRecord->user_id) ? $JournalEntryRecord->user_id : null;
//      $client_id = isset($JournalEntryRecord->client_id) ? $JournalEntryRecord->client_id : null;
//      $item_id = isset($JournalEntryRecord->item_id) ? $JournalEntryRecord->item_id : null;
//      $employee_id = isset($JournalEntryRecord->employee_id) ? $JournalEntryRecord->employee_id : null;
//      $asset_id = isset($JournalEntryRecord->asset_id) ? $JournalEntryRecord->asset_id : null;
//      $category_id = isset($JournalEntryRecord->category_id) ? $JournalEntryRecord->category_id : null;
      $JournalEntryRecord['user_id'] = optional($request)['user_id'] ? $request['user_id'] : null;
      $JournalEntryRecord['client_id'] = optional($request)['client_id'] ? $request['client_id'] : null;
       $JournalEntryRecord['employee_id'] = optional($request)['employee_id'] ? $request['employee_id'] : null;
      $JournalEntryRecord['asset_id'] = optional($request)['asset_id'] ? $request['asset_id'] : null;
       $JournalEntryRecord['item_id'] = optional($request)['item_id'] ? $request['item_id'] : null;
      $JournalEntryRecord['category_id'] = optional($request)['category_id'] ? $request['category_id'] : null;

    
      // $JournalEntryRecord['is_post_to_account'] = $JournalEntryRecord['is_post_to_account'];
      // $JournalEntryRecord['post_to_account_date'] = $JournalEntryRecord['post_to_account_date'];

//      $JournalEntryRecord['branch_name'] = Branch::find($request['branch_id']) ? Branch::find($request['branch_id'])->name : '';
//      $JournalEntryRecord['user_name'] = User::find($user_id) ? User::find($user_id)->name : '';
//      $JournalEntryRecord['client_name'] = Client::find($client_id) ? Client::find($client_id)->name : '';
////      $JournalEntryRecord['contra_account_name'] = Account::find($JournalEntryRecord['contra_account_id']) ? Account::find($JournalEntryRecord['contra_account_id'])->name : '';
//      $JournalEntryRecord['employee_name'] = Employee::find($employee_id) ? Employee::find($employee_id)->name : '';
//      $JournalEntryRecord['asset_name'] = Asset::find($asset_id) ? Asset::find($asset_id)->name : '';
////      $JournalEntryRecord['cost_center_name'] = CostCenter::find($JournalEntryRecord['cost_center_id']) ? CostCenter::find($JournalEntryRecord['cost_center_id'])->name : '';
//      $JournalEntryRecord['item_name'] = Item::find($item_id) ? Item::find($item_id)->name : '';
//      $JournalEntryRecord['category_name'] = Category::find($category_id) ? Category::find($category_id)->name : '';


      JournalEntryRecord::create($JournalEntryRecord);

    }
  }


//  public function updateJournalEntryRecord(JournalEntriesRequest $request, $journal_entry_id)
//  {
//    $JournalEntry_Records = JournalEntry::find($journal_entry_id)->records;
//    foreach ($JournalEntry_Records as $JournalEntry_Record) {
//      $JournalEntry_Record->delete();
//    }
//    $JournalEntryNewRecords = $request->records;
//    foreach ($JournalEntryNewRecords as $JournalEntryNewRecord) {
//      JournalEntryRecord::create([
//        'account_id' => $JournalEntryNewRecord['account_id'],
//        'debit' => $JournalEntryNewRecord['debit'],
//        'credit' => $JournalEntryNewRecord['credit'],
//        'notes' => $JournalEntryNewRecord['notes'],
//        'cost_center_id' => $JournalEntryNewRecord['cost_center_id'],
//        'currency_id' => $JournalEntryNewRecord['currency_id'],
//        'parity' => $JournalEntryNewRecord['parity'],
//        'equivalent' => $JournalEntryNewRecord['equivalent'],
//        'contra_account_id' => $JournalEntryNewRecord['contra_account_id'],
//        'current_balance' => $JournalEntryNewRecord['current_balance'],
//        'final_balance' => $JournalEntryNewRecord['final_balance'],
//        'journal_entry_id' => $journal_entry_id,
//        'is_post_to_account' => $JournalEntryNewRecord['is_post_to_account'],
//        'JournalEntryRecord' => $JournalEntryNewRecord['post_to_account_date']
//      ]);
//    }
//  }

  public function journalEntryRecordCostCenter($id)
  {
    $journalEntryRecords = JournalEntry::find($id)->records;
    foreach ($journalEntryRecords as $journalEntryRecord) {
      $records[] = $journalEntryRecord;
      foreach ($records as $record) {
        $costCeners[] = $record->CostCenter;
      }
    }
    return array_unique($costCeners);
  }

  public function saveJournalEntryPermissionUser(JournalEntriesRequest $request, $user_id)
  {

    $oldJournalEntryPermissionsUser = User::find($user_id)->JournalEntryPermissionUser;

    $oldJournalEntryPermissionsUser->delete();
    $JournalEntryNewPermissionsUser = $request->journal_entry_permission_user;
    foreach ($JournalEntryNewPermissionsUser as $JournalEntryNewPermissionUser) {
      JournalEntryPermissionUser::create([
        'print_setting' => $JournalEntryNewPermissionUser['print_setting'],
        'show_setting' => $JournalEntryNewPermissionUser['show_setting'],
        'user_id' => $user_id,

      ]);
    }

  }


  public function updateJournalEntryPermissionUser(JournalEntriesRequest $request, $user_id)
  {

    $oldJournalEntryPermissionsUser = User::find($user_id)->JournalEntryPermissionUser;

    $oldJournalEntryPermissionsUser->delete();

    $JournalEntryNewPermissionsUser = $request->journal_entry_permission_user;
    foreach ($JournalEntryNewPermissionsUser as $JournalEntryNewPermissionUser) {
      JournalEntryPermissionUser::create([
        'print_setting' => $JournalEntryNewPermissionUser['print_setting'],
        'show_setting' => $JournalEntryNewPermissionUser['show_setting'],
        'user_id' => $user_id,

      ]);
    }
  }


  public function userOptions()
  {
//        $token = PersonalAccessToken::findToken($hashed_token);
//        $user_id = $token->tokenable->id;
    $id = auth('sanctum')->user()->id;
    return User::find($id)->journalEntryPermissionUser;
  }


  public function getAccounts(Request $request)
  {
    $result = [];
    $Ids = $request->IDs;
    foreach ($Ids as $id) {
      $result[] = Account::find($id);
    }
    return $result;
  }


  public function getUser()
  {
    return $user_id = Auth::id();
  }
}
