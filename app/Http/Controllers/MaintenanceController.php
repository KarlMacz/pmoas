<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Artisan;
use Storage;

class MaintenanceController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'employees']);
    }

    public function index() {
        return view('maintenance.index', [
            'backupDatabaseFiles' => Storage::disk('database')->files(),
            'backupSystemFiles' => Storage::disk('compressed_file')->files()
        ]);
    }

    public function downloadBackupDatabase($filename) {
        return response()->download(storage_path('app/databases/' . $filename));
    }

    public function downloadBackupFile($filename) {
        return response()->download(storage_path('app/compressed_files/' . $filename));
    }

    public function postBackup(Request $request) {
        switch($request->input('id')) {
            case hash('sha256', date('Y-m-d') . '_database'):
                Artisan::call('backup:run', [
                    '--only-db' => true,
                    '--only-to-disk' => 'database'
                ]);

                break;
            case hash('sha256', date('Y-m-d') . '_files'):
                Artisan::call('backup:run', [
                    '--only-files' => true,
                    '--only-to-disk' => 'compressed_file'
                ]);

                break;
        }

        return redirect()->route('maintenance.get.index');
    }
}
