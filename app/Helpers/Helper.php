<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class Helper
{
    /**
     * @return JsonResponse
     */
    static function addCustomLog($errorLocation, $customMessage, $file, $line)
    {
        \Log::error($errorLocation . ' error! ' . $customMessage . ' on file ' . $file . ' on line: ' . $line);
        return response()->json([
            'error' => 1,
            'message' => 'Oooops something went wrong!'
        ]);
    }

}
