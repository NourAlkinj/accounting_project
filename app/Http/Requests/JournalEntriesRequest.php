<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class JournalEntriesRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }


  public function rules()
  {
    return [

    ];
  }

  public function messages()
  {
    app()->setLocale($this->header('lang'));
    return [

    ];
  }
}
