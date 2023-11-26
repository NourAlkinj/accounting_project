<?php

namespace App\Http\Controllers\Report;

use App\Models\JournalEntryRecord;
use App\Http\Controllers\Report\Interfaces\LedgerFilters;

class LedgerFilter {

    public function __construct(public LedgerFilters $filters) {}

    public function sources_filter($res): array {
        if (empty($this->filters->sources)) return $res;
           $filteredRecords = array_filter($res, function ($record) {
            foreach ($this->filters->sources as $source) {
                if ($record['source_name'] == $source["source_name"] && $record['source_id'] == $source["source_id"]) {
                    return true;
                }
            }
            return false;
        });

        return $filteredRecords;
    }
    public function date_range_filter($res): array {
        $created_between_from = date('Y-m-d', strtotime($this->filters->created_between['from']));
        $created_between_to = date('Y-m-d', strtotime($this->filters->created_between['to']));

        $res = array_filter($res, function($record) use ($created_between_from,$created_between_to) {
            return  date('Y-m-d', strtotime($record['date'])) > $created_between_from &&  date('Y-m-d', strtotime($record['date'])) <$created_between_to;
        });
        return $res;
    }

    public function account_filter($res): array {
        $res =JournalEntryRecord::where('account_id', $this->filters->account_id)->get()->toArray();
        return $res;
    }

    public function previous_date_filter($res): array {
    $created_between_from = date('Y-m-d', strtotime($this->filters->created_between['from']));

    $res = array_filter($res, function($record) use($created_between_from){
            return  date('Y-m-d', strtotime($record['date'])) < $created_between_from;
        });
        return $res;
    }

    public function after_date_filter($res): array {
    $created_between_to = date('Y-m-d', strtotime($this->filters->created_between['to']));

    $res = array_filter($res, function($record)use($created_between_to) {
            return date('Y-m-d', strtotime($record['date']))  > $created_between_to;
        });
        return $res;
    }

    public function cost_center_filter($res): array  {
        $res =  array_filter($res, function($record) {
            return $record['cost_center_id'] == $this->filters->cost_center_id;
        }) ;
        return $res;
    }

    public function branch_filter($res): array  {
        $res =  array_filter($res, function($record) {
            return $record['branch_id'] == $this->filters->branch_id;
        });
        return $res;
    }

    public function user_filter($res): array {
        $res =array_filter($res, function($record) {
            return $record['user_id'] == $this->filters->user_id;
        });
        return $res;
    }

    public function client_filter($res): array  {
        $res = array_filter($res, function($record) {
            return $record['client_id'] == $this->filters->client_id;
        });
        return $res;
    }

    public function contra_account_filter($res): array  {
        $res = array_filter($res, function($record) {
            return $record['contra_account_id'] == $this->filters->contra_account_id;
        });
        return $res;
    }

    public function category_filter($res): array {
        $res = array_filter($res, function($record) {
            return $record['category_id'] == $this->filters->category_id;
        });
        return $res;
    }

    public function employee_filter($res): array {
        $res = array_filter($res, function($record) {
            return $record['employee_id'] == $this->filters->employee_id;
        });
        return $res;
    }

    public function item_filter($res): array {
        $res = array_filter($res, function($record) {
            return $record['item_id'] == $this->filters->item_id;
        });
        return $res;
    }

    public function asset_filter($res): array {
        $res = array_filter($res, function($record) {
            return $record['asset_id'] == $this->filters->asset_id;
        });
        return $res;
    }

    public function contains_filter($res): array  {
        $res = array_filter($res, function($record) {
            return str_contains($record['notes'], $this->filters->contains);
        });
        return $res;
    }

    public function not_contains_filter($res): array  {
        $res = array_filter($res, function($record) {
            return !str_contains($record['notes'],$this->filters->not_contains);
        });
        return $res;
    }
    public function posted_date_range_filter($res): array  {
    $posted_between_from = date('Y-m-d', strtotime($this->filters->posted_between['from']));
    $posted_between_to = date('Y-m-d', strtotime($this->filters->posted_between['to']));

    $res = array_filter($res, function($record) use($posted_between_from,$posted_between_to){
            return date('Y-m-d', strtotime($record['post_to_account_date'])) > $posted_between_from &&  date('Y-m-d', strtotime($record['post_to_account_date'])) < $posted_between_to;
        });
        return $res;
    }

    public function not_posted_date_range_filter($res): array  {
    $posted_between_from = date('Y-m-d', strtotime($this->filters->posted_between['from']));
    $posted_between_to = date('Y-m-d', strtotime($this->filters->posted_between['to']));

    $res = array_filter($res, function($record)use($posted_between_from,$posted_between_to) {
        if(!$record['is_post_to_account']) {
            return date('Y-m-d', strtotime($record['date'])) > $posted_between_from && date('Y-m-d', strtotime($record['date'])) < $posted_between_to ;
        }
    });
    return $res;
    }

    public function debit_only_filter($res): array  {
        $res = array_filter($res, function($record) {
            return $record['debit'] > 0;
        });
        return $res;
    }
    public function credit_only_filter($res): array  {
        $res = array_filter($res, function($record) {
            return $record['credit'] > 0;
        });
        return $res;
    }
    public function all_filter($res): array  {
        $res = array_filter($res, function($record) {
            return ($record['credit'] > 0 || $record['debit'] > 0);
        });
        return $res;
    }
    public function is_post_to_account_filter($res): array  {
        $res = array_filter($res, function($record) {
            return $record['is_post_to_account'];
        });
        return $res;
    }
    public function is_not_post_to_account_filter($res): array  {
        $res = array_filter($res, function($record) {
            return !($record['is_post_to_account']);
        });
        return $res;
    }





}
