<?php
namespace App\Traits\Report;

use App\Models\JournalEntryRecord;

use function PHPUnit\Framework\stringContains;

class LedgerFilter {

    public function __construct(
        public $sources = [
            ["source_name" => null, "source_id" => null]
        ],
        public $account_id = null,
        public $cost_center_id = null,
        public $branch_id = null,
        public $user_id = null,
        public $contra_account_id = null,
        public $client_id = null,
        public $employee_id = null,
        public $asset_id = null,
        public $category_id = null,
        public $item_id = null,
        public $contains = null,
        public $not_contains = null,
        public $checked_entries = null,
        public $not_checked_entries = null,
        public $created_between = ["from" => null, "to" => null],
        public $posted_between = ["from" => null, "to" => null],
        public $not_posted_between = ["from" => null, "to" => null]
    ) {}

      public function sources_filter($res): array {
        if (empty($this->sources)) return $res;
        $filteredRecords = array_filter($res, function ($record) {
          foreach ($this->sources as $source) {
            if ($record['source_name'] == $source["source_name"] && $record['source_id'] == $source["source_id"]) {
              return true;
            }
          }
          return false;
        });

        return $filteredRecords;
      }
    public function date_range_filter($res): array {
          $res = array_filter($res, function($record) {
              return $record['date'] > $this->created_between['from'] &&  $record['date'] < $this->created_between['to'];
          });
      return $res;
    }

    public function account_filter($res): array {
      $res =JournalEntryRecord::where('account_id', $this->account_id)->get()->toArray();
      return $res;
    }

    public function previous_date_filter($res): array {
      $res = array_filter($res, function($record) {
          return $record['date'] < $this->created_between['from'];
      });
      return $res;
    }

    public function after_date_filter($res): array {
        $res = array_filter($res, function($record) {
          return $record['date'] > $this->created_between['to'];
      });
      return $res;
    }

    public function cost_center_filter($res): array  {
          $res =  array_filter($res, function($record) {
            return $record['cost_center_id'] == $this->cost_center_id;
          }) ;
           return $res;
    }

    public function branch_filter($res): array  {
        $res =  array_filter($res, function($record) {
          return $record['branch_id'] == $this->branch_id;
        });
      return $res;
    }

    public function user_filter($res): array {
        $res =array_filter($res, function($record) {
          return $record['user_id'] == $this->user_id;
        });
          return $res;
    }

    public function client_filter($res): array  {
        $res = array_filter($res, function($record) {
          return $record['client_id'] == $this->client_id;
        });
         return $res;
    }

    public function contra_account_filter($res): array  {
           $res = array_filter($res, function($record) {
             return $record['contra_account_id'] == $this->contra_account_id;
           });
            return $res;
    }

    public function category_filter($res): array {
      $res = array_filter($res, function($record) {
        return $record['category_id'] == $this->category_id;
      });
      return $res;
    }

    public function employee_filter($res): array {
      $res = array_filter($res, function($record) {
        return $record['employee_id'] == $this->employee_id;
      });
      return $res;
    }

    public function item_filter($res): array {
      $res = array_filter($res, function($record) {
        return $record['item_id'] == $this->item_id;
      });
      return $res;
    }

    public function asset_filter($res): array {
      $res = array_filter($res, function($record) {
        return $record['asset_id'] == $this->asset_id;
      });
      return $res;
    }

    public function contains_filter($res): array  {
      $res = array_filter($res, function($record) {
        return str_contains($record['notes'], $this->contains);
      });
      return $res;
    }

    public function not_contains_filter($res): array  {
      $res = array_filter($res, function($record) {
        return !str_contains($record['notes'],$this->not_contains);
      });
      return $res;
    }
    public function posted_date_range_filter($res): array  {
        $res = array_filter($res, function($record) {
            return $record['post_to_account_date'] > $this->posted_between['from'] &&  $record['post_to_account_date'] < $this->posted_between['to'];
        });
      return $res;
    }

    public function not_posted_date_range_filter($res): array  {
        $res = array_filter($res, function($record) {
            if(!$record['is_post_to_account']) {
              return $record['date'] > $this->not_posted_between['from'] &&  $record['date'] < $this->not_posted_between['to'];
            }
        });
      return $res;
    }

}
