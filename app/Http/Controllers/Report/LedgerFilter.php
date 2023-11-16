<?php

namespace App\Http\Controllers\Report;

use App\Models\JournalEntryRecord;
use App\Http\Controllers\Report\Interfaces\LedgerFilters;

class LedgerFilter {

    public function __construct(public LedgerFilters $filters) {}

    public function sources_filter(array $res = []): array {
      if(sizeof($this->filters->sources) < 1) return $res;
      foreach($this->filters->sources as $source) {
          $res = array_filter($res, function($record) use($source) {
              return $record['source_name'] == $source["source_name"] &&  $record['source_id'] == $source["source_id"];
          });
      }
      return $res;
    }

    public function date_range_filter(array $res = []): array {
      if($this->filters->created_between['from']){
        $res = array_filter($res, function($record) {
          dd($record['date'], $this->filters->created_between, $record['date'] == $this->filters->created_between['to']);
          return $record['date'] > $this->filters->created_between['from'] &&  $record['date'] < $this->filters->created_between['to'];
        });
      }
      return $res;
    }

    public function account_filter(array $res = []): array {
      $res = $this->filters->account_id ? JournalEntryRecord::where('account_id', $this->filters->account_id)->get()->toArray() : $res;
      return $res;
    }

    public function previous_date_filter($res): array {
      $res = array_filter($res, function($record) {
          return $record['date'] < $this->filters->created_between['from'];
      });
      return $res;
    }

    public function after_date_filter(array $res = []): array {
      $res = array_filter($res, function($record) {
          return $record['date'] > $this->filters->created_between['to'];
      });
      return $res;
    }

    public function cost_center_filter($res): array  {
      $res = array_filter($res, function($record) {
        return $record['cost_center_id'] == $this->filters->cost_center_id;
      });
      return $res;
    }

    public function branch_filter($res): array  {
      $res = array_filter($res, function($record) {
        return $record['branch_id'] == $this->filters->branch_id;
      });
      return $res;
    }

    public function user_filter($res): array  {
      $res = array_filter($res, function($record) {
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

    public function category_filter($res): array  {
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
        return $record['asset_id'] ==  $this->filters->asset_id;  
      });
      return $res;
    }
    
    public function not_contains_filter($res) {
      $res = array_filter($res, function($record) {
        return !str_contains($record['notes'], $this->filters->contains);  
      });
      return $res;
    }
    
    public function contains_filter($res) {
      $res = array_filter($res, function($record) {
        return str_contains($record['notes'], $this->filters->contains);  
      });
      return $res;
    }

    public function posted_date_range_filter($res): array {
      if($this->filters->posted_between['from']) {
        $res = array_filter($res, function($record) {
            return $record['post_to_account_date'] > $this->filters->posted_between['from'] &&  $record['post_to_account_date'] < $this->filters->posted_between['to'];
        });
      }
      return $res;
    }

    public function not_posted_date_range_filter($res): array {
      if($this->filters->posted_between['from']) {
        $res = array_filter($res, function($record) {
            if(!$record['is_post_to_account']) {
              return $record['date'] > $this->filters->posted_between['from'] &&  $record['date'] < $this->filters->posted_between['to'];
            }
        });
      }
      return $res;
    }

}
