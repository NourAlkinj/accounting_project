<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Report\Interfaces\LedgerFilters;
use App\Models\Account;
use App\Models\Asset;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Client;
use App\Models\CostCenter;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Unit;
use App\Models\User;
use App\Traits\Item\ItemTrait;
use App\Traits\Report\filterItemsForRepricing;
use Illuminate\Http\Request;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;
use DateTime;

class ReportController extends Controller
{
  use ItemTrait;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function ledger(Request $request)
  {

    $account = Account::find($request->account_id);
    if ($account->is_normal == true && $account['internalModels']->isEmpty()) {
      $accounts[] = $account;
    }
    if ($account->is_normal == true && !($account['internalModels']->isEmpty())) {
      $mainAccount = $account;
      $leafModels = $this->getLeafId($account);
      foreach ($leafModels as $leafModel) {
        $account = Account::find($leafModel);
        $accounts[] = $account;
      }
      array_push($accounts, $mainAccount);
    }
    if ($account->is_assembly == true && ($account['assembly_normal_ids'] != null)) {
      $mainAccount = $account;
      $assembly_normal_ids = [];
      foreach ($account['assembly_normal_ids'] as $item) {
        $assembly_normal_ids[] = $item['id'];
      }
      foreach ($assembly_normal_ids as $assembly_normal_id) {
        $account = Account::find($assembly_normal_id);
        $accounts[] = $account;
      }
      array_push($accounts, $mainAccount);
    }
//    return $accounts;

    // loop over every account and create a report for it
    $accounts_records = [];
    $previous_date_filter_accounts_records = [];
    $after_date_filter_accounts_records = [];
    foreach ($accounts as $account) {
      $account_report = new ReportBuilder(
        new LedgerFilter(
          new LedgerFilters(
            $account['id'],
            $request->cost_center_id,
            $request->branch_id,
            $request->user_id,
            $request->contra_account_id,
            $request->client_id,
            $request->employee_id,
            $request->asset_id,
            $request->category_id,
            $request->item_id,
            $request->contains,
            $request->not_contains,
            false,
            true,
            $request->created_between,
            $request->posted_between,
            $request->not_posted_between,
            $request->sources,
              null,
              null,
              null,
              null,
              null,

          )
        ),
        [],
        [
          ['name' => 'account_filter', 'affects_final_result' => true],
          $request->sources ? ['name' => 'sources_filter', 'affects_final_result' => true] : [],
          $request->cost_center_id ? ['name' => 'cost_center_filter', 'affects_final_result' => true] : [],
          $request->branch_id ? ['name' => 'branch_filter', 'affects_final_result' => true] : [],
          $request->user_id ? ['name' => 'user_filter', 'affects_final_result' => true] : [],
          $request->contra_account_id ? ['name' => 'contra_account_filter', 'affects_final_result' => true] : [],
          $request->client_id ? ['name' => 'client_filter', 'affects_final_result' => true] : [],
          $request->employee_id ? ['name' => 'employee_filter', 'affects_final_result' => true] : [],
          $request->asset_id ? ['name' => 'asset_filter', 'affects_final_result' => true] : [],
          $request->category_id ? ['name' => 'category_filter', 'affects_final_result' => true] : [],
          $request->item_id ? ['name' => 'item_filter', 'affects_final_result' => true] : [],
          $request->contains ? ['name' => 'contains_filter', 'affects_final_result' => true] : [],
          $request->not_contains ? ['name' => 'not_contains_filter', 'affects_final_result' => true] : [],
          $request->created_between ? ['name' => 'previous_date_filter', 'affects_final_result' => false] : [],
          $request->created_between ? ['name' => 'after_date_filter', 'affects_final_result' => false] : [],
          $request->created_between ? ['name' => 'date_range_filter', 'affects_final_result' => true] : [],
          $request->posted_between ? ['name' => 'posted_date_range_filter', 'affects_final_result' => true] : [],
          $request->not_posted_between ? ['name' => 'not_posted_date_range_filter', 'affects_final_result' => true] : []
        ]
      );

      foreach ($account_report->result as $record) {
        $record =[
                'id'=>$record['id'] ,
                'index'=> $record['index'],
                'date'=>$record['date'],
                'account_id'=>$record['account_id'],
                'main_account_name'=>  Account::find($record['account_id']) ? Account::find($record['account_id'])->name : null,
                'credit'=> $record['credit'],
                'debit'=> $record['debit'],
                'relative_debit'=> $record['relative_debit'],
                'relative_credit'=> $record['relative_credit'],
                'notes'=> $record['notes'],
                 'cost_center_id'=> $record['cost_center_id'],
                 'cost_center_name'=> CostCenter::find($record['cost_center_id'])? CostCenter::find($record['cost_center_id'])->name : null,
          'currency_id'=> $record['currency_id'],
          'currency_name'=>  Currency::find($record['currency_id']) ? Currency::find($record['currency_id'])->name : null,
                'parity'=> $record['parity'],
                'today_parity'=> $record['today_parity'],
                'equivalent'=> $record['equivalent'],
          'contra_account_id'=> $record['contra_account_id'],
          'contra_account_name'=>Account::find($record['contra_account_id']) ? Account::find($record['contra_account_id'])->name : null,
                'journal_entry_id'=> $record['journal_entry_id'],
                'current_balance'=> $record['current_balance'],
                'final_balance'=> $record['final_balance'],
                'is_post_to_account'=> $record['is_post_to_account'],
                'post_to_account_date'=> $record['post_to_account_date'],
                'relative_final_balance'=> $record['relative_final_balance'],
                'relative_current_balance'=> $record['relative_current_balance'],
                'source_name'=> $record['source_name'],
                'source_template_id'=> $record['source_template_id'],
                'source_id'=> $record['source_id'],
                'branch_id'=> $record['branch_id'],
                'branch_name'=> Branch::find($record['branch_id'])? Branch::find($record['branch_id'])->name : null,
                'user_id'=> $record['user_id'],
                'user_name'=> User::find($record['user_id']) ? User::find($record['user_id'])->name : null,
                'client_id'=> $record['client_id'],
                'client_name'=> Client::find($record['client_id']) ? Client::find($record['client_id'])->name : null,
                'item_id'=> $record['item_id'],
                'item_name'=>  Item::find($record['item_id']) ? Item::find($record['item_id'])->name : null,
                'employee_id'=> $record['employee_id'],
                'employee_name'=> Employee::find($record['employee_id']) ? Employee::find($record['employee_id'])->name : null,
                'asset_id'=> $record['asset_id'],
                'asset_name'=> Asset::find($record['asset_id'])? Asset::find($record['asset_id'])->name : null,
                'category_id'=> $record['category_id'],
                'category_name'=> Category::find($record['category_id']) ? Category::find($record['category_id'])->name : null,
                'deleted_at'=> $record['deleted_at'],
                'created_at'=> $record['created_at'],
                'updated_at'=> $record['updated_at'],
          ];

        $accounts_records[] = $record;
      }
      foreach ($account_report->eachFilterResult['previous_date_filter'] as $record) {
        $previous_date_filter_accounts_records[] = $record;
      }
      foreach ($account_report->eachFilterResult['after_date_filter'] as $record) {
        $after_date_filter_accounts_records[] = $record;
      }
    }
//      return $accounts_records;
//    return $previous_date_filter_accounts_records;
//    return $after_date_filter_accounts_records;


    $currencyID = null;
    $currency_id = $request->input('currency_id');
    $by_account_currency = $request->input('by_account_currency');
    if (!$by_account_currency) {
      $currencyID = $currency_id;
    }
    $accounts = array_map(function ($acc) use ( $currencyID, $accounts_records, $previous_date_filter_accounts_records, $after_date_filter_accounts_records) {
      if ($currencyID == null) {
        $currencyID = $acc->currency_id;
      }

      $acc['currency_name'] =  Currency::find($currencyID)->name ;

      $acc['children'] = array_filter($accounts_records, function ($record) use ($acc) {
        return $acc['id'] == $record['account_id'];
      });

      $previous_date_filter_Specific_account_records = array_filter($previous_date_filter_accounts_records, function ($record) use ($acc) {
        return $acc['id'] == $record['account_id'];
      });
      $after_date_filter_Specific_account_records = array_filter($after_date_filter_accounts_records, function ($record) use ($acc) {
        return $acc['id'] == $record['account_id'];
      });
      if ($acc['is_normal'] == true && !($acc['internalModels']->isEmpty()) || $acc['is_assembly'] == true && ($acc['assembly_normal_ids'] != null)) {
        $acc['credit'] = $this->getCredit($accounts_records, $currencyID);
        $acc['debit'] = $this->getDebit($accounts_records, $currencyID);
        $acc['current_balance'] = $acc['credit'] - $acc['debit'];
        $acc['previous_credit'] = $this->getCredit($previous_date_filter_accounts_records, $currencyID);
        $acc['previous_debit'] = $this->getDebit($previous_date_filter_accounts_records, $currencyID);
        $acc['previous_current_balance'] = $acc['previous_credit'] - $acc['previous_debit'];
        $acc['after_credit'] = $this->getCredit($after_date_filter_accounts_records, $currencyID);
        $acc['after_debit'] = $this->getDebit($after_date_filter_accounts_records, $currencyID);
        $acc['after_current_balance'] = $acc['after_credit'] - $acc['after_debit'];
      } else {
        $acc['credit'] = $this->getCredit($acc['children'], $currencyID);
        $acc['debit'] = $this->getDebit($acc['children'], $currencyID);
        $acc['current_balance'] = $acc['credit'] - $acc['debit'];
        $acc['previous_credit'] = $this->getCredit($previous_date_filter_Specific_account_records, $currencyID);
        $acc['previous_debit'] = $this->getDebit($previous_date_filter_Specific_account_records, $currencyID);
        $acc['previous_current_balance'] = $acc['previous_credit'] - $acc['previous_debit'];
        $acc['after_credit'] = $this->getCredit($after_date_filter_Specific_account_records, $currencyID);
        $acc['after_debit'] = $this->getDebit($after_date_filter_Specific_account_records, $currencyID);
        $acc['after_current_balance'] = $acc['after_credit'] - $acc['after_debit'];
      }
      return $acc;
    }, $accounts);

    //output
    $accounts = array_map(function ($account){
      return [
        'id' => $account['id'],
        'code' => $account['code'],
        'name' => $account['name'],
        'foreign_name' => $account['foreign_name'],
        'card_type' => $account['card_type'],
        'main_account_name' => Account::find($account['account_id'])?Account::find($account['account_id'])->name:null,
        'result_account_name' => Account::find($account['result_account_id'])?Account::find($account['result_account_id'])->name:null ,
        'final_account_name' => Account::find($account['final_account_id'])?Account::find($account['final_account_id'])->name:null ,
        'currency_name' => $account['currency_name'],
        'ratio' => $account['ratio'],
        'parity' => $account['parity'],
        'notes' => $account['notes'],
        'amount' => $account['amount'],
        'is_warning_when_pass_max_limit' => $account['is_warning_when_pass_max_limit'],
        'is_client' => $account['is_client'],
        'is_assembly' => $account['is_assembly'],
        'is_distributive' => $account['is_distributive'],
        'is_final' => $account['is_final'],
        'is_normal' => $account['is_normal'],
        'is_credit' => $account['is_credit'],
        'is_debit' => $account['is_debit'],
        'is_both' => $account['is_both'],
        'is_max_limit_credit' => $account['is_max_limit_credit'],
        'is_max_limit_debit' => $account['is_max_limit_debit'],
        'is_max_limit_both' => $account['is_max_limit_both'],
        'assembly_normal_ids' => $account['assembly_normal_ids'],
        'distributive_normal_ids' => $account['distributive_normal_ids'],
        'tax_account' => $account['tax_account'],
        'tax_ratio' => $account['tax_ratio'],
        'fixed_tax' => $account['fixed_tax'],
        'enable_tax' => $account['enable_tax'],
        'credit'=> $account['credit'],
        'debit'=>  $account['debit'],
        'current_balance'=> $account['current_balance'] ,
        'previous_credit'=> $account['previous_credit'] ,
        'previous_debit'=> $account['previous_debit'],
        'previous_current_balance'=> $account['previous_current_balance'] ,
        'after_credit'=> $account['after_credit'] ,
        'after_debit'=> $account['after_debit'] ,
        'after_current_balance'=> $account['after_current_balance'],
        'children'=>$account['children'],
      ];
    }, $accounts);

    return $accounts;
  }


  public function itemRepricing(Request $request)
  {
    $priceType = $request->price_type ? $request->price_type : null;
    $costPrice = $request->cost_price ? $request->cost_price : null;
    $currencyId = $request->currency_id ? $request->currency_id : null;
    $unitId = $request->unit != 0 ? $request->unit : 0;
    $price_between_from = $request->price_between ? $request->price_between['from'] : null;
    $price_between_to = $request->price_between ? $request->price_between['to'] : null;

    $items_records = [];
    $item_report = new ReportBuilder(
      new filterItemsForRepricing(
        $request->items,
        $request->only_items_have_quantities,
        $request->item_type,
        $request->currency_id,
        ),
      [],
      [
        $request->items ? ['name' => 'items_filter', 'affects_final_result' => true] : [],
        $request->only_items_have_quantities ? ['name' => 'only_items_have_quantities_filter', 'affects_final_result' => true] : [],
        $request->item_type ? ['name' => 'item_type_filter', 'affects_final_result' => true] : [],
        $request->currency_id ? ['name' => 'currency_filter', 'affects_final_result' => true] : [],
      ]
    );

    foreach ($item_report->result as $record) {
      $items_records[] = $record;
    }
//      return $items_records;

    $items = array_map(function ($item) use ($priceType, $unitId, $costPrice, $currencyId) {
      $price = null;
      if ($unitId == 0) {
        $itemController = new ItemController($item);
        $unitId = $itemController->getDefaultUnit();
      }
      foreach ($item['units'] as $unit) {
        if ($unit['unit_number'] == $unitId) {
          $item['unit_id'] = $unit->id;
          if (isset($unit['prices'][$priceType])) {
            $price = $unit['prices'][$priceType];
          }
          break;
        }

      }
      $item['price'] = $price;
      $item['cost_price'] = $this->getCostAccordingCostType($costPrice, $item->id, $unitId, $currencyId);
      $item['profit'] = $item['price'] - $item['cost_price'];
      $item['profit_ratio'] = $item['cost_price'] != 0 ? ($item['profit'] * 100) / $item['cost_price'] : 0;
      return $item;
    }, $items_records);

    if ($price_between_from != null) {
      $items = array_filter($items, function ($item) use ($price_between_from, $price_between_to) {
        return $item['price'] > $price_between_from && $item['price'] < $price_between_to;
      });
    }
//output
    $items = array_map(function ($item) use ($items) {
      return [
        'category_id' => $item['category_id'],
        'item_id' => $item['id'],
        'unit_id' => $item['unit_id'],
        'price' => $item['price'],
        'cost_price' => $item['cost_price'],
        'profit' => $item['profit'],
        'profit_ratio' => $item['profit_ratio'],
      ];
    }, $items);
    return $items;
  }

  public function getCostAccordingCostType($costType, $item_id, $unit_number, $currency_id)
  {
    if ($costType == 'min') {
      return $this->getItemMinPurchaseCost($item_id, $unit_number, $currency_id);
    } elseif ($costType == 'max') {
      return $this->getItemMaxPurchaseCost($item_id, $unit_number, $currency_id);
    } elseif ($costType == 'fifo') {
      return $this->getItemLastPurchaseCost($item_id, $unit_number, $currency_id);
    }
  }


  public function changeItemsPrice(Request $request)
  {
    $lang = $request->header('lang');
    $items = json_decode($request->getContent(), true);
    if (isset($items['items']) && is_array($items['items'])) {
      foreach ($items['items'] as $item) {
        $unitId = $item['unit_id'];
        $price = $item['price'];
        $unit = Unit::where('id', $unitId)->first();
        if ($unit) {
          $price_type = $items['price_type'];
          $prices = $unit->prices;
          $prices[$price_type] = $price;
          $unit->prices = $prices;
          $unit->save();
        }
      }
      return response()->json([
        'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
          ], 200);
    }
  }

  public function accountsBalancesReport(Request $request)
  {
      $account = Account::find($request->account_id);
    if ($account->is_normal == true && $account['internalModels']->isEmpty()) {
      $accounts[] = $account;
    }
    if ($account->is_normal == true && !($account['internalModels']->isEmpty())) {
      $leafModels = $this->getLeafId($account);
      foreach ($leafModels as $leafModel) {
        $account = Account::find($leafModel);
        $accounts[] = $account;
      }
    }
    if ($account->is_assembly == true && ($account['assembly_normal_ids'] != null)) {
      $assembly_normal_ids = [];
      foreach ($account['assembly_normal_ids'] as $item) {
        $assembly_normal_ids[] = $item['id'];
      }
      foreach ($assembly_normal_ids as $assembly_normal_id) {
        $account = Account::find($assembly_normal_id);
        $accounts[] = $account;
      }
    }
//    return $accounts;

      if($request->accounts_with_tax_only)
      {
          $accounts = array_filter($accounts, function ($account)  {
              return  $account['enable_tax'];
          });
      }
      if($request->accounts_without_tax_only)
      {
          $accounts = array_filter($accounts, function ($account)  {
              return  !$account['enable_tax'];
          });
      }

//    return $accounts;

      // loop over every account and create a report for it
      $accounts_records = [];
      $previous_date_filter_accounts_records = [];
      $after_date_filter_accounts_records = [];
      $post_to_accounts_records = [];
      $not_post_to_accounts_records = [];
      foreach ($accounts as $account) {
          $account_report = new ReportBuilder(
              new LedgerFilter(
                  new LedgerFilters(
                      $account['id'],
                      $request->cost_center_id,
                      $request->branch_id,
                      null,//   $request->user_id,
                      null,//   $request->contra_account_id,
                      $request->client_id,
                      null,//   $request->employee_id,
                      null,//   $request->asset_id,
                      null,//   $request->category_id,
                      null,//   $request->item_id,
                      $request->contains,
                      $request->not_contains,
                      null,
                      null,
                      $request->created_between,
                      null,//$request->posted_between,
                      null,//$request->not_posted_between,
                      $request->sources,
                      $request->debit_only,
                      $request->credit_only,
                      $request->all,
                      $request->show_posted_balance,
                      $request->show_not_posted_balance,

          )
              ),
              [],
              [
                  ['name' => 'account_filter', 'affects_final_result' => true],
                  $request->sources ? ['name' => 'sources_filter', 'affects_final_result' => true] : [],
                  $request->client_id ? ['name' => 'client_filter', 'affects_final_result' => true] : [],
                  $request->cost_center_id ? ['name' => 'cost_center_filter', 'affects_final_result' => true] : [],
                  $request->branch_id ? ['name' => 'branch_filter', 'affects_final_result' => true] : [],
                  $request->created_between ? ['name' => 'previous_date_filter', 'affects_final_result' => false] : [],
                  $request->created_between ? ['name' => 'after_date_filter', 'affects_final_result' => false] : [],
                  $request->created_between ? ['name' => 'date_range_filter', 'affects_final_result' => true] : [],
                  $request->contains ? ['name' => 'contains_filter', 'affects_final_result' => true] : [],
                  $request->not_contains ? ['name' => 'not_contains_filter', 'affects_final_result' => true] : [],
                  $request->debit_only ? ['name' => 'debit_only_filter', 'affects_final_result' => true] : [],
                  $request->credit_only ? ['name' => 'credit_only_filter', 'affects_final_result' => true] : [],
                  $request->all ? ['name' => 'all_filter', 'affects_final_result' => true] : [],
                 optional( $request->show_posted_balance) ? ['name' => 'is_post_to_account_filter', 'affects_final_result' => false] : [],
                  $request->show_not_posted_balance ? ['name' => 'is_not_post_to_account_filter', 'affects_final_result' => false] : [],

                ]
          );
      foreach ($account_report->result as $record) {
        $accounts_records[] = $record;
      }
      foreach ($account_report->eachFilterResult['previous_date_filter'] as $record) {
        $previous_date_filter_accounts_records[] = $record;
      }
      foreach ($account_report->eachFilterResult['after_date_filter'] as $record) {
        $after_date_filter_accounts_records[] = $record;
      }
      foreach ($account_report->eachFilterResult['is_post_to_account_filter'] as $record) {
          $post_to_accounts_records[] = $record;
      }
      foreach ($account_report->eachFilterResult['is_not_post_to_account_filter'] as $record) {
          $not_post_to_accounts_records[] = $record;
      }
    }
//      return $accounts_records;
//      return $previous_date_filter_accounts_records;
//      return $after_date_filter_accounts_records;
//      return $post_to_accounts_records;
//      return $not_post_to_accounts_records;

    $currencyID = null;

    $currency_id = $request->input('currency_id');
    $by_account_currency = $request->input('by_account_currency');
    if (!$by_account_currency) {
      $currencyID = $currency_id;
    }

    $accounts = array_map(function ($acc) use ($currencyID, $accounts_records, $previous_date_filter_accounts_records, $after_date_filter_accounts_records,$post_to_accounts_records,$not_post_to_accounts_records) {
      if ($currencyID == null) {
        $currencyID = $acc->currency_id;
      }
        $accountCurrencyName =  Currency::find($acc['currency_id'])?Currency::find($acc['currency_id'])->name:null;
        $reportCurrencyName = Currency::find($currencyID)? Currency::find($currencyID)->name:null;
        $finalAccountName = Account::find($acc['final_account_id'])?Account::find($acc['final_account_id'])->name:null;
        $mainAccountName = Account::find($acc['account_id'])?Account::find($acc['account_id'])->name:null;

        $accChildren = array_filter($accounts_records, function ($record) use ($acc) {
            return $acc['id'] == $record['account_id'];
        });
        $previous_date_filter_Specific_account_records = array_filter($previous_date_filter_accounts_records, function ($record) use ($acc) {
            return $acc['id'] == $record['account_id'];
        });
        $after_date_filter_Specific_account_records = array_filter($after_date_filter_accounts_records, function ($record) use ($acc) {
            return $acc['id'] == $record['account_id'];
        });

        $Specific_post_to_accounts_records = array_filter($post_to_accounts_records, function ($record) use ($acc) {
            return $acc['id'] == $record['account_id'];
        });
        $Specific_not_post_to_accounts_records = array_filter($not_post_to_accounts_records, function ($record) use ($acc) {
            return $acc['id'] == $record['account_id'];
        });


//      $maxLimit= $acc['profit_ratio'];


      $acc['credit']  =$this->sumCredit($accChildren) ;
      $acc['debit'] =$this->sumDebit($accChildren);
      $acc['current_balance'] = $this->getCredit($accChildren, $currencyID) -  $this->getDebit($accChildren, $currencyID);
      $acc['previous_credit'] = $this->getCredit($previous_date_filter_Specific_account_records, $currencyID);
      $acc['previous_debit'] = $this->getDebit($previous_date_filter_Specific_account_records, $currencyID);
      $acc['previous_current_balance'] = $acc['previous_credit'] - $acc['previous_debit'];
      $acc['after_credit'] = $this->getCredit($after_date_filter_Specific_account_records, $currencyID);
      $acc['after_debit'] = $this->getDebit($after_date_filter_Specific_account_records, $currencyID);
      $acc['after_current_balance'] = $acc['after_credit'] - $acc['after_debit'];
      $acc['account_currency_name'] = $accountCurrencyName;
      $acc['report_currency_name'] = $reportCurrencyName;
      $acc['final_account_name'] = $finalAccountName;
      $acc['main_account_name'] = $mainAccountName;
      $acc['show_posted_balance'] = $this->getCredit($Specific_post_to_accounts_records, $currencyID) -  $this->getDebit($Specific_post_to_accounts_records, $currencyID);;
      $acc['show_not_posted_balance'] = $this->getCredit($Specific_not_post_to_accounts_records, $currencyID) -  $this->getDebit($Specific_not_post_to_accounts_records, $currencyID);;
      $acc['final_balance'] = $acc['current_balance'] + $acc['after_current_balance'] +$acc['previous_current_balance'] ;
      if($acc['is_credit'])
         $acc['max_limit']=$acc['amount'].'Credit';
      elseif ($acc['is_debit'])
              $acc['max_limit']=$acc['amount'].'Debit';

      return $acc;
    }, $accounts);

      if($request->which_pass_max_limit)
      {
          $accounts = array_filter($accounts, function ($account)  {
              if($account['is_max_limit_credit'])
              return  $account['current_balance']< ($account['amount'] * -1);
              if($account['is_max_limit_debit'])
                  return  $account['current_balance']> $account['amount'] ;
          });
      }

//    return $accounts;

    //output
    $accounts = array_map(function ($acc) {
      return [
        'account_code' => $acc['code'],
        'account_name' => $acc['name'],
        'account_code_and_name'=> $acc['code']. $acc['name'],
        'main_account_name' => $acc['main_account_name'],
        'final_account_name' => $acc['final_account_name'],
        'debit' => $acc['debit'],
        'credit' => $acc['credit'],
        'balance' => $acc['current_balance'] >= 0 ? $acc['current_balance'].'Debit':abs($acc['current_balance']).'Credit' ,
        'balance_as_text' => $acc['current_balance'],
        'next_balance' => $acc['after_current_balance'],
        'previous_balance' => $acc['previous_current_balance'],
        'final_balance' => $acc['final_balance'] >= 0 ?$acc['final_balance'].'Debit':abs($acc['final_balance']).'Credit',
        'max_limit' => $acc['max_limit'],
        'currency' => $acc['account_currency_name'],
        'report_currency' => $acc['report_currency_name'],
        'max_limit_differencies' => $acc['max_limit'] -  $acc['current_balance'] ,
        'posted_balance' =>   $acc['show_posted_balance'] ,
        'unposted_balance' =>  $acc['show_not_posted_balance'],
      ];
    }, $accounts);
    return $accounts;
  }


    public function sumCredit($records)
    {
        $sumCredit=0;
        foreach ($records as $record) {
            $sumCredit  =$sumCredit + $record['credit'];
        }
        return $sumCredit;
    }
    public function sumDebit($records)
    {
        $sumDebit=0;
        foreach ($records as $record) {
            $sumDebit  =$sumDebit + $record['debit'];
        }
        return $sumDebit;
    }


}


