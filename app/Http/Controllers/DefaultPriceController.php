<?php

namespace App\Http\Controllers;

use App\Traits\Common\CommonTrait;
use App\Traits\DefaultPrice\DefaultPriceTrait;
use App\Traits\ActivityLog\ActivityLog;
use Illuminate\Support\Facades\Config;

class DefaultPriceController extends Controller
{
    use   DefaultPriceTrait, ActivityLog;

    public function index()
    {

        $allDefaultPrices = $this->commonQuery('default_prices', 1, 1);

        return response()->json($allDefaultPrices, 200);
    }


}
