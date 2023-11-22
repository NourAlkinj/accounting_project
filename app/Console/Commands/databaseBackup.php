<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class databaseBackup extends Command
{

    protected $signature = 'database:backups';


    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filename = "backups-" . Carbon::now()->format('Y-m-d') . ".gz";

        $command = "C:\\xampp\\mysql\\bin\\mysqldump --user="
            . env('DB_USERNAME') . " --password="
            . env('DB_PASSWORD') . " --host="
            . env('DB_HOST') . " "
            . env('DB_DATABASE') . "  | gzip > " .
            storage_path() . "/app/backups/" . $filename;

        $returnVar = NULL;
        $output = NULL;

        exec($command, $output, $returnVar);
    }
//    public function handle()
//    {
//        return Command::SUCCESS;
//    }
}
