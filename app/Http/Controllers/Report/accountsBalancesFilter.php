<?php
namespace App\Http\Controllers\Report;

use App\Models\JournalEntryRecord;


class accountsBalancesFilter {

    public function __construct(
        public $account_id = null,
        public $client_id = null,
        public $cost_center_id = null,
        public $branch_id = null,
        public $created_between = ["from" => null, "to" => null],
        public $contains = null,
        public $not_contains = null,
    ) {}

    public function account_filter($res): array {
      $res =JournalEntryRecord::where('account_id', $this->account_id)->get()->toArray();
      return $res;
    }

    public function client_filter($res): array  {
      $res = array_filter($res, function($record) {
        return $record['client_id'] == $this->client_id;
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

    public function date_range_filter($res): array {
      $res = array_filter($res, function($record) {
        return $record['date'] > $this->created_between['from'] &&  $record['date'] < $this->created_between['to'];
      });
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

//    public function is_posted_to_accounts_filter($res): array  {
//      $res =  array_filter($res, function($record) {
//        return $record['is_post_to_account'] == $this->branch_id;
//      });
//      return $res;
//    }

}
