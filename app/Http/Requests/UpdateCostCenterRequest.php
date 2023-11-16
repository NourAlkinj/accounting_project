<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class UpdateCostCenterRequest extends FormRequest
{
  public $commonMessage ;

  public function authorize()
  {
    return true;
  }

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function rules()
  {
    app()->setLocale($this->header('lang'));
    return [
      'code' => 'required|regex:/[0-9]$/|unique:cost_centers,code,'.$this->id,
      'name' => 'required|max:50|string|unique:cost_centers,name,'.$this->id,
      'foreign_name' => 'nullable|max:50|unique:cost_centers,foreign_name,'.$this->id,

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
