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
use Lang\Translate;
use Lang\Locales\CommonWordsEnum;

class ClientController extends Controller
{
    use ActivityLog, CommonTrait;
  public  $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

    public function index()//done
    {
        $parameters = ['id' => null];
        $allClients = Client::all();
        $this->callActivityMethod('clients', 'index', $parameters);
        return response()->json($allClients, 200);
    }

    public function store( $request,$account_id)//done
    {
        $client = Client::create($request->all());
        $this->updateValueInDB($client->id,Client::class, 'account_id',$account_id);
        $parameters = ['request' => $request, 'id' => $client->id];
        $this->callActivityMethod('clients', 'store', $parameters);
    }

    public function show($accountId)//done
    {
        $client=Client::where('account_id', $accountId)->first();
        $parameters = ['id' => $client->id];
        $client= Client::find($client->id);
        $this->callActivityMethod('clients', 'show', $parameters);
        return response()->json( $client, 200);
    }


    public function update($request ,$id,$account_id)//done
    {
        $old_data = Client::find($id)->toJson();
        $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
        $client = Client::find($id);
        $client->update($request->all());
       $this->updateValueInDB($client->id,Client::class, 'account_id',$account_id);
       $this->callActivityMethod('clients', 'update', $parameters);
    }

    public function delete($accountId)//done
    {
      $lang  =   app('request')->header('lang');;
      $client=Client::where('account_id', $accountId)->first();
        $parameters = ['id' => $client->id];

      if($this->isUseClient($client->id)) {
        $errors = ['client' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }

        $client->delete();
        $this->updateValueInDB($accountId,Account::class,'is_client',false);
        $this->callActivityMethod('clients', 'delete', $parameters);
        $data= $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang);
        return response()->json(['message' => $data], 200);
    }

  public function all()
  {
    $parameters = ['id' => null];
    $this->callActivityMethod('clients', 'allClients', $parameters);
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
