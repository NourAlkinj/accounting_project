<?php

namespace Database\Seeders;

use App\Models\DefaultCurrency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultCurrencySeeder extends Seeder
{

    public function run()
    {
        $defaultCurrency1 = DefaultCurrency::create([
            'name_ar' => 'ليرة سورية',
            'name_en' => 'Syrian Pound',
            'foreign_name' => 'Syrian Pound',
            'code_en' => 'SYP',
            'code_ar' => 'ل.س.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'قرش',
            'part_name_en' => 'Piastre',
            'foreign_part_name' => 'Piastre',
        ]);

        $defaultCurrency2 = DefaultCurrency::create([
            'name_ar' => 'دينار أردني',
            'name_en' => 'Jordanian Dinar',
            'foreign_name' => 'Jordanian Dinar',
            'code_en' => 'JOD',
            'code_ar' => 'د.أ.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'قرش',
            'part_name_en' => 'Piastre',
            'foreign_part_name' => 'Piastre',
        ]);
        $defaultCurrency3 = DefaultCurrency::create([
            'name_ar' => 'درهم إماراتي',
            'name_en' => 'UAE Dirham',
            'foreign_name' => 'UAE Dirham',
            'code_en' => 'AED',
            'code_ar' => 'د.هـ.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'فلس',
            'part_name_en' => 'Fils',
            'foreign_part_name' => 'Fils',
        ]);

        $defaultCurrency4 = DefaultCurrency::create([
            'name_ar' => 'ريال عماني',
            'name_en' => 'Omani Rial',
            'foreign_name' => 'Omani Rial',
            'code_en' => 'OMR',
            'code_ar' => 'ر.ع.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 1000,
            'part_name_ar' => 'بيسة',
            'part_name_en' => 'Baisa',
            'foreign_part_name' => 'Baisa',
        ]);

        $defaultCurrency5 = DefaultCurrency::create([
            'name_ar' => 'دينار كويتي',
            'name_en' => 'Kuwaiti Dinar',
            'foreign_name' => 'Kuwaiti Dinar',
            'code_en' => 'KWD',
            'code_ar' => 'د.كـ.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 1000,
            'part_name_ar' => 'فلس',
            'part_name_en' => 'Fils',
            'foreign_part_name' => 'Fils',
        ]);
        $defaultCurrency6 = DefaultCurrency::create([
            'name_ar' => 'ريال سعودي',
            'name_en' => 'Saudi Riyal',
            'foreign_name' => 'Saudi Riyal',
            'code_en' => 'SAR',
            'code_ar' => 'ر.س.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'هللة',
            'part_name_en' => 'Halalat',
            'foreign_part_name' => 'Halalat',
        ]);
        $defaultCurrency7 = DefaultCurrency::create([
            'name_ar' => 'دينار عراقي',
            'name_en' => 'Iraq Dinar',
            'foreign_name' => 'Iraq Dinar',
            'code_en' => 'IQD',
            'code_ar' => 'د.ع.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 1000,
            'part_name_ar' => 'فلس',
            'part_name_en' => 'Fils',
            'foreign_part_name' => 'Fils',
        ]);

        $defaultCurrency8 = DefaultCurrency::create([
            'name_ar' => 'ليرة لبنانية',
            'name_en' => 'Lebanon Pound',
            'foreign_name' => 'Lebanon Pound',
            'code_en' => 'LBP',
            'code_ar' => 'ل.ل.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'قرش',
            'part_name_en' => 'Piastre',
            'foreign_part_name' => 'Piastre',
        ]);

        $defaultCurrency9 = DefaultCurrency::create([
            'name_ar' => 'دينار بحريني',
            'name_en' => 'Bahraini Dinar',
            'foreign_name' => 'Bahraini Dinar',
            'code_en' => 'BHD',
            'code_ar' => 'د.ب.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 1000,
            'part_name_ar' => 'فلس',
            'part_name_en' => 'Fils',
            'foreign_part_name' => 'Fils',
        ]);

        $defaultCurrency10 = DefaultCurrency::create([
            'name_ar' => 'ريال قطري',
            'name_en' => 'Qatari Riyal',
            'foreign_name' => 'Qatari Riyal',
            'code_en' => 'QAR',
            'code_ar' => 'ر.ق.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'درهم',
            'part_name_en' => 'Dirham',
            'foreign_part_name' => 'Dirham',
        ]);
        $defaultCurrency11 = DefaultCurrency::create([
            'name_ar' => 'ريال يمني',
            'name_en' => 'Yemen Riyal',
            'foreign_name' => 'Yemen Riyal',
            'code_en' => 'YER',
            'code_ar' => 'ر.ي.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'فلس',
            'part_name_en' => 'Fils',
            'foreign_part_name' => 'Fils',
        ]);

        $defaultCurrency12 = DefaultCurrency::create([
            'name_ar' => 'جنيه مصري',
            'name_en' => 'Egypt Pound',
            'foreign_name' => 'Egypt Pound',
            'code_en' => 'EGP',
            'code_ar' => 'ج.م.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'قرش',
            'part_name_en' => 'Piastre',
            'foreign_part_name' => 'Piastre',
        ]);

        $defaultCurrency13 = DefaultCurrency::create([
            'name_ar' => 'دينار جزائري',
            'name_en' => 'Algerian Dinar',
            'foreign_name' => 'Algerian Dinar',
            'code_en' => 'DZD',
            'code_ar' => 'د.ج.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'سنتيم',
            'part_name_en' => 'Santeem',
            'foreign_part_name' => 'Santeem',
        ]);

        $defaultCurrency14 = DefaultCurrency::create([
            'name_ar' => 'دينار ليبي',
            'name_en' => 'Libyan Dinar',
            'foreign_name' => 'Libyan Dinar',
            'code_en' => 'LYD',
            'code_ar' => 'د.ل.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 1000,
            'part_name_ar' => 'درهم',
            'part_name_en' => 'Dirham',
            'foreign_part_name' => 'Dirham',
        ]);
        $defaultCurrency15 = DefaultCurrency::create([
            'name_ar' => 'شلن صومالي',
            'name_en' => 'Somali Shilling',
            'foreign_name' => 'Somali Shilling',
            'code_en' => 'SH',
            'code_ar' => 'SH',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'سنت',
            'part_name_en' => 'Senti',
            'foreign_part_name' => 'Senti',
        ]);
        $defaultCurrency16 = DefaultCurrency::create([
            'name_ar' => 'دينار تونسي',
            'name_en' => 'Tunisian Dinar',
            'foreign_name' => 'Tunisian Dinar',
            'code_en' => 'MAD',
            'code_ar' => 'د.ت.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'مليم',
            'part_name_en' => 'Millime',
            'foreign_part_name' => 'Millime',
        ]);
        $defaultCurrency17 = DefaultCurrency::create([
            'name_ar' => 'ريال إيراني',
            'name_en' => 'Iranian Rial',
            'foreign_name' => 'Iranian Rial',
            'code_en' => 'IRR',
            'code_ar' => 'ر.إ.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'دينار',
            'part_name_en' => 'Dinar',
            'foreign_part_name' => 'Dinar',
        ]);
        $defaultCurrency18 = DefaultCurrency::create([
            'name_ar' => 'جنيه سوداني',
            'name_en' => 'Sudanese pound',
            'foreign_name' => 'Sudanese pound',
            'code_en' => 'SDG',
            'code_ar' => 'ج.س.',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'قرش',
            'part_name_en' => 'Piastre',
            'foreign_part_name' => 'Piastre',
        ]);

        $defaultCurrency19 = DefaultCurrency::create([
            'name_ar' => 'دولار أمريكي',
            'name_en' => 'US Dollar',
            'foreign_name' => 'US Dollar',
            'code_en' => '$',
            'code_ar' => '$',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'سنت',
            'part_name_en' => 'Cent',
            'foreign_part_name' => 'Cent',
        ]);

        $defaultCurrency20 = DefaultCurrency::create([
            'name_ar' => 'يورو',
            'name_en' => 'Euro',
            'foreign_name' => 'Euro',
            'code_en' => '€',
            'code_ar' => '€',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'سنت',
            'part_name_en' => 'Santه',
            'foreign_part_name' => 'Santه',
        ]);

        $defaultCurrency21 = DefaultCurrency::create([
            'name_ar' => 'ليرة تركية',
            'name_en' => 'Turkish Lira',
            'foreign_name' => 'Turkish Lira',
            'code_en' => '₺',
            'code_ar' => '₺',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'قرش',
            'part_name_en' => 'Piastre',
            'foreign_part_name' => 'Piastre',
        ]);
        $defaultCurrency22 = DefaultCurrency::create([
            'name_ar' => 'روبل روسي',
            'name_en' => 'Russian Ruble',
            'foreign_name' => 'Russian Ruble',
            'code_en' => '₽',
            'code_ar' => '₽',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'كوبك',
            'part_name_en' => 'Kopek',
            'foreign_part_name' => 'Kopek',
        ]);

        $defaultCurrency23 = DefaultCurrency::create([
            'name_ar' => 'جنيه إسترليني',
            'name_en' => 'British Pound',
            'foreign_name' => 'British Pound',
            'code_en' => '£',
            'code_ar' => '£',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'بنس',
            'part_name_en' => 'Penny',
            'foreign_part_name' => 'Penny',
        ]);

        $defaultCurrency24 = DefaultCurrency::create([
            'name_ar' => 'راند جنوب أفريقي',
            'name_en' => 'South African Rand',
            'foreign_name' => 'South African Rand',
            'code_en' => 'R',
            'code_ar' => 'R',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'سنت',
            'part_name_en' => 'Cent',
            'foreign_part_name' => 'Cent',
        ]);

        $defaultCurrency25 = DefaultCurrency::create([
            'name_ar' => 'يوان صيني',
            'name_en' => 'YUAN PRC',
            'foreign_name' => 'YUAN PRC',
            'code_en' => '₺',
            'code_ar' => '₺',
            'parity' => 0,
            'equivalent' => 0,
            'proportion'  => 100,
            'part_name_ar' => 'سنت',
            'part_name_en' => 'Cent',
            'foreign_part_name' => 'Cent',

        ]);
    }
}
