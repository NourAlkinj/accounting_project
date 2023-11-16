<?php

namespace App\Http\Exceptions;

use Exception;

class CustomException extends Exception {

    public function __construct(public string $custom_message, public int $custom_code)  {
        $this->message = $custom_message;
        $this->code = $custom_code;
    }

    public $message = '';
    public $code = 400;
    public $headers;


}