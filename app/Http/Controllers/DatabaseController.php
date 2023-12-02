<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\CustomException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class DatabaseController extends Controller
{
    public $commonMessage;

    function __construct()
    {
        $this->commonMessage = new Translate(new CommonWords());
    }

    public function selectDatabase($newDatabaseName)
    {
        DB::disconnect();
        Config::set('database.mysql.database', $newDatabaseName);
        DB::reconnect();
        Config::set('database.connections.' . $newDatabaseName . '.driver', 'mysql');
        Config::set('database.connections.' . $newDatabaseName . '.host', 'localhost');
        Config::set('database.connections.' . $newDatabaseName . '.username', 'root');
        Config::set('database.connections.' . $newDatabaseName . '.password', '');
        Config::set('database.connections.' . $newDatabaseName . '.collation', 'utf8_general_ci');
        Config::set('database.connections.' . $newDatabaseName . '.charset', 'utf8');
        Config::set('database.connections.' . $newDatabaseName . '.dump', [
            'dump_binary_path' => 'C:\\xampp\\mysql\\bin',
            'use_single_transaction',
            'timeout' => 60 * 5,
        ]);
        Config::set('database.connections.' . $newDatabaseName . '.database', $newDatabaseName);
        Config::set('database.default', $newDatabaseName);
        DB::reconnect($newDatabaseName);
        $envPath = base_path('.env');
        $envContents = file_get_contents($envPath);
        $envContents = preg_replace(
            '/^DB_DATABASE=.*/m',
            'DB_DATABASE=' . $newDatabaseName,
            $envContents
        );
        file_put_contents($envPath, $envContents);


    }

    public function create($databaseName)
    {
        $lang = app('request')->header('lang');
        $exists = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$databaseName]);
        if ($exists) {
            return response()->json([
                'errors' => ['message' => $this->commonMessage->t(CommonWordsEnum::already_exist->name, $lang)],
        ], 422);
      }
        try {
            DB::statement("CREATE DATABASE IF NOT EXISTS $databaseName");

            return [
                'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang)
        ];
      } catch (CustomException $exc) {
            return response()->json(
                ['errors' => ['message' => [$exc->message]],],
                $exc->code
            );
        }
    }

    public function settingsDatabase()
    {
        $lang = app('request')->header('lang');
        DB::statement('CREATE DATABASE IF NOT EXISTS settings');
        config(['database.connections.mysql.database' => 'settings']);
        DB::reconnect('mysql');
//    DB::reconnect('settings');
        DB::statement('
          CREATE TABLE IF NOT EXISTS connections (
          id INT AUTO_INCREMENT PRIMARY KEY,

          database_information JSON,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)');
        return [
            'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang)
      ];
    }

    public function show()
    {
        return DB::select('SHOW DATABASES');
//        $user = auth('sanctum')->user();
//        $userDatabases = $user->databases;
//        return response()->json(['databases' => $userDatabases]);
    }

    public function switchDatabase($newDatabaseName)
    {
        $lang = app('request')->header('lang');
        if ($newDatabaseName == env('DB_DATABASE')) {
            return [
                'message' => $this->commonMessage->t(CommonWordsEnum::already_in_database->name, $lang) .'' . $newDatabaseName
      ];
      }

        DB::disconnect();
        Config::set('database.mysql.database', $newDatabaseName);
        DB::reconnect();
        // Default Settings
        Config::set('database.connections.' . $newDatabaseName . '.driver', 'mysql');
        Config::set('database.connections.' . $newDatabaseName . '.host', 'localhost');
        Config::set('database.connections.' . $newDatabaseName . '.username', 'root');
        Config::set('database.connections.' . $newDatabaseName . '.password', '');
        Config::set('database.connections.' . $newDatabaseName . '.collation', 'utf8_general_ci');
        Config::set('database.connections.' . $newDatabaseName . '.charset', 'utf8');
        Config::set('database.connections.' . $newDatabaseName . '.dump', [
            'dump_binary_path' => 'C:\\xampp\\mysql\\bin',
            'use_single_transaction',
            'timeout' => 60 * 5,
        ]);
        Config::set('database.connections.' . $newDatabaseName . '.database', $newDatabaseName);
        Config::set('database.default', $newDatabaseName);
        DB::reconnect($newDatabaseName);
        $envDatabaseName = env('DB_DATABASE');
//    if ($envDatabaseName !== $newDatabaseName) {
        $envPath = base_path('.env');
        $envContents = file_get_contents($envPath);
        $envContents = preg_replace(
            '/^DB_DATABASE=.*/m',
            'DB_DATABASE=' . $newDatabaseName,
            $envContents
        );
        file_put_contents($envPath, $envContents);
//    } else {
//      echo env('DB_DATABASE');
//    }
        $currentConnectionInformation = new Collection(DB::connection('mysql')->getConfig());
        DB::connection('settings')->table('connections')->insert([
            'database_information' => $currentConnectionInformation,
        ]);
        return [
            'message' => $this->commonMessage->t(CommonWordsEnum::switch_database->name, $lang)
      ];
    }

    public function runMigration()
    {
        $lang = app('request')->header('lang');
        Artisan::call('migrate');
        return [
            'message' => $this->commonMessage->t(CommonWordsEnum::command_runs_successfully->name, $lang)
      ];
    }

    public function runMigrationFreshSeed()
    {
        $lang = app('request')->header('lang');
        Artisan::call('migrate:fresh --seed');
        return [
            'message' => $this->commonMessage->t(CommonWordsEnum::command_runs_successfully->name, $lang)
      ];
    }

    public function runMigrationFresh()
    {
        $lang = app('request')->header('lang');
        Artisan::call('migrate:fresh');
        return [
            'message' => $this->commonMessage->t(CommonWordsEnum::command_runs_successfully->name, $lang)
      ];
    }

    public function backupDatabase(Request $request)
    {
        $lang = app('request')->header('lang');
        $databaseName = $request->input('database_name');
//    if ($databaseName) {
//      $this->switchDatabase($databaseName);
//    }
        $backupPath = $request->input('backup_path');
        $outputPath = $backupPath . '\backup_' . $databaseName . '_' . date('Y-m-d_H-i-s') . '.sql';
        $command = exec("mysqldump -u " . env('DB_USERNAME') . " " . $databaseName . " > {$outputPath}");
        return [
            'message' => $this->commonMessage->t(CommonWordsEnum::backup_database->name, $lang)
      ];
    }

    public function restore(Request $request)
    {
        $lang = app('request')->header('lang');
        $fileName = $request->input('file_name');
        Artisan::call('backup:restore', [
            '--filename' => $fileName,
        ]);
        return [
            'message' => $this->commonMessage->t(CommonWordsEnum::restore_database->name, $lang)
      ];
    }

    function getCurrentDatabaseInformation()
    {
        return DB::connection()->getConfig();
    }
}
