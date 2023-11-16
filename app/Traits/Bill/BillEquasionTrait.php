<?php
namespace App\Traits\Bill;

trait BillEquasionTrait
{
    
    public function calulateAdditionRatio($bill, $template): int {

        if($template->is_general_addition_is_affected_by_total_items) {
            return $bill->total_items ? $bill->addition_value / $bill->total_items : 0;
        } else {
            return $bill->total_items_net ? $bill->addition_value / $bill->total_items_net: 0;
        }
    
    }
    
    public function calulateDiscountRatio($bill, $template): int {

        if($template->is_general_discount_is_affected_by_total_items) {
            return $bill->total_items? $bill->discount_value / $bill->total_items : 0;
        } else {
            return $bill->total_items_net ? $bill->discount_value / $bill->total_items_net : 0 ;
        }

    }

    public function applyGeneralAdditionAndDiscountsOnRecords($bill, $records, $template): array {
        // Calculate General Discount On Records
        $general_discount_ratio = $this->calulateDiscountRatio($bill, $template);
        // Calculate General Addition On Records
        $general_addition_ratio = $this->calulateAdditionRatio($bill, $template);

        $records = array_map( function ($r) use($bill, $template, $general_addition_ratio, $general_discount_ratio) {
            $r['bill_id'] = $bill->id;

            $r['currency_id'] = $bill['currency_id'];
            $r['date'] = $bill['currency_id'];
            $r['parity'] = $bill['currency_id'];
            $r['security_level'] = $bill['security_level'];
            $r['storing_type'] = $bill['storing_type'];

            if($template->is_general_discount_is_affected_by_total_items) {
                $r['general_discount'] = $general_discount_ratio * $r['total'];
            } else {
                $r['general_discount'] = $general_discount_ratio * $r['net_without_tax'];
            }

            if($template->is_general_addition_is_affected_by_total_items) {
                $r['general_addition'] = $general_addition_ratio * $r['total'];
            } else {
                $r['general_addition'] = $general_addition_ratio * $r['net_without_tax'];
            }

            return $r;
        }, $records);

        return $records;

    }

};
