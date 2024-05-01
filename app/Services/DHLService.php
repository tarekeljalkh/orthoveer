<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use SplTempFileObject;
use Illuminate\Support\Facades\Log;

class DHLService
{
    /**
     * Generate a CSV file, save it locally, and optionally upload it to FTP.
     *
     * @param array $ordersData An array of order data.
     * @return string The path to the saved file.
     */
    public function generateAndUploadCsv(array $ordersData)
    {
        try {
            // Create a CSV Writer instance
            $csv = Writer::createFromFileObject(new SplTempFileObject());
            $csv->insertOne(['OrderNumber', 'Date', 'Name']);  // Example headers

            foreach ($ordersData as $order) {
                $csv->insertOne([
                    $order['OrderNumber'],
                    $order['Date'],
                    $order['Name'],
                    // Additional fields can be added here
                ]);
            }

            // Define file path within the local storage app folder
            $fileName = 'csv/orders-' . date('Y-m-d-H-i-s') . '.csv';
            Storage::disk('local')->put($fileName, $csv->getContent());

            // Log the local save
            Log::info('CSV file saved locally', ['path' => $fileName]);

            // Upload the file to FTP
            if ($this->uploadToFTP($fileName)) {
                // If the upload is successful, move the file to the 'out' directory
                Storage::disk('local')->move($fileName, str_replace('csv', 'out', $fileName));
                Log::info('CSV file uploaded to FTP and moved locally', ['newPath' => str_replace('csv', 'out', $fileName)]);
                return $fileName;
            }

            Log::error('Failed to upload CSV file to FTP');
            return false;

        } catch (\Exception $e) {
            Log::error('Failed to generate or handle CSV: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Upload a file to the FTP server.
     *
     * @param string $filePath The path to the file within local storage.
     * @return bool True if upload was successful, otherwise false.
     */
    private function uploadToFTP($filePath)
    {
        $localPath = storage_path('app/' . $filePath);
        $remotePath = 'IN/' . basename($filePath);

        try {
            // Retrieve the content of the local file
            $content = Storage::disk('local')->get($filePath);
            // Upload the file to the FTP server
            return Storage::disk('ftp')->put($remotePath, $content);
        } catch (\Exception $e) {
            Log::error('FTP upload failed: ' . $e->getMessage());
            return false;
        }
    }
}
