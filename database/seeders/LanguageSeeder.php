<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{

    public function run()
    {
      $defaultLang = Language::create([
        'lang' => 'en',

      ]);
    }
}
