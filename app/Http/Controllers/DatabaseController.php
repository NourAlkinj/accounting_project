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
//            $user = auth('sanctum')->user();
//            $databases = $user->databases ?? [];
//            $databases[] = $databaseName;
//            $user->databases = $databases;
//            $user->save();
//            DB::connection('settings')->table('connections')->insert([
//                'database_information' => $databaseName,
//            ]);
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

    public function switchDatabase(Request $request)
    {
        //    dd(config()->get('database.connections.mysql'));
        $newDatabaseName = $request->new_database_name;
        DB::disconnect();
        Config::set('database.mysql.database', $request->new_database_name);
        //    Config::set('database.default',$request->new_database_name);
        DB::reconnect();
        DB::purge('mysql');
//        $user = auth('sanctum')->user();
//        $databases[] = $newDatabaseName;
//        $user->databases = $databases;
//        $user->save();
        DB::purge('mysql');
        Config::set('database.connections.' . $newDatabaseName . '.driver', 'mysql');
        Config::set('database.connections.' . $newDatabaseName . '.host', 'localhost');
        Config::set('database.connections.' . $newDatabaseName . '.username', 'root');
        Config::set('database.connections.' . $newDatabaseName . '.password', '');
        Config::set('database.connections.' . $newDatabaseName . '.database', $newDatabaseName);
        Config::set('database.default', $newDatabaseName);
        DB::reconnect($newDatabaseName);
        DB::connection($newDatabaseName);
        $connection = DB::connection()->getDatabaseName();
        $envDatabaseName = env('DB_DATABASE');
        if ($envDatabaseName !== $newDatabaseName) {
            $envPath = base_path('.env');
            $envContents = file_get_contents($envPath);
            $envContents = preg_replace(
                '/^DB_DATABASE=.*/m',
                'DB_DATABASE=' . $newDatabaseName,
                $envContents
            );
            file_put_contents($envPath, $envContents);
        } else {
            echo env('DB_DATABASE');
        }
        $currentConnectionInformation = new Collection(DB::connection('mysql')->getConfig());
//        return  var_dump($currentConnectionInformation)  ;
        DB::connection('settings')->table('connections')->insert([
            'database_information' => $currentConnectionInformation,
        ]);
        return $connection;
    }

    public function restore($databaseName, $backupPath)
    {
        DB::statement("DROP DATABASE IF EXISTS $databaseName");
        DB::statement("CREATE DATABASE $databaseName");
        DB::statement("USE $databaseName");
        $command = "C:\xampp\mysql\bin\mysqldump -u username -p password $databaseName < $backupPath";
        exec($command);
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
        $backupPath = $request->input('backup_path');
        $backupLocation = $backupPath ? $backupPath : 'default_backup_path';
        $backupLocation = str_replace('\\', '\\\\', $backupLocation);
//        exec('C:\xampp\mysql\bin\mysqldump -u root -p palmyraAPI > backupe.sql 2> error.log');
        exec("C:\xampp\mysql\bin\mysqldump -u root -p palmyraAPI > $backupLocation\backup.sql 2> error.log");
        return [
            'message' => $this->commonMessage->t(CommonWordsEnum::command_runs_successfully->name, $lang)
      ];
    }

    function getCurrentDatabaseInformation()
    {
        return DB::connection()->getConfig();
    }
}
