<?php

namespace App\Http\Controllers;

use App\Models\CurrencyActivity;
use App\Http\Requests\StoreCurrencyActivityRequest;
use App\Http\Requests\UpdateCurrencyActivityRequest;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;

class CurrencyActivityController extends Controller
{
  use   CommonTrait, ActivityLog;

  public function index() {
    return CurrencyActivity::all();
  }

  public function store($currencyId,$parity,$LastUpdateDate,$request)
  {
    $currencyActivity = CurrencyActivity::create([
      'currency_id' => $currencyId,
      'parity' => $parity,
      'last_update_date' => $LastUpdateDate
    ]);

    $parameters = ['request' => $request, 'id' => $currencyActivity->id];
    $this->callActivityMethod('currency_activities', 'store', $parameters);
  }

}
