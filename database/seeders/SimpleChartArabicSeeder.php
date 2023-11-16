<?php

namespace Database\Seeders;

use App\Http\Controllers\CurrencyController;
use App\Models\Account;
use Illuminate\Database\Seeder;

class SimpleChartArabicSeeder extends Seeder
{
  public function isExist($name)
  {
    $existingAccount= Account::where([
      'name' => $name,
    ])->exists();

    if($existingAccount)
      return true;
    return false;
  }
    public function run()
    {
        $controller = new CurrencyController();
        $defaultCurrency = $controller->getDefaultCurrency();

        //final account
      if (!$this->isExist('الميزانية')) {
        $finalAccount1 = Account::create([
          'name' => 'الميزانية ',
          'code' => '00',
          'foreign_name' => 'Balance sheet',
          'card_type' => 3,
          'currency_id' => $defaultCurrency->id,
          'is_final' => true,
        ]);
      }
      if (!$this->isExist('الأرباح والخسائر')) {
        $finalAccount2 = Account::create([
          'name' => 'الأرباح والخسائر',
          'code' => '01',
          'foreign_name' => 'Profit and loss ',
          'card_type' => 3,
          'result_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_final' => true,
        ]);
      }
      if (!$this->isExist('المتاجرة')) {
        $finalAccount3 = Account::create([
          'name' => 'المتاجرة',
          'code' => '02',
          'foreign_name' => 'Trending ',
          'card_type' => 3,
          'result_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_final' => true,
        ]);
      }

        //normal account
      if (!$this->isExist('الموجودات')) {
        $normalAccount1 = Account::create([
          'name' => 'الموجودات',
          'code' => '1',
          'foreign_name' => 'Assets ',
          'card_type' => 0,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('الموجودات الثابتة')) {
        $normalAccount2 = Account::create([
          'name' => 'الموجودات الثابتة',
          'code' => '11',
          'foreign_name' => 'Fixed assets ',
          'card_type' => 0,
          'account_id' => $normalAccount1->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('الأراضي')) {
        $normalAccount3 = Account::create([
          'name' => 'الأراضي',
          'code' => '111',
          'foreign_name' => 'Lands ',
          'card_type' => 0,
          'account_id' => $normalAccount2->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('عقارات')) {
        $normalAccount4 = Account::create([
          'name' => 'عقارات',
          'code' => '112',
          'foreign_name' => 'Buildings',
          'card_type' => 0,
          'account_id' => $normalAccount2->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('أثاث ومفروشات')) {
        $normalAccount5 = Account::create([
          'name' => 'أثاث ومفروشات',
          'code' => '113',
          'foreign_name' => 'Furnitures and fittings ',
          'card_type' => 0,
          'account_id' => $normalAccount2->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('سيارات')) {
        $normalAccount6 = Account::create([
          'name' => 'سيارات',
          'code' => '114',
          'foreign_name' => 'Autocars ',
          'card_type' => 0,
          'account_id' => $normalAccount2->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('الموجودات المتداولة')) {
        $normalAccount7 = Account::create([
          'name' => 'الموجودات المتداولة',
          'code' => '12',
          'foreign_name' => 'Current assets ',
          'card_type' => 0,
          'account_id' => $normalAccount1->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('الزبائن')) {
        $normalAccount8 = Account::create([
          'name' => 'الزبائن',
          'code' => '121',
          'foreign_name' => 'Customers ',
          'card_type' => 0,
          'account_id' => $normalAccount7->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('مدينون مختلفون')) {
        $normalAccount9 = Account::create([
          'name' => 'مدينون مختلفون',
          'code' => '122',
          'foreign_name' => 'Other debitors ',
          'card_type' => 0,
          'account_id' => $normalAccount7->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('مسحوبات الشركاء')) {
        $normalAccount10 = Account::create([
          'name' => 'مسحوبات الشركاء',
          'code' => '123',
          'foreign_name' => 'Partners drawings ',
          'card_type' => 0,
          'account_id' => $normalAccount7->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('المخزون')) {
        $normalAccount11 = Account::create([
          'name' => 'المخزون',
          'code' => '124',
          'foreign_name' => 'Stock ',
          'card_type' => 0,
          'account_id' => $normalAccount7->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('الأموال الجاهزة')) {
        $normalAccount12 = Account::create([
          'name' => 'الأموال الجاهزة',
          'code' => '13',
          'foreign_name' => 'Cash holding ',
          'card_type' => 0,
          'account_id' => $normalAccount1->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('الصندوق')) {
        $normalAccount13 = Account::create([
          'name' => 'الصندوق',
          'code' => '131',
          'foreign_name' => 'Cash in hard ',
          'card_type' => 0,
          'account_id' => $normalAccount12->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('المصرف')) {
        $normalAccount14 = Account::create([
          'name' => 'المصرف',
          'code' => '132',
          'foreign_name' => 'Bank ',
          'card_type' => 0,
          'account_id' => $normalAccount12->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('المطاليب')) {
        $normalAccount15 = Account::create([
          'name' => 'المطاليب',
          'code' => '2',
          'foreign_name' => 'Liabilities ',
          'card_type' => 0,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('المطاليب الثابتة')) {
        $normalAccount16 = Account::create([
          'name' => 'المطاليب الثابتة',
          'code' => '21',
          'foreign_name' => 'Fixed liabilities ',
          'card_type' => 0,
          'account_id' => $normalAccount15->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('رأس المال')) {
        $normalAccount17 = Account::create([
          'name' => 'رأس المال',
          'code' => '211',
          'foreign_name' => 'Capital ',
          'card_type' => 0,
          'account_id' => $normalAccount16->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('القروض')) {
        $normalAccount18 = Account::create([
          'name' => 'القروض',
          'code' => '212',
          'foreign_name' => 'Loans ',
          'card_type' => 0,
          'account_id' => $normalAccount16->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('المطاليب المتداولة')) {
        $normalAccount19 = Account::create([
          'name' => 'المطاليب المتداولة',
          'code' => '22',
          'foreign_name' => 'Current liabilities ',
          'card_type' => 0,
          'account_id' => $normalAccount15->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('الموردون')) {
        $normalAccount20 = Account::create([
          'name' => 'الموردون',
          'code' => '221',
          'foreign_name' => 'Suppliers ',
          'card_type' => 0,
          'account_id' => $normalAccount19->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('دائنون مختلفون')) {
        $normalAccount21 = Account::create([
          'name' => 'دائنون مختلفون',
          'code' => '222',
          'foreign_name' => 'Other creditors ',
          'card_type' => 0,
          'account_id' => $normalAccount19->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('صافي المشتريات')) {
        $normalAccount22 = Account::create([
          'name' => 'صافي المشتريات',
          'code' => '3',
          'foreign_name' => 'Net purchases ',
          'card_type' => 0,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('المشتريات')) {
        $normalAccount23 = Account::create([
          'name' => 'المشتريات',
          'code' => '31',
          'foreign_name' => 'Purchases ',
          'card_type' => 0,
          'account_id' => $normalAccount22->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('مرتجع المشتريات')) {
        $normalAccount24 = Account::create([
          'name' => 'مرتجع المشتريات',
          'code' => '32',
          'foreign_name' => 'Purchases return  ',
          'card_type' => 0,
          'account_id' => $normalAccount22->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('مصاريف نقل المشتريات')) {
        $normalAccount25 = Account::create([
          'name' => 'مصاريف نقل المشتريات',
          'code' => '33',
          'foreign_name' => 'Purchases transport expenses ',
          'card_type' => 0,
          'account_id' => $normalAccount22->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('الحسم المكتسب')) {
        $normalAccount26 = Account::create([
          'name' => 'الحسم المكتسب',
          'code' => '34',
          'foreign_name' => 'Purchases discounts ',
          'card_type' => 0,
          'account_id' => $normalAccount22->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('صافي المبيعات')) {
        $normalAccount27 = Account::create([
          'name' => 'صافي المبيعات',
          'code' => '4',
          'foreign_name' => 'Net sales ',
          'card_type' => 0,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('المبيعات')) {
        $normalAccount28 = Account::create([
          'name' => 'المبيعات',
          'code' => '41',
          'foreign_name' => 'Sales  ',
          'card_type' => 0,
          'account_id' => $normalAccount27->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('مرتجع المبيعات')) {
        $normalAccount29 = Account::create([
          'name' => 'مرتجع المبيعات',
          'code' => '42',
          'foreign_name' => 'Sales return ',
          'card_type' => 0,
          'account_id' => $normalAccount27->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('الحسم الممنوح')) {
        $normalAccount30 = Account::create([
          'name' => 'الحسم الممنوح',
          'code' => '43',
          'foreign_name' => 'Sales discounts ',
          'card_type' => 0,
          'account_id' => $normalAccount27->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('المصاريف')) {
        $normalAccount31 = Account::create([
          'name' => 'المصاريف',
          'code' => '5',
          'foreign_name' => 'Expenses ',
          'card_type' => 0,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('رواتب وأجور')) {
        $normalAccount32 = Account::create([
          'name' => 'رواتب وأجور',
          'code' => '501',
          'foreign_name' => 'Salaries and wages ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('كهرباء و ماء')) {
        $normalAccount33 = Account::create([
          'name' => 'كهرباء و ماء',
          'code' => '502',
          'foreign_name' => 'Electricity and water ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('هاتف وفاكس وانترنت')) {
        $normalAccount34 = Account::create([
          'name' => 'هاتف وفاكس وانترنت',
          'code' => '503',
          'foreign_name' => 'Phone fax and internet ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('إكراميات وهدايا')) {
        $normalAccount35 = Account::create([
          'name' => 'إكراميات وهدايا',
          'code' => '504',
          'foreign_name' => 'Bonus and Tips ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('نقل وانتقال')) {
        $normalAccount36 = Account::create([
          'name' => 'نقل وانتقال',
          'code' => '505',
          'foreign_name' => 'Tranporation ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('وقود ومحروقات')) {
        $normalAccount37 = Account::create([
          'name' => 'وقود ومحروقات',
          'code' => '506',
          'foreign_name' => 'Fuel ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('صيانة و قطع غيار')) {
        $normalAccount38 = Account::create([
          'name' => 'صيانة و قطع غيار',
          'code' => '507',
          'foreign_name' => 'Maintenance ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('قرطاسية و مطبوعات')) {
        $normalAccount39 = Account::create([
          'name' => 'قرطاسية و مطبوعات',
          'code' => '508',
          'foreign_name' => 'Stationary ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('زيوت و شحوم')) {
        $normalAccount40 = Account::create([
          'name' => 'زيوت و شحوم',
          'code' => '509',
          'foreign_name' => 'Oil ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('مصاريف متفرقة')) {
        $normalAccount41 = Account::create([
          'name' => 'مصاريف متفرقة',
          'code' => '510',
          'foreign_name' => 'Other expanses ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('الإيرادات')) {
        $normalAccount42 = Account::create([
          'name' => 'الإيرادات',
          'code' => '6',
          'foreign_name' => 'Revenues ',
          'card_type' => 0,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('إيرادات مختلفة')) {
        $normalAccount43 = Account::create([
          'name' => 'إيرادات مختلفة',
          'code' => '601',
          'foreign_name' => 'Other revenues ',
          'card_type' => 0,
          'account_id' => $normalAccount42->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('البضاعة')) {
        $normalAccount44 = Account::create([
          'name' => 'البضاعة',
          'code' => '7',
          'foreign_name' => 'Goods ',
          'card_type' => 0,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('بضاعة أول المدة')) {
        $normalAccount45 = Account::create([
          'name' => 'بضاعة أول المدة',
          'code' => '71',
          'foreign_name' => 'Begining inventory ',
          'card_type' => 0,
          'account_id' => $normalAccount44->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('بضاعة آخر المدة')) {
        $normalAccount46 = Account::create([
          'name' => 'بضاعة آخر المدة',
          'code' => '72',
          'foreign_name' => ' Closing inventory ',
          'card_type' => 0,
          'account_id' => $normalAccount44->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }


    }
}
