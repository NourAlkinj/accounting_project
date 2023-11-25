<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Account;
use App\Models\Bill;
use App\Models\BillTemplate;
use App\Models\Client;
use App\Models\JournalEntryRecord;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class ClientController extends Controller
{
  use ActivityLog, CommonTrait;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()//done
  {

    $allClients = Client::all();

    return response()->json($allClients, 200);
  }

  public function store($request, $account_id)//done
  {
    $lang = app('request')->header('lang');
    $client = Client::create($request->all());
    $this->updateValueInDB($client->id, Client::class, 'account_id', $account_id);

    $result = $this->activityParameters($lang, 'store', 'category', $client,   'pc_name', null);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('store', $table, $parameters);


//      $this->callActivityMethod('clients', 'store', $parameters);
  }

  public function show($accountId)//done
  {
    $client = Client::where('account_id', $accountId)->first();

    $client = Client::find($client->id);

    return response()->json($client, 200);
  }


  public function update($request, $id, $account_id)//done
  {
    $lang = app('request')->header('lang');
    $old_data = Client::find($id)->toJson();
//    $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
    $client = Client::find($id);
    $client->update($request->all());
    $this->updateValueInDB($client->id, Client::class, 'account_id', $account_id);

    $result = $this->activityParameters($lang, 'update', 'client', $client,   'pc_name', $old_data);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('update', $table, $parameters);

  }

  public function delete($accountId)//done
  {
    $lang = app('request')->header('lang');;
    $client = Client::where('account_id', $accountId)->first();

    if ($this->isUseClient($client->id)) {
      $errors = ['client' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }

    $client->delete();
    $this->updateValueInDB($accountId, Account::class, 'is_client', false);

    $result = $this->activityParameters($lang, 'delete', 'client', $client,   'pc_name', null);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('delete', $table, $parameters);


    $data = $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang);
        return response()->json(['message' => $data], 200);
    }

  public function all()
  {

    $clients = Client::all();
    return $clients;
  }

  public function isUseClient($client_id)
  {
    //client related to bill
    $bill = Bill::where(function ($query) use ($client_id) {
      $query->where('client_id', $client_id);
    })->first();
    if ($bill != null)
      return true;
//      return ['billId' => $bill->id, 'table' => 'bills'];

    //client related to bill template
    $billTemplate = BillTemplate::where(function ($query) use ($client_id) {
      $query->where('client_id', $client_id);
    })->first();
    if ($billTemplate != null)
      return true;
//      return ['billTemplateId' => $billTemplate->id, 'table' => 'bill_templates'];

    //client related to journal entry record
    $journalEntryRecord = JournalEntryRecord::where(function ($query) use ($client_id) {
      $query->where('client_id', $client_id);
    })->first();
    if ($journalEntryRecord != null)
      return true;
//      return ['journalEntryRecordId' => $journalEntryRecord->id, 'table' => 'journal_entry_records'];


//    return ['id' => null, 'table' => null];
    return false;
  }


}
