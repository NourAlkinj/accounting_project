<?php

namespace App\Traits\Account;

use App\Models\Account;
use App\Traits\Common\CommonTrait;


trait  AccountTrait
{
  use CommonTrait;

    public function isFinalRelatedNormal($id)
    {
      $array = $this->getValueFromModelWithCondition(Account::class,'is_normal','final_account_id');
         foreach ($array as $a1)
         {
             if ($id == $a1)
                 return 1;
         }
        return 0;
    }


}
