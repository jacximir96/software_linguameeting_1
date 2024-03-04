<?php

namespace App\Http\Controllers\Admin;

use App\Src\File\Model\File;

trait Downloable
{
    public function obtainDownlaodInfo(File $file): array
    {
        return [
            'Content-Type' => $file->mime(),
            'Cache-Control' => 'no-cache, must-revalidate',
            'Content-Disposition' => 'attachment; filename="'.$file->originalName().'"',
        ];
    }
}
