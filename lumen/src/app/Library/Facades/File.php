<?php
namespace App\Library\Facades;

use Illuminate\Support\Facades\Facade;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @method static array upload(string $fileName, $file, string $path)
 * @method static BinaryFileResponse download(string $fullPath)
 * @method static bool remove(string $fullPath)
 * @method static bool exist(string $fullPath)
 *
 * @see \App\Library\Modules\FileModule
 */

class File extends Facade{
    protected static function getFacadeAccessor(){
        return self::class;
    }
}