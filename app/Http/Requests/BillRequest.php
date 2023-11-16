<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class BillRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }


  public function rules()
  {
    app()->setLocale($this->header('lang'));
    return [

      //    'parity'=> 'numeric|between:0,99.99' ,
    ];
  }

  public function messages()
  {
    return [];
  }
}
