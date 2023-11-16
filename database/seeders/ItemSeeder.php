<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{

    public function run()
    {
        $firstItem = Item::create(
            [

                'code' => '221221',
                'name' => 'item 1',
                'foreign_name' => 'المادة الأولى',
                'category_id' => 1,
                'location' => 'syria-lattakia-jableh',
                'manuf_company' => 'update',
                'country_of_origin' => 'syria',
                'source' => 'source',
                'caliber' => 'caliber',
                'chemical_composition' => 'chemical',
                'weight' => 23.23,
                'size' => 'size',
                'item_type' => 'Stock',
                'photo' => 'gbgfd',
                'notes' => 'this is first item',
                'currency_id'=>1,
                'parity'=>1,
                'auto_discount_on_salse'=>2.1,
                'added_value_tax'=>2.2,
                'auto_counting_for_prices'=>true

            ]
        );


        $secondItem = Item::create(
            [

                'code' => '234321',
                'name' => 'item 2',
                'foreign_name' => 'المادة الثانية',
                'category_id' => 2,
                'location' => 'syria-lattakia-jableh',
                'manuf_company' => 'update',
                'country_of_origin' => 'syria',
                'source' => 'source',
                'caliber' => 'caliber',
                'chemical_composition' => 'chemical',
                'weight' => 23.23,
                'size' => 'size',
                'item_type' =>'Stock',
                'photo' => 'gbgfd',
                'notes' => 'this is first item',
                'currency_id'=>2,
                'parity'=>1,
                'auto_discount_on_salse'=>3.3,
                'added_value_tax'=>5.5,
                'auto_counting_for_prices'=>true

            ]
        );
        $thirdItem = Item::create(
            [

                'code' => '121212',
                'name' => 'item 3',
                'foreign_name' => 'المادة الثالثة',
                'category_id' => 3,
                'location' => 'syria-lattakia-jableh',
                'manuf_company' => 'update',
                'country_of_origin' => 'syria',
                'source' => 'source',
                'caliber' => 'caliber',
                'chemical_composition' => 'chemical',
                'weight' => 23.23,
                'size' => 'size',
                'item_type' => 'Service',
                'photo' => 'gbgfd',
                'notes' => 'this is first item',
                'currency_id'=>3,
                'parity'=>1,
                'auto_discount_on_salse'=>8.1,
                'added_value_tax'=>2.2,
                'auto_counting_for_prices'=>true
            

            ]
        );
    }
}
