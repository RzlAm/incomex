<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class Backup extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static string $view = 'filament.pages.backup';

    public function backupNow()
    {
        $excludedTables = [
            'cache',
            'cache_locks',
            'jobs',
            'failed_jobs',
            'job_batches',
            'migrations',
            'password_reset_tokens',
            'sessions'
        ];

        $orderedTables = [
            'categories',
            'wallets',
            'transactions',
        ];

        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');
        $tableKey = 'Tables_in_' . $dbName;

        $unorderedTables = [];
        foreach ($tables as $table) {
            $name = $table->$tableKey;
            if (!in_array($name, $excludedTables) && !in_array($name, $orderedTables)) {
                $unorderedTables[] = $name;
            }
        }

        $allTables = array_merge($orderedTables, $unorderedTables);
        $sql = "-- Incomex Backup - Generated on " . now() . "\n\n";

        foreach ($allTables as $tableName) {
            if (in_array($tableName, $excludedTables)) continue;

            $sql .= "DELETE FROM `$tableName`;\n";

            $rows = DB::table($tableName)->get();
            if ($rows->isEmpty()) continue;

            foreach ($rows as $row) {
                $columns = array_map(fn($v) => "`$v`", array_keys((array) $row));
                $values = array_map(function ($v) {
                    if (is_null($v)) return 'NULL';
                    $v = str_replace("'", "''", $v);
                    return "'" . $v . "'";
                }, array_values((array) $row));

                $sql .= "INSERT INTO `$tableName` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ");\n";
            }
            $sql .= "\n";
        }

        $fileName = 'Incomex_Backup_' . now()->format('Ymd_His') . '.sql';
        $filePath = storage_path("app/$fileName");

        File::put($filePath, $sql);

        return Response::download($filePath)->deleteFileAfterSend(true);
    }
}
