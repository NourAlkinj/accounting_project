<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
  public function isExist($name)
  {
    $existingPermissionGroup = PermissionGroup::where([
      'name' => $name,
    ])->exists();

    if($existingPermissionGroup)
      return true;
    return false;
  }

    public function run()
    {
      if (!$this->isExist('branch_permissions'))
      {
        $branchPermissionGroup = PermissionGroup::create([
          'name' => 'branch_permissions',
          'caption_ar' => 'صلاحيات الأفرع',
          'caption_en' => 'Branch Permissions ',
        ]);
      }
      if (!$this->isExist('user_permissions'))
      {
        $userPermissionGroup = PermissionGroup::create([
          'name' => 'user_permissions',
          'caption_ar' => 'صلاحيات المستخدمين',
          'caption_en' => 'User Permissions ',
        ]);
      }
      if (!$this->isExist('store_permissions'))
      {
        $storePermissionGroup = PermissionGroup::create([
          'name' => 'store_permissions',
          'caption_ar' => 'صلاحيات المستودعات',
          'caption_en' => 'Store Permissions ',
        ]);
      }
      if (!$this->isExist('costCenter_permissions'))
      {
        $costCenterPermissionGroup = PermissionGroup::create([
          'name' => 'costCenter_permissions',
          'caption_ar' => 'صلاحيات مراكز الكلفة',
          'caption_en' => 'CostCenter Permissions ',
        ]);
      }
      if (!$this->isExist('currency_permissions'))
      {
        $currencyPermissionGroup = PermissionGroup::create([
          'name' => 'currency_permissions',
          'caption_ar' => 'صلاحيات العملات',
          'caption_en' => 'Currency Permissions ',
        ]);
      }
      if (!$this->isExist('account_permissions'))
      {
        $accountPermissionGroup = PermissionGroup::create([
          'name' => 'account_permissions',
          'caption_ar' => 'صلاحيات الحسابات',
          'caption_en' => 'Account Permissions ',
        ]);
      }
      if (!$this->isExist('category_permissions'))
      {
        $categoryPermissionGroup = PermissionGroup::create([
          'name' => 'category_permissions',
          'caption_ar' => 'صلاحيات الأصناف',
          'caption_en' => 'Category Permissions ',
        ]);
      }
      if (!$this->isExist('item_permissions'))
      {
        $itemPermissionGroup = PermissionGroup::create([
          'name' => 'item_permissions',
          'caption_ar' => 'صلاحيات المواد ',
          'caption_en' => 'Item Permissions ',
        ]);
      }
      if (!$this->isExist('department_permissions'))
      {
        $departmentPermissionGroup = PermissionGroup::create([
          'name' => 'department_permissions',
          'caption_ar' => 'صلاحيات الأقسام ',
          'caption_en' => 'Department Permissions ',
        ]);
      }
      if (!$this->isExist('employee_permissions'))
      {
        $employeePermissionGroup = PermissionGroup::create([
          'name' => 'employee_permissions',
          'caption_ar' => 'صلاحيات الموظفين ',
          'caption_en' => 'Employee Permissions ',
        ]);
      }
    }
}
