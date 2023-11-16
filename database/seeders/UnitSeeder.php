<?php

namespace Database\Seeders;

use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{

  public function run()
  {
    $nuit1 = Unit::create(
      [
        'unit_name' => 'gram',
        'unit_foreign_name' => 'غرام',
        'is_default' => true,
        'item_id' => 1,

        'unit_number' => 1,
        'relative_unit' => null,
        'conversion_factor' => null,
        'prices' => [
          'consumer' => 12,
          'wholesale' => 32,
          'semi_wholesale' => 1,
          'export' => 12,
          'distributer' => 2,
          'retail' => 12,
          'last_purchase' => Carbon::parse('5-1-2021'),
        ],
      ]
    );
    $nuit2 = Unit::create(
      [
        'unit_name' => 'kilo gram',
        'unit_foreign_name' => 'كيلو غرام',
        'is_default' => true,
        'item_id' => 2,

        'unit_number' => 1,
        'conversion_factor' => 10,
        'relative_unit' => 1,
        'prices' => [
          'consumer' => 22,
          'wholesale' => 11,
          'semi_wholesale' => 12,
          'export' => 11,
          'distributer' => 2,
          'retail' => 2,
          'last_purchase' => Carbon::parse('5-4-2021'),
        ],
      ]
    );
    $nuit3 = Unit::create(
      [
        'unit_name' => 'ton',
        'unit_foreign_name' => 'طن',
        'is_default' => true,
        'item_id' => 3,

        'unit_number' => 1,
        'conversion_factor' => 10,
        'relative_unit' => 1,
        'prices' => [
          'consumer' => 44,
          'wholesale' => 21,
          'semi_wholesale' => 32,
          'export' => 21,
          'distributer' => 32,
          'retail' => 3,
          'last_purchase' => Carbon::parse('5-9-2021'),
        ],
      ]
    );
  }
}
