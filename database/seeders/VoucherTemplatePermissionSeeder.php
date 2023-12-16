<?php

namespace Database\Seeders;


use App\Models\VoucherTemplatePermissionUser;
use Illuminate\Database\Seeder;


class VoucherTemplatePermissionSeeder extends Seeder
{


    public function run()
    {
        VoucherTemplatePermissionUser::create([

            'user_id' => 1,
            'voucher_permission_id' => 1,
            'voucher_template_id' => 1,
        ]);


    }

}
