<?php

namespace Database\Seeders;

use App\Models\VoucherPermission;
use Illuminate\Database\Seeder;


class VoucherPermissionSeeder extends Seeder
{
    public function isExist($name)
    {
        $existingPermission = VoucherPermission::where([
            'name' => $name,
        ])->exists();

        if ($existingPermission)
            return true;
        return false;
    }

    public function run()
    {


        if (!$this->isExist('save')) {
            $save = VoucherPermission::create([
                'name' => 'save ',
                'caption_ar' => 'حفظ ',
                'caption_en' => 'Save',
            ]);
        }
        if (!$this->isExist('update')) {
            $update = VoucherPermission::create([
                'name' => 'update ',
                'caption_ar' => 'تعديل',
                'caption_en' => 'Update',
            ]);
        }
        if (!$this->isExist('delete')) {
            $delete = VoucherPermission::create([
                'name' => 'delete',
                'caption_ar' => 'حذف',
                'caption_en' => 'Delete',
            ]);

        }
        if (!$this->isExist('print')) {
            $delete = VoucherPermission::create([
                'name' => 'print',
                'caption_ar' => 'طباعة',
                'caption_en' => 'Print',
            ]);

        }


    }

}
