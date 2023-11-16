<?php

namespace Lang\Locales;

use Lang\interface\Words;

enum AccountWordsEnum {

      case delete_condition;
}

class AccountWords implements Words
{

  function en(): array
  {
    return [
      'delete_condition'=>'Cannot Delete account Related to client .',
    ];
  }

  function ar(): array
  {
    return [
      'delete_condition'=>'لا يمكن حذف حساب مرتبط بزبون .',
    ];
  }

}
