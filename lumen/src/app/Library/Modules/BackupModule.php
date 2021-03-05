<?php

namespace App\Library\Modules;

use Illuminate\Support\Facades\File;

class BackupModule
{
    /**
     * Backups data.
     *
     * @param $path
     * @param $file
     * @param $data
     */
    public static function backup($path, $file, $data)
    {
        $date = date("Ymd");
        $path = base_path() . "/storage/backups/{$path}/{$date}/";
        File::makeDirectory($path, 0700, true, true);
        File::put("{$path}/{$file}.json", json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Restores users and posts of the channel.
     *
     * @param $path
     * @param $file
     *
     * @param $date
     *
     * @return mixed
     */
    public static function restore($path, $file, $date)
    {
        $path = base_path() . "/storage/backups/{$path}/{$date}/";
        if (File::exists("{$path}/{$file}.json")) {
            return json_decode(File::get("{$path}/{$file}.json"), true);
        }
        return false;
    }
}
