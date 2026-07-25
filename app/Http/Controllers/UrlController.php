<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Services\UrlService;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Create a controller instance.
     */
    public function __construct(Protected UrlService $urlService)
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $urls = $this->urlService->getUrls($user);
        return view('urls', compact('urls'));
    }
    /**
     * Store a new short URL for the authenticated user.
     */
    public function store(UrlRequest $request)
    {
        if ($request->user()->isSuperAdmin())
        {
            abort(403, 'Super Admins cannot create URLs.');
        }

        $url = $this->urlService->storeUrl($request->user(), $request->url);
        $url_code = $url->url_code;

        return redirect()->back()->with('success', 'URL shortened successfully! Your URL code is: ' . $url_code);
    }
}
