<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseController extends Controller
{

  function create($databaseName)
  {
    if (DB::statement("CREATE DATABASE IF NOT EXISTS $databaseName")) {
//      $user = auth()->user();
      $user = auth('sanctum')->user();
      $databases = $user->databases ?? [];
      $databases[] = $databaseName;
      $user->databases = $databases;
      $user->save();
      return 'Database ' . $databaseName . ' Created Successfully.';
    } else {
      return 'ERROR';
    }
  }

  public function show()
  {
//    return DB::select('SHOW DATABASES');
    $user = auth('sanctum')->user();
    $userDatabases = $user->databases;
    return response()->json(['databases' => $userDatabases]);
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
    $user = auth('sanctum')->user();
    $databases[] = $newDatabaseName;
    $user->databases = $databases;
    $user->save();

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
        "/^DB_DATABASE=.*/m",
        "DB_DATABASE=" . $newDatabaseName,
        $envContents
      );

      file_put_contents($envPath, $envContents);

    } else {
      print(env('DB_DATABASE'));
    }
//

    return $connection;
  }

  function restore($databaseName, $backupPath)
  {
    DB::statement("DROP DATABASE IF EXISTS $databaseName");
    DB::statement("CREATE DATABASE $databaseName");
    DB::statement("USE $databaseName");
    $command = "C:\xampp\mysql\bin\mysqldump -u username -p password $databaseName < $backupPath";
    exec($command);
  }

//  function backup($databaseName)
//  {
//    $backupPath = "C:\Users\asus\Desktop\Work\Palmyra API";
////        $backupPath = storage_path('app\backup') ;
//
//    // $backupPath = storage_path('backup');
//    if (!File::exists($backupPath)) {
//      File::makeDirectory($backupPath);
//    }
//    $command = "C:\xampp\mysql\bin\mysqldump -u root  $databaseName > $backupPath";
//    exec($command);
//    return "Done";
//  }


  public function runMigration()
  {
    Artisan::call('migrate');

    return 'Migrations executed successfully!';
  }

  public function runMigrationFreshSeed()
  {
    Artisan::call('migrate:fresh --seed');

    return 'Migrations - Fresh - Seed executed successfully!';
  }

  public function runMigrationFresh()
  {
    Artisan::call('migrate:fresh');

    return 'Migrations Fresh executed successfully!';
  }

  public function backupDatabase()
  {
    exec('C:\xampp\mysql\bin\mysqldump -u root -p palmyraAPI > backupe.sql 2> error.log');

    return 'Database backed up successfully!';
  }
}
