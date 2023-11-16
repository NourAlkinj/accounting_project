<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }


  public function rules()
  {
    app()->setLocale($this->header('lang'));
    return [
      'code' => 'required|unique:assets,code',
      'name' => 'required|max:50|string|unique:assets,name',
      'foreign_name' => 'nullable|max:50|unique:assets,foreign_name',
    ];
  }
}
