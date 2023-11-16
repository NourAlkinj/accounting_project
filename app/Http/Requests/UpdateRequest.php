<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class UpdateRequest extends FormRequest
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

      'category_id' => 'required:items,category_id',
      'code' => 'required|regex:/[0-9]$/|unique:items,code,'.$this->id,
      'name' => 'required|max:50|string|unique:items,name,'.$this->id,
      'foreign_name' => 'nullable|unique:items,foreign_name,'.$this->id,
      // 'units.*.barcodes.*.barcode_name' => 'unique:barcodes,barcode_name',

    ];
  }

  public function messages()
  {
    $lang = app('request')->header('lang');
    return [
      // 'units.*.barcodes.*.barcode_name' => __('barcode.barcode_name_is_unique'),


      'code.regex' => $this->commonMessage->t(CommonWordsEnum::CODE_MUST_END_WITH_NUMBER->name, $lang),
    ];
  }
}
