<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
     
    public function run()
    {
        Branch::create([
            'code' => '1',
            'name' => 'الفرع الرئيسي',
            'foreign_name' => 'Main Branch',
            'branch_id' => null,
            'responsibility' => '',
            'address' => '',
            'website' => 'mainbranch.com',
            'email' => 'mainbranch@gmail.com',
            'phone' => '041877645',
            'mobile' => '0994848736',
            'is_active' => true,
            'notes' => 'notes ',
            'is_root' =>true
        ]);
        Branch::create([
            'code' => '101',
            'name' => 'الفرع 1',
            'foreign_name' => 'branch 1',
            'branch_id' => 1,
            'responsibility' => '',
            'address' => '',
            'website' => 'branch1.com',
            'email' => 'branch1@gmail.com',
            'phone' => '0412088635',
            'mobile' => '0948943236',
            'is_active' => true,
            'notes' => 'notes 1 ',
        ]);

        Branch::create([
            'code' => '102',
            'name' => 'الفرع 2',
            'foreign_name' => 'branch 2',
            'branch_id' => 2,
            'responsibility' => '',
            'address' => '',
            'website' => 'branch2.com',
            'email' => 'branch2@gmail.com',
            'phone' => '043325645',
            'mobile' => '0093648736',
            'is_active' => true,
            'notes' => 'notes 2',
        ]);
        Branch::create([
            'code' => '10101',
            'name' => 'الفرع 3 ',
            'foreign_name' => 'branch 3',
            'branch_id' => 2,
            'responsibility' => '',
            'address' => '',
            'website' => 'branch3.com',
            'email' => 'branch3@gmail.com',
            'phone' => '041878875',
            'mobile' => '09940935736',
            'is_active' => true,
            'notes' => 'notes 3',
        ]);
        Branch::create([
            'code' => 'B9',
            'name' => 'الفرع 4',
            'foreign_name' => 'branch 4',
            'branch_id' => 2,
            'responsibility' => '',
            'address' => '',
            'website' => 'branch4.com',
            'email' => 'brancwqfh4@gmail.com',
            'phone' => '041078875',
            'mobile' => '09944935736',
            'is_active' => true,
            'notes' => 'notes 4',
        ]);
        Branch::create([
            'code' => '133',
            'name' => 'الفرع 5',
            'foreign_name' => 'branch 5',
            'branch_id' => 1,
            'responsibility' => '',
            'address' => '',
            'website' => 'branch5.com',
            'email' => 'branchece5@gmail.com',
            'phone' => '04107855875',
            'mobile' => '09944449',
            'is_active' => true,
            'notes' => 'notes 5',
        ]);
        Branch::create([
            'code' => '13436',
            'name' => 'الفرع 6',
            'foreign_name' => 'branch 6',
            'branch_id' => 5,
            'responsibility' => '',
            'address' => '',
            'website' => 'branch5.com',
            'email' => 'branwdwech5@gmail.com',
            'phone' => '04107855875',
            'mobile' => '09944449',
            'is_active' => true,
            'notes' => 'notes 6 ',
        ]);
        Branch::create([
            'code' => '13336',
            'name' => 'الفرع 7',
            'foreign_name' => 'branch 7',
            'branch_id' => 5,
            'responsibility' => '',
            'address' => '',
            'website' => 'branch5.com',
            'email' => 'branvvrch5@gmail.com',
            'phone' => '04107855875',
            'mobile' => '09944449',
            'is_active' => true,
            'notes' => 'notes 7',
        ]);
        Branch::create([
            'code' => '132236',
            'name' => 'الفرع 8 ',
            'foreign_name' => 'branch 8',
            'branch_id' => 7,
            'responsibility' => '',
            'address' => '',
            'website' => 'branch5.com',
            'email' => 'branvvch5@gmail.com',
            'phone' => '04107855875',
            'mobile' => '09944449',
            'is_active' => true,
            'notes' => 'notes 8',
        ]);
        Branch::create([
            'code' => '1232336',
            'name' => 'الفرع 9',
            'foreign_name' => 'branch 9',
            'branch_id' => 7,
            'responsibility' => '',
            'address' => '',
            'website' => 'branch5.com',
            'email' => 'brancrrh5@gmail.com',
            'phone' => '04107855875',
            'mobile' => '09944449',
            'is_active' => true,
            'notes' => 'notes 9',
        ]);
        Branch::create([
            'code' => '13362332',
            'name' => 'الفرع 11',
            'foreign_name' => 'branch 11',

            'branch_id' => 9,
            'responsibility' => '',
            'address' => '',
            'website' => 'branch5.com',
            'email' => 'brarrnch5@gmail.com',
            'phone' => '04107855875',
            'mobile' => '09944449',
            'notes' => 'notes 11',
            'is_active' => true,
        ]);
        Branch::create([
            'code' => '133232036',
            'name' => 'الفرع 12',
            'foreign_name' => 'branch 12',
            'branch_id' => 9,
            'responsibility' => '',
            'address' => '',
            'website' => 'branch5.com',
            'email' => 'brranch5@gmail.com',
            'phone' => '04107855875',
            'mobile' => '09944449',
            'is_active' => true,
            'notes' => 'notes 12',
        ]);
    }
    }

