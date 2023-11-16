<?php

namespace Database\Seeders;

use App\Models\BillAdditionAndDiscount;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

  public function run()
  {
    $this->call([
//         DefaultSeeder::class,
      CategorySeeder::class,
      ItemSeeder::class,
      UnitSeeder::class,
      BranchSeeder::class,
      PermissionSeeder::class,
      RoleSeeder::class,
      UserSeeder::class,
      CurrencySeeder::class,
      DefaultCurrencySeeder::class,
      CostCenterSeeder::class,
      AccountSeeder::class,
      ClientSeeder::class,
      DefaultPriceSeeder::class,
 //      PermissionGroupSeeder::class,
       PermissionGroupSeeder::class,
       StoreSeeder::class,
      BarcodeSeeder::class,
      JournalEntryRecordSeeder::class,
//      JournalEntrySeeder::class,
 //             JournalEntryPermissionUserSeeder::class,
////      VoucherTemplateSeeder::class,
//      VoucherSeeder::class,
////             VoucherPermissionUserSeeder::class,
//      VoucherRecordSeeder::class,
       JournalEntryPermissionUserSeeder::class,
      VoucherTemplateSeeder::class,
      VoucherSeeder::class,
      VoucherPermissionUserSeeder::class,
      VoucherRecordSeeder::class,
       BillSeeder::class,
      BillPermissionUserSeeder::class,
      BillRecordSeeder::class,
      BillAdditionAndDiscountSeeder::class,
      SerialSeeder::class,

    ///////////////////////////////////test/////////////////////
 //           CurrencySeeder::class,
           CurrencyActivitySeeder::class,
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
