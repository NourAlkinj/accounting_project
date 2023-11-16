<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class StoreRequest extends FormRequest
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
    return [
//      'code' => 'required|unique:items,code,'.$this->id,
      'code' => 'required|regex:/[0-9]$/|unique:items,code,' . $this->id,
      'name' => 'required|max:50|string|unique:items,name,' . $this->id,
      'foreign_name' => 'nullable|unique:items,foreign_name,' . $this->id,
      'category_id' => 'required:items,category_id',
      'item_type' => 'required:items,item_type',
      // 'units.0.unit_name' => 'required:units,unit_name',
      'units.*.barcodes.*.barcode_name' => 'unique:barcodes,barcode_name,' . $this->id,
      // 'units.*.conversion_factor' => 'required:units,conversion_factor',
    ];
  }

  public function messages()
  {
    $lang = app('request')->header('lang');
    return [

      'code.regex' => $this->commonMessage->t(CommonWordsEnum::CODE_MUST_END_WITH_NUMBER->name, $lang),

      'units.*.barcodes.*.barcode_name' => __('barcode.barcode_name_is_unique'),
      // 'units.0.unit_name' => __("unit.first_unit_is_required"),

      // 'units.0.conversion_factor' => __("unit.conversion_factor_is_required"),

    ];
  }


}
