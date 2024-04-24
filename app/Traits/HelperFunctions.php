<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HelperFunctions
{
    public function deleteFile($file_path) : void {
        if(!empty($file_path) && Storage::disk('public')->exists($file_path))
            Storage::disk('public')->delete($file_path);
    }
}
