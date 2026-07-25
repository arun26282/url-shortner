<?php

namespace App\Policies;

use App\Models\User;

class InvitationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * super admin can invite a company admin.
     */
    public function inviteCompanyAdmin(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Admin can invite another admin or member in their own company.
     */
    public function inviteTeamMember(User $user): bool
    {
        return $user->isAdmin();
    }
}
