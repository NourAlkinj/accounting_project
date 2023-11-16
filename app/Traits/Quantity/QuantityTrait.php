<?php

namespace App\Traits\Quantity;

use App\Models\Quantity;
use Illuminate\Support\Facades\DB;

trait  QuantityTrait
{

  private function addOnStore(int $input_store_id, int $item_id, int $quantity, int $gift_quantity, int $conversion_factor, int $gift_conversion_factor): void
  {
    $gift_quantity *= $gift_conversion_factor;
    $quantity *= $conversion_factor;
    $total_quantity = $gift_quantity + $quantity;

    DB::table('quantities')->where('store_id', $input_store_id)->where('item_id', $item_id)->increment('quantity', $total_quantity);
  }

  private function removeFromStore(int $store_id, int $item_id, int $quantity, int $gift_quantity, int $conversion_factor, int $gift_conversion_factor): void
  {
    $gift_quantity *= $gift_conversion_factor;
    $quantity *= $conversion_factor;
    $total_quantity = $gift_quantity + $quantity;

    DB::table('quantities')->where('store_id', $store_id)->where('item_id', $item_id)->decrement('quantity', $total_quantity);
  }

  public function applyBillAffect($records, string $storing_type)
  {

    switch ($storing_type) {
      case 'IN':
        foreach ($records as $record) {
          if (!DB::table('quantities')->where('store_id', $record['store_id'])->where('item_id', $record['item_id'])->exists()) {
            Quantity::create($record);
          } else {
            $this->addOnStore($record['store_id'], $record['item_id'], $record['quantity'], $record['gift'], $record['conversion_factor'], $record['gift_conversion_factor']);
            break;
          }
        }
        break;
      case 'OUT':
        foreach ($records as $record) {
          if (!DB::table('quantities')->where('store_id', $record['store_id'])->where('item_id', $record['item_id'])->exists()) {
            $record['quantity'] = -(int)$record['quantity'];
            Quantity::create($record);
          } else {
            $this->removeFromStore($record['store_id'], $record['item_id'], $record['quantity'], $record['gift'], $record['conversion_factor'], $record['gift_conversion_factor']);
            break;
          }
        }
        break;
      case 'EXCHANGE':
        foreach ($records as $record) {
          if (!DB::table('quantities')->where('store_id', $record['store_id'])->where('item_id', $record['item_id'])->exists()) {
            $quantity = new Quantity;
            $quantity->store_id = $record['store_id'];
            $quantity->item_id = $record['item_id'];
            $quantity->quantity = -$record['quantity'];
            $quantity->save();
          } else {
            $this->addOnStore($record['store_id'], $record['item_id'], $record['quantity'], $record['gift'], $record['conversion_factor'], $record['gift_conversion_factor']);
          }
          if (!DB::table('quantities')->where('store_id', $record['input_store_id'])->where('item_id', $record['item_id'])->exists()) {
            $quantity = new Quantity;
            $quantity->store_id = $record['input_store_id'];
            $quantity->item_id = $record['item_id'];
            $quantity->quantity = $record['quantity'];
            $quantity->save();
          } else {
            $this->removeFromStore($record['input_store_id'], $record['item_id'], $record['quantity'], $record['gift'], $record['conversion_factor'], $record['gift_conversion_factor']);
          }
        }
        break;
    }
  }

  public function reverseBillAffect($records, string $storing_type)
  {
    switch ($storing_type) {
      case 'IN':
        foreach ($records as $record) {
          if (!DB::table('quantities')->where('store_id', $record['store_id'])->where('item_id', $record['item_id'])->exists()) {
            Quantity::create($record);
          } else {
            $this->removeFromStore($record['store_id'], $record['item_id'], $record['quantity'], $record['gift'], $record['conversion_factor'], $record['gift_conversion_factor']);
            break;
          }
        }
        break;
      case 'OUT':
        foreach ($records as $record) {
          if (!DB::table('quantities')->where('store_id', $record['store_id'])->where('item_id', $record['item_id'])->exists()) {
            Quantity::create($record);
          } else {
            $this->addOnStore($record['store_id'], $record['item_id'], $record['quantity'], $record['gift'], $record['conversion_factor'], $record['gift_conversion_factor']);
            break;
          }
        }
        break;
      case 'EXCHANGE':
        foreach ($records as $record) {
          if (!DB::table('quantities')->where('input_store_id', $record['input_store_id'])->where('item_id', $record['item_id'])->exists()) {
            $quantity = new Quantity;
            $quantity->store_id = $record['input_store_id'];
            $quantity->item_id = $record['item_id'];
            $quantity->quantity = -$record['quantity'];
            $quantity->save();
          } else {
            $this->removeFromStore($record['input_store_id'], $record['item_id'], $record['quantity'], $record['gift'], $record['conversion_factor'], $record['gift_conversion_factor']);
          }
          if (!DB::table('quantities')->where('store_id', $record['store_id'])->where('item_id', $record['item_id'])->exists()) {
            $quantity = new Quantity;
            $quantity->store_id = $record['store_id'];
            $quantity->item_id = $record['item_id'];
            $quantity->quantity = $record['quantity'];
            $quantity->save();
          } else {
            $this->addOnStore($record['store_id'], $record['item_id'], $record['quantity'], $record['gift'], $record['conversion_factor'], $record['gift_conversion_factor']);
          }
        }
        break;
    }
  }

//  private function transferBetweenStores(int $store_id, int $input_store_id, int $item_id, int $quantity, int $conversion_factor): void
//  {
//    $this->removeFromStore($store_id, $item_id, $quantity, $conversion_factor);
//    $this->addOnStore($input_store_id, $item_id, $quantity, $conversion_factor);
//  }
//
//  public function transaction(int $store_id, int $input_store_id, $records)
//  {
//    foreach ($records as $record) {
//      $this->transferBetweenStores($store_id, $input_store_id, $record['item_id'], $record['quantity'], $record['conversion_factor']);
//    }
//  }
}
