<?php

namespace App\Http\Controllers;

use App\Models\Url;

class UrlRedirectController extends Controller
{
    /**
     * Resolve the short URL code and redirect to the original URL.
     */
    public function resolve(string $url_code)
    {
        $url = Url::where('url_code', $url_code)->firstOrFail();

        return redirect()->away($url->url);
    }
}
