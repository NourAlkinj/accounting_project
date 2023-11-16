<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherTemplateRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }


  public function rules()
  {
    app()->setLocale($this->header('lang'));
    return [
      'abbreviation' => 'required|unique:voucher_templates,abbreviation',
      'name' => 'required|max:50|string|unique:voucher_templates,name',
      'foreign_name' => 'nullable|max:50|unique:voucher_templates,foreign_name',
    ];
  }
}
