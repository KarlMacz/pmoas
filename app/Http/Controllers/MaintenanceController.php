<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Storage;

class MaintenanceController extends Controller
{
    public function __construct()
    {
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
        return redirect()->back();
        
        switch($request->input('id')) {
            case hash('sha256', date('Y-m-d') . '_database'):
                break;
            case hash('sha256', date('Y-m-d') . '_files'):
                break;
            default:
                return redirect()->back();

                break;
        }
    }
}
