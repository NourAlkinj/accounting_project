<?php

namespace App\Traits\Currency;

use App\Models\Currency;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Lang\Translate;
use Lang\Locales\CurrencyWords;
use Lang\Locales\CurrencyWordsEnum;

use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;


trait  CurrencyTrait
{

//  public  $currencyMessage;
//
//  function __construct()
//  {
//    $this->currencyMessage = new Translate(new CurrencyWords());
//  }

//  public function validateParity($parity,$lang)
//  {
//    if ($this->getCountRawsInModel(Currency::class) >= 1) {
//      if ($parity == 0) {
//        $errors = ['Parity' => $this->currencyMessage->t(CurrencyWordsEnum::parity_condition->name, $lang)];
////        $errors = ['Parity' => [__("currency.ParityCondition")]];
//        return response()->json(['errors' => $errors], 400);
//      }
//    }
//  }


//  public function commonQuery($table, $firstValueOfCondition = null, $secondValueOfCondition = null)  // Only for Default Currencies
//  {
//    $p = Config::get('app.locale');
//    $query = (DB::select("select
//                 id
//                ,code_$p as code
//                ,name_$p as name
//                ,part_name_$p as part_name
//                ,foreign_name
//                ,foreign_part_name
//                ,proportion
//                from
//                $table where($firstValueOfCondition = $secondValueOfCondition) "));
//    return $query;
//  }
}
