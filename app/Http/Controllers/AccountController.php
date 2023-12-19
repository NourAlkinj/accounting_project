<?php

namespace App\Http\Controllers;

use App\Events\AccountsUpdated;
use App\Events\LeafNormalAccountsUpdated;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use App\Models\Asset;
use App\Models\Bill;
use App\Models\BillAdditionAndDiscount;
use App\Models\BillTemplate;
use App\Models\Client;
use App\Models\Currency;
use App\Models\JournalEntryRecord;
use App\Models\ReturnedBill;
use App\Models\ReturnedBillAdditionAndDiscount;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use App\Models\VoucherTemplate;
use App\Traits\Account\AccountTrait;
use App\Traits\ActivityLog\ActivityLog;
use Database\Seeders\SimpleChartArabicSeeder;
use Database\Seeders\SimpleChartEnglishSeeder;
use Illuminate\Http\Request;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Locales\AccountWords;
use Lang\Locales\AccountWordsEnum;
use Lang\Translate;


/**
 * @group Account
 *
 * APIs for managing account
 */
class AccountController extends Controller
{
  use ActivityLog, AccountTrait ;

  public $commonMessage,$accountMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
    $this->accountMessage = new Translate(new AccountWords());
  }

  public function index()
  {

    $normalAccountTree = Account::whereNull('account_id')->where('is_normal', true)->with('normalAccountsTree')->select('id', 'name', 'code', 'account_id', 'is_client', 'final_account_id', 'currency_id')->get();
    $finalAccountsTree = Account::whereNull('result_account_id')->where('is_final', true)->with('finalAccountsTree')->select('id', 'name', 'code', 'result_account_id', 'is_client', 'final_account_id', 'currency_id')->get();
    $assemblyAccounts = Account::where('is_assembly', true)->select('id', 'name', 'code', 'assembly_normal_ids', 'is_client', 'final_account_id', 'currency_id')->get();
    $distributiveAccounts = Account::where('is_distributive', true)->select('id', 'name', 'code', 'distributive_normal_ids', 'is_client', 'final_account_id', 'currency_id')->get();
     $dataTree = ['normalAccountTree' => $normalAccountTree, 'finalAccountsTree' => $finalAccountsTree, 'assemblyAccounts' => $assemblyAccounts, 'distributiveAccounts' => $distributiveAccounts];
    return response()->json($dataTree, 200);
  }

  public function all()
  {

    $accounts = Account::all();
    return $accounts;
  }

  public function store(StoreAccountRequest $request)
  {
    $lang = $request->header('lang') ;
    $clientRequest = $request->get('client_exist');
    $account = Account::create($request->all());

    $this->validateCardType($account->id, Account::class, $request);
    if ($clientRequest == true) {
      $this->updateValueInDB($account->id, Account::class, 'is_client', true);
      $client = (new ClientController)->store($request, $account->id);
    }
    $result = $this->activityParameters($lang, 'store', 'account', $account,    null);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('store', $table, $parameters);

    event(new AccountsUpdated([...Account::all()]));
    event(new LeafNormalAccountsUpdated([...$this->getAllLeafNormal()]));
    return response()->json([
//      'message' => __('common.store'),
      'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),

      'id' => $account->id,
      'account_id' => $account->account_id,
      'result_account_id' => $account->result_account_id,
      'card_type' => $account->card_type,
      'final_account_id' => $account->final_account_id,
      'currency_id' => $account->currency_id,

    ], 200);
  }

  public function show($id)
  {

    $account = Account::find($id);

    return response()->json($account, 200);
  }

  public function update(UpdateAccountRequest $request, $id)
  {

    $lang = $request->header('lang');
    $clientRequest = $request->get('client_exist');

    $old_data_account = Account::find($id)->toJson();
    $client = Client::where('account_id', $id)->first();

//    $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data_account];
    $account = Account::find($id);
    $account->update($request->all());

    if ($clientRequest == true && $client != null) {
      $resultUpdateClient = (new ClientController)->update($request, $client->id,$id);
    }
    if ($clientRequest == true && $client == null) {
      $this->updateValueInDB($id, Account::class, 'is_client', true);
      $resultStoreClient = (new ClientController)->store($request, $id);
    }



    $result = $this->activityParameters($lang, 'update', 'account', $account    , $old_data_account);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('update', $table, $parameters);

//    $this->callActivityMethod('accounts', 'update', $parameters);

    event(new AccountsUpdated([...Account::all()]));
    event(new LeafNormalAccountsUpdated([...$this->getAllLeafNormal()]));
    return response()->json([
//      'message' => __('common.update'),
      'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
      'id' => $account->id,
      'account_id' => $account->account_id,
      'result_account_id' => $account->result_account_id,
      'card_type' => $account->card_type,
     'final_account_id' => $account->final_account_id,
      'currency_id' => $account->currency_id,
    ], 200);
  }

  public function delete($id)
  {
    $lang  =   app('request')->header('lang');;
    $parameters = ['id' => $id];
    $account = Account::find($id);
    if ($this->numOfSubModels(Account::class, $id, 'account_id', 'is_normal', true) > 0) {
      $errors = ['account' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
      return response()->json(['errors' => $errors], 400);
    }
    if ($this->numOfSubModels(Account::class, $id, 'result_account_id', 'is_final', true) > 0) {
      $errors = ['account' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
      return response()->json(['errors' => $errors], 400);
    }
    if ($this->isExistNormalInModel($id, Account::class, 'assembly_normal_ids', 'is_assembly') > 0) {
      $errors = ['account' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
      return response()->json(['errors' => $errors], 400);
    }
    if ($this->isExistNormalInModel($id, Account::class, 'distributive_normal_ids', 'is_distributive') > 0) {
      $errors = ['account' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
      return response()->json(['errors' => $errors], 400);
    }
//    return $account->is_final;
    if ($account->is_final) {
      if ($result = $this->isFinalRelatedNormal($id)) {
        $errors = ['account' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }
    }
//    if (Client::where('account_id', $id)->get() != null) {
//      Client::where('account_id', $id)->delete();
//    }

    if ($account->is_client) {
      $errors = ['account' => [$this->accountMessage->t(AccountWordsEnum::delete_condition->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
    }

    if($this->isUseAccount($id)) {
      $errors = ['account' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }

    $account->delete();

    $result = $this->activityParameters($lang, 'delete', 'account', $account    , null);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('delete', $table, $parameters);

//    $this->callActivityMethod('accounts', 'delete', $parameters);
    $data= $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang);
    event(new AccountsUpdated([...Account::all()]));
    event(new LeafNormalAccountsUpdated([...$this->getAllLeafNormal()]));
    return response()->json(['message' => $data], 200);
  }

  public function callGenerateCodes($id)
  {
    $account = Account::find($id);
    if ($account->is_normal == true)
      return $this->generateCodes($id, Account::class, Account::class, 'account_id');
    if ($account->is_final == true)
      return $this->generateCodes($id, Account::class, Account::class, 'result_account_id');
  }

  public function callAutoComplete($id)
  {
    $account = Account::find($id);
    if ($account->is_normal == true) // just leaf normal without client
      return $this->AutoComplete($id, Account::class, 'account_id', false, 'internalModels', 'is_normal', true, 'is_client', false);
    if ($account->is_final == true)
      return $this->AutoComplete($id, Account::class, 'result_account_id', false, 'internalModelsForFinal', 'is_final', true);
  }

  public function getAllNormals()
  {
    return $this->getAllModelsWithCondition(Account::class, 'is_normal', true);
  }

  public function getAllNormalsWithOutClients()
  {
    return $this->getAllModelsWithCondition(Account::class, 'is_normal', true, 'is_client', false);
  }

  public function getAllLeafNormal()
  {
    return $this->getAllLeafModelsWithCondition(Account::class, 'account_id', 'is_normal', true);
  }

  public function getAllFinals()
  {
    return $this->getAllModelsWithCondition(Account::class, 'is_final', true);
  }

  public function getAllLeafFinal()
  {
    return $this->getAllLeafModelsWithCondition(Account::class, 'result_account_id', 'is_final', true);
  }

  public function getAllAssembly()
  {
    return $this->getAllModelsWithCondition(Account::class, 'is_assembly', true);
  }

  public function getAllNormalAndAssembly()
  {
    $allNormalModels = $this->getAllModelsWithCondition(Account::class, 'is_normal', true);
    $allAssemblyModels = $this->getAllModelsWithCondition(Account::class, 'is_assembly', true);
    $data = ['allNormalModels' => $allNormalModels, 'allAssemblyModels' => $allAssemblyModels];
    return $data;
  }

  public function getNormalsInAssembly($id)
  {
    return $this->getNormalsInModel($id, Account::class, 'assembly_normal_ids');
  }

  public function getNormalsInDistributive($id)
  {
    return $this->getNormalsInModel($id, Account::class, 'distributive_normal_ids');
  }

  public function getAllLeafNormalWithDistributive()
  {
    $alldistributiveModels = Account::where("is_distributive", true)->select('id', 'code', 'name')->get();
    $AllLeafNormal = $this->getAllLeafNormal();
    $data = ['alldistributiveModels' => $alldistributiveModels, 'AllLeafNormal' => $AllLeafNormal];
    return $data;
  }

  public function callGetCurrentBalance($id, $requiredCurrencyId)
  {
    return $this->callGetDebit($id, $requiredCurrencyId) - $this->callGetCredit($id, $requiredCurrencyId);
  }

  public function callGetCredit($id, $requiredCurrencyId)
  {
    $account = Account::find($id);
    if ($account->is_normal == true && $account['internalModels']->isEmpty())
      {
          $dealCurrencies = JournalEntryRecord::whereIN('account_id', [$account->id])->where('is_post_to_account', true)->get();
          return $this->getCredit($dealCurrencies, $requiredCurrencyId);
      }
    if ($account->is_normal == true && !($account['internalModels']->isEmpty()))
      {
          $leafModel = $this->getLeafId($account);
          $dealCurrencies = JournalEntryRecord::whereIN('account_id', $leafModel)->where('is_post_to_account', true)->get();
          return $this->getCredit($dealCurrencies, $requiredCurrencyId);
      }
    if ($account->is_assembly == true && ($account['assembly_normal_ids'] != null))
      {
          $dealCurrencies = JournalEntryRecord::whereIN('account_id', $account['assembly_normal_ids'])->where('is_post_to_account', true)->get();
          return $this->getCredit($dealCurrencies, $requiredCurrencyId);
      }
  }

  public function callGetDebit($id, $requiredCurrencyId)
  {
    $account = Account::find($id);
    if ($account->is_normal == true && $account['internalModels']->isEmpty())
    {
      $dealCurrencies = JournalEntryRecord::whereIN('account_id', [$account->id])->where('is_post_to_account', true)->get();
      return $this->getDebit($dealCurrencies, $requiredCurrencyId);
    }
    if ($account->is_normal == true && !($account['internalModels']->isEmpty()))
    {
      $leafModel = $this->getLeafId($account);
      $dealCurrencies = JournalEntryRecord::whereIN('account_id', $leafModel)->where('is_post_to_account', true)->get();
      return $this->getDebit($dealCurrencies, $requiredCurrencyId);
    }
    if ($account->is_assembly == true && ($account['assembly_normal_ids'] != null))
    {
      $dealCurrencies = JournalEntryRecord::whereIN('account_id', $account['assembly_normal_ids'])->where('is_post_to_account', true)->get();
      return $this->getDebit($dealCurrencies, $requiredCurrencyId);
    }
  }

  public function arabicSimpleChart()
  {
    $seeder = new SimpleChartArabicSeeder();
    $seeder->run();
    return $this->index();
  }

  public function englishSimpleChart()
  {
    $seeder = new SimpleChartEnglishSeeder();
    $seeder->run();
    return $this->index();
  }

  public function accountBalanceInfo($id)
  {
    $acc_data = Account::find($id)->toarray();
    $data = ['currentBalance' => $this->callGetCurrentBalance($id, $acc_data['currency_id']), ...$acc_data];
    return $data;
  }

  public function isUseAccount($account_id)
  {
    //account related to account
    $account = Account::where(function ($query) use ($account_id) {
      $query->where('account_id', $account_id)->orWhere('result_account_id', $account_id)->orWhere('final_account_id', $account_id);
    })->first();
    if ($account != null)
      return true;
//      return ['accountId' => $account->id, 'table' => 'accounts'];

    //account related to asset
    $asset = Asset::where(function ($query) use ($account_id) {
      $query->where('asset_account_id', $account_id)->orWhere('depreciation_account_id', $account_id)
        ->orWhere('accumulated_account_id', $account_id)->orWhere('expenses_account_id', $account_id)
        ->orWhere('captial_gains_account_id', $account_id)->orWhere('captial_losses_account_id', $account_id)
        ->orWhere('surplus_of_reappraisal_account_id', $account_id)->orWhere('deficit_of_reappraisal_account_id', $account_id);
    })->first();
    if ($asset != null)
      return true;
//      return ['assetId' => $asset->id, 'table' => 'assets'];

    //account related to bill
    $bill = Bill::where(function ($query) use ($account_id) {
      $query->where('account_id', $account_id)->orWhere('items_account_id', $account_id)
        ->orWhere('cash_account_id', $account_id);
    })->first();
    if ($bill != null)
      return true;
//      return ['billId' => $bill->id, 'table' => 'bills'];

    //account related to bill addition and discount
    $billAdditionAndDiscount = BillAdditionAndDiscount::where(function ($query) use ($account_id) {
      $query->where('account_id', $account_id);
    })->first();
    if ($billAdditionAndDiscount != null)
      return true;
//      return ['billAdditionAndDiscountId' => $billAdditionAndDiscount->id, 'table' => 'bill_addition_and_discounts'];

    //account related to bill template
    $billTemplate = BillTemplate::where(function ($query) use ($account_id) {
      $query->where('items_account_id', $account_id)->orWhere('discount_account_id', $account_id)
        ->orWhere('addition_account_id', $account_id)->orWhere('cash_account_id', $account_id)
        ->orWhere('tax_account_id', $account_id)->orWhere('cost_account_id', $account_id)
        ->orWhere('stock_account_id', $account_id)->orWhere('gifts_account_id', $account_id)
        ->orWhere('gifts_contra_account_id', $account_id)->orWhere('input_items_account_id', $account_id)
        ->orWhere('input_discount_account_id', $account_id)->orWhere('input_addition_account_id', $account_id)
        ->orWhere('input_cash_account_id', $account_id)->orWhere('input_tax_account_id', $account_id)
        ->orWhere('input_cost_account_id', $account_id)->orWhere('input_stock_account_id', $account_id)
        ->orWhere('input_gifts_account_id', $account_id)->orWhere('input_gifts_contra_account_id', $account_id);
    })->first();
    if ($billTemplate != null)
      return true;
//      return ['billTemplateId' => $billTemplate->id, 'table' => 'bill_templates'];

    //account related to client
    $client = Client::where(function ($query) use ($account_id) {
      $query->where('discount_account_id', $account_id)->orWhere('account_id', $account_id);
    })->first();
    if ($client != null)
      return true;
//      return ['clientId' => $client->id, 'table' => 'clients'];

    //account related to journal entry record
    $journalEntryRecord = JournalEntryRecord::where(function ($query) use ($account_id) {
      $query->where('account_id', $account_id)->orWhere('contra_account_id', $account_id);
    })->first();
    if ($journalEntryRecord != null)
      return true;
//      return ['journalEntryRecordId' => $journalEntryRecord->id, 'table' => 'journal_entry_records'];

//    //account related to returned bill
//    $returnedBill = ReturnedBill::where(function ($query) use ($account_id) {
//      $query->where('account_id', $account_id)->orWhere('items_account_id', $account_id)
//        ->orWhere('cash_account_id', $account_id);
//    })->first();
//    if ($returnedBill != null)
//      return true;
////      return ['returnedBillId' => $returnedBill->id, 'table' => 'returned_bills'];
//
//
//    //account related to returned bill addition and discount
//    $returnedBillAdditionAndDiscount = ReturnedBillAdditionAndDiscount::where(function ($query) use ($account_id) {
//      $query->where('account_id', $account_id);
//    })->first();
//    if ($returnedBillAdditionAndDiscount != null)
//      return true;
////      return ['returnedBillAdditionAndDiscountId' => $returnedBillAdditionAndDiscount->id, 'table' => 'returned_bill_addition_and_discounts'];

    //account related to voucher
    $voucher = Voucher::where(function ($query) use ($account_id) {
      $query->where('account_id', $account_id);
    })->first();
    if ($voucher != null)
      return true;
//      return ['voucherId' => $voucher->id, 'table' => 'vouchers'];

    //account related to voucher record
    $voucherRecord = VoucherRecord::where(function ($query) use ($account_id) {
      $query->where('account_id', $account_id)->orWhere('contra_account_id', $account_id);
    })->first();
    if ($voucherRecord != null)
      return true;
//      return ['voucherRecordId' => $voucherRecord->id, 'table' => 'voucher_records'];

    //account related to voucher template
    $voucherTemplate = VoucherTemplate::where(function ($query) use ($account_id) {
      $query->where('account_id', $account_id);
    })->first();
    if ($voucherTemplate != null)
      return true;
//      return ['voucherTemplateId' => $voucherTemplate->id, 'table' => 'voucher_templates'];


//    return ['id' => null, 'table' => null];
    return false;
  }
}
