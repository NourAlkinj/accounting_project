<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class UpdateUserRequest extends FormRequest
{

  public $commonMessage;

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
//      'code' => 'required|unique:users,code,'.$this->id,
      'code' => 'required|regex:/[0-9]$/|unique:users,code,' . $this->id,
      'name' => 'required|max:50|string|unique:users,name,' . $this->id,
      'email' => 'required|email|max:255|unique:users,email,' . $this->id,
      'branch_id' => 'required:users,branch_id',
      'password' => 'Required|min:8|unique:users,password,' . $this->id,
      'foreign_name' => 'nullable|unique:users,foreign_name,' . $this->id,
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
