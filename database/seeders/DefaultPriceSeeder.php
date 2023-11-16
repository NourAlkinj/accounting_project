<?php

namespace Database\Seeders;

use App\Models\DefaultPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultPrice1 = DefaultPrice::create([
            'name_ar' => 'بدون',
            'name_en' => 'None',
            'caption_ar' => 'بدون',
            'caption_en' => 'None',
            'type' => 'none'
        ]);
        $defaultPrice2 = DefaultPrice::create([
            'name_ar' => 'آخر شراء',
            'name_en' => 'Last Purchase',
            'caption_ar' => 'آخر شراء',
            'caption_en' => 'Last Purchase',
            'type' => 'last_purchase'
        ]);
        $defaultPrice3 = DefaultPrice::create([
            'name_ar' => 'الجملة',
            'name_en' => 'wholesale',
            'caption_ar' => 'الجملة',
            'caption_en' => 'wholesale',
            'type' => 'wholesale'
        ]);
        $defaultPrice4 = DefaultPrice::create([
            'name_ar' => 'نصف الجملة',
            'name_en' => 'Semi wholesale',
            'caption_ar' => 'نصف الجملة',
            'caption_en' => 'Semi wholesale',
            'type' => 'semi_wholesale'
        ]);
        $defaultPrice5 = DefaultPrice::create([
            'name_ar' => 'التصدير',
            'name_en' => 'Export',
            'caption_ar' => 'التصدير',
            'caption_en' => 'Export',
            'type' => 'export'
        ]);
        $defaultPrice6 = DefaultPrice::create([
            'name_ar' => 'الموزع',
            'name_en' => 'Distributer',
            'caption_ar' => 'الموزع',
            'caption_en' => 'Distributer',
            'type' => 'distributer'
        ]);
        $defaultPrice7 = DefaultPrice::create([
            'name_ar' => 'المفرق',
            'name_en' => 'Retail ',
            'caption_ar' => 'المفرق',
            'caption_en' => 'Retail',
            'type' => 'retail'
        ]);
        $defaultPrice8 = DefaultPrice::create([
            'name_ar' => 'المستهلك',
            'name_en' => 'Consumer ',
            'caption_ar' => 'المستهلك',
            'caption_en' => 'Consumer',
            'type' => 'consumer'
        ]);
        $defaultPrice9 = DefaultPrice::create([
            'name_ar' => 'آخر مبيع للزبون ',
            'name_en' => 'Last customer price',
            'caption_ar' => 'آخر مبيع للزبون',
            'caption_en' => 'Last customer price',
            'type' => 'last_customer_price'
        ]);
        $defaultPrice10 = DefaultPrice::create([
            'name_ar' => 'سعر بطاقة الزبون ',
            'name_en' => 'Customer price',
            'caption_ar' => 'سعر بطاقة الزبون',
            'caption_en' => 'Customer price',
            'type' => 'customer_price'
        ]);
        $defaultPrice11 = DefaultPrice::create([
            'name_ar' => 'آخر شراء مع الحسميات والإضافات',
            'name_en' => 'Last price with discount and addition',
            'caption_ar' => 'آخر شراء مع الحسميات والإضافات',
            'caption_en' => 'Last price with discount and addition',
            'type' => 'last_price_with_discount_and_addition'
        ]);
    }
}
