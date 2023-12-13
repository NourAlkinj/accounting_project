<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    public function run()
    {
        // Store::create([
        //     'code' => '1',
        //     'name' => 'المستودع الرئيسي 1',
        //     'foreign_name' => 'Main Normal store 1',
        //     'card_type' => 0,
        //     'store_id' => null,
        //     'assembly_normal_ids' => null,
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Ahmad',
        //     'storage_capacity' => 11,
        //     'is_normal' => true,
        //     'is_assembly' => false,
        //     'notes' => 'notes ',
        // ]);
        // Store::create([
        //     'code' => '2',
        //     'name' => 'المستودع الرئيسي 2',
        //     'foreign_name' => 'Main Normal store 2',
        //     'card_type' => 0,
        //     'store_id' => null,
        //     'assembly_normal_ids' => null,
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Ali',
        //     'storage_capacity' => 11,
        //     'is_normal' => true,
        //     'is_assembly' => false,
        //     'notes' => 'notes ',
        // ]);
        // Store::create([
        //     'code' => '3',
        //     'name' => 'المستودع الفرعي 1',
        //     'foreign_name' => 'Sub Normal store 1',
        //     'card_type' => 0,
        //     'store_id' => 1,
        //     'assembly_normal_ids' => null,
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Clauda',
        //     'storage_capacity' => 11,
        //     'is_normal' => true,
        //     'is_assembly' => false,
        //     'notes' => 'notes ',
        // ]);
        // Store::create([
        //     'code' => '4',
        //     'name' => 'المستودع الفرعي 2',
        //     'foreign_name' => 'Sub Normal store 2',
        //     'card_type' => 0,
        //     'store_id' => 3,
        //     'assembly_normal_ids' => null,
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Nour',
        //     'storage_capacity' => 11,
        //     'is_normal' => true,
        //     'is_assembly' => false,
        //     'notes' => 'notes ',
        // ]);
        // Store::create([
        //     'code' => '5',
        //     'name' => 'المستودع الفرعي 3',
        //     'foreign_name' => 'Sub Normal store 3',
        //     'card_type' => 0,
        //     'store_id' => 3,
        //     'assembly_normal_ids' => null,
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Sara',
        //     'storage_capacity' => 11,
        //     'is_normal' => true,
        //     'is_assembly' => false,
        //     'notes' => 'notes ',
        // ]);

        // Store::create([
        //     'code' => '55',
        //     'name' => 'المستودع الفرعي 33',
        //     'foreign_name' => 'Sub Normal store 33',
        //     'card_type' => 0,
        //     'store_id' => 5,
        //     'assembly_normal_ids' => null,
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Sara',
        //     'storage_capacity' => 11,
        //     'is_normal' => true,
        //     'is_assembly' => false,
        //     'notes' => 'notes ',
        // ]);

        // Store::create([
        //     'code' => '115',
        //     'name' => 'المستودع الفرعي 3331',
        //     'foreign_name' => 'Sub Normal store 3331',
        //     'card_type' => 0,
        //     'store_id' => 5,
        //     'assembly_normal_ids' => null,
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Sara',
        //     'storage_capacity' => 11,
        //     'is_normal' => true,
        //     'is_assembly' => false,
        //     'notes' => 'notes ',
        // ]);


        // Store::create([
        //     'code' => '6',
        //     'name' => 'المستودع الفرعي 4',
        //     'foreign_name' => 'Sub Normal store 4',
        //     'card_type' => 0,
        //     'store_id' => 1,
        //     'assembly_normal_ids' => null,
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Obai',
        //     'storage_capacity' => 11,
        //     'is_normal' => true,
        //     'is_assembly' => false,
        //     'notes' => 'notes ',
        // ]);
        // Store::create([
        //     'code' => '7',
        //     'name' => 'المستودع الفرعي 5',
        //     'foreign_name' => 'Sub Normal store 5',
        //     'card_type' => 0,
        //     'store_id' => 6,
        //     'assembly_normal_ids' => null,
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Aleen',
        //     'storage_capacity' => 11,
        //     'is_normal' => true,
        //     'is_assembly' => false,
        //     'notes' => 'notes ',
        // ]);
        // Store::create([
        //     'code' => '8',
        //     'name' => 'المستودع الفرعي 6',
        //     'foreign_name' => 'Sub Normal store 6',
        //     'card_type' => 0,
        //     'store_id' => 2,
        //     'assembly_normal_ids' => null,
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Zikra',
        //     'storage_capacity' => 11,
        //     'is_normal' => true,
        //     'is_assembly' => false,
        //     'notes' => 'notes ',
        // ]);
        // Store::create([
        //     'code' => '9',
        //     'name' => 'المستودع الفرعي 7',
        //     'foreign_name' => 'Sub Normal store 7',
        //     'card_type' => 0,
        //     'store_id' => 2,
        //     'assembly_normal_ids' => null,
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Karam',
        //     'storage_capacity' => 11,
        //     'is_normal' => true,
        //     'is_assembly' => false,
        //     'notes' => 'notes ',
        // ]);
        // Store::create([
        //     'code' => '10',
        //     'name' => 'المستودع التجميعي الأول',
        //     'foreign_name' => 'Assembly Store 1',
        //   'card_type' => 1,
        //     'store_id' => null,
        //     'assembly_normal_ids' => [['id' => 10], ['id' => 11]],
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Alaa',
        //     'storage_capacity' => 11,
        //     'is_normal' => false,
        //     'is_assembly' => true,
        //     'notes' => 'notes ',
        // ]);
        // Store::create([
        //     'code' => '11',
        //     'name' => 'المستودع التجميعي الثاني',
        //     'foreign_name' => 'Assembly Store 2',
        //     'card_type' => 1,
        //     'store_id' => null,
        //     'assembly_normal_ids' => [['id' => 7]],
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Taim',
        //     'storage_capacity' => 11,
        //     'is_normal' => false,
        //     'is_assembly' => true,
        //     'notes' => 'notes ',
        // ]);
        // Store::create([
        //     'code' => '12',
        //     'name' => 'المستودع التجميعي الثالث',
        //     'foreign_name' => 'Assembly Store 3',
        //     'card_type' => 1,
        //     'store_id' => null,
        //     'assembly_normal_ids' => [['id' => 4], ['id' => 7], ['id' => 8]],
        //     'address' => 'Lattakia-jableh',
        //     'store_keeper' => 'Leen',
        //     'storage_capacity' => 11,
        //     'is_normal' => false,
        //     'is_assembly' => true,
        //     'notes' => 'notes ',
        // ]);

        // Store::factory()->count(10)->for(
        //     Store::factory()->state([
        //         'is_normal' => true
        //     ])
        // )->create();

        Store::truncate();
        Store::factory(15000)->create();

    }

}
