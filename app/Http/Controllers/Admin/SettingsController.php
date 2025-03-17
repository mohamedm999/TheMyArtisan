<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        // Fetch settings from database
        $settingsCollection = DB::table('settings')->get();

        // Convert to key-value array
        $settings = [];
        foreach ($settingsCollection as $setting) {
            $settings[$setting->key] = $setting->value;
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'site_description' => 'required|string',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
        ]);

        // Update each setting in the database
        foreach ($validatedData as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now()]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully');
    }
}
