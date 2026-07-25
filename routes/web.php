<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\UrlRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function ()
{
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Url Routes
    Route::get('/urls', [UrlController::class, 'index'])->name('urls.index');
    Route::post('/urls/store', [UrlController::class, 'store'])->name('urls.store');

    // super-admin routes
    Route::middleware('role:super-admin')->group(function () {
        Route::prefix('/super-admin')->group(function () {
            Route::post('/invitations', [InvitationController::class, 'storeCompanyAdmin'])->name('super-admin.invite');
            Route::resource('companies', CompanyController::class)->only(['index', 'create', 'store', 'edit', 'update']);
        });
    });

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::post('/admin/invitations', [InvitationController::class, 'storeTeamMember'])->name('admin.invite');
    });
});

// url redirection route
Route::get('/{shortCode}', [UrlRedirectController::class, 'resolve'])->name('url.resolve');
