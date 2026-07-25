<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Companies') }}
        </h2>
    </x-slot>

    <!-- Main Dashboard Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between gap-4">
                    <h3 class="text-lg font-semibold text-gray-900">Companies List</h3>
                    <a href="{{ route('companies.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 shadow-sm transition">
                        <i class="fas fa-plus mr-2"></i> Add New Company
                    </a>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-center border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-sm">
                                <th class="px-6 py-3 font-medium text-gray-600">Company</th>
                                <th class="px-6 py-3 font-medium text-gray-600">Email</th>
                                <th class="px-6 py-3 font-medium text-gray-600 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">

                            <!-- Row 1 -->
                            @forelse ($companies as $company)
                                <tr>
                                    <td class="px-6 py-4">{{ $company->name }}</td>
                                    <td class="px-6 py-4">{{ $company->email }}</td>
                                    <td class="px-6 py-4 ">
                                        <a href="{{ route('companies.edit', $company->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No companies found.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                <!-- Table Footer / Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-end">
                    <div>
                        {{ $companies->links() }}
                    </div>
                </div>
            </div>
        </div>

    </main>
</x-app-layout>
