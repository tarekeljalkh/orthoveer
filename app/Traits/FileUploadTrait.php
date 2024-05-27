<?php

namespace App\Traits;

use Illuminate\Http\Request;
use File;

trait FileUploadTrait
{

    function uploadImage(Request $request, $inputName, $oldPath = NULL, $path = "/uploads")
    {

        if ($request->hasFile($inputName)) {

            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $ext;

            $image->move(public_path($path), $imageName);

            // delete previous file if exist
            if ($oldPath && File::exists(public_path($oldPath))) {
                File::delete(public_path($oldPath));
            }

            return $path . '/' . $imageName;
        }

        return NULL;
    }

    public function uploadFiles(Request $request, $inputName, $path = "/uploads")
    {
        $paths = [];
        if ($request->hasFile($inputName)) {
            foreach ($request->file($inputName) as $file) {
                $ext = $file->getClientOriginalExtension();
                $fileName = 'media_' . uniqid() . '.' . $ext;
                $file->move(public_path($path), $fileName);
                $paths[] = $path . '/' . $fileName;
            }
        }
        return $paths ? $paths : NULL;
    }


    /**
     * Remove file
     */
    function removeImage(string $path): void
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    public function uploadZip(Request $request, $inputName, $scanId, $basePath = "/uploads")
    {
        if ($request->hasFile($inputName)) {
            $zip = $request->file($inputName);
            $ext = $zip->getClientOriginalExtension();
            $fileName = 'zip_' . uniqid() . '.' . $ext;

            // Create the scan-specific directory if it doesn't exist
            $scanPath = public_path($basePath . '/' . $scanId);
            if (!file_exists($scanPath)) {
                mkdir($scanPath, 0777, true);
            }

            // Move the file to the scan-specific directory
            $zip->move($scanPath, $fileName);

            return $basePath . '/' . $scanId . '/' . $fileName;
        }

        return NULL;
    }


    public function removeFile(string $path): void
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
