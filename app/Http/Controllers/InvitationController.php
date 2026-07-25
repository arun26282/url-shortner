<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteRequest;
use App\Http\Requests\TeamMemberInviteRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class InvitationController extends Controller
{
    public function storeCompanyAdmin(InviteRequest $request)
    {
        Gate::authorize('inviteCompanyAdmin');

        User::create([
            'created_by' => $request->user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password'),
            'role' => 'admin',
            'company_id' => $request->company_id,
        ]);

        return redirect()->back()->with('success', 'Admin invited to the company successfully.');
    }

    /**
     * Process admin inviting another admin or member to their own company.
     */
    public function storeTeamMember(TeamMemberInviteRequest $request)
    {
        Gate::authorize('inviteTeamMember');

        User::create([
            'created_by' => $request->user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password'),
            'role' => $request->role,
            'company_id' => $request->user()->company_id,
        ]);

        return redirect()->back()->with('success', $request->role . ' invited successfully.');
    }
}
