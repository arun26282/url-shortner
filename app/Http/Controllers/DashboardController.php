<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     *
     */

    public function __construct(protected DashboardService $dashboardService)
    {
        //
    }

    /**
     * Display the dashboard with users and companies data for inviting users.
     */
    public function index(Request $request)
    {
        $data = $this->dashboardService->getDashboardData($request->user());
        return view('dashboard', $data);
    }
}
