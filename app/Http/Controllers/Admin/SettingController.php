<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $allSettings = SiteSetting::all()->pluck('setting_value', 'setting_key');
        return view('admin.settings.index', compact('allSettings'));
    }

    public function update(Request $request)
    {
        // 1. Handle File Uploads
        $fileKeys = ['site_logo', 'site_logo_light', 'site_favicon', 'footer_logo'];

        foreach ($fileKeys as $key) {
            if ($request->hasFile($key)) {
                
                // Delete old file if exists
                $oldFile = SiteSetting::where('setting_key', $key)->value('setting_value');
                if ($oldFile && File::exists(public_path('uploads/settings/' . $oldFile))) {
                    File::delete(public_path('uploads/settings/' . $oldFile));
                }

                // Upload new file
                $file = $request->file($key);
                $filename = $key . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/settings'), $filename);

                // Update Request Data to store PDF/Image name instead of object
                // We update the DB directly here for files to ensure it persists correctly
                SiteSetting::updateOrCreate(
                    ['setting_key' => $key],
                    ['setting_value' => $filename]
                );
            }
        }

        // 2. Handle Text Inputs
        $data = $request->except(['_token', '_method', 'site_logo', 'site_logo_light', 'site_favicon', 'footer_logo']);

        foreach ($data as $key => $value) {
            // Skip if value is null (unless we want to clear it, but usually empty string is sent)
            if ($value === null) continue;

            SiteSetting::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return redirect()->back()->with('success', 'System settings updated successfully.');
    }
}
