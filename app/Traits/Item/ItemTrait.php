<?php

namespace App\Traits\Item;

use App\Models\Bill;
use App\Models\BillRecord;
use App\Models\BillTemplate;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Unit;
use App\Traits\Currency\ActivityCurrencyTrait;
use function PHPUnit\Framework\isNull;


trait  ItemTrait
{
  use ActivityCurrencyTrait;

  public function getItemMaxPurchaseCost($item_id, $unit_number, $currency_id)
  {
    $unit = Unit::where('unit_number', $unit_number)->first();
    $records = BillRecord::where('item_id', $item_id)->get();
//return $records;
    if (!isNull($records)) {
      $sortedRecords = $records->map(function ($record) {
        return [
          'result' => $record['unit_price'] * $record['parity'] * $record['conversion_factor'],
          'data' => $record];
      })->sortByDesc('result');
      $maxRecord = $sortedRecords->first()['data'];
      $bill = Bill::find($maxRecord->bill_id);
      $max_purchase_cost = $this->currencyAffect($maxRecord, $bill);
      if ($unit['conversion_factor'] != 0)
        $max_purchase_cost = ($max_purchase_cost * $unit['conversion_factor']) / $bill['conversion_factor'];
      return $max_purchase_cost;
    } else {
      return 0;
    }

//    return [
//      'Max Record' => $maxRecord,
//      'Max Purchase Cost ' => $max_purchase_cost
//    ];
  }

  public function getItemMinPurchaseCost($item_id, $unit_number, $currency_id)
  {
    $unit = Unit::where('unit_number', $unit_number)->first();
    $records = BillRecord::where('item_id', $item_id)->get();
    if (!isNull($records)) {
      $sortedRecords = $records->map(function ($record) {
        return [
          'result' => $record['unit_price'] * $record['parity'] * $record['conversion_factor'],
          'data' => $record];
      })->sortBy('result');

      $minRecord = $sortedRecords->first()['data'];
      $bill = Bill::find($minRecord->bill_id);
      $min_purchase_cost = $this->currencyAffect($minRecord, $bill);
      if ($unit['conversion_factor'] != 0)
        $min_purchase_cost = ($min_purchase_cost * $unit['conversion_factor']) / $bill['conversion_factor'];
      return $min_purchase_cost;
    } else {
      return 0;
    }
//    return [
//      'Min Record' => $minRecord,
//      'Min Purchase Cost ' => $min_purchase_cost
//    ];
  }


  public function getItemLastPurchaseCost($item_id, $unit_number, $currency_id)
  {
    $unit = Unit::where('unit_number', $unit_number)->first();
    $lastRecord = BillRecord::where('item_id', $item_id)->orderBy('bill_id', 'asc')->latest()->get()->last();
    if (!isNull($lastRecord)) {
      $bill = Bill::find($lastRecord->bill_id);
      $last_purchase_cost = $this->currencyAffect($lastRecord, $bill);
      if ($unit['conversion_factor'] != 0)
        $last_purchase_cost = ($last_purchase_cost * $unit['conversion_factor']) / $bill['conversion_factor'];
      return $last_purchase_cost;
    } else {
      return 0;
    }
//    return [
//      'Last Record' => $lastRecord,
//      'Last Purchase Cost ' => $last_purchase_cost
//    ];
  }


  public function getItemFIFOCost($currency_id)
  {
    $out_Bill_records = BillRecord::where('storing_type', 'OUT')->get();
    $sumOfQuantityAndConversion_factor = 0;
    foreach ($out_Bill_records as $out_Bill_record) {
      $sumOfQuantityAndConversion_factor += $out_Bill_record['quantity'] * $out_Bill_record['conversion_factor'];
    }
//    return $sumOfQuantityAndConversion_factor;
    $in_Bill_records = BillRecord::where('storing_type', 'IN')->get();
    $inQuantityBeforeFirstOutQuantity = $sumOfQuantityAndConversion_factor;
    $FIFOQuantity = 0;
    $result = 0;
    foreach ($in_Bill_records as $in_Bill_record) {
      $bill = Bill::find($in_Bill_record->bill_id);

      if ($inQuantityBeforeFirstOutQuantity > 0) {
        $inQuantityBeforeFirstOutQuantity -= $in_Bill_record['quantity'] * $in_Bill_record['conversion_factor'];

        if ($inQuantityBeforeFirstOutQuantity < 0) {
          $first_out_quantity = abs($inQuantityBeforeFirstOutQuantity) / $in_Bill_record['conversion_factor'];
          $FIFOQuantity += $in_Bill_record['quantity'] * $in_Bill_record['unit_price'];
          if ($currency_id == $bill->currency_id) {
            $result += $FIFOQuantity;
          }
          if ($currency_id == $this->getDefaultCurrencyID()) {
            $result += $FIFOQuantity * $bill->parity;
          } else
            $result += $FIFOQuantity * $bill->parity / $this->logParity($currency_id, $bill->date);
        }
        continue;
      }

      $FIFOQuantity += $in_Bill_record['quantity'] * $in_Bill_record['unit_price'];

    if ($currency_id == $bill->currency_id) {
      $result += $FIFOQuantity;
    }
    if ($currency_id == $this->getDefaultCurrencyID()) {
      $result += $FIFOQuantity * $bill->parity;
    } else
      $result += $FIFOQuantity * $bill->parity / $this->logParity($currency_id, $bill->date);
  }
    return $result;
  }

  public function currencyAffect($record, $bll)
  {
    if ($currency_id = $bll['currency_id']) {
      $last_purchase_cost = $record['unit_price'];
    } elseif ($currency_id = $this->getDefaultCurrency()) {
      $last_purchase_cost = $record['unit_price'] * $bll['parity'];
    } else {
      $last_purchase_cost = ($record['unit_price'] * $bll['parity']) / $this->logParity($currency_id, $bll['date']);
    }
    return $last_purchase_cost;
  }


  public function getCost($item_id, $unit_id, $store_id, $currency_id)
  {

    // Check If There Is A Specific Store For The Cost
//    if ($store_id != null) {
//      $records = BillRecord::where('item_id', $item_id)->where('store_id', $store_id)->where('is_affects_cost_price', true)->get();
//    } else {
//      $records = BillRecord::where('item_id', $item_id)->where('is_affects_cost_price', true)->get();
//    }
//
//    //
//    $addition = 0;
//    $discount = 0;
//    $total = 0;
//    $quantity_conversion_factor = 0;
//    $gift_quantity_conversion_factor = 0;
//    $record_result = 0;
//
//    //
//    foreach ($records as $record) {
//      if ($record['is_discounts_affects_cost_price'] && $record['is_additions_affects_cost_price']) {
//        $addition += $record['item_addition'] + $record['general_additions'];
//        $discount += $record['item_discount'] + $record['general_discount'];
//      }
////      $bill = Bill::where('id', $record['bill_id'])->first();
//      $user = auth('sanctum')->user();
//      if ($record['storing_type'] == 'IN' && $record['security_level'] <= $user['security_level']) {
//        $total += $record['quantity'] * $record['conversion_factor'] * $record['cost_price'];
//        $quantity_conversion_factor += $record['quantity'] * $record['conversion_factor'];
//        $gift_quantity_conversion_factor += $record['gift_quantity'] * $record['gift_conversion_factor'];
//      }
//      if ($currency_id == $record['currency_id']) {
//        $record_result = $total - $discount + $addition;
//      } elseif ($currency_id == $this->getDefaultCurrencyID()) {
//        $record_result = ($total - $discount + $addition) * $record['parity'];
//      } else {
//        $record_result = ($total - $discount + $addition) * ($record['parity'] / $this->logParity($currency_id, $record['date']));
//      }
//    }
//
//    $sumQuantity = $quantity_conversion_factor + $gift_quantity_conversion_factor;
//    return $record_result / $sumQuantity;

    // Get The Input Bills
    $user = auth('sanctum')->user();
    $inputBills = Bill::where('storing_type', "IN")->where('security_level', "<", $user['security_level'])->get()->toArray();
    //
    $quantitySum = 0;
    $totalPricesSum = 0;

    //
    foreach ($inputBills as $bill) {
      $template = BillTemplate::where("id", $bill['bill_template_id'])->get()->toArray();
      if ($template) {

        // Pass The Bill That does not Affect On The Cost
        if ($template[0]['is_affects_cost_price']) {

          if ($store_id) {
            $records = array_filter(Bill::where('id', $bill['id'])->get()->first()['records']->toArray(), function ($r) use ($item_id, $store_id) {
              return $r['item_id'] == $item_id && $r['store_id'] == $store_id;
            });
          } else {
            $records = array_filter(Bill::where('id', $bill['id'])->get()->first()['records']->toArray(), function ($r) use ($item_id, $store_id) {
              return $r['item_id'] == $item_id;
            });
          }

          foreach ($records as $record) {
            // Handle The Currency Mutation
            $parity = 1;

            if ($this->getDefaultCurrencyID() == $currency_id) {
              $parity = $bill['parity'];
            } else if ($currency_id != $bill['currency_id']) {
              $parity = $bill['parity'] / $this->logParity($currency_id, $bill['date']);
            }

            $totalPricesSum += $record['quantity'] * $record['unit_price'] * $parity;
            $quantitySum += ($record['quantity'] * $record['conversion_factor']) + ($record['gift'] * $record['gift_conversion_factor']);

            if ($template[0]['is_additions_affects_cost_price']) {
              $totalPricesSum += $record['item_addition'] + $record['general_addition'] * $parity;
            }

            if ($template[0]['is_discounts_affects_cost_price']) {
              $totalPricesSum -= $record['item_discount'] + $record['general_discount'] * $parity;
            }


          }

        }

      }
    }


    // Convert The Quantity Sum To The Required Unit
    $unit_conversion_factor = Item::with('units')->where('id', $item_id)->get()->toArray()[0]['units'][0]['conversion_factor'] ?? 1;

    $quantity_factor = 1 / $unit_conversion_factor;
    $quantitySum *= $quantity_factor;

    if ($totalPricesSum && $quantitySum) {
      return $totalPricesSum / $quantitySum;
    } else {
      return 0;
    }

  }


  public function getDefaultCurrencyID()
  {
    $defaultCurrency = Currency::where('is_default', true)->first();
    return $defaultCurrency->id;
  }


}
