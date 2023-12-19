<?php
namespace App\Http\Controllers\Report;

use App\Models\Activity;

class activityLogFilter {

    public function __construct(
        public $user_id = null,
        public $branch_id = null,
        public $created_between = ["from" => null, "to" => null],

    ) {}
    public function user_filter($res): array {
      $res =Activity::where('user_id', $this->user_id)->get()->toArray();
      return $res;
    }
    public function branch_filter($res): array  {
      $res = array_filter($res, function($record) {
        return $record['branch_id'] == $this->branch_id;
      });
      return $res;
    }
    public function date_range_filter($res): array {
      $created_between_from = date('Y-m-d', strtotime($this->created_between['from']));
      $created_between_to = date('Y-m-d', strtotime($this->created_between['to']));
      $res = array_filter($res, function($record) use ($created_between_from,$created_between_to) {
        return  $record['created_at'] > $created_between_from && $record['created_at'] < $created_between_to;
      });
      return $res;
    }

}
