<?php

namespace App\Traits\Report;

use App\Interfaces\BarChartResponse;
use App\Models\Account;
use App\Models\Quantity;
use App\Models\Unit;
use App\Traits\Common\CommonTrait;
use App\Traits\Item\ItemTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait  ReportTrait
{
  use  CommonTrait;

//  public function ledger(Request $request)
//  {
//    $account = Account::find($request->account_id);
//    if ($account->is_normal == true && $account['internalModels']->isEmpty()) {
//      $accounts[] = $account;
//    }
//    if ($account->is_normal == true && !($account['internalModels']->isEmpty())) {
//      $mainAccount = $account;
//      $leafModels = $this->getLeafId($account);
//      foreach ($leafModels as $leafModel) {
//        $account = Account::find($leafModel);
//        $accounts[] = $account;
//      }
//      array_push($accounts, $mainAccount);
//    }
//    if ($account->is_assembly == true && ($account['assembly_normal_ids'] != null)) {
//      $mainAccount = $account;
//      $assembly_normal_ids = [];
//      foreach ($account['assembly_normal_ids'] as $item) {
//        $assembly_normal_ids[] = $item['id'];
//      }
//      foreach ($assembly_normal_ids as $assembly_normal_id) {
//        $account = Account::find($assembly_normal_id);
//        $accounts[] = $account;
//      }
//      array_push($accounts, $mainAccount);
//    }
////    return $accounts;
//
//    // loop over every account and create a report for it
//    $accounts_records = [];
//    $previous_date_filter_accounts_records = [];
//    $after_date_filter_accounts_records = [];
//    foreach ($accounts as $account) {
//      $account_report = new ReportBuilder(
//        new LedgerFilter(
//          $request->sources,
//          $account['id'],
//          $request->cost_center_id,
//          $request->branch_id,
//          $request->user_id,
//          $request->contra_account_id,
//          $request->client_id,
//          $request->employee_id,
//          $request->asset_id,
//          $request->category_id,
//          $request->item_id,
//          $request->contains,
//          $request->not_contains,
//          false,
//          true,
//          $request->created_between,
//          $request->posted_between,
//          $request->not_posted_between
//        ),
//        [],
//        [
//          ['name' => 'account_filter', 'affects_final_result' => true],
//          $request->sources ? ['name' => 'sources_filter', 'affects_final_result' => true] : [],
//          $request->cost_center_id ? ['name' => 'cost_center_filter', 'affects_final_result' => true] : [],
//          $request->branch_id ? ['name' => 'branch_filter', 'affects_final_result' => true] : [],
//          $request->user_id ? ['name' => 'user_filter', 'affects_final_result' => true] : [],
//          $request->contra_account_id ? ['name' => 'contra_account_filter', 'affects_final_result' => true] : [],
//          $request->client_id ? ['name' => 'client_filter', 'affects_final_result' => true] : [],
//          $request->employee_id ? ['name' => 'employee_filter', 'affects_final_result' => true] : [],
//          $request->asset_id ? ['name' => 'asset_filter', 'affects_final_result' => true] : [],
//          $request->category_id ? ['name' => 'category_filter', 'affects_final_result' => true] : [],
//          $request->item_id ? ['name' => 'item_filter', 'affects_final_result' => true] : [],
//          $request->contains ? ['name' => 'contains_filter', 'affects_final_result' => true] : [],
//          $request->not_contains ? ['name' => 'not_contains_filter', 'affects_final_result' => true] : [],
//          $request->created_between ? ['name' => 'previous_date_filter', 'affects_final_result' => false] : [],
//          $request->created_between ? ['name' => 'after_date_filter', 'affects_final_result' => false] : [],
//          $request->created_between ? ['name' => 'date_range_filter', 'affects_final_result' => true] : [],
//          $request->posted_between ? ['name' => 'posted_date_range_filter', 'affects_final_result' => true] : [],
//          $request->not_posted_between ? ['name' => 'not_posted_date_range_filter', 'affects_final_result' => true] : []
//        ]
//      );
//
//      foreach ($account_report->result as $record) {
//        $accounts_records[] = $record;
//      }
//      foreach ($account_report->eachFilterResult['previous_date_filter'] as $record) {
//        $previous_date_filter_accounts_records[] = $record;
//      }
//      foreach ($account_report->eachFilterResult['after_date_filter'] as $record) {
//        $after_date_filter_accounts_records[] = $record;
//      }
//    }
////      return $accounts_records;
////    return $previous_date_filter_accounts_records;
////    return $after_date_filter_accounts_records;
//
//
//    $currencyID = null;
//    $currency_id = $request->input('currency_id');
//    $by_account_currency = $request->input('by_account_currency');
//    if (!$by_account_currency) {
//      $currencyID = $currency_id;
//    }
//    $accounts = array_map(function ($acc) use ($currencyID, $accounts_records, $previous_date_filter_accounts_records, $after_date_filter_accounts_records) {
//      if ($currencyID == null) {
//        $currencyID = $acc->currency_id;
//      }
//      $acc['children'] = array_filter($accounts_records, function ($record) use ($acc) {
//        return $acc['id'] == $record['account_id'];
//      });
//      $previous_date_filter_Specific_account_records = array_filter($previous_date_filter_accounts_records, function ($record) use ($acc) {
//        return $acc['id'] == $record['account_id'];
//      });
//      $after_date_filter_Specific_account_records = array_filter($after_date_filter_accounts_records, function ($record) use ($acc) {
//        return $acc['id'] == $record['account_id'];
//      });
//      if ($acc['is_normal'] == true && !($acc['internalModels']->isEmpty()) || $acc['is_assembly'] == true && ($acc['assembly_normal_ids'] != null)) {
//        $acc['credit'] = $this->getCredit($accounts_records, $currencyID);
//        $acc['debit'] = $this->getDebit($accounts_records, $currencyID);
//        $acc['current_balance'] = $acc['credit'] - $acc['debit'];
//        $acc['previous_credit'] = $this->getCredit($previous_date_filter_accounts_records, $currencyID);
//        $acc['previous_debit'] = $this->getDebit($previous_date_filter_accounts_records, $currencyID);
//        $acc['previous_current_balance'] = $acc['previous_credit'] - $acc['previous_debit'];
//        $acc['after_credit'] = $this->getCredit($after_date_filter_accounts_records, $currencyID);
//        $acc['after_debit'] = $this->getDebit($after_date_filter_accounts_records, $currencyID);
//        $acc['after_current_balance'] = $acc['after_credit'] - $acc['after_debit'];
//      } else {
//        $acc['credit'] = $this->getCredit($acc['children'], $currencyID);
//        $acc['debit'] = $this->getDebit($acc['children'], $currencyID);
//        $acc['current_balance'] = $acc['credit'] - $acc['debit'];
//        $acc['previous_credit'] = $this->getCredit($previous_date_filter_Specific_account_records, $currencyID);
//        $acc['previous_debit'] = $this->getDebit($previous_date_filter_Specific_account_records, $currencyID);
//        $acc['previous_current_balance'] = $acc['previous_credit'] - $acc['previous_debit'];
//        $acc['after_credit'] = $this->getCredit($after_date_filter_Specific_account_records, $currencyID);
//        $acc['after_debit'] = $this->getDebit($after_date_filter_Specific_account_records, $currencyID);
//        $acc['after_current_balance'] = $acc['after_credit'] - $acc['after_debit'];
//      }
//      return $acc;
//    }, $accounts);
//    return $accounts;
//  }

//  public function itemRepricing(Request $request)
//  {
//    $priceType  = $request->price_type  ? $request->price_type : null;
//    $costPrice  = $request->cost_price  ? $request->cost_price : null;
//    $currencyId = $request->currency_id ? $request->currency_id : null;
//    $unitId     =  $request->unit !=0  ? $request->unit : 0;
//    $price_between_from = $request->price_between['from'] ? $request->price_between['from'] : null;
//    $price_between_to = $request->price_between['to'] ? $request->price_between['to'] : null;
//
//    $items_records = [];
//    $item_report = new ReportBuilder(
//      new filterItemsForRepricing(
//        $request->items,
//        $request->only_items_have_quantities,
//        $request->item_type,
//        $request->currency_id,
//        ),
//      [],
//      [
//        $request->items ? ['name' => 'items_filter', 'affects_final_result' => true] : [],
//        $request->only_items_have_quantities ? ['name' => 'only_items_have_quantities_filter', 'affects_final_result' => true] : [],
//        $request->item_type ?['name' => 'item_type_filter', 'affects_final_result' => true]: [],
//        $request->currency_id ?['name' => 'currency_filter', 'affects_final_result' => true]: [],
//      ]
//    );
//
//    foreach ($item_report->result as $record) {
//      $items_records[] = $record;
//    }
////      return $items_records;
//
//    $items = array_map(function ($item) use ( $priceType, $unitId, $costPrice, $currencyId) {
//      $price = null;
//      if ($unitId == 0) {
//        $unitId = $this->getDefaultUnit($item);
//      }
//      foreach ($item['units'] as $unit) {
//        if ($unit['unit_number'] == $unitId && isset($unit['prices'][$priceType])) {
//          $price = $unit['prices'][$priceType];
//          $item['unit_id'] = $unit->id;
//          break;
//        }
//      }
//      $item['price'] = $price;
//      $item['cost_price'] = $this->getCostAccordingCostType($costPrice, $item->id, $unitId, $currencyId);
//      $item['profit'] = $item['price'] - $item['cost_price'];
//      $item['profit_ratio'] = $item['cost_price'] != 0 ? ($item['profit'] * 100) / $item['cost_price'] : 0 ;
//      return $item;
//    }, $items_records);
//
//    if ($price_between_from != null) {
//    $items = array_filter($items, function ($item) use ($price_between_from,$price_between_to) {
//      return $item['price'] > $price_between_from &&  $item['price'] < $price_between_to;
//    });
//  }
//
//    $items = array_map(function ($item) use($items) {
//      return [
//        'category_id' => $item['category_id'],
//        'item_id' => $item['id'],
//        'unit_id' => $item['unit_id'],
//        'price'=> $item['price'],
//        'cost_price'=> $item['cost_price'],
//        'profit'=>$item['profit'],
//        'profit_ratio'=> $item['profit_ratio'],
//        ];
//    },$items);
//    return $items;
//  }
//
//  public function getCostAccordingCostType($costType,$item_id,$unit_number,$currency_id)
//  {
//    if($costType=='min')
//      {
//        return $this->getItemMinPurchaseCost($item_id,$unit_number,$currency_id);
//      }
//    elseif($costType=='max')
//      {
//        return $this->getItemMaxPurchaseCost($item_id,$unit_number,$currency_id);
//      }
//    elseif($costType=='fifo')
//      {
//        return $this->getItemLastPurchaseCost($item_id,$unit_number,$currency_id);
//      }
//  }


//  public function changeItemsPrice(Request $request)
//  {
//    $items = json_decode($request->getContent(), true);
//    if (isset($items['items']) && is_array($items['items'])) {
//      foreach ($items['items'] as $item) {
////        $itemId = $item['item_id'];
//        $unitId = $item['unit_id'];
//        $price = $item['price'];
////        $unit = Unit::where('unit_number', $unitId)->where('item_id', $itemId)->first();
//        $unit = Unit::where('id', $unitId)->first();
//        if ($unit) {
//          $price_type = $items['price_type'];
//          $prices = $unit->prices;
//          $prices[$price_type] = $price;
//          $unit->prices = $prices;
//          $unit->save();
//        }
//      }
//    }
//  }






  public function filterAccount($account_id)
  {
//    return $query->where('account_id', $account_id);
    return "account_id = '{$account_id}'";
  }

  public function filterCostCenter($cost_center_id)
  {
//    $query = $query->where('cost_center_id',$cost_center_id);
    $filterConditions = "cost_center_id = '{$cost_center_id}'";
    return $filterConditions;
  }

  public function filterBranch($branch_id)
  {
//    $query = $query->where('branch_id', $branch_id);
    $filterConditions = "branch_id = '{$branch_id}'";
    return $filterConditions;
  }

  public function filterUser($user_id)
  {
//  $query = $query->where('user_id', $user_id);
    $filterConditions = "user_id = '{$user_id}'";
    return $filterConditions;
  }

  public function filterContraAccount($contra_account_id)
  {
//    $query = $query->where('contra_account_id', $contra_account_id);
    $filterConditions = "contra_account_id = '{$contra_account_id}'";
    return $filterConditions;
  }

  public function filterClient($client_id)
  {
//    $query = $query->where('client_id', $client_id);
    $filterConditions = "client_id = '{$client_id}'";
    return $filterConditions;
  }

  public function filterEmployee($employee_id)
  {
//    $query = $query->where('employee_id', $employee_id);
    $filterConditions = "employee_id = '{$employee_id}'";
    return $filterConditions;
  }

  public function filterAsset($asset_id)
  {
//    $query = $query->where('asset_id', $asset_id);
    $filterConditions = "asset_id = '{$asset_id}'";
    return $filterConditions;

  }

  public function filterCategory($category_id)
  {
//    $query = $query->where('category_id', $category_id);
    $filterConditions = "category_id = '{$category_id}'";
    return $filterConditions;
  }

  public function filterItem($item_id)
  {
//    $query = $query->where('item_id', $item_id);
    $filterConditions = "item_id = '{$item_id}'";
    return $filterConditions;

  }

  public function filterContainsInNotes($contains)
  {
//    $query = $query->where('notes', 'like', '%' . $contains . '%');
    $filterConditions = "notes  LIKE '%$contains%'";
    return $filterConditions;
  }

  public function filterNotContainsInNotes($not_contains)
  {
//    $query = $query->where('notes', 'not like', '%' . $not_contains . '%');
    $filterConditions = "notes NOT LIKE '%$not_contains%' OR notes IS NULL";
    return $filterConditions;
  }


  public function filterLedgerReport($request, $account, $mainAccount)
  {
    $filterConditions = [];
    $cost_center_id = $request->input('cost_center_id');
    $branch_id = $request->input('branch_id');
    $user_id = $request->input('user_id');
    $contra_account_id = $request->input('contra_account_id');
    $client_id = $request->input('client_id');
    $employee_id = $request->input('employee_id');
    $asset_id = $request->input('asset_id');
    $category_id = $request->input('category_id');
    $item_id = $request->input('item_id');
    $contains = $request->input('contains');
    $not_contains = $request->input('not_contains');

    if (!$mainAccount) {
      $filterConditions[] = $this->filterAccount($account->id);
    }
    if ($cost_center_id != null) {
      $filterConditions[] = $this->filterCostCenter($cost_center_id);
    }
    if ($branch_id != null) {
      $filterConditions[] = $this->filterBranch($branch_id);
    }
    if ($user_id != null) {
      $filterConditions[] = $this->filterUser($user_id);
    }
    if ($contra_account_id != null) {
      $filterConditions[] = $this->filterContraAccount($contra_account_id);
    }
    if ($client_id != null) {
      $filterConditions[] = $this->filterClient($client_id);;
    }
    if ($employee_id != null) {
      $filterConditions[] = $this->filterEmployee($employee_id);
    }
    if ($asset_id != null) {
      $filterConditions[] = $this->filterAsset($asset_id);
    }
    if ($category_id != null) {
      $filterConditions[] = $this->filterCategory($category_id);
    }
    if ($item_id != null) {
      $filterConditions[] = $this->filterItem($item_id);
    }
    if ($contains != null) {
      $filterConditions[] = $this->filterContainsInNotes($contains);
    }
    if ($not_contains != null) {
      $filterConditions[] = $this->filterNotContainsInNotes($not_contains);
    }
    return $filterConditions;
  }

  public function sourcesLedgerReport($sources, $filterConditions)
  {
    $sourceConditions = [];
    foreach ($sources as $source) {
      $sourceConditions[] = $filterConditions . " AND source_id = '{$source['source_id']}' AND source_name = '{$source['source_name']}'";
    }
    $sourceConditions = implode(' OR ', $sourceConditions);
    return $sourceConditions;
  }

  public function ledgerReport($request, $account, $mainAccount)
  {

    $sources = $request->input('sources');
    $currency_id = $request->input('currency_id');
    $previous_current_Balance = 0;
    $after_current_Balance = 0;
    $filterConditions = $this->filterLedgerReport($request, $account, $mainAccount);
    $filterConditions = implode(' AND ', $filterConditions);
    if ($sources != null) {
      $allConditions = $this->sourcesLedgerReport($sources, $filterConditions);
    } else {
      $allConditions = $filterConditions;
    }
    if ($allConditions != null) {
      $sql = "SELECT * FROM journal_entry_records WHERE {$allConditions}";
    } else {
      $sql = "SELECT * FROM journal_entry_records ";
    }
//    return $sql;
    $query = DB::select($sql);
    $collectionQuery = new Collection($query);
//    return $collectionQuery;

    if (!$request->by_account_currency) {
      $currencyID = $currency_id;
    } else {
      $currencyID = $account->currency_id;
    }
    if ($request['created_between']['from'] != null && $request['created_between']['to'] != null) {
      $collectionQueryForBeforeSpecificDate = clone $collectionQuery;
      $collectionQueryForAfterSpecificDate = clone $collectionQuery;
      $start_created_date = date('Y-m-d', strtotime($request['created_between']['from']));
      $end_created_date = date('Y-m-d', strtotime($request['created_between']['to']));
      $collectionQuery = $collectionQuery->where('date', '>', $start_created_date)
        ->where('date', '<', $end_created_date);

      $collectionQueryForBeforeSpecificDate = $collectionQueryForBeforeSpecificDate->where('date', '<', $start_created_date);
      $previous_credit = $this->getCreditDebit('credit', 'account_id', $account, $currencyID, $collectionQueryForBeforeSpecificDate);
      $previous_debit = $this->getCreditDebit('debit', 'account_id', $account, $currencyID, $collectionQueryForBeforeSpecificDate);
      $previous_current_Balance = $previous_debit - $previous_credit;
      $collectionQueryForAfterSpecificDate = $collectionQueryForAfterSpecificDate->where('date', '>', $end_created_date);
      $after_credit = $this->getCreditDebit('credit', 'account_id', $account, $currencyID, $collectionQueryForAfterSpecificDate);
      $after_debit = $this->getCreditDebit('debit', 'account_id', $account, $currencyID, $collectionQueryForAfterSpecificDate);
      $after_current_Balance = $after_debit - $after_credit;
    }

    if ($request['posted_between']['from'] != null && $request['posted_between']['to'] != null) {
      $start_posted_date = date('Y-m-d', strtotime($request['posted_between']['from']));
      $end_posted_date = date('Y-m-d', strtotime($request['posted_between']['to']));
      $collectionQuery = $collectionQuery->where('date', '>', $start_posted_date)
        ->where('date', '<', $end_posted_date);
    }
    if ($request['not_posted_between']['from'] != null && $request['not_posted_between']['to'] != null) {
      $start_not_posted_date = date('Y-m-d', strtotime($request['not_posted_between']['from']));
      $end_not_posted_date = date('Y-m-d', strtotime($request['not_posted_between']['to']));
      $collectionQuery = $collectionQuery->where('date', '>', $start_not_posted_date)
        ->where('date', '<', $end_not_posted_date);
    }
    $credit = $this->getCreditDebit('credit', 'account_id', $account, $currencyID, $collectionQuery);
    $debit = $this->getCreditDebit('debit', 'account_id', $account, $currencyID, $collectionQuery);
    $current = $credit - $debit;

    if ($mainAccount) {
      $collectionQuery = $collectionQuery->where('account_id', $account->id);
    }


    $response = [
      'id' => $account['id'],
      'code' => $account['code'],
      'name' => $account['name'],
      'foreign_name' => $account['foreign_name'],
      "card_type" => $account['card_type'],
      "account_id" => $account['account_id'],
      "result_account_id" => $account['result_account_id'],
      "final_account_id" => $account->finalNormalAccount ? $account->finalNormalAccount['name'] : ' ',
      "currency_id" => $account->currency ? $account->currency['name'] : '',
      "ratio" => $account['ratio'],
      "parity" => $account['parity'],
      "notes" => $account['notes'],
      "amount" => $account['amount'],
      "is_warning_when_pass_max_limit" => $account['is_warning_when_pass_max_limit'],
      "is_client" => $account['is_client'],
      "is_assembly" => $account['is_assembly'],
      "is_distributive" => $account['is_distributive'],
      "is_final" => $account['is_final'],
      "is_normal" => $account['is_normal'],
      "is_credit" => $account['is_credit'],
      "is_debit" => $account['is_debit'],
      "is_both" => $account['is_both'],
      "is_max_limit_credit" => $account['is_max_limit_credit'],
      "is_max_limit_debit" => $account['is_max_limit_debit'],
      "is_max_limit_both" => $account['is_max_limit_both'],
      "assembly_normal_ids" => $account['assembly_normal_ids'],
      "distributive_normal_ids" => $account['distributive_normal_ids'],
      "internal_models" => $account['internal_models'],
      'credit' => $credit,
      'debit' => $debit,
      'current_Balance' => $current,
      'previous_current_Balance' => $previous_current_Balance,
      'after_current_Balance' => $after_current_Balance,
      'children' => $collectionQuery->values()->toArray()
    ];
    return $response;
  }

  public function finalLedgerReport(Request $request)
  {
    $totalCredit = 0;
    $totalDebit = 0;
    $totalCurrentBalance = 0;
    $totalPreviousCurrentBalance = 0;
    $totalAfterCurrentBalance = 0;
    $data = [];
    $account_id = $request['account_id'];
    $account = Account::find($account_id);
    if ($account->is_normal == true && $account['internalModels']->isEmpty()) {
      $data[] = $this->ledgerReport($request, $account, false);
    }
    if ($account->is_normal == true && !($account['internalModels']->isEmpty())) {
      $data[] = $this->ledgerReport($request, $account, true);
      $leafModels = $this->getLeafId($account);
      foreach ($leafModels as $leafModel) {
        $account = Account::find($leafModel);
        $data[] = $this->ledgerReport($request, $account, false);
      }
    }
    if ($account->is_assembly == true && ($account['assembly_normal_ids'] != null)) {
      $data[] = $this->ledgerReport($request, $account, true);
      $assembly_normal_ids = [];
      foreach ($account['assembly_normal_ids'] as $item) {
        $assembly_normal_ids[] = $item['id'];
      }
      foreach ($assembly_normal_ids as $assembly_normal_id) {
        $account = Account::find($assembly_normal_id);
        $data[] = $this->ledgerReport($request, $account, false);
      }
    }
    return $data;
  }


  public function getPieChartItemQuantityInStore($store_id)
  {
    $quantities = Quantity::where('store_id', $store_id)
      ->with('item')
      ->get(['quantity', 'item_id']);
    $result = $quantities->map(function ($quantity) {
      return [
        'quantity' => $quantity->quantity,
        'name' => $quantity->item->name,
      ];
    });
    return $result->toArray();
  }

  public function getPieChartItemQuantityInAllStores()
  {
    $quantities = DB::table('quantities')
      ->join('items', 'quantities.item_id', '=', 'items.id')
      ->join('stores', 'quantities.store_id', '=', 'stores.id')
      ->select('quantities.quantity', 'items.name', 'stores.name as store')
      ->get();
    return $quantities->toArray();
  }


  public function getBarChartItemQuantityInAllStores()
  {
    $quantities = DB::table('quantities')
      ->join('items', 'quantities.item_id', '=', 'items.id')
      ->join('stores', 'quantities.store_id', '=', 'stores.id')
      ->select('quantities.quantity', 'items.name as item_name', 'stores.name as store_name')
      ->get();

    $xAxisData = $quantities->pluck('item_name')->toArray();
    $yAxisData = $quantities->pluck('quantity')->toArray();

    $response = new class($xAxisData, $yAxisData) implements BarChartResponse {
      private $xAxisData;
      private $yAxisData;

      public function __construct(array $xAxisData, array $yAxisData)
      {
        $this->xAxisData = $xAxisData;
        $this->yAxisData = $yAxisData;
      }

      public function getXAxis(): array
      {
        return [
          'type' => 'category',
          'data' => $this->xAxisData,
        ];
      }

      public function getYAxis(): array
      {
        return [
          'type' => 'value',
        ];
      }

      public function getSeries(): array
      {
        return [
          [
            'data' => $this->yAxisData,
            'type' => 'bar',
          ],
        ];
      }
    };

    if (request()->expectsJson()) {
      $chartData = [
        'xAxis' => $response->getXAxis(),
        'yAxis' => $response->getYAxis(),
        'series' => $response->getSeries(),
      ];
      return response()->json($chartData);
    }
  }

  public function getBarChartItemQuantityInStore($store_id)
  {
    $quantities = DB::table('quantities')
      ->join('items', 'quantities.item_id', '=', 'items.id')
      ->join('stores', 'quantities.store_id', '=', 'stores.id')
      ->where('quantities.store_id', $store_id)
      ->select('quantities.quantity', 'items.name as item_name', 'stores.name as store_name')
      ->get();
    $xAxisData = $quantities->pluck('item_name')->toArray();
    $yAxisData = $quantities->pluck('quantity')->toArray();


    $response = new class($xAxisData, $yAxisData) implements BarChartResponse {
      private $xAxisData;
      private $yAxisData;

      public function __construct(array $xAxisData, array $yAxisData)
      {
        $this->xAxisData = $xAxisData;
        $this->yAxisData = $yAxisData;
      }

      public function getXAxis(): array
      {
        return [
          'type' => 'category',
          'data' => $this->xAxisData,
        ];
      }

      public function getYAxis(): array
      {
        return [
          'type' => 'value',
        ];
      }

      public function getSeries(): array
      {
        return [
          [
            'data' => $this->yAxisData,
            'type' => 'bar',
          ],
        ];
      }
    };
    if (request()->expectsJson()) {
      $chartData = [
        'xAxis' => $response->getXAxis(),
        'yAxis' => $response->getYAxis(),
        'series' => $response->getSeries(),
      ];
      return response()->json($chartData);
    }

  }
}
=======
// // namespace App\Traits\Report;

// use App\Interfaces\BarChartResponse;
// use App\Models\Account;
// use App\Models\Currency;
// use App\Models\Quantity;
// use App\Traits\Common\CommonTrait;
// use Illuminate\Http\Request;
// use Illuminate\Support\Collection;
// use Illuminate\Support\Facades\DB;
// use App\Interfaces\Report\LedgerFilters;

// trait  ReportTrait
// {
//   use  CommonTrait;

//   public function filterAccount($account_id)
//   {
// //    return $query->where('account_id', $account_id);
//     return "account_id = '{$account_id}'";
//   }

//   public function filterCostCenter($cost_center_id)
//   {
// //    $query = $query->where('cost_center_id',$cost_center_id);
//     $filterConditions = "cost_center_id = '{$cost_center_id}'";
//     return $filterConditions;
//   }

//   public function filterBranch($branch_id)
//   {
// //    $query = $query->where('branch_id', $branch_id);
//     $filterConditions = "branch_id = '{$branch_id}'";
//     return $filterConditions;
//   }

//   public function filterUser($user_id)
//   {
// //  $query = $query->where('user_id', $user_id);
//     $filterConditions = "user_id = '{$user_id}'";
//     return $filterConditions;
//   }

//   public function filterContraAccount($contra_account_id)
//   {
// //    $query = $query->where('contra_account_id', $contra_account_id);
//     $filterConditions = "contra_account_id = '{$contra_account_id}'";
//     return $filterConditions;
//   }

//   public function filterClient($client_id)
//   {
// //    $query = $query->where('client_id', $client_id);
//     $filterConditions = "client_id = '{$client_id}'";
//     return $filterConditions;
//   }

//   public function filterEmployee($employee_id)
//   {
// //    $query = $query->where('employee_id', $employee_id);
//     $filterConditions = "employee_id = '{$employee_id}'";
//     return $filterConditions;
//   }

//   public function filterAsset($asset_id)
//   {
// //    $query = $query->where('asset_id', $asset_id);
//     $filterConditions = "asset_id = '{$asset_id}'";
//     return $filterConditions;

//   }

//   public function filterCategory($category_id)
//   {
// //    $query = $query->where('category_id', $category_id);
//     $filterConditions = "category_id = '{$category_id}'";
//     return $filterConditions;
//   }

//   public function filterItem($item_id)
//   {
// //    $query = $query->where('item_id', $item_id);
//     $filterConditions = "item_id = '{$item_id}'";
//     return $filterConditions;

//   }

//   public function filterContainsInNotes($contains)
//   {
// //    $query = $query->where('notes', 'like', '%' . $contains . '%');
//     $filterConditions = "notes  LIKE '%$contains%'";
//     return $filterConditions;
//   }

//   public function filterNotContainsInNotes($not_contains)
//   {
// //    $query = $query->where('notes', 'not like', '%' . $not_contains . '%');
//     $filterConditions = "notes NOT LIKE '%$not_contains%' OR notes IS NULL";
//     return $filterConditions;
//   }


//   public function filterLedgerReport($request, $account, $mainAccount)
//   {
//     $filterConditions = [];
//     $cost_center_id = $request->input('cost_center_id');
//     $branch_id = $request->input('branch_id');
//     $user_id = $request->input('user_id');
//     $contra_account_id = $request->input('contra_account_id');
//     $client_id = $request->input('client_id');
//     $employee_id = $request->input('employee_id');
//     $asset_id = $request->input('asset_id');
//     $category_id = $request->input('category_id');
//     $item_id = $request->input('item_id');
//     $contains = $request->input('contains');
//     $not_contains = $request->input('not_contains');

//     if (!$mainAccount) {
//       $filterConditions[] = $this->filterAccount($account->id);
//     }
//     if ($cost_center_id != null) {
//       $filterConditions[] = $this->filterCostCenter($cost_center_id);
//     }
//     if ($branch_id != null) {
//       $filterConditions[] = $this->filterBranch($branch_id);
//     }
//     if ($user_id != null) {
//       $filterConditions[] = $this->filterUser($user_id);
//     }
//     if ($contra_account_id != null) {
//       $filterConditions[] = $this->filterContraAccount($contra_account_id);
//     }
//     if ($client_id != null) {
//       $filterConditions[] = $this->filterClient($client_id);;
//     }
//     if ($employee_id != null) {
//       $filterConditions[] = $this->filterEmployee($employee_id);
//     }
//     if ($asset_id != null) {
//       $filterConditions[] = $this->filterAsset($asset_id);
//     }
//     if ($category_id != null) {
//       $filterConditions[] = $this->filterCategory($category_id);
//     }
//     if ($item_id != null) {
//       $filterConditions[] = $this->filterItem($item_id);
//     }
//     if ($contains != null) {
//       $filterConditions[] = $this->filterContainsInNotes($contains);
//     }
//     if ($not_contains != null) {
//       $filterConditions[] = $this->filterNotContainsInNotes($not_contains);
//     }
//     return $filterConditions;
//   }

//   public function sourcesLedgerReport($sources, $filterConditions)
//   {
//     $sourceConditions = [];
//     foreach ($sources as $source) {
//       $sourceConditions[] = $filterConditions . " AND source_id = '{$source['source_id']}' AND source_name = '{$source['source_name']}'";
//     }
//     $sourceConditions = implode(' OR ', $sourceConditions);
//     return $sourceConditions;
//   }

//   public function ledgerReport($request, $account, $mainAccount)
//   {

//     $sources = $request->input('sources');
//     $currency_id = $request->input('currency_id');
//     $previous_current_Balance = 0;
//     $after_current_Balance = 0;
//     $filterConditions = $this->filterLedgerReport($request, $account, $mainAccount);
//     $filterConditions = implode(' AND ', $filterConditions);
//     if ($sources != null) {
//       $allConditions = $this->sourcesLedgerReport($sources, $filterConditions);
//     } else {
//       $allConditions = $filterConditions;
//     }
//     if ($allConditions != null) {
//       $sql = "SELECT * FROM journal_entry_records WHERE {$allConditions}";
//     } else {
//       $sql = "SELECT * FROM journal_entry_records ";
//     }
// //    return $sql;
//     $query = DB::select($sql);
//     $collectionQuery = new Collection($query);
// //    return $collectionQuery;

//     if (!$request->by_account_currency) {
//       $currencyID = $currency_id;
//     } else {
//       $currencyID = $account->currency_id;
//     }
//     if ($request['created_between']['from'] != null && $request['created_between']['to'] != null) {
//       $collectionQueryForBeforeSpecificDate = clone $collectionQuery;
//       $collectionQueryForAfterSpecificDate = clone $collectionQuery;
//       $start_created_date = date('Y-m-d', strtotime($request['created_between']['from']));
//       $end_created_date = date('Y-m-d', strtotime($request['created_between']['to']));
//       $collectionQuery = $collectionQuery->where('date', '>', $start_created_date)
//         ->where('date', '<', $end_created_date);

//       $collectionQueryForBeforeSpecificDate = $collectionQueryForBeforeSpecificDate->where('date', '<', $start_created_date);
//       $previous_credit = $this->getCreditDebit('credit', 'account_id', $account, $currencyID, $collectionQueryForBeforeSpecificDate);
//       $previous_debit = $this->getCreditDebit('debit', 'account_id', $account, $currencyID, $collectionQueryForBeforeSpecificDate);
//       $previous_current_Balance = $previous_debit - $previous_credit;
//       $collectionQueryForAfterSpecificDate = $collectionQueryForAfterSpecificDate->where('date', '>', $end_created_date);
//       $after_credit = $this->getCreditDebit('credit', 'account_id', $account, $currencyID, $collectionQueryForAfterSpecificDate);
//       $after_debit = $this->getCreditDebit('debit', 'account_id', $account, $currencyID, $collectionQueryForAfterSpecificDate);
//       $after_current_Balance = $after_debit - $after_credit;
//     }

//     if ($request['posted_between']['from'] != null && $request['posted_between']['to'] != null) {
//       $start_posted_date = date('Y-m-d', strtotime($request['posted_between']['from']));
//       $end_posted_date = date('Y-m-d', strtotime($request['posted_between']['to']));
//       $collectionQuery = $collectionQuery->where('date', '>', $start_posted_date)
//         ->where('date', '<', $end_posted_date);
//     }
//     if ($request['not_posted_between']['from'] != null && $request['not_posted_between']['to'] != null) {
//       $start_not_posted_date = date('Y-m-d', strtotime($request['not_posted_between']['from']));
//       $end_not_posted_date = date('Y-m-d', strtotime($request['not_posted_between']['to']));
//       $collectionQuery = $collectionQuery->where('date', '>', $start_not_posted_date)
//         ->where('date', '<', $end_not_posted_date);
//     }
//     $credit = $this->getCreditDebit('credit', 'account_id', $account, $currencyID, $collectionQuery);
//     $debit = $this->getCreditDebit('debit', 'account_id', $account, $currencyID, $collectionQuery);
//     $current = $credit - $debit;

//     if ($mainAccount) {
//       $collectionQuery = $collectionQuery->where('account_id', $account->id);
//     }


//     $response = [
//       'id' => $account['id'],
//       'code' => $account['code'],
//       'name' => $account['name'],
//       'foreign_name' => $account['foreign_name'],
//       "card_type" => $account['card_type'],
//       "account_id" => $account['account_id'],
//       "result_account_id" => $account['result_account_id'],
//       "final_account_id" => $account->finalNormalAccount ? $account->finalNormalAccount['name'] : ' ',
//       "currency_id" => $account->currency ? $account->currency['name'] : '',
//       "ratio" => $account['ratio'],
//       "parity" => $account['parity'],
//       "notes" => $account['notes'],
//       "amount" => $account['amount'],
//       "is_warning_when_pass_max_limit" => $account['is_warning_when_pass_max_limit'],
//       "is_client" => $account['is_client'],
//       "is_assembly" => $account['is_assembly'],
//       "is_distributive" => $account['is_distributive'],
//       "is_final" => $account['is_final'],
//       "is_normal" => $account['is_normal'],
//       "is_credit" => $account['is_credit'],
//       "is_debit" => $account['is_debit'],
//       "is_both" => $account['is_both'],
//       "is_max_limit_credit" => $account['is_max_limit_credit'],
//       "is_max_limit_debit" => $account['is_max_limit_debit'],
//       "is_max_limit_both" => $account['is_max_limit_both'],
//       "assembly_normal_ids" => $account['assembly_normal_ids'],
//       "distributive_normal_ids" => $account['distributive_normal_ids'],
//       "internal_models" => $account['internal_models'],
//       'credit' => $credit,
//       'debit' => $debit,
//       'current_Balance' => $current,
//       'previous_current_Balance' => $previous_current_Balance,
//       'after_current_Balance' => $after_current_Balance,
//       'children' => $collectionQuery->values()->toArray()
//     ];
//     return $response;
//   }

//   public function finalLedgerReport(Request $request)
//   {
//     $totalCredit = 0;
//     $totalDebit = 0;
//     $totalCurrentBalance = 0;
//     $totalPreviousCurrentBalance = 0;
//     $totalAfterCurrentBalance = 0;
//     $data = [];
//     $account_id = $request['account_id'];
//     $account = Account::find($account_id);
//     if ($account->is_normal == true && $account['internalModels']->isEmpty()) {
//       $data[] = $this->ledgerReport($request, $account, false);
//     }
//     if ($account->is_normal == true && !($account['internalModels']->isEmpty())) {
//       $data[] = $this->ledgerReport($request, $account, true);
//       $leafModels = $this->getLeafId($account);
//       foreach ($leafModels as $leafModel) {
//         $account = Account::find($leafModel);
//         $data[] = $this->ledgerReport($request, $account, false);
//       }
//     }
//     if ($account->is_assembly == true && ($account['assembly_normal_ids'] != null)) {
//       $data[] = $this->ledgerReport($request, $account, true);
//       $assembly_normal_ids = [];
//       foreach ($account['assembly_normal_ids'] as $item) {
//         $assembly_normal_ids[] = $item['id'];
//       }
//       foreach ($assembly_normal_ids as $assembly_normal_id) {
//         $account = Account::find($assembly_normal_id);
//         $data[] = $this->ledgerReport($request, $account, false);
//       }
//     }
//     return $data;
//   }


//   public function getPieChartItemQuantityInStore($store_id)
//   {
//     $quantities = Quantity::where('store_id', $store_id)
//       ->with('item')
//       ->get(['quantity', 'item_id']);
//     $result = $quantities->map(function ($quantity) {
//       return [
//         'quantity' => $quantity->quantity,
//         'name' => $quantity->item->name,
//       ];
//     });
//     return $result->toArray();
//   }

//   public function getPieChartItemQuantityInAllStores()
//   {
//     $quantities = DB::table('quantities')
//       ->join('items', 'quantities.item_id', '=', 'items.id')
//       ->join('stores', 'quantities.store_id', '=', 'stores.id')
//       ->select('quantities.quantity', 'items.name', 'stores.name as store')
//       ->get();
//     return $quantities->toArray();
//   }


//   public function getBarChartItemQuantityInAllStores()
//   {
//     $quantities = DB::table('quantities')
//       ->join('items', 'quantities.item_id', '=', 'items.id')
//       ->join('stores', 'quantities.store_id', '=', 'stores.id')
//       ->select('quantities.quantity', 'items.name as item_name', 'stores.name as store_name')
//       ->get();

//     $xAxisData = $quantities->pluck('item_name')->toArray();
//     $yAxisData = $quantities->pluck('quantity')->toArray();

//     $response = new class($xAxisData, $yAxisData) implements BarChartResponse {
//       private $xAxisData;
//       private $yAxisData;

//       public function __construct(array $xAxisData, array $yAxisData)
//       {
//         $this->xAxisData = $xAxisData;
//         $this->yAxisData = $yAxisData;
//       }

//       public function getXAxis(): array
//       {
//         return [
//           'type' => 'category',
//           'data' => $this->xAxisData,
//         ];
//       }

//       public function getYAxis(): array
//       {
//         return [
//           'type' => 'value',
//         ];
//       }

//       public function getSeries(): array
//       {
//         return [
//           [
//             'data' => $this->yAxisData,
//             'type' => 'bar',
//           ],
//         ];
//       }
//     };

//     if (request()->expectsJson()) {
//       $chartData = [
//         'xAxis' => $response->getXAxis(),
//         'yAxis' => $response->getYAxis(),
//         'series' => $response->getSeries(),
//       ];
//       return response()->json($chartData);
//     }
//   }

//   public function getBarChartItemQuantityInStore($store_id)
//   {
//     $quantities = DB::table('quantities')
//       ->join('items', 'quantities.item_id', '=', 'items.id')
//       ->join('stores', 'quantities.store_id', '=', 'stores.id')
//       ->where('quantities.store_id', $store_id)
//       ->select('quantities.quantity', 'items.name as item_name', 'stores.name as store_name')
//       ->get();
//     $xAxisData = $quantities->pluck('item_name')->toArray();
//     $yAxisData = $quantities->pluck('quantity')->toArray();


//     $response = new class($xAxisData, $yAxisData) implements BarChartResponse {
//       private $xAxisData;
//       private $yAxisData;

//       public function __construct(array $xAxisData, array $yAxisData)
//       {
//         $this->xAxisData = $xAxisData;
//         $this->yAxisData = $yAxisData;
//       }

//       public function getXAxis(): array
//       {
//         return [
//           'type' => 'category',
//           'data' => $this->xAxisData,
//         ];
//       }

//       public function getYAxis(): array
//       {
//         return [
//           'type' => 'value',
//         ];
//       }

//       public function getSeries(): array
//       {
//         return [
//           [
//             'data' => $this->yAxisData,
//             'type' => 'bar',
//           ],
//         ];
//       }
//     };
//     if (request()->expectsJson()) {
//       $chartData = [
//         'xAxis' => $response->getXAxis(),
//         'yAxis' => $response->getYAxis(),
//         'series' => $response->getSeries(),
//       ];
//       return response()->json($chartData);
//     }

//   }
// }
>>>>>>> 69b37f8019958d164d45d9082185c2f8b5033d79
