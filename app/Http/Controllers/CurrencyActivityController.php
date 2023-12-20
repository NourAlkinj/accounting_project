<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Currency;
use App\Models\CurrencyActivity;
use App\Http\Requests\StoreCurrencyActivityRequest;
use App\Http\Requests\UpdateCurrencyActivityRequest;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use Carbon\Carbon;
use DateTime;

class CurrencyActivityController extends Controller
{
    use   CommonTrait, ActivityLog;

    public function index()
    {
        return CurrencyActivity::all();
    }


    public function store($currencyId,$parity,$start_fanancial_period)
    {
//      $appSetting = AppSetting::find(1);
//      $end_fanancial_period = $appSetting->settings['end_fanancial_period'];
//      $end_fanancial_period = date('Y-m-d', strtotime($end_fanancial_period));

        $end_fanancial_period = '2024-1-19';
        $start_fanancial_period = new Carbon($start_fanancial_period);
        $end_fanancial_period = new Carbon($end_fanancial_period);
        $fanancial_period_in_days = $start_fanancial_period->diffInDays($end_fanancial_period);
        foreach (range(0, $fanancial_period_in_days) as $index) {
            CurrencyActivity::create([
                'currency_id' => $currencyId,
                'parity' => $parity,
                'date' => $start_fanancial_period->toDateString(),
            ]);
            $start_fanancial_period->addDay();
        }
    }


    public function update($currencyId,$parity,$start_fanancial_period)
    {
        $start_fanancial_period = date('Y-m-d', strtotime($start_fanancial_period));
        $update = ['parity' => $parity];
        CurrencyActivity::where('currency_id', $currencyId)
            ->where('date', '>=', $start_fanancial_period)
            ->update($update);
    }
}