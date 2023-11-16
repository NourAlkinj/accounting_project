<?php

namespace Database\Seeders;

use App\Http\Controllers\CurrencyController;
use App\Models\Account;
use Illuminate\Database\Seeder;

class SimpleChartEnglishSeeder extends Seeder
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
      if (!$this->isExist('Balance sheet')) {
          $finalAccount1 = Account::create([
            'name' => 'Balance sheet',
            'code' => '00',
            'foreign_name' => 'الميزانية',
            'card_type' => 3,
            'currency_id' => $defaultCurrency->id,
            'is_final' => true,
          ]);
        }
        if (!$this->isExist('Profit and loss')) {
          $finalAccount2 = Account::create([
            'name' => 'Profit and loss',
            'code' => '01',
            'foreign_name' => 'الأرباح والخسائر',
            'card_type' => 3,
            'result_account_id' => $finalAccount1->id,
            'currency_id' => $defaultCurrency->id,
            'is_final' => true,
          ]);
        }
      if (!$this->isExist('Trending')) {
        $finalAccount3 = Account::create([
          'name' => 'Trending',
          'code' => '02',
          'foreign_name' => 'المتاجرة',
          'card_type' => 3,
          'result_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_final' => true,
        ]);
      }


        //normal account
      if (!$this->isExist('Assets')) {
        $normalAccount1 = Account::create([
          'name' => 'Assets',
          'code' => '1',
          'foreign_name' => 'الموجودات',
          'card_type' => 0,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Fixed assets')) {
        $normalAccount2 = Account::create([
          'name' => 'Fixed assets',
          'code' => '11',
          'foreign_name' => 'الموجودات الثابتة ',
          'card_type' => 0,
          'account_id' => $normalAccount1->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Lands')) {
        $normalAccount3 = Account::create([
          'name' => 'Lands',
          'code' => '111',
          'foreign_name' => ' الأراضي',
          'card_type' => 0,
          'account_id' => $normalAccount2->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Buildings')) {
        $normalAccount4 = Account::create([
          'name' => 'Buildings',
          'code' => '112',
          'foreign_name' => ' عقارات',
          'card_type' => 0,
          'account_id' => $normalAccount2->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Furnitures and fittings')) {
        $normalAccount5 = Account::create([
          'name' => ' Furnitures and fittings',
          'code' => '113',
          'foreign_name' => 'أثاث ومفروشات',
          'card_type' => 0,
          'account_id' => $normalAccount2->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Autocars')) {
        $normalAccount6 = Account::create([
          'name' => 'Autocars',
          'code' => '114',
          'foreign_name' => 'سيارات',
          'card_type' => 0,
          'account_id' => $normalAccount2->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Current assets')) {
        $normalAccount7 = Account::create([
          'name' => 'Current assets',
          'code' => '12',
          'foreign_name' => 'الموجودات المتداولة',
          'card_type' => 0,
          'account_id' => $normalAccount1->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Customers')) {
        $normalAccount8 = Account::create([
          'name' => 'Customers',
          'code' => '121',
          'foreign_name' => ' الزبائن ',
          'card_type' => 0,
          'account_id' => $normalAccount7->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Other debitors')) {
        $normalAccount9 = Account::create([
          'name' => 'Other debitors',
          'code' => '122',
          'foreign_name' => '  مدينون مختلفون',
          'card_type' => 0,
          'account_id' => $normalAccount7->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Partners drawings')) {
        $normalAccount10 = Account::create([
          'name' => 'Partners drawings',
          'code' => '123',
          'foreign_name' => ' مسحوبات الشركاء',
          'card_type' => 0,
          'account_id' => $normalAccount7->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Stock')) {
        $normalAccount11 = Account::create([
          'name' => 'Stock',
          'code' => '124',
          'foreign_name' => ' المخزون ',
          'card_type' => 0,
          'account_id' => $normalAccount7->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Cash holding')) {
        $normalAccount12 = Account::create([
          'name' => 'Cash holding',
          'code' => '13',
          'foreign_name' => 'الأموال الجاهزة',
          'card_type' => 0,
          'account_id' => $normalAccount1->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Cash in hard')) {
        $normalAccount13 = Account::create([
          'name' => 'Cash in hard ',
          'code' => '131',
          'foreign_name' => ' الصندوق',
          'card_type' => 0,
          'account_id' => $normalAccount12->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Bank')) {
        $normalAccount14 = Account::create([
          'name' => ' Bank ',
          'code' => '132',
          'foreign_name' => ' المصرف  ',
          'card_type' => 0,
          'account_id' => $normalAccount12->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Liabilities')) {
        $normalAccount15 = Account::create([
          'name' => 'Liabilities',
          'code' => '2',
          'foreign_name' => 'المطاليب  ',
          'card_type' => 0,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Fixed liabilities')) {
        $normalAccount16 = Account::create([
          'name' => ' Fixed liabilities',
          'code' => '21',
          'foreign_name' => 'المطاليب الثابتة ',
          'card_type' => 0,
          'account_id' => $normalAccount15->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Capital')) {
        $normalAccount17 = Account::create([
          'name' => ' Capital',
          'code' => '211',
          'foreign_name' => 'رأس المال  ',
          'card_type' => 0,
          'account_id' => $normalAccount16->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Loans')) {
        $normalAccount18 = Account::create([
          'name' => ' Loans',
          'code' => '212',
          'foreign_name' => 'القروض  ',
          'card_type' => 0,
          'account_id' => $normalAccount16->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Current liabilities')) {
        $normalAccount19 = Account::create([
          'name' => ' Current liabilities',
          'code' => '22',
          'foreign_name' => ' المطاليب المتداولة  ',
          'card_type' => 0,
          'account_id' => $normalAccount15->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Suppliers')) {
        $normalAccount20 = Account::create([
          'name' => ' Suppliers',
          'code' => '221',
          'foreign_name' => ' الموردون  ',
          'card_type' => 0,
          'account_id' => $normalAccount19->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Other creditors')) {
        $normalAccount21 = Account::create([
          'name' => ' Other creditors',
          'code' => '222',
          'foreign_name' => ' دائنون مختلفون  ',
          'card_type' => 0,
          'account_id' => $normalAccount19->id,
          'final_account_id' => $finalAccount1->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Net purchases')) {
        $normalAccount22 = Account::create([
          'name' => 'Net purchases',
          'code' => '3',
          'foreign_name' => 'صافي المشتريات  ',
          'card_type' => 0,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Purchases')) {
        $normalAccount23 = Account::create([
          'name' => ' Purchases ',
          'code' => '31',
          'foreign_name' => 'المشتريات  ',
          'card_type' => 0,
          'account_id' => $normalAccount22->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Purchases return')) {
        $normalAccount24 = Account::create([
          'name' => 'Purchases return  ',
          'code' => '32',
          'foreign_name' => 'مرتجع المشتريات  ',
          'card_type' => 0,
          'account_id' => $normalAccount22->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Purchases transport expense')) {
        $normalAccount25 = Account::create([
          'name' => 'Purchases transport expenses',
          'code' => '33',
          'foreign_name' => 'مصاريف نقل المشتريات   ',
          'card_type' => 0,
          'account_id' => $normalAccount22->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Purchases discounts')) {
        $normalAccount26 = Account::create([
          'name' => ' Purchases discounts  ',
          'code' => '34',
          'foreign_name' => 'الحسم المكتسب ',
          'card_type' => 0,
          'account_id' => $normalAccount22->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Net sales')) {
        $normalAccount27 = Account::create([
          'name' => 'Net sales',
          'code' => '4',
          'foreign_name' => 'صافي المبيعات  ',
          'card_type' => 0,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Sales')) {
        $normalAccount28 = Account::create([
          'name' => ' Sales  ',
          'code' => '41',
          'foreign_name' => '  المبيعات',
          'card_type' => 0,
          'account_id' => $normalAccount27->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Sales return')) {
        $normalAccount29 = Account::create([
          'name' => ' Sales return',
          'code' => '42',
          'foreign_name' => 'مرتجع المبيعات  ',
          'card_type' => 0,
          'account_id' => $normalAccount27->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Sales discounts')) {
        $normalAccount30 = Account::create([
          'name' => ' Sales discounts',
          'code' => '43',
          'foreign_name' => 'الحسم الممنوح  ',
          'card_type' => 0,
          'account_id' => $normalAccount27->id,
          'final_account_id' => $finalAccount3->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Expenses')) {
        $normalAccount31 = Account::create([
          'name' => 'Expenses ',
          'code' => '5',
          'foreign_name' => ' المصاريف',
          'card_type' => 0,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Salaries and wages')) {
        $normalAccount32 = Account::create([
          'name' => ' Salaries and wages ',
          'code' => '501',
          'foreign_name' => 'رواتب وأجور  ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Electricity and water')) {
        $normalAccount33 = Account::create([
          'name' => ' Electricity and water',
          'code' => '502',
          'foreign_name' => ' كهرباء و ماء',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Phone fax and internet')) {
        $normalAccount34 = Account::create([
          'name' => 'Phone fax and internet  ',
          'code' => '503',
          'foreign_name' => ' هاتف وفاكس وانترنت',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Bonus and Tips')) {
        $normalAccount35 = Account::create([
          'name' => 'Bonus and Tips ',
          'code' => '504',
          'foreign_name' => 'إكراميات وهدايا  ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Tranporation')) {
        $normalAccount36 = Account::create([
          'name' => 'Tranporation  ',
          'code' => '505',
          'foreign_name' => ' نقل وانتقال',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Fuel')) {
        $normalAccount37 = Account::create([
          'name' => 'Fuel',
          'code' => '506',
          'foreign_name' => ' وقود ومحروقات  ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Maintenance')) {
        $normalAccount38 = Account::create([
          'name' => ' Maintenance',
          'code' => '507',
          'foreign_name' => 'صيانة و قطع غيار  ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Stationary')) {
        $normalAccount39 = Account::create([
          'name' => 'Stationary ',
          'code' => '508',
          'foreign_name' => ' قرطاسية و مطبوعات  ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Oil')) {
        $normalAccount40 = Account::create([
          'name' => 'Oil',
          'code' => '509',
          'foreign_name' => 'زيوت و شحوم ',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Other expanses')) {
        $normalAccount41 = Account::create([
          'name' => 'Other expanses ',
          'code' => '510',
          'foreign_name' => 'مصاريف متفرقة',
          'card_type' => 0,
          'account_id' => $normalAccount31->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Revenues')) {
        $normalAccount42 = Account::create([
          'name' => 'Revenues',
          'code' => '6',
          'foreign_name' => 'الإيرادات',
          'card_type' => 0,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Other revenues')) {
        $normalAccount43 = Account::create([
          'name' => 'Other revenues ',
          'code' => '601',
          'foreign_name' => 'إيرادات مختلفة ',
          'card_type' => 0,
          'account_id' => $normalAccount42->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Goods')) {
        $normalAccount44 = Account::create([
          'name' => 'Goods',
          'code' => '7',
          'foreign_name' => 'البضاعة',
          'card_type' => 0,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Begining inventory')) {
        $normalAccount45 = Account::create([
          'name' => 'Begining inventory  ',
          'code' => '71',
          'foreign_name' => 'بضاعة أول المدة  ',
          'card_type' => 0,
          'account_id' => $normalAccount44->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }
      if (!$this->isExist('Closing inventory')) {
        $normalAccount46 = Account::create([
          'name' => 'Closing inventory',
          'code' => '72',
          'foreign_name' => 'بضاعة آخر المدة ',
          'card_type' => 0,
          'account_id' => $normalAccount44->id,
          'final_account_id' => $finalAccount2->id,
          'currency_id' => $defaultCurrency->id,
          'is_normal' => true,
        ]);
      }


    }
}
