<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class StoreDepartmentRequest extends FormRequest
{
  public $commonMessage  ;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    app()->setLocale($this->header('lang'));
    return [
//      'code' => 'required|unique:departments,code',
      'code' => 'required|regex:/[0-9]$/|unique:departments,code',
      'name' => 'required|max:50|string|unique:departments,name',
      'foreign_name' => 'nullable|max:50|unique:departments,foreign_name',
    ];
  }
  public function messages()
  {
    $lang = app('request')->header('lang');
    return [

      'code.regex' => $this->commonMessage->t(CommonWordsEnum::CODE_MUST_END_WITH_NUMBER->name, $lang)
     ];
  }
}
