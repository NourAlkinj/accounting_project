<?php

namespace Database\Seeders;

use App\Models\BillAdditionAndDiscount;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{

  public function run()
  {
    $this->call([
        PermissionGroupSeeder::class,
        BranchSeeder::class,
        PermissionSeeder::class,
        RoleSeeder::class,
        UserSeeder::class,
        DefaultPriceSeeder::class,
        DefaultCurrencySeeder::class,
        //         DefaultSeeder::class,
            //   CategorySeeder::class,
            //   ItemSeeder::class,
            //   UnitSeeder::class,
    //   CurrencySeeder::class,
    //   CostCenterSeeder::class,
    //   AccountSeeder::class,
    //   ClientSeeder::class,
 //      PermissionGroupSeeder::class,
    //    StoreSeeder::class,
    //   BarcodeSeeder::class,
    //   JournalEntryRecordSeeder::class,
    //   JournalEntrySeeder::class,
 //             JournalEntryPermissionUserSeeder::class,
////      VocherTemplateSeeder::class,
//      VoucherSeeder::class,
////             VoucherPermissionUserSeeder::class,
//      VoucherRecordSeeder::class,
    //    JournalEntryPermissionUserSeeder::class,
    //   VocherTemplateSeeder::class,
    //   VoucherSeeder::class,
    //   VoucherPermissionUserSeeder::class,
    //   VoucherRecordSeeder::class,
    //    BillSeeder::class,
    //   BillPermissionUserSeeder::class,
    //   BillRecordSeeder::class,
    //   BillAdditionAndDiscountSeeder::class,
    //   SerialSeeder::class,

    ///////////////////////////////////test/////////////////////
 //           CurrencySeeder::class,
        //    CurrencyActivitySeeder::class,
//           JournalEntrySeeder::class,
//           JournalEntryRecordSeeder::class,
//            AccountSeeder::class,
//            LanguageSeeder::class,
//            CostCenterSeeder::class,
 //        CurrencySeeder::class,
//        CurrencyActivitySeeder::class,
//        JournalEntrySeeder::class,
//        JournalEntryRecordSeeder::class,
//        AccountSeeder::class,
//        LanguageSeeder::class,
//        CostCenterSeeder::class,



    ]);
  }
}
