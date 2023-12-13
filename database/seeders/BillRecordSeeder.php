<?php

namespace Database\Seeders;

use App\Models\BillRecord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillRecordSeeder extends Seeder
{

  public function run()
  {
//        $billRecord = BillRecord::create([
//            'index' => 1,
//            'total' => 321,
//            'unit_price' => 231,
//            'unit_unit_price' => 321,
//            'quantity' => 432,
//            'net' => 321,
//            'net_without_tax' => 2,
//            'category_id' => 1,
//            'item_id' => 1,
//            'cost_center_id' => 1,
//            'store_id' => 1,
//            'bill_id' => 1,
//            'item_discount' => 321,
//            'item_discount_ratio' => 321,
//            'tax' => 321,
//            'count' => 321,
//            'tax_ratio' => 12,
//            'item_addition' => 321,
//            'item_addition_ratio' => 21,
//            'is_input' => false,
//            'is_output' => false,
//
//            'current_exist_quantity' => 432,
//            'current_store_exist_quantity' => 342,
//            'unit_id' =>1,
//            'barcode' => 'barcode',
//            'production_date' => '23-3-2022',
//            'expired_date' => '23-3-2022',
//            'conversion_factor' => 2,
//            'count' => 321,
//            'final_store_quantity' => 32,
//            'final_quantity' => 32,
//            'gift' => 'g',
//            'gift_unit_id' => 'gu',
//            'last_buy' => 432,
//            'notes' => 'notes',
//
//        ]);
//
//        $billRecord = BillRecord::create([
//            'index' => 2,
//            'total' => 321,
//            'unit_price' => 231,
//            'unit_unit_price' => 321,
//            'quantity' => 432,
//            'net' => 321,
//            'net_without_tax' => 2,
//            'category_id' => 1,
//            'count' => 321,
//            'item_id' => 1,
//            'cost_center_id' => 1,
//            'store_id' => 1,
//            'bill_id' => 1,
//            'item_discount' => 321,
//            'item_discount_ratio' => 321,
//            'tax' => 321,
//            'tax_ratio' => 12,
//            'item_addition' => 321,
//            'item_addition_ratio' => 21,
//            'is_input' => false,
//            'is_output' => false,
//
//            'current_exist_quantity' => 432,
//            'current_store_exist_quantity' => 342,
//            'unit_id' => 2,
//            'barcode' => 'barcode',
//            'production_date' => '23-3-2022',
//            'expired_date' => '23-3-2022',
//            'conversion_factor' => 2,
//            'final_store_quantity' => 32,
//            'final_quantity' => 32,
//            'gift' => 'g',
//            'gift_unit_id' => 'gu',
//            'last_buy' => 432,
//            'notes' => 'notes',
//
//        ]);
//
//        $billRecord = BillRecord::create([
//            'index' => 2,
//            'total' => 321,
//            'unit_price' => 231,
//            'unit_unit_price' => 321,
//            'quantity' => 432,
//            'net' => 321,
//            'net_without_tax' => 2,
//            'category_id' => 1,
//            'item_id' => 4,
//            'cost_center_id' => 5,
//            'store_id' => 3,
//            'bill_id' => 2,
//            'item_discount' => 321,
//            'item_discount_ratio' => 321,
//            'tax' => 321,
//            'tax_ratio' => 12,
//            'item_addition' => 321,
//            'item_addition_ratio' => 21,
//            'is_input' => false,
//            'is_output' => false,
//
//            'current_store_exist_quantity' => 432,
//            'current_exist_quantity' => 342,
//            'unit_id' => 1,
//            'barcode' => 'barcode',
//            'production_date' => '23-3-2022',
//            'expired_date' => '23-3-2022',
//            'conversion_factor' => 2,
//            'final_store_quantity' => 32,
//            'final_quantity' => 32,
//            'gift' => 'g',
//            'gift_unit_id' => 'gu',
//            'last_buy' => 432,
//            'notes' => 'notes',
//
//        ]);
//
//        $billRecord = BillRecord::create([
//            'index' => 4,
//            'total' => 321,
//            'unit_price' => 231,
//            'unit_unit_price' => 321,
//            'quantity' => 432,
//            'net' => 321,
//            'net_without_tax' => 2,
//            'category_id' => 1,
//            'item_id' => 4,
//            'cost_center_id' => 1,
//            'store_id' => 1,
//            'bill_id' => 2,
//            'item_discount' => 321,
//            'item_discount_ratio' => 321,
//            'tax' => 321,
//            'tax_ratio' => 12,
//            'item_addition' => 321,
//            'item_addition_ratio' => 21,
//            'is_input' => false,
//            'is_output' => false,
//
//
//            'current_store_exist_quantity' => 432,
//            'current_exist_quantity' => 342,
//            'unit_id' => 1,
//            'barcode' => 'barcode',
//            'production_date' => '23-3-2022',
//            'expired_date' => '23-3-2022',
//            'conversion_factor' => 2,
//            'final_store_quantity' => 32,
//            'final_quantity' => 32,
//            'gift' => 'g',
//            'gift_unit_id' => 'gu',
//            'last_buy' => 432,
//            'notes' => 'notes',
//
//        ]);


//    $BillRecord1 = BillRecord::create([
//      'quantity' => 1,
//      'unit_price' => 5000,
//      'bill_id' => 1,
//      'item_id' => 1,
//      'currency_id' => 1,
//      'parity' => 1,
//      'store_id' =>1,
//      'date' =>  '2020-1-1',
//      'security_level'=> 1,
//      'storing_type' => 'IN' ,
//      'conversion_factor' =>1,
//
//    ]);
//    $BillRecord2 = BillRecord::create([
//      'quantity' => 1,
//      'unit_price' => 5000,
//      'bill_id' => 2,
//      'item_id' => 1,
//      'currency_id' => 1,
//      'parity' => 1,
//      'store_id' =>1,
//      'date' =>  '2020-1-2',
//      'security_level'=> 1,
//      'storing_type' => 'IN' ,
//      'conversion_factor' =>1,
//    ]);
//    $BillRecord3 = BillRecord::create([
//      'quantity' => 1,
//      'unit_price' => 5,
//      'bill_id' => 3,
//      'item_id' => 1,
//      'store_id' =>1,
//      'currency_id' => 2,
//      'parity' => 7000,
//      'date' =>  '2020-1-3',
//      'security_level'=> 1,
//      'storing_type' => 'IN' ,
//      'conversion_factor' =>1,
//    ]);
//    $BillRecord4 = BillRecord::create([
//      'quantity' => 1,
//      'unit_price' => 10000,
//      'bill_id' => 4,
//      'item_id' => 1,
//      'currency_id' => 1,
//      'store_id' =>1,
//      'parity' => 1,
//      'date' =>  '2020-1-3',
//      'security_level'=> 1,
//      'storing_type' => 'IN' ,
//      'conversion_factor' =>1,
//    ]);
//    $BillRecord5 = BillRecord::create([
//      'quantity' => 1,
//      'unit_price' => 10,
//      'bill_id' => 9,
//      'item_id' => 1,
//      'store_id' =>1,
//      'currency_id' => 2,
//      'parity' => 10000,
//      'date' =>  '2020-1-4',
//      'security_level'=> 3,
//      'storing_type' => 'IN' ,
//      'conversion_factor' =>1,
//    ]);
//    $BillRecord6 = BillRecord::create([
//      'quantity' => 1,
//      'unit_price' => 10,
//      'bill_id' => 9,
//      'item_id' => 1,
//      'currency_id' => 2,
//      'store_id' =>1,
//      'parity' => 12000,
//      'date' =>  '2020-1-5',
//      'security_level'=> 3,
//      'storing_type' => 'IN' ,
//      'conversion_factor' =>1,
//    ]);
//    $BillRecord7 = BillRecord::create([
//      'quantity' => 1,
//      'unit_price' => 55,
//      'bill_id' => 9,
//      'item_id' => 1,
//      'currency_id' => 2,
//      'store_id' =>1,
//      'parity' => 13000,
//      'date' =>  '2020-1-6',
//      'security_level'=> 3,
//      'storing_type' => 'IN' ,
//      'conversion_factor' =>1,
//    ]);
//
//    $BillRecord8 = BillRecord::create([
//      'quantity' => 1,
//      'unit_price' => 110,
//      'bill_id' => 4,
//      'item_id' => 1,
//      'currency_id' => 2,
//      'store_id' =>1,
//      'parity' => 12000,
//      'date' =>  '2020-1-8',
//
//      'security_level'=> 3,
//      'storing_type' => 'IN' ,
//      'conversion_factor' =>1,
//    ]);
//    $BillRecord9 = BillRecord::create([
//      'quantity' => 1,
//      'unit_price' => 7,
//      'bill_id' => 3,
//      'item_id' => 1,
//      'conversion_factor' =>1,
//      'store_id' =>1,
//      'currency_id' => 3,
//      'parity' => 10000,
//      'date' =>  '2020-1-9',
//      'security_level'=> 3,
//      'storing_type' => 'IN' ,
//    ]);

      BillRecord::truncate();
      BillRecord::factory(20000)->create();
  }
}
