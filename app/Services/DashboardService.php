<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;

class DashboardService
{
    /**
     * users and companies data for inviting users. based on the role of the authenticated user.
     *
     * Admin is authorize for role and invite another admin or member in their own company.
     * Super Admin is authorize to invite a company admin.
     */
    public function getDashboardData(User $user) : array
    {
        $users = collect();
        $companies = collect();

        if ($user->isSuperAdmin())
        {
            $users = User::where('role', 'admin')->where('created_by', $user->id)->with(['company' => function ($query) {
                $query->withCount('users');
                $query->withCount('urls');
            }])->paginate(10);

            $companies = Company::orderBy('name')->get();
        } elseif ($user->isAdmin())
        {
            $users = User::where('company_id', $user->company_id)->where('id', '!=', $user->id)->withCount('urls')->paginate(10);
        }

        return [
            'users' => $users,
            'companies' => $companies,
        ];
    }
}
