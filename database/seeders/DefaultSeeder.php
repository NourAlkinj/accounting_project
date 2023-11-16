<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\DefaultCurrency;
use App\Models\DefaultPrice;
use App\Models\PermissionGroup;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Spatie\DataTransferObject\Attributes\DefaultCast;

class DefaultSeeder extends Seeder
{

    public function run()
    {


        // Main Branch 
        Branch::create([
            'code' => '1',
            'name' => 'الفرع الرئيسي',
            'foreign_name' => 'Main Branch',
            'branch_id' => null,
            'responsibility' => '',
            'address' => '',
            'website' => 'mainbranch.com',
            'email' => 'mainbranch@gmail.com',
            'phone' => '041877645',
            'mobile' => '0994848736',
            'is_active' => true,
            'notes' => 'notes ',
            'is_root' => true
        ]);

        $this->call([
            PermissionGroupSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            DefaultCurrencySeeder::class,
            DefaultPriceSeeder::class,
            // UserSeeder::class
            // JournalEntryPermissionUserSeeder::class

        ]);



        // $defaultCurrency1 = DefaultCurrency::create([
        //     'name_ar' => 'ليرة سورية',
        //     'name_en' => 'Syrian Pound',
        //     'latin_name' => 'Syrian Pound',
        //     'code_en' => 'SYP',
        //     'code_ar' => 'ل.س.',
        //     'proportion' => '100',
        //     'part_name_ar' => 'قرش',
        //     'part_name_en' => 'Piastre',
        //     'latin_part_name' => 'Piastre',
        // ]);

        // $defaultCurrency2 = DefaultCurrency::create([
        //     'name_ar' => 'دينار أردني',
        //     'name_en' => 'Jordanian Dinar',
        //     'latin_name' => 'Jordanian Dinar',
        //     'code_en' => 'JOD',
        //     'code_ar' => 'د.أ.',
        //     'proportion' => '100',
        //     'part_name_ar' => 'قرش',
        //     'part_name_en' => 'Piastre',
        //     'latin_part_name' => 'Piastre',
        // ]);
        // $defaultCurrency3 = DefaultCurrency::create([
        //     'name_ar' => 'درهم إماراتي',
        //     'name_en' => 'UAE Dirham',
        //     'latin_name' => 'UAE Dirham',
        //     'code_en' => 'AED',
        //     'code_ar' => 'د.هـ.',
        //     'proportion' => '100',
        //     'part_name_ar' => 'فلس',
        //     'part_name_en' => 'Fils',
        //     'latin_part_name' => 'Fils',
        // ]);

        // $defaultCurrency4 = DefaultCurrency::create([
        //     'name_ar' => 'ريال عماني',
        //     'name_en' => 'Omani Rial',
        //     'latin_name' => 'Omani Rial',
        //     'code_en' => 'OMR',
        //     'code_ar' => 'ر.ع.',
        //     'proportion' => '1000',
        //     'part_name_ar' => 'بيسة',
        //     'part_name_en' => 'Baisa',
        //     'latin_part_name' => 'Baisa',
        // ]);

        // $defaultCurrency5 = DefaultCurrency::create([
        //     'name_ar' => 'دينار كويتي',
        //     'name_en' => 'Kuwaiti Dinar',
        //     'latin_name' => 'Kuwaiti Dinar',
        //     'code_en' => 'KWD',
        //     'code_ar' => 'د.كـ.',
        //     'proportion' => '1000',
        //     'part_name_ar' => 'فلس',
        //     'part_name_en' => 'Fils',
        //     'latin_part_name' => 'Fils',
        // ]);
        // $defaultCurrency6 = DefaultCurrency::create([
        //     'name_ar' => 'ريال سعودي',
        //     'name_en' => 'Saudi Riyal',
        //     'latin_name' => 'Saudi Riyal',
        //     'code_en' => 'SAR',
        //     'code_ar' => 'ر.س.',
        //     'proportion' => '100',
        //     'part_name_ar' => 'هللة',
        //     'part_name_en' => 'Halalat',
        //     'latin_part_name' => 'Halalat',
        // ]);
        // $defaultCurrency7 = DefaultCurrency::create([
        //     'name_ar' => 'دينار عراقي',
        //     'name_en' => 'Iraq Dinar',
        //     'latin_name' => 'Iraq Dinar',
        //     'code_en' => 'IQD',
        //     'code_ar' => 'د.ع.',
        //     'proportion' => '1000',
        //     'part_name_ar' => 'فلس',
        //     'part_name_en' => 'Fils',
        //     'latin_part_name' => 'Fils',
        // ]);

        // $defaultCurrency8 = DefaultCurrency::create([
        //     'name_ar' => 'ليرة لبنانية',
        //     'name_en' => 'Lebanon Pound',
        //     'latin_name' => 'Lebanon Pound',
        //     'code_en' => 'LBP',
        //     'code_ar' => 'ل.ل.',
        //     'proportion' => '100',
        //     'part_name_ar' => 'قرش',
        //     'part_name_en' => 'Piastre',
        //     'latin_part_name' => 'Piastre',
        // ]);

        // $defaultCurrency9 = DefaultCurrency::create([
        //     'name_ar' => 'دينار بحريني',
        //     'name_en' => 'Bahraini Dinar',
        //     'latin_name' => 'Bahraini Dinar',
        //     'code_en' => 'BHD',
        //     'code_ar' => 'د.ب.',
        //     'proportion' => '1000',
        //     'part_name_ar' => 'فلس',
        //     'part_name_en' => 'Fils',
        //     'latin_part_name' => 'Fils',
        // ]);

        // $defaultCurrency10 = DefaultCurrency::create([
        //     'name_ar' => 'ريال قطري',
        //     'name_en' => 'Qatari Riyal',
        //     'latin_name' => 'Qatari Riyal',
        //     'code_en' => 'QAR',
        //     'code_ar' => 'ر.ق.',
        //     'proportion' => '100',
        //     'part_name_ar' => 'درهم',
        //     'part_name_en' => 'Dirham',
        //     'latin_part_name' => 'Dirham',
        // ]);
        // $defaultCurrency11 = DefaultCurrency::create([
        //     'name_ar' => 'ريال يمني',
        //     'name_en' => 'Yemen Riyal',
        //     'latin_name' => 'Yemen Riyal',
        //     'code_en' => 'YER',
        //     'code_ar' => 'ر.ي.',
        //     'proportion' => '100',
        //     'part_name_ar' => 'فلس',
        //     'part_name_en' => 'Fils',
        //     'latin_part_name' => 'Fils',
        // ]);

        // $defaultCurrency12 = DefaultCurrency::create([
        //     'name_ar' => 'جنيه مصري',
        //     'name_en' => 'Egypt Pound',
        //     'latin_name' => 'Egypt Pound',
        //     'code_en' => 'EGP',
        //     'code_ar' => 'ج.م.',
        //     'proportion' => '100',
        //     'part_name_ar' => 'قرش',
        //     'part_name_en' => 'Piastre',
        //     'latin_part_name' => 'Piastre',
        // ]);

        // $defaultCurrency13 = DefaultCurrency::create([
        //     'name_ar' => 'دينار جزائري',
        //     'name_en' => 'Algerian Dinar',
        //     'latin_name' => 'Algerian Dinar',
        //     'code_en' => 'DZD',
        //     'code_ar' => 'د.ج.',
        //     'proportion' => '100',
        //     'part_name_ar' => 'سنتيم',
        //     'part_name_en' => 'Santeem',
        //     'latin_part_name' => 'Santeem',
        // ]);

        // $defaultCurrency14 = DefaultCurrency::create([
        //     'name_ar' => 'دينار ليبي',
        //     'name_en' => 'Libyan Dinar',
        //     'latin_name' => 'Libyan Dinar',
        //     'code_en' => 'LYD',
        //     'code_ar' => 'د.ل.',
        //     'proportion' => '1000',
        //     'part_name_ar' => 'درهم',
        //     'part_name_en' => 'Dirham',
        //     'latin_part_name' => 'Dirham',
        // ]);
        // $defaultCurrency15 = DefaultCurrency::create([
        //     'name_ar' => 'شلن صومالي',
        //     'name_en' => 'Somali Shilling',
        //     'latin_name' => 'Somali Shilling',
        //     'code_en' => 'SH',
        //     'code_ar' => 'SH',
        //     'proportion' => '100',
        //     'part_name_ar' => 'سنت',
        //     'part_name_en' => 'Senti',
        //     'latin_part_name' => 'Senti',
        // ]);
        // $defaultCurrency16 = DefaultCurrency::create([
        //     'name_ar' => 'دينار تونسي',
        //     'name_en' => 'Tunisian Dinar',
        //     'latin_name' => 'Tunisian Dinar',
        //     'code_en' => 'MAD',
        //     'code_ar' => 'د.ت.',
        //     'proportion' => '100',
        //     'part_name_ar' => 'مليم',
        //     'part_name_en' => 'Millime',
        //     'latin_part_name' => 'Millime',
        // ]);
        // $defaultCurrency17 = DefaultCurrency::create([
        //     'name_ar' => 'ريال إيراني',
        //     'name_en' => 'Iranian Rial',
        //     'latin_name' => 'Iranian Rial',
        //     'code_en' => 'IRR',
        //     'code_ar' => 'ر.إ.',
        //     'proportion' => '100',
        //     'part_name_ar' => 'دينار',
        //     'part_name_en' => 'Dinar',
        //     'latin_part_name' => 'Dinar',
        // ]);
        // $defaultCurrency18 = DefaultCurrency::create([
        //     'name_ar' => 'جنيه سوداني',
        //     'name_en' => 'Sudanese pound',
        //     'latin_name' => 'Sudanese pound',
        //     'code_en' => 'SDG',
        //     'code_ar' => 'ج.س.',
        //     'proportion' => '100',
        //     'part_name_ar' => 'قرش',
        //     'part_name_en' => 'Piastre',
        //     'latin_part_name' => 'Piastre',
        // ]);

        // $defaultCurrency19 = DefaultCurrency::create([
        //     'name_ar' => 'دولار أمريكي',
        //     'name_en' => 'US Dollar',
        //     'latin_name' => 'US Dollar',
        //     'code_en' => 'SH',
        //     'code_ar' => 'SH',
        //     'proportion' => '100',
        //     'part_name_ar' => 'سنت',
        //     'part_name_en' => 'Cent',
        //     'latin_part_name' => 'Cent',
        // ]);

        // $defaultCurrency20 = DefaultCurrency::create([
        //     'name_ar' => 'يورو',
        //     'name_en' => 'Euro',
        //     'latin_name' => 'Euro',
        //     'code_en' => '€',
        //     'code_ar' => '€',
        //     'proportion' => '100',
        //     'part_name_ar' => 'سنت',
        //     'part_name_en' => 'Santه',
        //     'latin_part_name' => 'Santه',
        // ]);

        // $defaultCurrency21 = DefaultCurrency::create([
        //     'name_ar' => 'ليرة تركية',
        //     'name_en' => 'Turkish Lira',
        //     'latin_name' => 'Turkish Lira',
        //     'code_en' => '₺',
        //     'code_ar' => '₺',
        //     'proportion' => '100',
        //     'part_name_ar' => 'قرش',
        //     'part_name_en' => 'Piastre',
        //     'latin_part_name' => 'Piastre',
        // ]);
        // $defaultCurrency22 = DefaultCurrency::create([
        //     'name_ar' => 'روبل روسي',
        //     'name_en' => 'Russian Ruble',
        //     'latin_name' => 'Russian Ruble',
        //     'code_en' => '₽',
        //     'code_ar' => '₽',
        //     'proportion' => '100',
        //     'part_name_ar' => 'كوبك',
        //     'part_name_en' => 'Kopek',
        //     'latin_part_name' => 'Kopek',
        // ]);

        // $defaultCurrency23 = DefaultCurrency::create([
        //     'name_ar' => 'جنيه إسترليني',
        //     'name_en' => 'British Pound',
        //     'latin_name' => 'British Pound',
        //     'code_en' => '£',
        //     'code_ar' => '£',
        //     'proportion' => '100',
        //     'part_name_ar' => 'بنس',
        //     'part_name_en' => 'Penny',
        //     'latin_part_name' => 'Penny',
        // ]);

        // $defaultCurrency24 = DefaultCurrency::create([
        //     'name_ar' => 'راند جنوب أفريقي',
        //     'name_en' => 'South African Rand',
        //     'latin_name' => 'South African Rand',
        //     'code_en' => 'R',
        //     'code_ar' => 'R',
        //     'proportion' => '100',
        //     'part_name_ar' => 'سنت',
        //     'part_name_en' => 'Cent',
        //     'latin_part_name' => 'Cent',
        // ]);

        // $defaultCurrency25 = DefaultCurrency::create([
        //     'name_ar' => 'يوان صيني',
        //     'name_en' => 'YUAN PRC',
        //     'latin_name' => 'YUAN PRC',
        //     'code_en' => '₺',
        //     'code_ar' => '₺',
        //     'proportion' => '100',
        //     'part_name_ar' => 'سنت',
        //     'part_name_en' => 'Cent',
        //     'latin_part_name' => 'Cent',

        // ]);
    }
}
