<?php
namespace App\Traits\Bill;

use App\Models\Bill;
use App\Models\BillTemplate;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Unit;
use App\Traits\Currency\CurrencyTrait;
use App\Traits\Quantity\QuantityTrait;

trait  CostTrait
{
//  use QuantityTrait;

  use CurrencyTrait;

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
      if($template) {

        // Pass The Bill That does not Affect On The Cost
        if($template[0]['is_affects_cost_price']) {

          if($store_id) {
            $records = array_filter(Bill::where('id', $bill['id'])->get()->first()['records']->toArray(), function($r) use ($item_id, $store_id) {
              return $r['item_id'] == $item_id && $r['store_id'] == $store_id;
            });
          } else {
            $records = array_filter(Bill::where('id', $bill['id'])->get()->first()['records']->toArray(), function($r) use ($item_id, $store_id) {
              return $r['item_id'] == $item_id;
            });
          }

          foreach ($records as $record) {
            // Handle The Currency Mutation
            $parity = 1;

            if ($this->getDefaultCurrencyID() == $currency_id) {
              $parity = $bill['parity'];
            } else if($currency_id != $bill['currency_id']) {
              $parity = $bill['parity'] / $this->logParity($currency_id, $bill['date']);
            }

            $totalPricesSum += $record['quantity'] * $record['unit_price'] * $parity;
            $quantitySum += ($record['quantity'] * $record['conversion_factor']) + ($record['gift'] * $record['gift_conversion_factor']);

            if($template[0]['is_additions_affects_cost_price']) {
              $totalPricesSum += $record['item_addition'] + $record['general_addition'] * $parity;
            }

            if($template[0]['is_discounts_affects_cost_price']) {
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

    if($totalPricesSum && $quantitySum) {
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

};
