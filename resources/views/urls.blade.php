<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('URL Manager') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header & Button -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">
                    {{ auth()->user()->isSuperAdmin() ? 'Global URLs' : (auth()->user()->isAdmin() ? 'Company URLs' : 'My URLs') }}
                </h2>

                <!-- Only Admins and Members can create URLs -->
                @if(!auth()->user()->isSuperAdmin())
                    <button onclick="toggleUrlModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 shadow-sm transition">
                        <i class="fas fa-link mr-2"></i> Short New URL
                    </button>
                @endif
            </div>

            <!-- Global Alerts -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->has('url'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ $errors->first('url') }}
                </div>
            @endif

            <!-- The URLs Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-sm">
                                <th class="px-6 py-3 font-medium text-gray-600">Short Link</th>
                                <th class="px-6 py-3 font-medium text-gray-600">Long URL</th>
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                                    <th class="px-6 py-3 font-medium text-gray-600">Created By</th>
                                @endif
                                @if(auth()->user()->isSuperAdmin())
                                    <th class="px-6 py-3 font-medium text-gray-600">Company</th>
                                @endif
                                <th class="px-6 py-3 font-medium text-gray-600">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse ($urls as $url)
                                <tr>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('url.resolve', $url->url_code) }}" target="_blank" class="text-indigo-600 font-semibold hover:underline">
                                            {{ url('/' . $url->url_code) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 truncate max-w-xs">
                                        <a href="{{ $url->url }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ $url->url }}
                                        </a>
                                    </td>
                                    @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                                        <td class="px-6 py-4 capitalize">
                                            {{ $url->user->name }}
                                        </td>
                                    @endif
                                    @if(auth()->user()->isSuperAdmin())
                                        <td class="px-6 py-4 capitalize">
                                            {{ $url->user->company->name }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $url->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No shortened URLs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- The URL Modal -->
            <div id="urlModal" class="{{ $errors->has('url') ? '' : 'hidden' }} fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center px-4">
                <div class="bg-white rounded-xl shadow-lg w-full max-w-lg overflow-hidden transform transition-all">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Create Short URL</h3>
                        <button onclick="toggleUrlModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
                    </div>

                    <form action="{{ route('urls.store') }}" method="POST">
                        @csrf
                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <label for="url" class="block text-sm font-medium text-gray-700 mb-1">Original Full URL</label>
                                <input type="url" id="url" name="url" value="{{ old('url') }}" placeholder="eg https://test.com/path/path2" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none transition-colors">
                                Shorten URL
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleUrlModal() {
            const modal = document.getElementById('urlModal');
            modal.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
