<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBillTemplateRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }


  public function rules()
  {
    app()->setLocale($this->header('lang'));
    return [
      'abbreviation' => 'required|unique:bill_templates,abbreviation,'.$this->id,
      'name' => 'required|max:50|string|unique:bill_templates,name,'.$this->id,
      'foreign_name' => 'nullable|max:50|unique:bill_templates,foreign_name,'.$this->id,
    ];
  }
}
