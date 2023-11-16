<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class UpdateBranchRequest extends FormRequest
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
    return $rules = [
//      'code' => 'required|unique:branches,code,'.$this->id,
      'code' => 'required|regex:/[0-9]$/|unique:branches,code,'.$this->id,
      'name' => 'required|max:50|string|unique:branches,name,'.$this->id,
      'foreign_name' => 'nullable|unique:branches,foreign_name,'.$this->id,
    ];
  }


  public function messages()
  {
    $lang = app('request')->header('lang');
    return [

      'code.regex' => $this->commonMessage->t(CommonWordsEnum::CODE_MUST_END_WITH_NUMBER->name, $lang),
     ];
  }
}
