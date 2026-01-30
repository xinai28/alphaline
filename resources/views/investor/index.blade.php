<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Investor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-start mb-6">
                        <a href="{{ route('investors.create') }}"
                           class="inline-flex items-center px-5 py-2.5 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition duration-150 text-base font-medium shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4" />
                            </svg>
                            Create Investor
                        </a>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('investors.index') }}" class="mb-4 flex gap-2 items-center">
                        <select name="search_type" class="border p-2 rounded focus:ring-1 focus:ring-indigo-500">
                            <option value="name" {{ ($searchType ?? '') === 'name' ? 'selected' : '' }}>Name</option>
                            <option value="email" {{ ($searchType ?? '') === 'email' ? 'selected' : '' }}>Email</option>
                            <option value="contact_number" {{ ($searchType ?? '') === 'contact_number' ? 'selected' : '' }}>Contact Number</option>
                        </select>

                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search..."
                               class="border p-2 rounded w-64 focus:ring-1 focus:ring-indigo-500">

                        <button type="submit"
                                class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100 transition duration-150">
                            Search
                        </button>

                        @if(!empty($search))
                            <a href="{{ route('investors.index') }}"
                               class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition duration-150">
                                Clear
                            </a>
                        @endif
                    </form>

                    <!-- Investor Table -->
                    <table class="w-full border">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">Name</th>
                            <th class="border p-2">Email</th>
                            <th class="border p-2">Contact</th>
                            <th class="border p-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($investors as $investor)
                            <tr>
                                <td class="border p-2">{{ $investor['name'] ?? '-' }}</td>
                                <td class="border p-2">{{ $investor['email'] ?? '-' }}</td>
                                <td class="border p-2">{{ $investor['contact_number'] ?? '-' }}</td>
                                <td class="border p-2">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('investors.investments', $investor['id']) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-md hover:bg-indigo-100 transition duration-150 text-base font-bold">
                                            View Investments
                                        </a>

                                        <a href="{{ route('investors.edit', $investor['id']) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-amber-50 text-amber-700 rounded-md hover:bg-amber-100 transition duration-150 text-base font-bold">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border p-4 text-center text-gray-500">
                                    No investors found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
