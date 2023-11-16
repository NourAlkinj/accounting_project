<?php

namespace Lang\Locales;

use Lang\Interface\Words;

enum AuthWordsEnum {

   case failed;
   case password ;
   case throttle;
   case Invalid_login_details  ;

}

class AuthWords implements Words {

    function en(): array {
        return [
          'failed' => 'These credentials do not match our records.',
          'password' => 'The provided password is incorrect.',
          'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
          'Invalid_login_details' => 'Invalid login details'
        ];
    }

    function ar(): array {
        return [
          'failed' => 'These credentials do not match our records.',
          'password' => 'The provided password is incorrect.',
          'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
          'Invalid_login_details' => 'معلومات الإخال غير مطابقة'
        ];
    }

}
