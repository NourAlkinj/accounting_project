<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
     
    public function run()
    {
       $category1= Category::create([
        'name'=>'category 1',
        'code'=>'11111',
        'foreign_name'=>'الصنف الأول',
        'category_id'=>null,
       ]);
       $category2= Category::create([
        'name'=>'category 2',
        'code'=>'2222222',
        'foreign_name'=>'الصنف الثاني',
        'category_id'=>null,
       ]);
       $category3= Category::create([
        'name'=>'category 3',
        'code'=>'33333333',
        'foreign_name'=>'الصنف الثالث',
        'category_id'=>1,
       ]);
       $category4= Category::create([
        'name'=>'category 4',
        'code'=>'444444',
        'foreign_name'=>'الصنف الرابع',
        'category_id'=>3,
       ]);
       $category5= Category::create([
        'name'=>'category 5',
        'code'=>'55555',
        'foreign_name'=>'الصنف الخامس',
        'category_id'=>4,
       ]);

       $category6= Category::create([
        'name'=>'category 6',
        'code'=>'666666',
        'foreign_name'=>'الصنف السادس',
        'category_id'=>5,
       ]);
    }
}
