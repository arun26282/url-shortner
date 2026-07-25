<?php

namespace App\Helpers;
use Illuminate\Support\Str;

class Helper
{
    /**
     * Generate a unique short url code for the URL.
     */
    public static function generateUniqueUrlCode(): string
    {
        $url_code = Str::random(6);

        while (\App\Models\Url::where('url_code', $url_code)->exists()) {
            $url_code = Str::random(6);
        }

        return $url_code;
    }
}
