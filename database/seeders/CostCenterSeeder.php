<?php

namespace Database\Seeders;

use App\Models\CostCenter;
use Illuminate\Database\Seeder;

class CostCenterSeeder extends Seeder
{
    public function run()
    {
        CostCenter::create([
            'code' => '011',
            'name' => 'مركز الكلفة 1',
            'foreign_name' => 'Cost Center 1',
            'is_normal' => true,
            'card_type' => 0,
            'is_assembly' => false,
            'cost_center_id' => null,
            'assembly_normal_ids' => null,
            'balance' => 0,
            'credit' => null,
            'debit' => null,
            'notes' => null,
        ]);
        CostCenter::create([
            'code' => '012',
            'name' => 'مركز الكلفة 2',
            'foreign_name' => 'Cost Center 2',
            'is_normal' => true,
            'card_type' => 0,
            'is_assembly' => false,
            'cost_center_id' => 1,
            'assembly_normal_ids' => null,
            'balance' => 0,
            'credit' => null,
            'debit' => null,
            'notes' => null,
        ]);

        CostCenter::create([
            'code' => '013',
            'name' => 'مركز الكلفة 3',
            'foreign_name' => 'Cost Center 3',
            'is_normal' => true,
            'card_type' => 0,
            'is_assembly' => false,
            'cost_center_id' => 2,
            'assembly_normal_ids' => null,
            'balance' => 0,
            'credit' => null,
            'debit' => null,
            'notes' => null,
        ]);

        CostCenter::create([
            'code' => '014',
            'name' => 'مركز الكلفة 4',
            'foreign_name' => 'Cost Center 4',
            'is_normal' => true,
            'card_type' => 0,
            'is_assembly' => false,
            'cost_center_id' => 1,
            'assembly_normal_ids' => null,
            'balance' => 0,
            'credit' => null,
            'debit' => null,
            'notes' => null,
        ]);

        CostCenter::create([
            'code' => '015',
            'name' => 'مركز الكلفة 5',
            'foreign_name' => 'Cost Center 5',
            'is_normal' => true,
            'card_type' => 0,
            'is_assembly' => false,
            'cost_center_id' => 4,
            'assembly_normal_ids' => null,
            'balance' => 0,
            'credit' => null,
            'debit' => null,
            'notes' => null,
        ]);
        CostCenter::create([
            'code' => '016',
            'name' => 'مركز الكلفة 6',
            'foreign_name' => 'Cost Center 6',
            'is_normal' => true,
            'card_type' => 0,
            'is_assembly' => false,
            'cost_center_id' => 5,
            'assembly_normal_ids' => null,
            'balance' => 0,
            'credit' => null,
            'debit' => null,
            'notes' => null,
        ]);

        CostCenter::create([
            'code' => '0166',
            'name' => 'مركز الكلفة التجميعي 1',
            'foreign_name' => 'Assembly Cost Center 1',
            'card_type' => 1,
            'is_normal' => false,
            'is_assembly' => true,
            'cost_center_id' => null,
            'assembly_normal_ids' => [['id' => 3]],
            'balance' => 0,
            'credit' => null,
            'debit' => null,
            'notes' => null,
        ]);
        CostCenter::create([
            'code' => '0167',
            'name' => 'مركز الكلفة التجميعي 2',
            'foreign_name' => 'Assembly Cost Center 2',
            'is_normal' => false,
            'is_assembly' => true,
            'card_type' => 1,
            'cost_center_id' => null,
            'assembly_normal_ids' => [['id' => 3], ['id' => 5]],
            'balance' => 0,
            'credit' => null,
            'debit' => null,
            'notes' => null,
        ]);
    }


}
