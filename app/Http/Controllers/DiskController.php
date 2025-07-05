<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DiskController extends Controller
{
    public function index()
    {
        Storage::put('test.text', 'hello to s3 bucket');
    }

    public function exportDatabase()
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

    // Upload and replace database
    public function importDatabase(Request $request)
    {
        // Validate the uploaded file
        // $request->validate([
        //     'database_file' => 'required|mimes:sql|max:10240', // Validate the uploaded file
        // ]);

        // Handle the uploaded file
        $file = $request->file('database_file');
        $fileName = 'uploaded_database_' . Carbon::now()->format('Y_m_d_H_i_s') . '.sql';
        $storagePath = storage_path('app/' . $fileName);
        $file->move(storage_path('app'), $fileName);

        // Preprocess the SQL file to add `DROP TABLE IF EXISTS` statements
        $processedFilePath = storage_path('app/processed_' . $fileName);
        $this->addDropStatements($storagePath, $processedFilePath);

        // Get database credentials
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');

        // Construct the MySQL command based on whether a password is set
        if (!empty($password)) {
            $command = sprintf(
                'mysql -u%s -p%s -h%s %s < %s',
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($database),
                escapeshellarg($processedFilePath)
            );
        } else {
            $command = sprintf(
                'mysql -u%s -h%s %s < %s',
                escapeshellarg($username),
                escapeshellarg($host),
                escapeshellarg($database),
                escapeshellarg($processedFilePath)
            );
        }

        // Execute the command
        $result = null;
        $output = [];
        exec($command . ' 2>&1', $output, $result);

        // Remove the uploaded and processed files after execution
        @unlink($storagePath);
        @unlink($processedFilePath);

        if ($result !== 0) {
            return response()->json([
                'error' => 'Failed to import the database. Detailed Output: ' . implode("\n", $output)
            ], 500);
        }

        return response()->json(['success' => 'Database successfully imported']);
    }

    /**
     * Add DROP TABLE IF EXISTS statements to the SQL file before each CREATE TABLE statement.
     */
    private function addDropStatements(string $inputFilePath, string $outputFilePath)
    {
        $fileContent = file_get_contents($inputFilePath);
        $updatedContent = preg_replace(
            '/CREATE TABLE `([a-zA-Z0-9_]+)`/i',
            'DROP TABLE IF EXISTS `\1`;\nCREATE TABLE `\1`',
            $fileContent
        );

        file_put_contents($outputFilePath, $updatedContent);
    }


}
