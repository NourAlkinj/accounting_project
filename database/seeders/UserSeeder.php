<?php

namespace Database\Seeders;

use App\Models\User;
use App\Traits\User\UserTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Crypt;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{


  public function run()
  {
    // $adminUser = User::create([
    //     'code' => 'A11',
    //     'name' => 'المدير العام',
    //     'email' => 'superAdmin@gmail.com',
    //     'password' => Crypt::encryptString('12345superadmin'),
    //     'branch_id' => 1,
    //     'profile_photo_path' => null,
    //     'first_name' => 's',
    //     'middle_name' => 's',
    //     'last_name' => 's',
    //     'phone' => '09913646374',
    //     'mobile' => '0414949494',
    //     'id_number' => '001123938373774',
    //     'notes' => 'notes',
    //     'account_box_id' => 0,
    //     'store_id' => 0,
    //     'is_active' => true,
    //     'foreign_name' => 'Super Admin',
    //     'national_number' => '3456789',
    //     'address' => 'latakkia-jableh',
    //     'is_root' =>true,
    // 'security_level'=>1
    // ]);
    // $adminUser->assignRole('Admin');
    // $adminUser->givePermissionTo('update-permission');
    // $adminUser->givePermissionTo('store-user');
    // $adminUser->givePermissionTo('delete-user');
    // $adminUser->givePermissionTo('show-user');


    // $adminUser = User::create([
    //     'code' => 'A11',
    //     'name' => 'المدير العام',
    //     'email' => 'superAdmin@gmail.com',
    //     'password' => Crypt::encryptString('12345superadmin'),
    //     'branch_id' => 1,
    //     'profile_photo_path' => null,
    //     'first_name' => 's',
    //     'middle_name' => 's',
    //     'last_name' => 's',
    //     'phone' => '09913646374',
    //     'mobile' => '0414949494',
    //     'id_number' => '001123938373774',
    //     'notes' => 'notes',
    //     'account_box_id' => 0,
    //     'store_id' => 0,
    //     'is_active' => true,
    //     'foreign_name' => 'Super Admin',
    //     'national_number' => '3456789',
    //     'address' => 'latakkia-jableh',
    //     'is_root' => true,
    //   'security_level'=>1
    // ]);
    // $adminUser->assignRole('Admin');
    // // $adminUser->givePermissionTo('update-permission');
    // // $adminUser->givePermissionTo('store-user');
    // // $adminUser->givePermissionTo('delete-user');
    // // $adminUser->givePermissionTo('show-user');

    // $adminUser->givePermissionTo('store-user');
    // $adminUser->givePermissionTo('update-user');
    // $adminUser->givePermissionTo('delete-user');
    // $adminUser->givePermissionTo('show-user');
    // $adminUser->givePermissionTo('store-role');
    // $adminUser->givePermissionTo('update-role');
    // $adminUser->givePermissionTo('show-role');
    // $adminUser->givePermissionTo('delete-role');
    // $adminUser->givePermissionTo('show-permission');
    // $adminUser->givePermissionTo('store-permission');
    // $adminUser->givePermissionTo('update-permission');
    // $adminUser->givePermissionTo('delete-permission');
    // $adminUser->givePermissionTo('show-permission');
    // //-----give permissions to Manager Role-----//
    // $adminUser->givePermissionTo('store-role');
    // $adminUser->givePermissionTo('update-role');
    // $adminUser->givePermissionTo('delete-role');
    // $adminUser->givePermissionTo('show-role');
    // //-----give permissions to Owner Role-----//
    // $adminUser->givePermissionTo('store-user');
    // $adminUser->givePermissionTo('update-user');
    // $adminUser->givePermissionTo('delete-user');
    // $adminUser->givePermissionTo('show-user');
    // // user 2
    $userNoor = User::create([
      'code' => 'U2',
      'name' => 'نور الكنج',
      'email' => 'noor@gmail.com',
      'password' => Crypt::encryptString('12345noor'),
      // 'password' => '12345noor',
      'profile_photo_path' => null,
//      'branch_id' => 1,
      'first_name' => 'a',
      'middle_name' => 's',
      'last_name' => 's',
      'phone' => '09955556374',
      'mobile' => '0414949494',
      'id_number' => '001123938373774',
      'notes' => 'notes',
      // 'account_box_id' => 0,
      // 'store_id' => 0,
      'is_active' => true,
      'foreign_name' => 'Noor Al-kinj',
      'national_number' => '345675489',
      'address' => 'latakkia-jableh',
      'is_root' => false,
      'security_level' => 2
    ]);
    $userNoor->assignRole('Accountant');
    // $userNoor->assignRole('Casher');
//        $userNoor->givePermissionTo('update-role');
//        $userNoor->givePermissionTo('store-permission');

    // user 3
    $userClauda = User::create([
      'code' => 'U3',
      'name' => 'كلودا الركاد',
      'email' => "clauda@gmail.com",
      'password' => Crypt::encryptString('12345clauda'),
      'branch_id' => 2,
      'first_name' => 's',
      'profile_photo_path' => null,
      'middle_name' => 's',
      'last_name' => 's',
      'phone' => '09913646374',
      'mobile' => '0414949494',
      'id_number' => '001123938373774',
      'notes' => 'notes ',
      // 'account_box_id' => 0,
      // 'store_id' => 0,
      'is_active' => true,
      'foreign_name' => 'Clauda Al-Rakkad',
      'national_number' => '3445356789',
      'address' => 'latakkia-jableh',
      'is_root' => false,
      'security_level' => 3


    ]);
    $userClauda->assignRole('Accountant');
    $userClauda->givePermissionTo('save_branch');
    $userClauda->givePermissionTo('update_branch');


    // user 4
    $userSara = User::create([
      'code' => 'u5',
      'name' => 'سارا عبدو',
      'email' => 'sara@gmail.com',
      'password' => Crypt::encryptString('12345sara'),
      'profile_photo_path' => null,
      // 'password' => '12345sara',
      'branch_id' => 3,
      'first_name' => 'a',
      'middle_name' => 's',
      'last_name' => 's',
      'phone' => '09955556374',
      'mobile' => '0414949494',
      'id_number' => '001123938373774',
      'notes' => 'notes',
      // 'account_box_id' => 0,
      // 'store_id' => 0,
      'is_active' => true,
      'foreign_name' => 'Sara Abdo',
      'national_number' => '345346789',
      'address' => 'latakkia-jableh',
      'is_root' => false,
      'security_level' => 1


    ]);
    $userSara->assignRole('Casher');


    // user 5
    $userMohannad = User::create([
      'code' => 'z100',
      'name' => 'مهند محمود',
      'email' => 'raghad@gmail.com',
      'password' => Crypt::encryptString('12345mohannad'),
      'profile_photo_path' => null,
      'branch_id' => 4,
      'first_name' => 'a',
      'middle_name' => 's',
      'last_name' => 's',
      'phone' => '09955556374',
      'mobile' => '0414949494',
      'id_number' => '001123938373774',
      'notes' => 'notes',
      // 'account_box_id' => 0,
      // 'store_id' => 0,
      'is_active' => true,
      'foreign_name' => 'Mohannad Mahmoud',
      'national_number' => '3398765456789',
      'address' => 'latakkia-jableh',
      'is_root' => false,
      'security_level' => 1


    ]);
    $userMohannad->assignRole('Casher');
//    $userMohannad->givePermissionTo('store-user');


    // user 5
    $userAhmad = User::create([
      'code' => 'A987',
      'name' => 'أحمد علي',
      'email' => 'ahmad@gmail.com',
      'password' => Crypt::encryptString('12345ahmad'),
      'profile_photo_path' => null,
      'branch_id' => 3,
      'first_name' => 'a',
      'middle_name' => 's',
      'last_name' => 's',
      'phone' => '09955556374',
      'mobile' => '0414949494',
      'id_number' => '001123938373774',
      'notes' => 'notes',
      // 'account_box_id' => 0,
      // 'store_id' => 0,
      'is_active' => true,
      'foreign_name' => 'Ahmad Ali',
      'national_number' => '339856789',
      'address' => 'Banyas',
      'is_root' => false,
      'security_level' => 1


    ]);
    $userAhmad->assignRole('Accountant');
//    $userAhmad->givePermissionTo('store-role');
  }
}
