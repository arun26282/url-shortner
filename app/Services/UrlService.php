<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\Url;
use App\Models\User;
use Illuminate\Support\Collection;

class UrlService
{
    /**
     * Generate a unique short code for the given URL.
     */
    public function getUrls(User $user): Collection
    {
        if ($user->isSuperAdmin()) {
            return Url::with('user.company')->latest()->get();
        }
        elseif ($user->isAdmin()) {
            return $user->company->urls()->with('user')->latest()->get();
        }

        return Url::where('user_id', $user->id)->latest()->get();
    }

    /**
     * store a new short URL for the authenticated user.
     */

    public function storeUrl(User $user, string $url): Url
    {
        $url_code = Helper::generateUniqueUrlCode();

        return Url::create([
            'user_id' => $user->id,
            'url' => $url,
            'url_code' => $url_code,
        ]);
    }
}
