<?php

namespace Lang\Locales;

use Lang\Interface\Words;

enum BranchWordsEnum {

   case root_branch_can_not_be_deleted;
   case branch_delete_error ;
   case branch_not_found;
}

class BranchWords implements Words {

    function en(): array {
        return [
          'root_branch_can_not_be_deleted' => 'Root Branch Can Not Be Deleted',
          'branch_delete_error' => 'Can Not Be Deleted. Related To Other Cards.',
          'branch_not_found' =>'Branch Not Found.'
        ];
    }

    function ar(): array {
        return [
          'root_branch_can_not_be_deleted' => 'الفرع  الرئيسي لا يحذف ',
          'branch_delete_error' => 'لا يمكن حذفه, متعلق ببطاقات أخرى.',
          'branch_not_found' =>'الفرع غير موجود.'
        ];
    }

}
