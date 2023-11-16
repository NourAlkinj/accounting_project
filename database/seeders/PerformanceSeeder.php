<?php

namespace Database\Seeders;

use App\Models\BillAdditionAndDiscount;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Item;
use App\Models\Store;
use Illuminate\Database\Seeder;
use App\Models\User;

class PerformanceSeeder extends Seeder
{

  public function run()
  {

    Store::factory()->count(1000)->create();

    Branch::factory()->count(1000)->create();

    User::factory()->count(1000)->for(
        Branch::factory()
    )->create();

    Category::factory()->count(1000)->create();
    
    Item::factory()->count(1000)->for(
      Category::factory()
    )->create();

  }
}
