<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class VoucherRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }


  public function rules()
  {
    app()->setLocale($this->header('lang'));
    return [];
  }

  public function messages()
  {
    return [];
  }
}
