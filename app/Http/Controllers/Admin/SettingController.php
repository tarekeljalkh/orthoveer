<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SettingController extends Controller
{
    use FileUploadTrait;

    function index()
    {
        $englishTranslations = include base_path('lang/en/messages.php');
        $frenchTranslations = include base_path('lang/fr/messages.php');

        return view('admin.setting.index', compact('englishTranslations', 'frenchTranslations'));
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

    public function updateTranslations(Request $request)
    {
        // Get the translations data from the form submission
        $translations = $request->get('translations');

        // Update English translations
        $englishFile = base_path('lang/en/messages.php');
        $englishTranslations = include $englishFile;
        foreach ($translations['en'] as $key => $value) {
            $englishTranslations[$key] = $value;
        }
        // Save the updated English translations back to the file
        file_put_contents($englishFile, "<?php\n\nreturn " . var_export($englishTranslations, true) . ";\n");

        // Update French translations
        $frenchFile = base_path('lang/fr/messages.php');
        $frenchTranslations = include $frenchFile;
        foreach ($translations['fr'] as $key => $value) {
            $frenchTranslations[$key] = $value;
        }
        // Save the updated French translations back to the file
        file_put_contents($frenchFile, "<?php\n\nreturn " . var_export($frenchTranslations, true) . ";\n");

        toastr()->success('Translations updated successfully!');

        // Return the updated translations back to the view
        return view('admin.setting.index', compact('englishTranslations', 'frenchTranslations'));
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

    public function backupDatabase()
    {
        $fileName = 'database_backup_' . Carbon::now()->format('Y_m_d_H_i_s') . '.sql';
        $storagePath = storage_path('app/' . $fileName);

        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');
        $dbConnection = env('DB_CONNECTION');

        $command = '';

        switch ($dbConnection) {
            case 'mysql':
                $command = sprintf(
                    'mysqldump --user=%s --password=%s --host=%s %s > %s',
                    escapeshellarg($username),
                    escapeshellarg($password),
                    escapeshellarg($host),
                    escapeshellarg($database),
                    escapeshellarg($storagePath)
                );
                break;

            case 'pgsql':
                $command = sprintf(
                    'PGPASSWORD=%s pg_dump --username=%s --host=%s --dbname=%s --no-password > %s',
                    escapeshellarg($password),
                    escapeshellarg($username),
                    escapeshellarg($host),
                    escapeshellarg($database),
                    escapeshellarg($storagePath)
                );
                break;

                // Add other database connections if necessary

            default:
                return response()->json(['error' => 'Unsupported database connection type'], 500);
        }

        // Execute the command
        $result = null;
        $output = [];
        exec($command . ' 2>&1', $output, $result);

        if ($result !== 0) {
            return response()->json(['error' => 'Failed to export the database. Detailed Output: ' . implode("\n", $output)], 500);
        }

        // Return the backup file as a download response
        return response()->download($storagePath)->deleteFileAfterSend(true);
    }
}
