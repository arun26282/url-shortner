<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold text-gray-900">
            {{ auth()->user()->hasRole('super-admin') ? 'Company Admins' : 'Team Members' }}
        </h2>
        <button onclick="toggleModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 shadow-sm transition">
            <i class="fas fa-envelope mr-2"></i> Invite User
        </button>
    </div>

    @canany(['inviteCompanyAdmin', 'inviteTeamMember'], App\Models\User::class)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Company members</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-sm">
                            <th class="px-6 py-3 font-medium text-gray-600">Client Name</th>
                            <th class="px-6 py-3 font-medium text-gray-600">Email</th>
                            @if(auth()->user()->isAdmin())
                                <th class="px-6 py-3 font-medium text-gray-600">Role</th>
                            @endif
                            @if(auth()->user()->isSuperAdmin())
                                <th class="px-6 py-3 font-medium text-gray-600">Total Users</th>
                            @endif
                            <th class="px-6 py-3 font-medium text-gray-600">Url Count</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-left"> {{ $user->name }}
                                    @if(auth()->user()->isSuperAdmin())
                                        <p class="text-gray-500 text-sm">{{ $user->company->name ?? 'N/A' }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                @if(auth()->user()->isAdmin())
                                    <td class="px-6 py-4">{{ $user->role }}</td>
                                @endif
                                @if(auth()->user()->isSuperAdmin())
                                    <td class="px-6 py-4">{{ $user->company->users_count ?? 0 }}</td>
                                @endif
                                <td class="px-6 py-4">{{ $user->company?->urls_count ?? $user->urls_count ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">No admins found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users && $users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-end">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    @endcanany

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div id="myModal" class="{{ $errors->any() ? '' : 'hidden' }} fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center px-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-xl overflow-hidden transform transition-all">

            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Invite User</h3>
                <button onclick="toggleModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
            </div>

            <form action="{{ auth()->user()->isSuperAdmin() ? route('super-admin.invite') : route('admin.invite') }}" method="POST">
                @csrf
                <div class="px-6 py-4 space-y-4">
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <ul class="list-disc pl-5 text-sm p-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>

                    <!-- Only super admin can assign company to admin -->
                    @can('inviteCompanyAdmin', App\Models\User::class)
                        <div>
                            <label for="company_id" class="block text-sm font-medium text-gray-700 mb-1">Assign Company</label>
                            <select id="company_id" name="company_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm bg-white">
                                <option value="" disabled {{ old('company_id') ? '' : 'selected' }}>Select a company...</option>
                                @if($companies)
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endcan

                    <!-- Only admin can select role -->
                    @can('inviteTeamMember', App\Models\User::class)
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Select Role</label>
                            <select id="role" name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm bg-white">
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
                            </select>
                        </div>
                    @endcan

                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none transition-colors">
                        Send Invitation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal() {
        const modal = document.getElementById('myModal');
        modal.classList.toggle('hidden');
    }
</script>
