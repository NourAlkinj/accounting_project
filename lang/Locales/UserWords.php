<?php

namespace Lang\Locales;

use Lang\Interface\Words;

enum UserWordsEnum {

   case admin_can_not_be_deleted;
   case user_not_found ;

}

class UserWords implements Words {

//  public function __construct()
//  {
//  }

  function en(): array {
        return [
          'admin_can_not_be_deleted'=> 'Admin User not deleted',
          'user_not_found' => 'User not Found',
        ];
    }

    function ar(): array {
        return [
          'admin_can_not_be_deleted'=>  'لا يمكن حذف المدير العام ',
          'user_not_found' => 'المستخدم غير موجود ',
        ];
    }

}
