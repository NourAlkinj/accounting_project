<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang\Locales\CurrencyWords;
use Lang\Locales\CurrencyWordsEnum;
use Lang\Translate;

class UpdateCurrencyRequest extends FormRequest
{
  public   $currencyMessage;


  public function authorize()
  {
    return true;
  }

  function __construct()
  {
    $this->currencyMessage = new Translate(new CurrencyWords());
  }


  public function rules()
  {
    app()->setLocale($this->header('lang'));
    return [
      'code' => 'required|unique:currencies,code,'.$this->id,
      'name' => 'required|max:50|string|unique:currencies,name,'.$this->id,
      'foreign_name' => 'nullable|max:50|unique:currencies,foreign_name,'.$this->id,
      'parity' => 'required|not_in:0|:currencies,parity',
    ];
  }

  public function messages()
  {
    $lang = app('request')->header('lang');
    return [
      'parity.not_in' => $this->currencyMessage->t(CurrencyWordsEnum::parity_condition->name, $lang)
    ];
  }
}



