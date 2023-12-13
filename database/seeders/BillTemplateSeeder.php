<?php

namespace Database\Seeders;

use App\Models\BillTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillTemplateSeeder extends Seeder
{
   
    public function run()
    {
        BillTemplate::truncate();
        BillTemplate::factory(5000)->create();
    }
}
