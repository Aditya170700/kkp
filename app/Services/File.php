<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class File
{
    public static function upload($path, $file, $ext = 'png')
    {
        $random = Str::random(10);
        $path = "{$path}/{$random}.{$ext}";

        Storage::disk('public')->put($path, $file);

        return "storage/{$path}";
    }

    public static function show($path)
    {
        return asset($path);
    }
}
