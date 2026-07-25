<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @canany(['inviteCompanyAdmin', 'inviteTeamMember'], App\Models\User::class)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                    <x-invite :companies="$companies" :users="$users" />
                </div>
            @endcanany
        </div>
    </div>
</x-app-layout>
