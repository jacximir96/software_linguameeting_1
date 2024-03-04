<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CheckFileSize extends Controller
{
    public function __invoke(float $sizeInKB)
    {
        $maxSizeInKB = config('linguameeting.files.max_upload_size_in_KB');

        $maxExceeded = $sizeInKB > $maxSizeInKB;

        $response = [
            'max_size_in_kb' => $maxSizeInKB,
            'max_size_in_mb' => round($maxSizeInKB / 1024, 2),
            'upload_size_in_kb' => round($sizeInKB, 2),
            'max_exceeded' => $maxExceeded,
        ];

        return response()->json(['response' => $response], 200);
    }
}
