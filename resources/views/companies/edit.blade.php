<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Companies') }}
        </h2>
    </x-slot>
    <!-- Main Dashboard Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Company</h3>
                </div>

                <!-- Card Body (Form) -->
                <form action="{{ route('companies.update', $company->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Input Group -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                            <input type="text" id="name" name="name" placeholder="Google Inc."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-shadow text-sm" value="{{ old('name', $company->name) }}">
                            @error('name')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Input Group -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                            <input type="email" id="email" name="email" placeholder="info@google.com"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-shadow text-sm" value="{{ old('email', $company->email) }}">
                            @error('email')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <!-- Card Footer -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-3">
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Update Company
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </main>
</x-app-layout>
