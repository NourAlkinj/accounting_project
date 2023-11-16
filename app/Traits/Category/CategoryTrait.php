<?php

namespace App\Traits\Category;

use App\Models\Category;
use App\Models\Item;

trait  CategoryTrait
{

    public function isContainItems($id)
    {

        $items = Item::where('category_id', $id)->get();
        return count($items) > 0;

    }

    public function isNotContainItems($id)
    {
        return !$this->isContainItems($id);

    }


}
