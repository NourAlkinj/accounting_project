<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetGroupRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }


  public function rules()
  {
    app()->setLocale($this->header('lang'));
    return [
      'code' => 'required|unique:asset_groups,code',
      'name' => 'required|max:50|string|unique:asset_groups,name',
      'foreign_name' => 'nullable|max:50|unique:asset_groups,foreign_name',

    ];
  }
}
