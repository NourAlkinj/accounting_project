<?php

namespace Database\Seeders;

use App\Models\JournalEntry;
use Carbon\Carbon;
use Database\Factories\JournalEntryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JournalEntrySeeder extends Seeder
{

    public function run()
    {
        JournalEntryFactory::new();
    }
}
