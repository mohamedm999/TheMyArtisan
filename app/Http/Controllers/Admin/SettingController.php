<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_description' => 'nullable|string',
            'maintenance_mode' => 'nullable|boolean',
            'booking_fee_percentage' => 'required|numeric|min:0|max:100',
            'site_logo' => 'nullable|image|max:2048',
        ]);

        foreach ($validatedData as $key => $value) {
            if ($key === 'site_logo' && $request->hasFile('site_logo')) {
                $path = $request->file('site_logo')->store('logos', 'public');
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $path]
                );
            } elseif ($key !== 'site_logo') {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }

        // Toggle maintenance mode if needed
        if (isset($validatedData['maintenance_mode'])) {
            if ($validatedData['maintenance_mode']) {
                Artisan::call('down');
            } else {
                Artisan::call('up');
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    public function backupIndex()
    {
        $backups = Storage::disk('backup')->files();
        return view('admin.settings.backup', compact('backups'));
    }

    public function createBackup()
    {
        // Create a database backup
        $filename = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
        $command = "mysqldump -u " . env('DB_USERNAME') . " -p" . env('DB_PASSWORD') . " " . env('DB_DATABASE') . " > " . storage_path('app/backup/') . $filename;

        exec($command);

        return redirect()->route('admin.backup')
            ->with('success', 'Database backup created successfully.');
    }

    public function downloadBackup($filename)
    {
        return Storage::disk('backup')->download($filename);
    }
}
