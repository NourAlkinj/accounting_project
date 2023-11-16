<?php
namespace App\Http\Controllers\Report;

use App\Models\Item;

use function PHPUnit\Framework\stringContains;

class filterItemsForRepricing {

    public function __construct(
        public $items = null,
        public $only_items_have_quantities = null,
        public $item_type = null,
        public $currency_id = null

    ) {}

      public function items_filter($res)  {
            $res= item::whereIn('id', $this->items)->get();
                return $res;
      }

      public function only_items_have_quantities_filter($res)
      {
        $filteredRecords = [];
        foreach ($res as $record) {
          if ($record->quantities->count()>0) {
            $filteredRecords[] = $record;
          }
        }
        return collect($filteredRecords);
      }

      public function item_type_filter($res)  {
        $res = $res->where('item_type', $this->item_type);
        return $res;
      }

     public function currency_filter($res)  {
        $res = $res->where('currency_id', $this->currency_id);
        return $res;
     }

}
