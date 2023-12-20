<?php

namespace Database\Seeders;

use App\Models\Bill;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{

  public function run()
  {
//        $bill1 = Bill::create([
//            'date' =>  '4-4-2020',
//            'time' => '',
//            'receipt_number' => 1,
//            'currency_id' => 1,
//            'account_id' => 1,
//            'parity' => 1,
//            'security_level' => 'high',
//            'client_id' => 1,
//            'bill_price_id' => 3,
//            'branch_id' => 1,
//            'cost_center_id' => 1,
//            'store_id' => 1,
//            'bill_template_id' => 2,
//            'discount_value' => 32.2,
//            'addition_value' => 11.1,
//            'best_choice_for_addition_discount' => 32.2,
//            'notes' => 'notes',
//            'bill_value' => 44.4,
//            'first_pay' => '22.2',
//            'first_pay_rest' => 22,
//            'is_input' => false,
//            'is_output' => false,
//            'total_items' => 55,
//            'total_item_addition' => 23,
//            'total_item_discount' => 432,
//            'total_items_net' => 23,
//            'items_account_id' => 1,
//            'cash_account_id' => 2,
//            'payment_type' => 6.7
//
//        ]);
//        $bill2 = Bill::create([
//            'date' =>  '4-4-2020',
//            'time' => '',
//            'receipt_number' => 3,
//            'currency_id' => 1,
//            'account_id' => 2,
//            'parity' => 1,
//            'security_level' => 'high',
//            'client_id' => 1,
//            'bill_price_id' => 1,
//            'branch_id' => 2,
//            'cost_center_id' => 3,
//            'store_id' => 1,
//            'bill_template_id' => 1,
//            'discount_value' => 32.2,
//            'addition_value' => 11.1,
//            'best_choice_for_addition_discount' => 323,
//            'notes' => '/notes',
//            'bill_value' => 44.4,
//            'first_pay' => '22.2',
//            'first_pay_rest' => 22,
//            'is_input' => false,
//            'is_output' => false,
//            'total_items' => 55,
//            'total_item_addition' => 23,
//            'total_item_discount' => 432,
//            'total_items_net' => 23,
//            'items_account_id' => 1,
//            'cash_account_id' => 2,
//            'payment_type' => 6.7
//        ]);
//
//        $bill3 = Bill::create([
//            'date' =>  '4-4-2020',
//            'time' => '',
//            'receipt_number' => 3,
//            'currency_id' => 1,
//            'account_id' => 2,
//            'parity' => 1,
//            'security_level' => 'high',
//            'client_id' => 1,
//            'bill_price_id' => 1,
//            'branch_id' => 2,
//            'cost_center_id' => 3,
//            'store_id' => 1,
//            'bill_template_id' => 2,
//            'discount_value' => 32.2,
//            'addition_value' => 11.1,
//            'best_choice_for_addition_discount' => 323,
//            'notes' => '/notes',
//            'bill_value' => 44.4,
//            'first_pay' => '22.2',
//            'first_pay_rest' => 22,
//            'is_input' => false,
//            'is_output' => false,
//            'total_items' => 55,
//            'total_item_addition' => 23,
//            'total_item_discount' => 432,
//            'total_items_net' => 23,
//            'items_account_id' => 1,
//            'cash_account_id' => 2,
//            'payment_type' => 6.7
//        ]);
//        $bill4 = Bill::create([
//            'date' =>  '4-4-2020',
//            'time' => '',
//            'receipt_number' => 3,
//            'currency_id' => 1,
//            'account_id' => 2,
//            'parity' => 1,
//            'security_level' => 'high',
//            'client_id' => 3,
//            'bill_price_id' => 1,
//            'branch_id' => 4,
//            'cost_center_id' => 2,
//            'store_id' => 1,
//            'bill_template_id' => 1,
//            'discount_value' => 32.2,
//            'addition_value' => 11.1,
//            'best_choice_for_addition_discount' => 323,
//            'notes' => '/notes',
//            'bill_value' => 44.4,
//            'first_pay' => '22.2',
//            'first_pay_rest' => 22,
//            'is_input' => false,
//            'is_output' => false,
//            'total_items' => 55,
//            'total_item_addition' => 23,
//            'total_item_discount' => 432,
//            'total_items_net' => 23,
//            'items_account_id' => 1,
//            'cash_account_id' => 2,
//            'payment_type' => 6.7
//        ]);


    $Bill1 = Bill::create([
      'storing_type' => 'IN',
      'bill_type' => 'in',
      'currency_id' => 1,
      'parity' => 1,
      'date' => '2020-1-1',
      'security_level' => 1,


    ]);
    $Bill2 = Bill::create([
      'currency_id' => 1,
      'parity' => 1,
      'date' => '2020-1-2',
      'storing_type' => 'IN',
      'bill_type' => 'in',
      'security_level' => 1,


    ]);
    $Bill3 = Bill::create([
      'storing_type' => 'IN',
      'bill_type' => 'in',
      'currency_id' => 2,
      'parity' => '7000',
      'date' => '2020-1-3',
      'security_level' => 1,


    ]);
    $Bill4 = Bill::create([
      'storing_type' => 'IN',
      'bill_type' => 'in',
      'currency_id' => 1,
      'parity' => '1',
      'date' => '2020-1-3',

      'security_level' => 1,
    ]);
    $Bill5 = Bill::create([
      'currency_id' => 2,
      'storing_type' => 'IN',
      'bill_type' => 'in',
      'parity' => '10000',
      'date' => '2020-1-4',
      'security_level' => 3,

    ]);
    $Bill6 = Bill::create([
      'currency_id' => 2,
      'parity' => '12000',
      'storing_type' => 'IN',
      'bill_type' => 'in',
      'date' => '2020-1-5',
      'security_level' => 3,

    ]);
    $Bill7 = Bill::create([
      'currency_id' => 2,
      'parity' => '13000',
      'storing_type' => 'IN',
      'bill_type' => 'in',
      'date' => '2020-1-6',
      'security_level' => 3,

    ]);
    $Bill8 = Bill::create([
      'currency_id' => 2,
      'storing_type' => 'IN',
      'bill_type' => 'in',
      'parity' => '13000',
      'date' => '2020-1-7',
      'security_level' => 3,

    ]);

    $Bill9 = Bill::create([
      'currency_id' => 3,
      'storing_type' => 'IN',
      'bill_type' => 'in',
      'parity' => '10000',
      'date' => '2020-1-9',
      'security_level' => 3,

    ]);

//      Bill::truncate();
//      Bill::factory(10000)->create();
  }
}
