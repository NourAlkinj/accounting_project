<?php

namespace Database\Seeders;

use App\Models\Barcode;
use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarcodeSeeder extends Seeder
{

    public function run()
    {
        $barcod1 = Barcode::create([
            'barcode_name' => '111',
           
            'item_id' => 1,
            'unit_id' => 1,
            'notes' => 'notes'
        ]);
        $barcod2 = Barcode::create([
            'barcode_name' => '222',
           
            'item_id' => 1,
            'unit_id' => 3,
            'notes' => 'notes'
        ]);
        $barcod3 = Barcode::create([
            'barcode_name' => '333',
          
            'item_id' => 1,
            'unit_id' => 3,
            'notes' => 'notes'
        ]);
        $barcod4 = Barcode::create([
            'barcode_name' => '444',
           
            'item_id' => 2,
            'unit_id' => 2,
            'notes' => 'notes'
        ]);
        $barcod5 = Barcode::create([
            'barcode_name' => '555',
           
            'item_id' => 3,
            'unit_id' => 3,
            'notes' => 'notes'
        ]);
    }
}
