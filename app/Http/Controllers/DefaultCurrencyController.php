<?php

namespace App\Http\Controllers;

use App\Models\DefaultCurrency;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use App\Traits\Currency\CurrencyTrait;
use Database\Seeders\DefaultSeeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DefaultCurrencyController extends Controller
{
    use     ActivityLog;

    public function index()
    {
        $parameters = ['id' => null];
        $allDefaultCurrencies = $this->commonQuery('default_currencies', 1, 1);
        $this->callActivityMethod('default_currencies', 'index', $parameters);
        return response()->json($allDefaultCurrencies, 200);
    }


    public function all()
    {
        $parameters = ['id' => null];
        $this->callActivityMethod('default_currencies', 'index', $parameters);
        $defaultCurrencies = DefaultCurrency::all();
        return $defaultCurrencies;
    }



    public function show($id)
    {
        $parameters = ['id' => $id];
        $defaultCurrency = $this->commonQuery('default_currencies', 'id', $id);
        $this->callActivityMethod('default_currencies', 'show', $parameters);
        return response()->json($defaultCurrency, 200);
    }


  public function commonQuery($table, $firstValueOfCondition = null, $secondValueOfCondition = null)  // Only for Default Currencies
  {
    $p = Config::get('app.locale');
    $query = (DB::select("select
                 id
                ,code_$p as code
                ,name_$p as name
                ,part_name_$p as part_name
                ,foreign_name
                ,foreign_part_name
                ,proportion
                from
                $table where($firstValueOfCondition = $secondValueOfCondition) "));
    return $query;
  }
}
