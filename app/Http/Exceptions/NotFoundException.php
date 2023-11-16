<?php

namespace App\Http\Exceptions;

use Exception;

class NotFoundException extends Exception {

    public function __construct(public string $item_name) {
        $this->message = $item_name . $this->message;
    }

    public $message = ' Not Found';
    public $code = 404;
    public $headers;

}
