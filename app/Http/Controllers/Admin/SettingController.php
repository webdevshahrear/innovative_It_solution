<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Manually group settings by prefix (contact_, social_) since there's no group column
        $allSettings = SiteSetting::all();
        
        $settings = [
            'contact' => $allSettings->filter(function($setting) {
                return str_starts_with($setting->setting_key, 'contact_');
            }),
            'social' => $allSettings->filter(function($setting) {
                return str_starts_with($setting->setting_key, 'social_');
            }),
        ];
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
