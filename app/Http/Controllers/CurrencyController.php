<?php

namespace App\Http\Controllers;

use App\Events\CurrenciesUpdated;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Models\Account;
use App\Models\Bill;
use App\Models\BillAdditionAndDiscount;
use App\Models\BillRecord;
use App\Models\BillTemplate;
use App\Models\Currency;
use App\Models\CurrencyActivity;
use App\Models\Item;
use App\Models\JournalEntry;
use App\Models\JournalEntryRecord;
use App\Models\ReturnedBill;
use App\Models\ReturnedBillAdditionAndDiscount;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use App\Models\VoucherTemplate;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;


class CurrencyController extends Controller
{
  use   CommonTrait, ActivityLog;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()
  {
    $parameters = ['id' => null];
    $allCurrencies = Currency::all();
    $this->callActivityMethod('currencies', 'index', $parameters);
    return response()->json($allCurrencies, 200);
  }

  public function all()
  {
    $parameters = ['id' => null];
    $this->callActivityMethod('currencies', 'allCurrency', $parameters);
    $currencies = Currency::all();
    return $currencies;
  }

  public function store(StoreCurrencyRequest $request)
  {
    $lang = $request->header('lang');
    $currency = Currency::create($request->all());
    if ($currency->is_default) {
      CurrencyActivity::create([
        'currency_id' => $currency->id,
        'parity' => 1,
        'last_update_date' => $request->created_at
      ]);

    } else {
      CurrencyActivity::create([
        'currency_id' => $currency->id,
        'parity' => $request->parity,
        'last_update_date' => $request->created_at
      ]);
    }
    if ($this->getCountRawsInModel(Currency::class) == 1)
      $this->updateValueInDB($currency->id, Currency::class, 'is_default', true);
    $storeCurrencyActivity = (new CurrencyActivityController)->store($currency->id, $currency->parity, $currency->created_at, $request);

    $result = $this->activityParameters($lang, 'store', 'currency', $currency,     null);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('store', $table, $parameters);

    event(new CurrenciesUpdated([...Currency::all()]));
    return response()->json(['message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang)], 200);

    }

  public function show($id)
  {

    $currency = Currency::where('id', $id)->get();

    return response()->json($currency, 200);
  }

  public function update(UpdateCurrencyRequest $request, $id)
  {
    $lang = $request->header('lang');
    $old_data = Currency::find($id)->toJson();

    $currency = Currency::find($id);
    $currencyBeforUpdate = $currency->parity;
    $currency->update($request->all());
    if ($currencyBeforUpdate != $currency->parity)
      $storeCurrencyActivity = (new CurrencyActivityController)->store($currency->id, $currency->parity, $currency->updated_at, $request);

    $result = $this->activityParameters($lang, 'update', 'currency', $currency,     $old_data);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('update', $table, $parameters);

    event(new CurrenciesUpdated([...Currency::all()]));
    $data = $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang);
        return response()->json(['message' => $data], 200);
    }

  public function delete($id)
  {
    $lang = app('request')->header('lang');

    $currency = Currency::find($id);
    if ($this->isUseCurrency($id)) {
      $errors = ['currency' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
      return response()->json(['errors' => $errors], 400);
    }
    $currency->delete();
    $result = $this->activityParameters($lang, 'delete', 'currency', $currency,     null);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('delete', $table, $parameters);
    event(new CurrenciesUpdated([...Currency::all()]));
    $data = $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang);
        return response()->json(['message' => $data], 200);
    }

  public function getDefaultCurrency()
  {
    return $defaultCurrency = Currency::where('is_default', true)->first();
  }

  public function isUseCurrency($currency_id)
  {
    //currency related to account
    $account = Account::where(function ($query) use ($currency_id) {
      $query->where('currency_id', $currency_id);
    })->first();
    if ($account != null)
      return true;
//      return ['accountId' => $account->id, 'table' => 'accounts'];

    //currency related to bill
    $bill = Bill::where(function ($query) use ($currency_id) {
      $query->where('currency_id', $currency_id);
    })->first();
    if ($bill != null)
      return true;
//      return ['billId' => $bill->id, 'table' => 'bills'];

    //currency related to bill addition and discount
    $billAdditionAndDiscount = BillAdditionAndDiscount::where(function ($query) use ($currency_id) {
      $query->where('currency_id', $currency_id);
    })->first();
    if ($billAdditionAndDiscount != null)
      return true;
//      return ['billAdditionAndDiscountId' => $billAdditionAndDiscount->id, 'table' => 'bill_addition_and_discounts'];

    //currency related to bill record
    $billRecord = BillRecord::where(function ($query) use ($currency_id) {
      $query->where('currency_id', $currency_id);
    })->first();
    if ($billRecord != null)
      return true;
//      return ['billRecordId' => $billRecord->id, 'table' => 'bill_records'];

    //currency related to bill template
    $billTemplate = BillTemplate::where(function ($query) use ($currency_id) {
      $query->where('currency_id', $currency_id);
    })->first();
    if ($billTemplate != null)
      return true;
//      return ['billTemplateId' => $billTemplate->id, 'table' => 'bill_templates'];

    //currency related to item
    $item = Item::where(function ($query) use ($currency_id) {
      $query->where('currency_id', $currency_id);
    })->first();
    if ($item != null)
      return true;
//      return ['itemId' => $item->id, 'table' => 'items'];

    //currency related to journal entry
    $journalEntry = JournalEntry::where(function ($query) use ($currency_id) {
      $query->where('currency_id', $currency_id);
    })->first();
    if ($journalEntry != null)
      return true;
//      return ['journalEntryId' => $journalEntry->id, 'table' => 'journal_entries'];

    //currency related to journal entry record
    $journalEntryRecord = JournalEntryRecord::where(function ($query) use ($currency_id) {
      $query->where('currency_id', $currency_id);
    })->first();
    if ($journalEntryRecord != null)
      return true;
//      return ['journalEntryRecordId' => $journalEntryRecord->id, 'table' => 'journal_entry_records'];

//    //currency related to Returned Bill
//    $returnedBill = ReturnedBill::where(function ($query) use ($currency_id) {
//      $query->where('currency_id', $currency_id);
//    })->first();
//    if ($returnedBill != null)
//      return true;
////      return ['returnedBillId' => $returnedBill->id, 'table' => 'returned_bills'];
//
////currency related to Returned Bill Addition And Discount
//    $returnedBillAdditionAndDiscount = ReturnedBillAdditionAndDiscount::where(function ($query) use ($currency_id) {
//      $query->where('currency_id', $currency_id);
//    })->first();
//    if ($returnedBillAdditionAndDiscount != null)
//      return true;
////      return ['returnedBillAdditionAndDiscountId' => $returnedBillAdditionAndDiscount->id, 'table' => 'returned_bill_addition_and_discounts'];

    //currency related to voucher
    $voucher = Voucher::where(function ($query) use ($currency_id) {
      $query->where('currency_id', $currency_id);
    })->first();
    if ($voucher != null)
      return true;
//      return ['voucherId' => $voucher->id, 'table' => 'vouchers'];

    //currency related to voucher record
    $voucherRecord = VoucherRecord::where(function ($query) use ($currency_id) {
      $query->where('currency_id', $currency_id);
    })->first();
    if ($voucherRecord != null)
      return true;
//      return ['voucherRecordId' => $voucherRecord->id, 'table' => 'voucher_records'];

    //currency related to voucher template
    $voucherTemplate = VoucherTemplate::where(function ($query) use ($currency_id) {
      $query->where('currency_id', $currency_id);
    })->first();
    if ($voucherTemplate != null)
      return true;
//      return ['voucherTemplateId' => $voucherTemplate->id, 'table' => 'voucher_templates'];

//    return ['id' => null, 'table' => null];
    return false;
  }


}
