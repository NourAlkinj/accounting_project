<?php


namespace App\Traits\ActivityLog;

use App\Models\Activity;
use App\Models\Trash;

trait  ActivityLog
{
  public function makeActivity($activity)
  {
    if ($activity['method'] == 'update') {
      Activity::create([
        'table' => $activity['table'],
        'table_id' => $activity['parameters']['id'],
        'user_id' => auth('sanctum')->user()->id,
        'description_ar' => $activity['parameters']['description_ar'],
        'description_en' => $activity['parameters']['description_en'],
        'table_name' => $activity['parameters']['name'],
        'operation_ar' => $activity['parameters']['operation_ar'],
        'operation_en' => $activity['parameters']['operation_en'],
        'mac' => $activity['parameters']['mac'],
        'pc_name' => $activity['parameters']['pc_name'],
        'old_data' => $activity['parameters']['old_data'],
        'branch_id' => auth('sanctum')->user()->branch_id,
      ]);
    } elseif ($activity['method'] == 'delete') {
      Trash::create([
        'table' => $activity['table'],
        'user_id' => auth('sanctum')->user()->id,
        'table_id' => $activity['parameters']['id'],

      ]);
      Activity::create([
        'table' => $activity['table'],
        'user_id' => auth('sanctum')->user()->id,
        'branch_id' => auth('sanctum')->user()->branch_id,
        'table_id' => $activity['parameters']['id'],
        'description_ar' => $activity['parameters']['description_ar'],
        'description_en' => $activity['parameters']['description_en'],
        'table_name' => $activity['parameters']['name'],
        'operation_ar' => $activity['parameters']['operation_ar'],
        'operation_en' => $activity['parameters']['operation_en'],
        'mac' => $activity['parameters']['mac'],
        'pc_name' => $activity['parameters']['pc_name'],
      ]);
    } else
      Activity::create([
        'table' => $activity['table'],
        'user_id' => auth('sanctum')->user() ? auth('sanctum')->user()->id : $activity['parameters']['id'],
        'branch_id' => auth('sanctum')->user() ? auth('sanctum')->user()->branch_id : null,
        'table_id' => $activity['parameters']['id'],
        'description_ar' => $activity['parameters']['description_ar'],
        'description_en' => $activity['parameters']['description_en'],
        'table_name' => $activity['parameters']['name'],
        'operation_ar' => $activity['parameters']['operation_ar'],
        'operation_en' => $activity['parameters']['operation_en'],
        'mac' => $activity['parameters']['mac'],
        'pc_name' => $activity['parameters']['pc_name'],

      ]);

  }


  public function getOperation($method)
  {
    $operation_en = '';
    $operation_ar = '';
    if ($method == 'store') {
      $operation_en = 'Created';
      $operation_ar = 'تم إنشاء';
    }
    if ($method == 'login') {
      $operation_en = 'Logged In';
      $operation_ar = 'تسجيل الدخول من قبل';
    }
    if ($method == 'logout') {

      $operation_en = 'Log Out';
      $operation_ar = 'تسجيل الخروج من قبل';
    }
    if ($method == 'update') {

      $operation_en = 'Updated';
      $operation_ar = 'تم تعديل';
    }
    if ($method == 'delete') {

      $operation_en = 'Deleted';
      $operation_ar = 'تم حذف';
    }
    if ($method == 'generated') {

      $operation_en = 'Generated';
      $operation_ar = 'تم توليد';
    }
    if ($method == 'post') {

      $operation_en = 'Posted';
      $operation_ar = 'تم إرسال';
    }
    return [$operation_ar, $operation_en];
  }


  public function getTable($lang, $model)
  {
    $table = '';
    if ($model == 'user') {
      $table = $lang == 'en' ? 'User' : 'المستخدم';
    }
    if ($model == 'branch') {
      $table = $lang == 'en' ? 'Branch' : 'الفرع';
    }
    if ($model == 'account') {
      $table = $lang == 'en' ? 'Account' : 'الحساب';
    }
    if ($model == 'bill') {
      $table = $lang == 'en' ? 'Bill' : 'الفاتورة';
    }
    if ($model == 'category') {
      $table = $lang == 'en' ? 'Category' : 'الصنف';
    }
    if ($model == 'client') {
      $table = $lang == 'en' ? 'Client' : 'الزبون';
    }
    if ($model == 'costCenter') {
      $table = $lang == 'en' ? 'Cost Center' : 'مركز الكلفة';
    }
    if ($model == 'currency') {
      $table = $lang == 'en' ? 'Currency' : 'العملة';
    }
    if ($model == 'department') {
      $table = $lang == 'en' ? 'Department' : 'القسم';
    }
    if ($model == 'employee') {
      $table = $lang == 'en' ? 'Employee' : 'الموظف';
    }
    if ($model == 'task') {
      $table = $lang == 'en' ? 'Task' : 'المهمة';
    }
    if ($model == 'item') {
      $table = $lang == 'en' ? 'Item' : 'المادة';
    }
    if ($model == 'journalEntry') {
      $table = $lang == 'en' ? 'Journal Entry' : 'السند';
    }
    if ($model == 'voucher') {
      $table = $lang == 'en' ? 'Voucher' : 'القيد';
    }
    if ($model == 'report') {
      $table = $lang == 'en' ? 'Report' : 'التقرير';
    }
    if ($model == 'settings') {
      $table = $lang == 'en' ? 'Settings' : 'الإعدادات';
    }
    return $table;
  }

  public function getDiscriptionEn($operation_en, $model, $element)
  {
    $code = $element->code ? $element->code : null;
    $name = $element->foreign_name ? $element->foreign_name : null;
    $number = $element->number ? $element->number : null;
    $table = $this->getTable('en', $model);
    $discription = $table . ' ' . $code . ' ' . $name . ' ' . $number . ' ' . $operation_en . ' Successfully. ';
    return $discription;
  }

  public function getDiscriptionAr($operation_ar, $model, $element)
  {
    $code = $element->code ? $element->code : null;
    $name = $element->name ? $element->name : null;
    $number = $element->number ? $element->number : null;
    $table = $this->getTable('ar', $model);
    $discription = $operation_ar . ' ' . $table . ' ' . $name . ' ' . $code . ' ' . ' بنجاح ';
    return $discription;
  }

  public function getLogs()
  {
    return Activity::all();
  }

}
