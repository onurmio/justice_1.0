<?php

namespace App\Library\Modules;

use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileModule
{

    public function upload($name, $file, $path)
    {
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $fileName = join(".", [$name, $extension]);

        $destinationPath = base_path(join(DIRECTORY_SEPARATOR, ['storage', 'files', $path]));
        File::makeDirectory($destinationPath, 0777, true, true);
        $file->move($destinationPath, $fileName);

        return true;
    }

    public function download($fullPath)
    {
        $destinationPath = base_path(join(DIRECTORY_SEPARATOR, ['storage', 'files', $fullPath]));
        return new BinaryFileResponse($destinationPath, 200, ['Content-Type' => mime_content_type($destinationPath)]);
    }

    public function remove($fullPath)
    {
        $destinationPath = base_path(join(DIRECTORY_SEPARATOR, ['storage', 'files', $fullPath]));
        return File::delete($destinationPath);
    }

    public function exist($fullPath){
        $destinationPath = base_path(join(DIRECTORY_SEPARATOR, ['storage', 'files', $fullPath]));
        return File::exists($destinationPath);
    }
}