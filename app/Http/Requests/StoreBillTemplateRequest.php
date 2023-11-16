<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillTemplateRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }


  public function rules()
  {
    app()->setLocale($this->header('lang'));
    return [
      'abbreviation' => 'required|unique:bill_templates,abbreviation',
      'name' => 'required|max:50|string|unique:bill_templates,name',
      'foreign_name' => 'nullable|max:50|unique:bill_templates,foreign_name',
    ];
  }
}
