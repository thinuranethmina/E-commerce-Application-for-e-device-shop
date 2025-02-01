<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DatabaseBackup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DatabaseBackup::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('file_name', 'LIKE', '%' . $search . '%');
            });
        }

        $backups = $query->orderBy('id', 'desc')->paginate(15);
        return view('backend.pages.backup.index', compact('backups'));
    }

    public function create()
    {
        $backupDirectory = storage_path('app/backup');
        if (!is_dir($backupDirectory)) {
            mkdir($backupDirectory, 0775, true);
        }

        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');

        $gzip_file_name = $database . '_backup_' . date('Y-m-d_H-i-s') . '.sql.gz';
        $gzip_file_path = $backupDirectory . "/" . $gzip_file_name;

        $backup_cmd = "mysqldump --user=$username --password=$password --host=$host --port=$port --single-transaction --quick --lock-tables=false $database | gzip > $gzip_file_path";

        exec($backup_cmd, $output, $result);

        if ($result) {
            Log::error("Backup failed for user: " . implode("\n", $output));
            throw new \Exception('Database backup failed.');
        }

        DatabaseBackup::create([
            'file_name' => $gzip_file_name,
        ]);
        return $this->index(new Request());
    }

    public function store()
    {
        if ((date('H') == 0 && (date('i') >= 0 || date('i') < 5)) || (date('H') == 12 && (date('i') >= 0 || date('i') < 5))) {
            $backupDirectory = storage_path('app/backup');
            if (!is_dir($backupDirectory)) {
                mkdir($backupDirectory, 0775, true);
            }

            $host = env('DB_HOST');
            $port = env('DB_PORT');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $database = env('DB_DATABASE');

            $gzip_file_name = $database . '_backup_' . date('Y-m-d_H-i-s') . '.sql.gz';
            $gzip_file_path = $backupDirectory . "/" . $gzip_file_name;

            $backup_cmd = "mysqldump --user=$username --password=$password --host=$host --port=$port --single-transaction --quick --lock-tables=false $database | gzip > $gzip_file_path";

            exec($backup_cmd, $output, $result);

            if ($result) {
                Log::error("Backup failed for user: " . implode("\n", $output));
                throw new \Exception('Database backup failed.');
            }

            DatabaseBackup::create([
                'file_name' => $gzip_file_name,
            ]);

            return true;
        }
    }

    public function download($id)
    {
        $backup = DatabaseBackup::findOrFail($id);

        $filePath = 'backup/' . $backup->file_name;

        $fullPath = Storage::path($filePath);
        Log::info("Looking for file at: " . $fullPath);

        if (!Storage::exists($filePath)) {
            abort(404);
        }

        return Storage::download($filePath);
    }
}
