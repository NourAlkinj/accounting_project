<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'abbreviation',
        'name',
        'is_active',
        'bill_type', //sales=0,purchases=1,sales_retuen=2,purchasing_return=3,exchange=4,output_store=5,input_store=6,beginning_inventory=7
        'foreign_name',

        //tab1
        //Default account
        'items_account_id',
        'is_items_account_lock',
        'is_items_account_show',
        'discount_account_id',
//        'is_discount_account_lock',
//        'is_discount_account_show',
        'addition_account_id',
//        'is_addition_account_lock',
//        'is_addition_account_show',
        'cash_account_id',
        'is_cash_account_lock',
        'is_cash_account_show',
        'tax_account_id',
//        'is_tax_account_lock',
//        'is_tax_account_show',
        'cost_account_id',
//        'is_cost_account_lock',
//        'is_cost_account_show',
        'stock_account_id',
//        'is_stock_account_lock',
//        'is_stock_account_show',
        'gifts_account_id',
        'gifts_contra_account_id',


        /////input Default account
        'input_items_account_id',
        'is_input_items_account_lock',
        'is_input_items_account_show',
        'input_discount_account_id',
//        'is_input_discount_account_lock',
//        'is_input_discount_account_show',
        'input_addition_account_id',
//        'is_input_addition_account_lock',
//        'is_input_addition_account_show',
        'input_cash_account_id',
        'is_input_cash_account_lock',
        'is_input_cash_account_show',
        'input_tax_account_id',
//        'is_input_tax_account_lock',
//        'is_input_tax_account_show',
        'input_cost_account_id',
//        'is_input_cost_account_lock',
//        'is_input_cost_account_show',
        'input_stock_account_id',
//        'is_input_stock_account_lock',
//        'is_input_stock_account_show',
        'input_gifts_account_id',
        'input_gifts_contra_account_id',

        //conditions generatedEntry
        'is_generate_entry',
        'is_auto_posting_to_accounts',
        //conditions inventorySystem
        'is_perpetual_inventory',
        'is_consider_gifts_from_sales',
        //conditions effectOnPrice
        'is_affects_cost_price',
        'is_discounts_affects_cost_price',
        'is_additions_affects_cost_price',
        //conditions storeOptions
        'is_auto_posting_to_stores',
        //conditions taxes
        'is_use_VAT_system',
        'is_use_TTC_system',
        'is_use_sales_tax',
        'is_calculate_before_discounts',
        'is_calculate_before_additions',
        'is_apply_taxes_on_gifts',
        'is_consider_TTC_differences_as_sales_or_purchases',
        //conditions generalDiscountsAndAdditions
        'is_general_discount_is_affected_by_total_items',
        'is_general_addition_is_affected_by_total_items',
        'is_client_discount',
        'is_item_discount',
      //conditionExchangeOptions
        'is_addtions_affect_output',
        'is_additions_affect_input',
        'is_discounts_affect_output',
        'is_discounts_affect_input',
        'is_affects_item_profits_and_losses',
        'is_discount_affect_profits_and_losses',
        'is_addition_affect_profits_and_losses',


        //tab2
        //field Options
        'bill_price_id',
        'is_bill_price_lock',
        'is_bill_price_show',
        'cost_price_id',
        'is_cost_price_lock',
        'is_cost_price_show',
        'gifts_price_id',
        'branch_id',
        'is_branch_show',
        'cost_center_id',
        'is_cost_center_lock',
        'is_cost_center_show',
        'currency_id',
        'is_currency_lock',
        'is_currency_show',
        'return_bill_id',
        'date',
        'is_date_lock',
        'is_date_show',
        'time',
        'is_time_show',
        'payment_type', //cash=0 ,on_credit=1
        'is_payment_type_lock',
        'is_payment_type_show',
        'is_receipt_number_show',
        'client_id',
        'is_client_lock',
        'is_client_show',
        'store_id',
        'is_store_lock',
        'is_store_show',
        'input_store_id',
        'is_input_store_lock',
        'is_input_store_show',

        //conditionEnforceOptions
        'is_client',
        'is_cost_center',
        'is_fix_purchases_bill',
        'is_receipt_number',
        'is_fix_sales_invoice',


        //        //conditionReferencesOptions
        //        'is_whenCreatingAReturnedSales',
        //        'is_whenCreatingAReturnedPurChase',


        //tab3
        //conditionWarnings
        'is_negative_output',
        'is_sale_less_than_cost_price',
        'is_changing_store',
        'is_changing_price',
        'is_client_has_discount',
        'is_item_is_expired',
        'is_item_has_discount',
        //conditionOtherPropertion
        'is_use_payment_terms',
        'is_print_duplicated_copy',

        //tab4
        //rounding
        'is_use_rounding',
        'round_type', //up=0,down=1,round=2
        'value',
        'rounding_on_type', //none=0,bill_value=1,item_value=2,both=3
        'rounding_account',

        'is_sales',
        'is_purchases',
        'is_sales_return',
        'is_purchasing_return',
        'is_exchange',
        'is_output_store',
        'is_input_store',
        'is_beginning_inventory',
        'is_cash',
        'is_on_credit',
        'is_up',
        'is_down',
        'is_round',
        'is_none',
        'is_bill_value',
        'is_item_value',
        'is_both',

    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function bills()
    {
        return $this->hasMany(Bill::class, 'bill_template_id');
    }

    protected $casts = [
        'is_active' => 'boolean',
        'is_items_account_lock' => 'boolean',
        'is_items_account_show' => 'boolean',
        'is_discount_account_lock' => 'boolean',
        'is_discount_account_show' => 'boolean',
        'is_addition_account_lock' => 'boolean',
        'is_addition_account_show' => 'boolean',
        'is_cash_account_lock' => 'boolean',
        'is_cash_account_show' => 'boolean',
        'is_tax_account_lock' => 'boolean',
        'is_tax_account_show' => 'boolean',
        'is_cost_account_lock' => 'boolean',
        'is_cost_account_show' => 'boolean',
        'is_stock_account_lock' => 'boolean',
        'is_stock_account_show' => 'boolean',
        'is_input_items_account_lock' => 'boolean',
        'is_input_items_account_show' => 'boolean',
        'is_input_discount_account_lock' => 'boolean',
        'is_input_discount_account_show' => 'boolean',
        'is_input_addition_account_lock' => 'boolean',
        'is_input_addition_account_show' => 'boolean',
        'is_input_cash_account_lock' => 'boolean',
        'is_input_cash_account_show' => 'boolean',
        'is_input_tax_account_lock' => 'boolean',
        'is_input_tax_account_show' => 'boolean',
        'is_input_cost_account_lock' => 'boolean',
        'is_input_cost_account_show' => 'boolean',
        'is_input_stock_account_lock' => 'boolean',
        'is_input_stock_account_show' => 'boolean',
        'is_generate_entry' => 'boolean',
        'is_auto_posting_to_accounts' => 'boolean',
        'is_perpetual_inventory' => 'boolean',
        'is_consider_gifts_from_sales' => 'boolean',
        'is_affects_cost_price' => 'boolean',
        'is_discounts_affects_cost_price' => 'boolean',
        'is_additions_affects_cost_price' => 'boolean',
        'is_auto_posting_to_stores' => 'boolean',
        'is_use_VAT_system' => 'boolean',
        'is_use_TTC_system' => 'boolean',
        'is_use_sales_tax' => 'boolean',
        'is_calculate_before_discounts' => 'boolean',
        'is_calculate_before_additions' => 'boolean',
        'is_apply_taxes_on_gifts' => 'boolean',
        'is_consider_TTC_differences_as_sales_or_purchases' => 'boolean',
        'is_general_discount_is_affected_by_total_items' => 'boolean',
        'is_general_addition_is_affected_by_total_items' => 'boolean',
        'is_client_discount' => 'boolean',
        'is_addtions_affect_output' => 'boolean',
        'is_additions_affect_input' => 'boolean',
        'is_discounts_affect_output' => 'boolean',
        'is_discounts_affect_input' => 'boolean',
        'is_bill_price_lock' => 'boolean',
        'is_bill_price_show' => 'boolean',
        'is_cost_price_lock' => 'boolean',
        'is_cost_price_show' => 'boolean',
        'is_branch_show' => 'boolean',
        'is_cost_center_lock' => 'boolean',
        'is_cost_center_show' => 'boolean',
        'is_currency_lock' => 'boolean',
        'is_currency_show' => 'boolean',
        'is_date_lock' => 'boolean',
        'is_date_show' => 'boolean',
        'is_time_show' => 'boolean',
        'is_payment_type_lock' => 'boolean',
        'is_payment_type_show' => 'boolean',
        'is_receipt_number_show' => 'boolean',
        'is_client_lock' => 'boolean',
        'is_client_show' => 'boolean',
        'is_store_lock' => 'boolean',
        'is_store_show' => 'boolean',
        'is_input_store_lock' => 'boolean',
        'is_input_store_show' => 'boolean',
        'is_client' => 'boolean',
        'is_cost_center' => 'boolean',
        'is_fix_purchases_bill' => 'boolean',
        'is_receipt_number' => 'boolean',
        'is_fix_sales_invoice' => 'boolean',
        'is_negative_output' => 'boolean',
        'is_sale_less_than_cost_price' => 'boolean',
        'is_changing_store' => 'boolean',
        'is_changing_price' => 'boolean',
        'is_client_has_discount' => 'boolean',
        'is_item_is_expired' => 'boolean',
        'is_item_has_discount' => 'boolean',
        'is_use_payment_terms' => 'boolean',
        'is_print_duplicated_copy' => 'boolean',
        'is_use_rounding' => 'boolean',
        'is_sales' => 'boolean',
        'is_purchases' => 'boolean',
        'is_sales_return' => 'boolean',
        'is_purchasing_return' => 'boolean',
        'is_exchange' => 'boolean',
        'is_output_store' => 'boolean',
        'is_input_store' => 'boolean',
        'is_beginning_inventory' => 'boolean',
        'is_cash' => 'boolean',
        'is_on_credit' => 'boolean',
        'is_up' => 'boolean',
        'is_down' => 'boolean',
        'is_round' => 'boolean',
        'is_none' => 'boolean',
        'is_bill_value' => 'boolean',
        'is_item_value' => 'boolean',
        'is_both' => 'boolean',
    ];



    public function billTemplatePermissionUser()
    {
        return $this->hasMany(BillTemplatePermissionUser::class, 'bill_template_id');
    }
}
