<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    app()->setLocale($this->header('lang'));
    return [
      'code' => 'required:assets,code',
      'name' => 'required|max:50|string:assets,name',
      'foreign_name' => 'nullable|max:50|:assets,foreign_name',];
  }
}
