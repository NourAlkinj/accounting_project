<?php

namespace Lang\Locales;

use Lang\interface\Words;

enum ItemWordsEnum {

      case unit_not_found;
      case default_unit_can_not;
      case item_not_found;
      case first_unit_is_required;
      case conversion_factor_is_required;
      case relative_unit_is_required;
      case barcode_name_is_unique;
      case barcode_name_required;
}

class ItemWords implements Words
{

  function en(): array
  {
    return [
      'item_not_found' => 'Item Not Found.',
      'default_unit_can_not be deleted' => 'Default Unit can not be Deleted',
      'unit_not_found' => 'Unit Not Found',
      'first_unit_is_required' => 'First Unit Name Is Required',
      'conversion_factor_is_required' => 'Conversion Factor is required.',
      'relative_unit_is_required' => 'Relative Unit is Required.',
      'barcode_name_is_unique'=>'Barcode Name Is Unique ! .',
      'barcode_is_already_exist'=> 'The barcode already exists',
      'barcode_name_failed' => 'provide a value for the Barcode Name field.',
      'item_has_no_units' => 'Item Has No Units.',
      'barcode_name_required' => 'Barcode Name Required'
    ];
  }

  function ar(): array
  {
    return [
      'default_unit_can_not_be_deleted' => 'لا يمكن حذف الوحدة الافتراضية',
      'unit_not_found' => 'الوحدة غير موجود ',
      'first_unit_is_required' => 'اسم الوحدة الأولى مطلوب',
      'conversion_factor_is_required' => 'عامل التحويل مطلوب.',
      'relative_unit_is_required' => 'تبعية الوحدة مطلوبة.',
      'item_not_found' => 'المادة غير موجود.',
      'barcode_name_is_unique'=>'اسم الباركود يجب أن يكون فريد.',
//      'barcode_is_already_exist'=> 'The barcode already exists'
      'barcode_name_failed' => 'اسم الباركود غير صالح',
      'item_has_no_units' => 'المادة ليس لها وحدات.',
      'barcode_name_required' => 'اسم الباركود مطلوب'

    ];
  }

}
