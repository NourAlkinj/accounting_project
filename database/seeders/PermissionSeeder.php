<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
  public function isExist($name)
  {
      $existingPermission = Permission::where([
        'name' => $name,
      ])->exists();

      if($existingPermission)
        return true;
    return false;
  }

  public function run()
  {
    $seeder = new PermissionGroupSeeder();
    $seeder->run();
//---------------Branch--------------------------
    if (!$this->isExist('save_branch'))
    {
      $saveBranch = Permission::create([
        'name' => 'save_branch',
        'permission_group_id' => 1,
        'caption_ar' => 'حفظ فرع  ',
        'caption_en' => 'Save Branch ',
      ]);
    }
    if (!$this->isExist('update_branch'))
    {
      $updateBranch = Permission::create([
        'name' => 'update_branch',
        'permission_group_id' => 1,
        'caption_ar' => 'تعديل فرع  ',
        'caption_en' => 'Update Branch',
      ]);
    }
    if (!$this->isExist('delete_branch'))
    {
      $deleteBranch = Permission::create([
        'name' => 'delete_branch',
        'permission_group_id' => 1,
        'caption_ar' => 'حذف فرع  ',
        'caption_en' => 'Delete Branch',
      ]);

    }
    if (!$this->isExist('update_main_branch'))
    {
      $updateMainBranch = Permission::create([
        'name' => 'update_main_branch',
        'permission_group_id' => 1,
        'caption_ar' => 'تعديل الفرع الرئيسي ',
        'caption_en' => 'Update Main Branch',
      ]);
    }
    if (!$this->isExist('update_branch_name'))
    {
      $updateBranchName = Permission::create([
        'name' => 'update_branch_name',
        'permission_group_id' => 1,
        'caption_ar' => 'تعديل اسم الفرع ',
        'caption_en' => 'Update Branch Name',
      ]);
    }
    if (!$this->isExist('update_branch_code'))
    {
      $updateBranchCode = Permission::create([
        'name' => 'update_branch_code',
        'permission_group_id' => 1,
        'caption_ar' => 'تعديل كود الفرع',
        'caption_en' => 'Update Branch Code',
      ]);
    }
    if (!$this->isExist('update_branch_foreign_name'))
    {
      $updateBranchForeignName = Permission::create([
        'name' => 'update_branch_foreign_name',
        'permission_group_id' => 1,
        'caption_ar' => 'تعديل الاسم الأجنبي للفرع ',
        'caption_en' => 'Update Branch Foreign Name',
      ]);
    }
    if (!$this->isExist('update_branch_activation'))
    {
      $updateBranchActivation = Permission::create([
        'name' => 'update_branch_activation',
        'permission_group_id' => 1,
        'caption_ar' => 'تعديل تنشيط الفرع ',
        'caption_en' => 'Update Branch Activation',
      ]);
    }
//---------------User--------------------------
    if (!$this->isExist('save_user'))
    {
      $saveUser = Permission::create([
        'name' => 'save_user',
        'permission_group_id' => 2,
        'caption_ar' => 'حفظ مستخدم  ',
        'caption_en' => 'Save User',
      ]);
    }
    if (!$this->isExist('update_user'))
    {
      $updateUser = Permission::create([
        'name' => 'update_user',
        'permission_group_id' => 2,
        'caption_ar' => 'تعديل مستخدم  ',
        'caption_en' => 'Update User',
      ]);
    }
    if (!$this->isExist('delete_user'))
    {
      $deleteUser = Permission::create([
        'name' => 'delete_user',
        'permission_group_id' => 2,
        'caption_ar' => 'حذف مستخدم  ',
        'caption_en' => 'Delete User',
      ]);
    }
    if (!$this->isExist('update_user_main_branch'))
    {
      $updateUserMainBranch = Permission::create([
        'name' => 'update_user_main_branch',
        'permission_group_id' => 2,
        'caption_ar' => 'تعديل الفرع الرئيسي للمستخدم ',
        'caption_en' => 'Update User Main Branch',
      ]);
    }
    if (!$this->isExist('update_user_name'))
    {
      $updateUserName = Permission::create([
        'name' => 'update_user_name',
        'permission_group_id' => 2,
        'caption_ar' => 'تعديل اسم المستخدم',
        'caption_en' => 'Update User Name',
      ]);
    }
    if (!$this->isExist('update_user_code'))
    {
      $updateUserCode = Permission::create([
        'name' => 'update_user_code',
        'permission_group_id' => 2,
        'caption_ar' => ' تعديل كود المستخدم ',
        'caption_en' => 'Update User Code',
      ]);
    }
    if (!$this->isExist('update_user_foreign_name'))
    {
      $updateUserForeignName = Permission::create([
        'name' => 'update_user_foreign_name',
        'permission_group_id' => 2,
        'caption_ar' => 'تعديل الاسم الأجنبي للمستخدم ',
        'caption_en' => 'Update User Foreign Name',
      ]);
    }
    if (!$this->isExist('update_user_activation'))
    {
      $updateUserActivation = Permission::create([
        'name' => 'update_user_activation',
        'permission_group_id' => 2,
        'caption_ar' => 'تعديل تنشيط االمستخدم ',
        'caption_en' => 'Update User Activation',
      ]);
    }
//---------------Store--------------------------
    if (!$this->isExist('save_store'))
    {
      $saveStore = Permission::create([
        'name' => 'save_store',
        'permission_group_id' => 3,
        'caption_ar' => 'حفظ مستودع  ',
        'caption_en' => 'Save Store',
      ]);
    }
    if (!$this->isExist('update_store'))
    {
      $updateStore = Permission::create([
        'name' => 'update_store',
        'permission_group_id' => 3,
        'caption_ar' => 'تعديل مستودع  ',
        'caption_en' => 'Update Store',
      ]);
    }
    if (!$this->isExist('delete_store'))
    {
      $deleteStore = Permission::create([
        'name' => 'delete_store',
        'permission_group_id' => 3,
        'caption_ar' => 'حذف مستودع  ',
        'caption_en' => 'Delete Store',
      ]);
    }
    if (!$this->isExist('update_main_store'))
    {
      $updateMainStore = Permission::create([
        'name' => 'update_main_store',
        'permission_group_id' => 3,
        'caption_ar' => 'تعديل المستودع الرئيسي ',
        'caption_en' => 'Update Main Store',
      ]);
    }
    if (!$this->isExist('update_store_name'))
    {
      $updateStoreName = Permission::create([
        'name' => 'update_store_name',
        'permission_group_id' => 3,
        'caption_ar' => 'تعديل اسم المستودع ',
        'caption_en' => 'Update Store Name',
      ]);
    }
    if (!$this->isExist('update_store_code'))
    {
      $updateStoreCode = Permission::create([
        'name' => 'update_store_code',
        'permission_group_id' => 3,
        'caption_ar' => 'تعديل كود المسودع',
        'caption_en' => 'Update Store Code',
      ]);
    }
    if (!$this->isExist('update_store_foreign_name'))
    {
      $updateStoreForeignName = Permission::create([
        'name' => 'update_store_foreign_name',
        'permission_group_id' => 3,
        'caption_ar' => 'تعديل الاسم الأجنبي للمستودع ',
        'caption_en' => 'Update Store Foreign Name',
      ]);
    }
//---------------CostCenter--------------------------
    if (!$this->isExist('save_costCenter'))
    {
      $saveCostCenter = Permission::create([
        'name' => 'save_costCenter',
        'permission_group_id' => 4,
        'caption_ar' => 'حفظ مركز الكلفة  ',
        'caption_en' => 'Save CostCenter',
      ]);
    }
    if (!$this->isExist('update_costCenter'))
    {
      $updateCostCenter = Permission::create([
        'name' => 'update_costCenter',
        'permission_group_id' => 4,
        'caption_ar' => 'تعديل مركز الكلفة  ',
        'caption_en' => 'Update CostCenter',
      ]);
    }
    if (!$this->isExist('delete_costCenter'))
    {
      $deleteCostCenter = Permission::create([
        'name' => 'delete_costCenter',
        'permission_group_id' => 4,
        'caption_ar' => 'حذف مركز الكلفة  ',
        'caption_en' => 'Delete CostCenter',
      ]);
    }
    if (!$this->isExist('update_main_costCenter'))
    {
      $updateMainCostCenter = Permission::create([
        'name' => 'update_main_costCenter',
        'permission_group_id' => 4,
        'caption_ar' => 'تعديل مركز الكلفة الرئيسي ',
        'caption_en' => 'Update Main CostCenter',
      ]);
    }
    if (!$this->isExist('update_costCenter_name'))
    {
      $updateCostCenterName = Permission::create([
        'name' => 'update_costCenter_name',
        'permission_group_id' => 4,
        'caption_ar' => 'تعديل اسم مركز الكلفة ',
        'caption_en' => 'Update CostCenter Name',
      ]);
    }
    if (!$this->isExist('update_costCenter_code'))
    {
      $updateCostCenterCode = Permission::create([
        'name' => 'update_costCenter_code',
        'permission_group_id' => 4,
        'caption_ar' => ' تعديل كود مركز الكلفة',
        'caption_en' => 'Update CostCenter Code',
      ]);
    }
    if (!$this->isExist('update_costCenter_foreign_name'))
    {
      $updateCostCenterForeignName = Permission::create([
        'name' => 'update_costCenter_foreign_name',
        'permission_group_id' => 4,
        'caption_ar' => 'تعديل الاسم الأجنبي لمركز الكلفة',
        'caption_en' => 'Update CostCenter Foreign Name',
      ]);
    }
//---------------Currency--------------------------
    if (!$this->isExist('save_currency'))
    {
      $saveCurrency = Permission::create([
        'name' => 'save_currency',
        'permission_group_id' => 5,
        'caption_ar' => 'حفظ العملة   ',
        'caption_en' => 'Save Currency',
      ]);
    }
    if (!$this->isExist('update_currency'))
    {
      $updateCurrency = Permission::create([
        'name' => 'update_currency',
        'permission_group_id' => 5,
        'caption_ar' => 'تعديل العملة   ',
        'caption_en' => 'Update Currency',
      ]);
    }
    if (!$this->isExist('delete_currency'))
    {
      $deleteCurrency = Permission::create([
        'name' => 'delete_currency',
        'permission_group_id' => 5,
        'caption_ar' => 'حذف العملة   ',
        'caption_en' => 'Delete Currency',
      ]);
    }
    if (!$this->isExist('update_currency_name'))
    {
      $updateCurrencyName = Permission::create([
        'name' => 'update_currency_name',
        'permission_group_id' => 5,
        'caption_ar' => 'تعديل اسم العملة ',
        'caption_en' => 'Update Currency Name',
      ]);
    }
    if (!$this->isExist('update_currency_code'))
    {
      $updateCurrencyCode = Permission::create([
        'name' => 'update_currency_code',
        'permission_group_id' => 5,
        'caption_ar' => 'تعديل كود العملة',
        'caption_en' => 'Update Currency Code',
      ]);
    }
    if (!$this->isExist('update_currency_foreign_name'))
    {
      $updateCurrencyForeignName = Permission::create([
        'name' => 'update_currency_foreign_name',
        'permission_group_id' => 5,
        'caption_ar' => 'تعديل الاسم الأجنبي للعملة ',
        'caption_en' => 'Update Currency Foreign Name',
      ]);
    }
    if (!$this->isExist('update_currency_part_name'))
    {
      $updateCurrencyPartName = Permission::create([
        'name' => 'update_currency_part_name',
        'permission_group_id' => 5,
        'caption_ar' => 'تعديل الاسم الجزئي للعملة ',
        'caption_en' => 'Update Currency Part Name',
      ]);
    }
    if (!$this->isExist('update_currency_foreign_part_name'))
    {
      $updateCurrencyForeignPartName = Permission::create([
        'name' => 'update_currency_foreign_part_name',
        'permission_group_id' => 5,
        'caption_ar' => 'تعديل الاسم الجزئي الأجنبي للعملة ',
        'caption_en' => 'Update Currency Foreign Part Name',
      ]);
    }
    if (!$this->isExist('update_currency_value_of_part'))
    {
      $updateCurrencyValueOfPart = Permission::create([
        'name' => 'update_currency_value_of_part',
        'permission_group_id' => 5,
        'caption_ar' => 'تعديل قيمة الجزء للعملة ',
        'caption_en' => 'Update Currency Value Of Part',
      ]);
    }
    if (!$this->isExist('update_currency_parity'))
    {
      $updateCurrencyParity = Permission::create([
        'name' => 'update_currency_parity',
        'permission_group_id' => 5,
        'caption_ar' => 'تعديل تكافؤ العملة ',
        'caption_en' => 'Update Currency Parity',
      ]);
    }
    if (!$this->isExist('update_currency_decimal_places'))
    {
      $updateCurrencyDecimalPlaces = Permission::create([
        'name' => 'update_currency_decimal_places',
        'permission_group_id' => 5,
        'caption_ar' => 'تعديل قيمة المنازل العشرية للعملة ',
        'caption_en' => 'Update Currency Decimal Places',
      ]);
    }
    if (!$this->isExist('update_currency_exchange_rate_reminder'))
    {
      $updateCurrencyExchangeRateReminder = Permission::create([
        'name' => 'update_currency_exchange_rate_reminder',
        'permission_group_id' => 5,
        'caption_ar' => 'تعديل تذكير سعر الصرف للعملة ',
        'caption_en' => 'Update Currency Exchange Rate Reminder',
      ]);
    }
//--------------Account---------------------------
    if (!$this->isExist('save_account'))
    {
      $saveAccount = Permission::create([
        'name' => 'save_account',
        'permission_group_id' => 6,
        'caption_ar' => 'حفظ الحساب   ',
        'caption_en' => 'Save Account',
      ]);
    }
    if (!$this->isExist('update_account'))
    {
      $updateAccount = Permission::create([
        'name' => 'update_account',
        'permission_group_id' => 6,
        'caption_ar' => 'تعديل الحساب   ',
        'caption_en' => 'Update Account',
      ]);
    }
    if (!$this->isExist('delete_account'))
    {
      $deleteAccount = Permission::create([
        'name' => 'delete_account',
        'permission_group_id' => 6,
        'caption_ar' => 'حذف الحساب   ',
        'caption_en' => 'Delete Account',
      ]);
    }
    if (!$this->isExist('update_main_account'))
    {
      $updateMainAccount = Permission::create([
        'name' => 'update_main_account',
        'permission_group_id' => 6,
        'caption_ar' => 'تعديل الحساب الرئيسي ',
        'caption_en' => 'Update Main Account',
      ]);
    }
      if (!$this->isExist('update_account_name'))
      {
        $updateAccountName = Permission::create([
          'name' => 'update_account_name',
          'permission_group_id' => 6,
          'caption_ar' => 'تعديل اسم الحساب ',
          'caption_en' => 'Update Account Name',
        ]);
    }
    if (!$this->isExist('update_account_code'))
    {
      $updateAccountCode = Permission::create([
        'name' => 'update_account_code',
        'permission_group_id' => 6,
        'caption_ar' => 'تعديل كود الحساب',
        'caption_en' => 'Update Account Code',
      ]);
    }
    if (!$this->isExist('update_account_foreign_name'))
    {
      $updateAccountForeignName = Permission::create([
        'name' => 'update_account_foreign_name',
        'permission_group_id' => 6,
        'caption_ar' => 'تعديل الاسم الأجنبي للحساب ',
        'caption_en' => 'Update Account Foreign Name',
      ]);
    }
    if (!$this->isExist('update_final_account'))
    {
      $updateFinalAccount = Permission::create([
        'name' => 'update_final_account',
        'permission_group_id' => 6,
        'caption_ar' => 'تعديل الحساب النهائي ',
        'caption_en' => 'Update Final Account',
      ]);
    }
    if (!$this->isExist('update_result_account'))
    {
      $updateResultAccount = Permission::create([
        'name' => 'update_result_account',
        'permission_group_id' => 6,
        'caption_ar' => 'تعديل حساب النتيجة ',
        'caption_en' => 'Update Result Account',
      ]);
    }
//--------------Category---------------------------
    if (!$this->isExist('save_category'))
    {
      $saveCategory = Permission::create([
        'name' => 'save_category',
        'permission_group_id' => 7,
        'caption_ar' => 'حفظ الصنف   ',
        'caption_en' => 'Save Category',
      ]);
    }
    if (!$this->isExist('update_category'))
    {
      $updateCategory = Permission::create([
        'name' => 'update_category',
        'permission_group_id' => 7,
        'caption_ar' => 'تعديل الصنف   ',
        'caption_en' => 'Update Category',
      ]);
    }
    if (!$this->isExist('delete_category'))
    {
      $deleteCategory = Permission::create([
        'name' => 'delete_category',
        'permission_group_id' => 7,
        'caption_ar' => 'حذف الصنف   ',
        'caption_en' => 'Delete Category',
      ]);
    }
    if (!$this->isExist('update_main_category'))
    {
      $updateMainCategory = Permission::create([
        'name' => 'update_main_category',
        'permission_group_id' => 7,
        'caption_ar' => 'تعديل الصنف الرئيسي ',
        'caption_en' => 'Update Main Category',
      ]);
    }
    if (!$this->isExist('update_category_name'))
    {
      $updateCategoryName = Permission::create([
        'name' => 'update_category_name',
        'permission_group_id' => 7,
        'caption_ar' => 'تعديل اسم الصنف ',
        'caption_en' => 'Update Category Name',
      ]);
    }
    if (!$this->isExist('update_category_code'))
    {
      $updateCategoryCode = Permission::create([
        'name' => 'update_category_code',
        'permission_group_id' => 7,
        'caption_ar' => 'تعديل كود الصنف',
        'caption_en' => 'Update Category Code',
      ]);
    }
    if (!$this->isExist('update_category_foreign_name'))
    {
      $updateCategoryForeignName = Permission::create([
        'name' => 'update_category_foreign_name',
        'permission_group_id' => 7,
        'caption_ar' => 'تعديل الاسم الأجنبي للصنف ',
        'caption_en' => 'Update Category Foreign Name',
      ]);
    }
//-----------------Item------------------------
    if (!$this->isExist('save_item'))
    {
      $saveItem = Permission::create([
        'name' => 'save_item',
        'permission_group_id' => 8,
        'caption_ar' => 'حفظ المادة   ',
        'caption_en' => 'Save Item',
      ]);
    }
    if (!$this->isExist('update_item'))
    {
      $updateItem = Permission::create([
        'name' => 'update_item',
        'permission_group_id' => 8,
        'caption_ar' => 'تعديل المادة ',
        'caption_en' => 'Update Item',
      ]);
    }
    if (!$this->isExist('delete_item'))
    {
      $deleteItem = Permission::create([
        'name' => 'delete_item',
        'permission_group_id' => 8,
        'caption_ar' => 'حذف المادة   ',
        'caption_en' => 'Delete Item',
      ]);
    }
    if (!$this->isExist('update_item_main_category'))
    {
      $updateItemMainCategory = Permission::create([
        'name' => 'update_item_main_category',
        'permission_group_id' => 8,
        'caption_ar' => 'تعديل الصنف الرئيسي للمادة ',
        'caption_en' => 'Update Item Main Category',
      ]);
    }
    if (!$this->isExist('update_item_name'))
    {
      $updateItemName = Permission::create([
        'name' => 'update_item_name',
        'permission_group_id' => 8,
        'caption_ar' => 'تعديل اسم المادة ',
        'caption_en' => 'Update Item Name',
      ]);
    }
    if (!$this->isExist('update_item_code'))
    {
      $updateItemCode = Permission::create([
        'name' => 'update_item_code',
        'permission_group_id' => 8,
        'caption_ar' => 'تعديل كود المادة',
        'caption_en' => 'Update Item Code',
      ]);
    }
    if (!$this->isExist('update_item_foreign_name'))
    {
      $updateItemForeignName = Permission::create([
        'name' => 'update_item_foreign_name',
        'permission_group_id' => 8,
        'caption_ar' => 'تعديل الاسم الأجنبي للمادة ',
        'caption_en' => 'Update Item Foreign Name',
      ]);
    }
//-----------------Department------------------------
    if (!$this->isExist('save_department'))
    {
      $saveDepartment = Permission::create([
        'name' => 'save_department',
        'permission_group_id' => 9,
        'caption_ar' => 'حفظ القسم   ',
        'caption_en' => 'Save Department',
      ]);
    }
    if (!$this->isExist('update_department'))
    {
      $updateDepartment = Permission::create([
        'name' => 'update_department',
        'permission_group_id' => 9,
        'caption_ar' => 'تعديل القسم   ',
        'caption_en' => 'Update Department',
      ]);
    }
    if (!$this->isExist('delete_department'))
    {
      $deleteDepartment = Permission::create([
        'name' => 'delete_department',
        'permission_group_id' => 9,
        'caption_ar' => 'حذف القسم   ',
        'caption_en' => 'Delete Department',
      ]);
    }
    if (!$this->isExist('update_main_department'))
    {
      $updateMainDepartment = Permission::create([
        'name' => 'update_main_department',
        'permission_group_id' => 9,
        'caption_ar' => 'تعديل القسم الرئيسي ',
        'caption_en' => 'Update Main Department',
      ]);
    }
    if (!$this->isExist('update_department_name'))
    {
      $updateDepartmentName = Permission::create([
        'name' => 'update_department_name',
        'permission_group_id' => 9,
        'caption_ar' => 'تعديل اسم القسم ',
        'caption_en' => 'Update Department Name',
      ]);
    }
    if (!$this->isExist('update_department_code'))
    {
      $updateDepartmentCode = Permission::create([
        'name' => 'update_department_code',
        'permission_group_id' => 9,
        'caption_ar' => ' تعديل كود القسم ',
        'caption_en' => 'Update Department Code',
      ]);
    }
    if (!$this->isExist('update_department_foreign_name'))
    {
      $updateDepartmentForeignName = Permission::create([
        'name' => 'update_department_foreign_name',
        'permission_group_id' => 9,
        'caption_ar' => 'تعديل الاسم الأجنبي للقسم ',
        'caption_en' => 'Update Department Foreign Name',
      ]);
    }
    if (!$this->isExist('update_department_branch'))
    {
      $updateDepartmentBranch = Permission::create([
        'name' => 'update_department_branch',
        'permission_group_id' => 9,
        'caption_ar' => 'تعديل فرع القسم ',
        'caption_en' => 'Update Department Branch',
      ]);
    }
//-----------------Employee------------------------
    if (!$this->isExist('save_employee'))
    {
      $saveEmployee = Permission::create([
        'name' => 'save_employee',
        'permission_group_id' => 10,
        'caption_ar' => 'حفظ موظف   ',
        'caption_en' => 'Save Employee',
      ]);
    }
    if (!$this->isExist('update_employee'))
    {
      $updateEmployee = Permission::create([
        'name' => 'update_employee',
        'permission_group_id' => 10,
        'caption_ar' => 'تعديل الموظف   ',
        'caption_en' => 'Update Employee',
      ]);
    }
    if (!$this->isExist('delete_employee'))
    {
      $deleteEmployee = Permission::create([
        'name' => 'delete_employee',
        'permission_group_id' => 10,
        'caption_ar' => 'حذف الموظف   ',
        'caption_en' => 'Delete Employee',
      ]);
    }
    if (!$this->isExist('update_employee_main_department'))
    {
      $updateEmployeeMainDepartment = Permission::create([
        'name' => 'update_employee_main_department',
        'permission_group_id' => 10,
        'caption_ar' => 'تعديل القسم الرئيسي للموظف ',
        'caption_en' => 'Update Employee Main Department',
      ]);
    }
    if (!$this->isExist('update_employee_name'))
    {
      $updateEmployeeName = Permission::create([
        'name' => 'update_employee_name',
        'permission_group_id' => 10,
        'caption_ar' => 'تعديل اسم الموظف ',
        'caption_en' => 'Update Employee Name',
      ]);
    }
    if (!$this->isExist('update_employee_code'))
    {
      $updateEmployeeCode = Permission::create([
        'name' => 'update_employee_code',
        'permission_group_id' => 10,
        'caption_ar' => 'تعديل كود الموظف',
        'caption_en' => 'Update Employee Code',
      ]);
    }
    if(!$this->isExist('update_employee_foreign_name'))
    {
      $updateEmployeeForeignName = Permission::create([
        'name' => 'update_employee_foreign_name',
        'permission_group_id' => 10,
        'caption_ar' => 'تعديل الاسم الأجنبي للموظف ',
        'caption_en' => 'Update Employee Foreign Name',
      ]);
    }
  }
}
