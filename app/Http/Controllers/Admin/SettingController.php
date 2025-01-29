<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    use FileUploadTrait;

    function index()
    {
        return view('admin.setting.index');
    }

    function UpdateGeneralSetting(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => ['required', 'max:255'],
            'site_email' => ['nullable', 'max:255'],
            'site_phone' => ['nullable', 'max:255'],
            'site_default_currency' => ['required', 'max:4'],
            'site_currency_icon' => ['required', 'max:4'],
            'site_currency_icon_position' => ['required', 'max:255'],
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated Successfully!');

        return redirect()->back();
    }

    function UpdatePusherSetting(Request $request)
    {
        $validatedData = $request->validate([
            'pusher_app_id' => ['required'],
            'pusher_key' => ['required'],
            'pusher_secret' => ['required'],
            'pusher_cluster' => ['required'],
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated Successfully!');

        return redirect()->back();
    }

    function UpdateMailSetting(Request $request)
    {
        $validatedData = $request->validate([
            'mail_driver' => ['required'],
            'mail_host' => ['required'],
            'mail_port' => ['required'],
            'mail_username' => ['required'],
            'mail_password' => ['required'],
            'mail_encryption' => ['required'],
            'mail_from_address' => ['required'],
            'mail_receive_address' => ['required'],
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
            $this->updateEnvFile(strtoupper($key), $value);
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();
        Cache::forget('mail_settings');

        // Clear Laravel's config cache to reflect the new settings
        Artisan::call('config:clear');

        toastr()->success('Mail Settings Updated Successfully!');

        return redirect()->back();
    }

    // Function to update .env file
    private function updateEnvFile($key, $value)
    {
        $envPath = base_path('.env');

        if (file_exists($envPath)) {
            $env = file_get_contents($envPath);

            // Check if key exists
            if (preg_match("/^{$key}=.*/m", $env)) {
                // Replace the existing key-value pair
                $env = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $env);
            } else {
                // Append new key-value pair
                $env .= "\n{$key}={$value}";
            }

            file_put_contents($envPath, $env);
        }
    }

    function UpdateLogoSetting(Request $request)
    {
        $validatedData = $request->validate([
            'logo' => ['nullable', 'image', 'max:1000'],
            'favicon' => ['nullable', 'image', 'max:1000'],
        ]);

        foreach ($validatedData as $key => $value) {

            $imagePatch = $this->uploadImage($request, $key);
            if (!empty($imagePatch)) {
                $oldPath = config('settings.' . $key);
                $this->removeImage($oldPath);

                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $imagePatch]
                );
            }
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();
        Cache::forget('mail_settings');

        toastr()->success('Updated Successfully!');

        return redirect()->back();
    }

    function UpdateAppearanceSetting(Request $request)
    {
        $validatedData = $request->validate([
            'site_color' => ['required']
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();
        Cache::forget('mail_settings');

        toastr()->success('Updated Successfully!');

        return redirect()->back();
    }

}
