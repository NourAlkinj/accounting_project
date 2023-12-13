<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
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

  public function store($currencyId,$parity)
  {
      $appSetting = AppSetting::find(1);

      $start_fanancial_period = $appSetting->settings['start_fanancial_period'];
      $start_fanancial_period = date('Y-m-d', strtotime($start_fanancial_period));
      $end_fanancial_period = $appSetting->settings['end_fanancial_period'];
      $end_fanancial_period = date('Y-m-d', strtotime($end_fanancial_period));

      $fanancial_period_in_days = $end_fanancial_period->diffInDays($start_fanancial_period);


      $currencyActivity = CurrencyActivity::create([
      'currency_id' => $currencyId,
      'parity' => $parity,
      'date' => $start_fanancial_period
    ]);



  }

}
