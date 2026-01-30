<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Investor') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-4 text-gray-900">

                    @if(session('success'))
                        <div class="bg-green-100 text-green-800 p-2 mb-3 rounded text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Sync + Create Buttons -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button id="sync-investors"
                            class="inline-flex items-center px-3 py-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 transition font-semibold text-sm">
                            Sync Investors
                        </button>

                        <a href="{{ route('investors.create') }}"
                           class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-md hover:bg-indigo-100 transition text-sm font-medium shadow-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create Investor
                        </a>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('investors.index') }}" class="mb-3 flex gap-2 flex-wrap items-center text-sm">
                        <select name="search_type" 
                                class="border p-1 rounded focus:ring-1 focus:ring-indigo-500 min-w-[120px]">
                            <option value="name" {{ ($searchType ?? '') === 'name' ? 'selected' : '' }}>Name</option>
                            <option value="email" {{ ($searchType ?? '') === 'email' ? 'selected' : '' }}>Email</option>
                            <option value="contact_number" {{ ($searchType ?? '') === 'contact_number' ? 'selected' : '' }}>Contact Number</option>
                        </select>

                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search..."
                               class="border p-1 rounded min-w-[200px] focus:ring-1 focus:ring-indigo-500">

                        <button type="submit"
                                class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100 transition">
                            Search
                        </button>

                        @if(!empty($search))
                            <a href="{{ route('investors.index') }}"
                               class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">
                                Clear
                            </a>
                        @endif
                    </form>

                    <!-- Investor Table -->
                    <table class="w-full border text-sm">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-1">Name</th>
                            <th class="border p-1">Email</th>
                            <th class="border p-1">Contact</th>
                            <th class="border p-1">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($investors as $investor)
                        <tr>
                            <td class="border p-1">{{ $investor['name'] ?? '-' }}</td>
                            <td class="border p-1">{{ $investor['email'] ?? '-' }}</td>
                            <td class="border p-1">{{ $investor['contact_number'] ?? '-' }}</td>
                            <td class="border p-1">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('investors.investments', $investor['id']) }}"
                                       class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded-md hover:bg-indigo-100 transition text-sm font-semibold">
                                        View Investments
                                    </a>
                                    <a href="{{ route('investors.edit', $investor['id']) }}"
                                       class="px-2 py-1 bg-amber-50 text-amber-700 rounded-md hover:bg-amber-100 transition text-sm font-semibold ml-2">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="border p-2 text-center text-gray-500">
                                No investors found.
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 text-sm">
                        {{ $investors->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.getElementById('sync-investors').addEventListener('click', function() {
    const btn = this;
    btn.disabled = true;
    btn.textContent = 'Syncing...';

    fetch('{{ route("investors.sync") }}')
        .then(res => res.json())
        .then(data => {
            alert(`${data.message} (${data.count} investors)`);
            location.reload();
        })
        .catch(() => alert('Failed to sync investors.'))
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'Sync Investors';
        });
});
</script>
