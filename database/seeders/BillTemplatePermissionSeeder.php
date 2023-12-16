<?php

namespace Database\Seeders;


use App\Models\BillTemplatePermissionUser;

use Illuminate\Database\Seeder;


class BillTemplatePermissionSeeder extends Seeder
{


    public function run()
    {
        BillTemplatePermissionUser::create([
            'user_id' => 1,
            'bill_permission_id' => 1,
            'bill_template_id' => 1,
        ]);


    }

}
