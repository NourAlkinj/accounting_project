<?php

namespace Database\Seeders;

use App\Models\Serial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SerialSeeder extends Seeder
{

    public function run()
    {
        $serial1 = Serial::create([
            'code' => '0909',
            'item_id' => 1,
            'manufacture_year' => '2023',
            'color' => 'red',
            'notes' => 'notes'
        ]);
        $serial1 = Serial::create([
            'code' => '9999',
            'item_id' => 1,
            'manufacture_year' => '2023',
            'color' => 'red',
            'notes' => 'notes'
        ]);
        $serial1 = Serial::create([
            'code' => '7777',
            'item_id' => 2,
            'manufacture_year' => '2023',
            'color' => 'red',
            'notes' => 'notes'
        ]);
        $serial1 = Serial::create([
            'code' => '8888',
            'item_id' => 1,
            'manufacture_year' => '2023',
            'color' => 'red',
            'notes' => 'notes'
        ]);
        $serial1 = Serial::create([
            'code' => '5555',
            'item_id' => 3,
            'manufacture_year' => '2023',
            'color' => 'red',
            'notes' => 'notes'
        ]);
        $serial1 = Serial::create([
            'code' => '4444',
            'item_id' => 4,
            'manufacture_year' => '2023',
            'color' => 'red',
            'notes' => 'notes'
        ]);
        $serial1 = Serial::create([
            'code' => '33333',
            'item_id' => 2,
            'manufacture_year' => '2023',
            'color' => 'red',
            'notes' => 'notes'
        ]);

        $serial1 = Serial::create([
            'code' => '22222',
            'item_id' => 1,
            'manufacture_year' => '2023',
            'color' => 'red',
            'notes' => 'notes'
        ]);
    }
}
