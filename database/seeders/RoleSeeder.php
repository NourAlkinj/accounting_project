<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Crypt;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{

    public function run()
    {
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleAccoutant = Role::create(['name' => 'Accountant']);
        $roleCasher = Role::create(['name' => 'Casher']);

        //-----give permissions to Admin Role-----//

//        $roleAdmin->givePermissionTo('store-user');
//        $roleAdmin->givePermissionTo('update-user');
//        $roleAdmin->givePermissionTo('delete-user');
//        $roleAdmin->givePermissionTo('show-user');
//        $roleAdmin->givePermissionTo('store-role');
//        $roleAdmin->givePermissionTo('update-role');
//        $roleAdmin->givePermissionTo('show-role');
//        $roleAdmin->givePermissionTo('delete-role');
//        $roleAdmin->givePermissionTo('show-permission');
//        $roleAdmin->givePermissionTo('store-permission');
//        $roleAdmin->givePermissionTo('update-permission');
//        $roleAdmin->givePermissionTo('delete-permission');
//        $roleAdmin->givePermissionTo('show-permission');
        //-----give permissions to Manager Role-----//
//        $roleAccoutant->givePermissionTo('store-role');
//        $roleAccoutant->givePermissionTo('update-role');
//        $roleAccoutant->givePermissionTo('delete-role');
//        $roleAccoutant->givePermissionTo('show-role');
        //-----give permissions to Owner Role-----//
//        $roleCasher->givePermissionTo('store-user');
//        $roleCasher->givePermissionTo('update-user');
//        $roleCasher->givePermissionTo('delete-user');
//        $roleCasher->givePermissionTo('show-user');
        //-----give permissions to User Role-----//


        $adminUser = User::create([
            'code' => 'A11',
            'name' => 'المدير العام',
            'email' => 'superAdmin@gmail.com',
            'password' => Crypt::encryptString('12345superadmin'),
            'branch_id' => 1,
            'profile_photo_path' => null,
            'first_name' => 's',
            'middle_name' => 's',
            'last_name' => 's',
            'phone' => '09913646374',
            'mobile' => '0414949494',
            'id_number' => '001123938373774',
            'notes' => 'notes',
            // 'account_box_id' => 0,
            // 'store_id' => 0,
            'is_active' => true,
            'foreign_name' => 'Super Admin',
            'national_number' => '3456789',
            'address' => 'latakkia-jableh',
            'is_root' => true,
            'security_level'=>1
        ]);

      $allPermissions = Permission::all();
      foreach ($allPermissions as $permission) {
        $adminUser->givePermissionTo($permission['name']);
                $roleAdmin->givePermissionTo($permission['name']);

      }

        $adminUser->assignRole('Admin');
        //permission Branch
//         $adminUser->givePermissionTo('save_branch');
//         $adminUser->givePermissionTo('update_branch');
//         $adminUser->givePermissionTo('delete_branch');
//         $adminUser->givePermissionTo('update_main_branch');
//         $adminUser->givePermissionTo('update_branch_name');
//         $adminUser->givePermissionTo('update_branch_code');
//         $adminUser->givePermissionTo('update_branch_foreign_name');
//         $adminUser->givePermissionTo('update_branch_activation');
//        //permission User
//        $adminUser->givePermissionTo('save_user');
//        $adminUser->givePermissionTo('update_user');
//        $adminUser->givePermissionTo('delete_user');
//        $adminUser->givePermissionTo('update_user_main_branch');
//        $adminUser->givePermissionTo('update_user_name');
//        $adminUser->givePermissionTo('update_user_code');
//        $adminUser->givePermissionTo('update_user_foreign_name');
//        $adminUser->givePermissionTo('update_user_activation');
//        //permission Store
//        $adminUser->givePermissionTo('save_store');
//        $adminUser->givePermissionTo('update_store');
//        $adminUser->givePermissionTo('delete_store');
//        $adminUser->givePermissionTo('update_main_store');
//        $adminUser->givePermissionTo('update_store_name');
//        $adminUser->givePermissionTo('update_store_code');
//        $adminUser->givePermissionTo('update_store_foreign_name');
//        //permission CostCenter
//        $adminUser->givePermissionTo('save_costCenter');
//        $adminUser->givePermissionTo('update_costCenter');
//        $adminUser->givePermissionTo('delete_costCenter');
//        $adminUser->givePermissionTo('update_main_costCenter');
//        $adminUser->givePermissionTo('update_costCenter_name');
//        $adminUser->givePermissionTo('update_costCenter_code');
//        $adminUser->givePermissionTo('update_costCenter_foreign_name');
//        //permission Currency
//        $adminUser->givePermissionTo('save_currency');
//        $adminUser->givePermissionTo('update_currency');
//        $adminUser->givePermissionTo('delete_currency');
//        $adminUser->givePermissionTo('update_currency_name');
//        $adminUser->givePermissionTo('update_currency_code');
//        $adminUser->givePermissionTo('update_currency_foreign_name');
//        $adminUser->givePermissionTo('update_currency_part_name');
//        $adminUser->givePermissionTo('update_currency_foreign_part_name');
//        $adminUser->givePermissionTo('update_currency_value_of_part');
//        $adminUser->givePermissionTo('update_currency_parity');
//        $adminUser->givePermissionTo('update_currency_decimal_places');
//        $adminUser->givePermissionTo('update_currency_exchange_rate_reminder');
//        //permission Account
//        $adminUser->givePermissionTo('save_account');
//        $adminUser->givePermissionTo('update_account');
//        $adminUser->givePermissionTo('delete_account');
//        $adminUser->givePermissionTo('update_main_account');
//        $adminUser->givePermissionTo('update_account_name');
//        $adminUser->givePermissionTo('update_account_code');
//        $adminUser->givePermissionTo('update_account_foreign_name');
//        $adminUser->givePermissionTo('update_final_account');
//        $adminUser->givePermissionTo('update_result_account');
//        //permission Category
//        $adminUser->givePermissionTo('save_category');
//        $adminUser->givePermissionTo('update_category');
//        $adminUser->givePermissionTo('delete_category');
//        $adminUser->givePermissionTo('update_main_category');
//        $adminUser->givePermissionTo('update_category_name');
//        $adminUser->givePermissionTo('update_category_code');
//        $adminUser->givePermissionTo('update_category_foreign_name');
//        //permission Item
//        $adminUser->givePermissionTo('save_item');
//        $adminUser->givePermissionTo('update_item');
//        $adminUser->givePermissionTo('delete_item');
//        $adminUser->givePermissionTo('update_item_main_category');
//        $adminUser->givePermissionTo('update_item_name');
//        $adminUser->givePermissionTo('update_item_code');
//        $adminUser->givePermissionTo('update_item_foreign_name');
//        //permission Department
//        $adminUser->givePermissionTo('save_department');
//        $adminUser->givePermissionTo('update_department');
//        $adminUser->givePermissionTo('delete_department');
//        $adminUser->givePermissionTo('update_main_department');
//        $adminUser->givePermissionTo('update_department_name');
//        $adminUser->givePermissionTo('update_department_code');
//        $adminUser->givePermissionTo('update_department_foreign_name');
//        $adminUser->givePermissionTo('update_department_branch');
//        //permission Employee
//        $adminUser->givePermissionTo('save_employee');
//        $adminUser->givePermissionTo('update_employee');
//        $adminUser->givePermissionTo('delete_employee');
//        $adminUser->givePermissionTo('update_employee_main_department');
//        $adminUser->givePermissionTo('update_employee_name');
//        $adminUser->givePermissionTo('update_employee_code');
//        $adminUser->givePermissionTo('update_employee_foreign_name');
//



    }


}
