<?php

namespace Database\Seeders;

use App\Models\BillPermission;

use Illuminate\Database\Seeder;


class BillPermissionSeeder extends Seeder
{
    public function isExist($name)
    {
        $existingPermission = BillPermission::where([
            'name' => $name,
        ])->exists();

        if ($existingPermission)
            return true;
        return false;
    }

    public function run()
    {


        if (!$this->isExist('save')) {
            $save = BillPermission::create([
                'name' => 'BillPermission ',
                'caption_ar' => 'حفظ ',
                'caption_en' => 'Save',
            ]);
        }
        if (!$this->isExist('update')) {
            $update = BillPermission::create([
                'name' => 'update ',
                'caption_ar' => 'تعديل',
                'caption_en' => 'Update',
            ]);
        }
        if (!$this->isExist('delete')) {
            $delete = BillPermission::create([
                'name' => 'delete',
                'caption_ar' => 'حذف',
                'caption_en' => 'Delete',
            ]);

        }
        if (!$this->isExist('print')) {
            $delete = BillPermission::create([
                'name' => 'print',
                'caption_ar' => 'طباعة',
                'caption_en' => 'Print',
            ]);

        }


    }

}
