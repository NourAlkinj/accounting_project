<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Locales\CurrencyWords;
use Lang\Locales\CurrencyWordsEnum;
use Lang\Translate;

class StoreCurrencyRequest extends FormRequest
{
  public $commonMessage , $currencyMessage;


  public function authorize()
  {
    return true;
  }

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
    $this->currencyMessage = new Translate(new CurrencyWords());

  }


  public function rules()
  {
    app()->setLocale($this->header('lang'));
    return [
      'code' => 'required|unique:currencies,code',
      'name' => 'required|max:50|string|unique:currencies,name',
      'foreign_name' => 'nullable|max:50|unique:currencies,foreign_name',
      'parity' => 'required|not_in:0|:currencies,parity',
    ];
  }

  public function messages()
  {
    $lang = app('request')->header('lang');
    return [

      'code.regex' => $this->commonMessage->t(CommonWordsEnum::CODE_MUST_END_WITH_NUMBER->name, $lang),
      'parity.not_in' => $this->currencyMessage->t(CurrencyWordsEnum::parity_condition->name, $lang)
    ];
  }
}
