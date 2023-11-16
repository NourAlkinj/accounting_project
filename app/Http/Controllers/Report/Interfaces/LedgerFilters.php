<?php

namespace App\Http\Controllers\Report\Interfaces;

class LedgerFilters {

    function __construct(
        public $account_id,
        public $cost_center_id,
        public $branch_id,
        public $user_id,
        public $contra_account_id,
        public $client_id,
        public $employee_id,
        public $asset_id,
        public $category_id,
        public $item_id,
        public $contains,
        public $not_contains,
        public $checked_entries,
        public $not_checked_entries,
        public $created_between,
        public $posted_between,
        public $not_posted_between,
        public $sources
    ) {
    }

}

?>