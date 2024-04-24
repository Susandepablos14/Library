<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait StoresFile
{
    public function storeFile(string $destinationPath = '', string $fileName = '', UploadedFile $file)
    {
        return $file->storeAs($destinationPath, $fileName . '.' . $file->getClientOriginalExtension());
    }

    public function putFile(UploadedFile $file, string $destinationPath = '', string $fileName = ''):array
    {
        $initPath = '/public/' . $destinationPath;
        $name = $fileName != ''
                    ? $fileName
                    : pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $path = $this->storeFile(
                $initPath,
                $name,
                $file);
        return [
            'path'      => $path,
            'extension' => $file->getClientOriginalExtension(),
            'size'      => $file->getSize(),
        ];
    }
}
