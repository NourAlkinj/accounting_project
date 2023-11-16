<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Locales\CurrencyWords;
use Lang\Locales\CurrencyWordsEnum;
use Lang\Translate;

class StoreUserRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }

  public $commonMessage, $currencyMessage;

  function __construct()
  {

    $this->commonMessage = new Translate(new CommonWords());
    $this->currencyMessage = new Translate(new CurrencyWords());
  }

  public function rules()
  {

    app()->setLocale($this->header('lang'));

    return $rules = [
//      'code' => 'required|unique:users,code',
//      'code' => 'required|not_in:0|regex:/[0-9]$/|unique:users,code',
      'code' => 'required|regex:/[0-9]$/|unique:users,code',
      'branch_id' => 'required:users,branch_id',
      'name' => 'required|max:50|string|unique:users,name',
      'foreign_name' => 'nullable|unique:users,foreign_name',
      'email' => 'required|email|unique:users|max:255',
      'password' => 'Required|min:8',
    ];
  }

  public function messages()
  {
    $lang = app('request')->header('lang');
    return [

      'code.regex' => $this->commonMessage->t(CommonWordsEnum::CODE_MUST_END_WITH_NUMBER->name, $lang),
//      'code.not_in' => $this->currencyMessage->t(CurrencyWordsEnum::parity_condition->name, $lang)
    ];
  }




//  protected function prepareForValidation()
//  {
//    $lang = $this->header('lang');
//
//    if ($lang) {
//       app()->setLocale($lang);
//    }
//
//    parent::prepareForValidation();
//  }
}
