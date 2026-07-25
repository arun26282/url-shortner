<?php

namespace App\Providers;

use App\Policies\InvitationPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('inviteCompanyAdmin', [InvitationPolicy::class, 'inviteCompanyAdmin']);
        Gate::define('inviteTeamMember', [InvitationPolicy::class, 'inviteTeamMember']);
    }
}
