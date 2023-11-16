<?php

namespace App\Traits\DefaultPrice;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

trait  DefaultPriceTrait
{

    public function commonQuery($table, $firstValueOfCondition = null, $secondValueOfCondition = null)
    {
        $p = Config::get('app.locale');
        $query = (DB::select("select
                        id,
                     name_$p as name,
                     caption_$p as caption,
                     type
                from
                $table where($firstValueOfCondition = $secondValueOfCondition) "));
        return $query;
    }



}
