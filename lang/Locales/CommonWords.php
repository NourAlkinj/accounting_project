<?php

namespace Lang\Locales;

use Lang\interface\Words;

enum CommonWordsEnum {
case
  CODE_MUST_END_WITH_NUMBER;
case
  UPDATE;
case
  STORE;
case
  DELETE;
case
  THIS_CODE_IS_ALREADY_EXIST;
case
  CAN_NOT_DELETE_DEFAULT_VALUES;
case
  ZERO_VALUES;
case
  RESTORE;
case
  ERROR_RESTORE;
case
  FORCE_DEFLATE;
case
  UPDATE_ERROR;
case
  MAIN_BRANCH_IS_REQUIRED;
case
  DELETE_ERROR;
case
  this_abbreviation_is_already_exist;
case
  this_email_is_already_exist;
case
  this_foreign_name_is_already_exist;
case
  this_name_is_already_exist;
case
  this_code_is_already_exist;


case
  voucher_not_found;
case
  Can_not_delete_this_task;
case
  journalEntry_not_found;
case
  item_not_found;
case
  root_department_can_not_be_deleted;
case
  department_not_found;
case
  ParityCondition;
case
  category_not_found;
case
  bill_not_found;
case
  this_task_is_in_use;
case
  save;



}
class CommonWords implements Words
{
  function en(): array
  {
    return [
      'CODE_MUST_END_WITH_NUMBER' => 'Code Must be End With Number',
      'STORE' => 'Created Successfully ',
      'save' => 'Saved Successfully ',
      'UPDATE' => 'Updated Successfully',
      'DELETE' => 'deleted Successfully',
      'THIS_CODE_IS_ALREADY_EXIST' => 'This code is Already Existً',
      "CAN_NOT_DELETE_DEFAULT_VALUES" => 'Can not Delete Default Values',
      'ZERO_VALUES' => "This Value Can't Be Zero.",
      'RESTORE' => 'Restore Successfully.',
      'ERROR_RESTORE' => 'Can not be Restored.',
      'FORCE_DEFLATE' => 'Permanent Delete Done.',
      'UPDATE_ERROR' => 'Update Failed.',
      'MAIN_BRANCH_IS_REQUIRED' => 'Main Branch Is Required.',
      'DELETE_ERROR' => 'Cannot Delete Card ,Related to Other Cards.',
      'this_abbreviation_is_already_exist' => 'This abbreviation is Already Exist',
      'this_email_is_already_exist' => 'This email is Already Exist',
      'this_foreign_name_is_already_exist' => 'This foreign name is Already Exist',
      'this_name_is_already_exist' => 'This name is Already Exist',
      'this_code_is_already_exist' => 'This code is Already Exist',
      'voucher_not_found' => 'Voucher is not Found.',
      'Can_not_delete_this_task' => 'Can Not Delete This Task.',
      'journalEntry_not_found' => 'Journal Entry Is Not Found',
      'item_not_found' => 'Item Not Found',
      'root_department_can_not_be_deleted' => 'Root Department Can Not Be Deleted',
      'department_not_found' => 'Department Not Found.',
      'ParityCondition' => 'Parity Can not be 0.',
      'category_not_found' => 'Category Not Found',
      'bill_not_found' => 'Bill is not Found.',
      'this_task_is_in_use' => 'This Task Is In Use.'
    ];
  }

  function ar(): array
  {
    return [
      'CODE_MUST_END_WITH_NUMBER' => 'الرمز يجب ان ينتهي برقم',
      'STORE' => '  تم الإنشاء بنجاح',
      'UPDATE' => ' تم التعديل بنجاح ',
      'save' => '  تم الحفظ بنجاح ',
      'DELETE' => ' تم الحذف بنجاح',
      'THIS_CODE_IS_ALREADY_EXIST' => ' هذا الكود موجود سابقاً',
      "CAN_NOT_DELETE_DEFAULT_VALUES" => 'لا يمكن حذف القيم الافتراضية',
      'ZERO_VALUES' => 'لا يمكن أن تكون قيمة هذا الحقل صفرية',
      'RESTORE' => 'تم الاسترجاع بنجاح.',
      'ERROR_RESTORE' => 'لا يمكن استعادته ! ',
      'FORCE_DEFLATE' => 'تم الحذف النهائي بنجاح.',
      'UPDATE_ERROR' => 'لم يتم التعديل ',
      'MAIN_BRANCH_IS_REQUIRED' => 'يجب أن يتم إدخال الفرع الرئيسي',
      'DELETE_ERROR' => 'لا يمكن حذف بطاقة متعلقة ببطاقات أخرى',
      'this_abbreviation_is_already_exist' => ' هذا الاختصار موجود سابقاً',
      'this_foreign_name_is_already_exist' => ' هذا الاسم البديل موجود سابقاً',
      'this_email_is_already_exist' => ' هذا البريد الإلكتروني موجود سابقاً',
      'this_name_is_already_exist' => ' هذا الاسم موجود سابقاً',
      'this_code_is_already_exist' => ' هذا الكود موجود سابقاً',
      'voucher_not_found' => ' النمط غير موجود.',
      'Can_not_delete_this_task' => 'لا يمكن حذف هذه المهمة',
      'journalEntry_not_found' => 'سند القيد غير موجود.',
      'item_not_found' => 'المادة غير موجود ',
      'root_department_can_not_be_deleted' => 'القسم  الرئيسي لايحذف ',
      'department_not_found' => 'القسم غير موجود.',
      'ParityCondition' => 'التعادل لايمكن أن يكون صفر.',
      'category_not_found' => 'الصنف  غير موجود ',
      'bill_not_found' => ' الفاتورة غير موجودة.',
      'this_task_is_in_use' => 'هذه المهمة مستخدمة.'

    ];
  }

}
