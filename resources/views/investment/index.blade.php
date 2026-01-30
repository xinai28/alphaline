<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Investments') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-4 text-gray-900">

                    <!-- Sync Investments Button -->
                    <div class="flex justify-start mb-3">
                        <button id="sync-investments"
                            class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition font-semibold text-sm">
                            Sync Investments
                        </button>
                    </div>

                    <!-- Filters -->
                    <form method="GET" class="mb-3 flex flex-wrap gap-2 items-end text-sm">
                        <div>
                            <label class="block mb-1">Investor</label>
                            <select name="investor_id" class="border p-1 rounded text-sm">
                                <option value="">All</option>
                                @foreach($investors as $inv)
                                    <option value="{{ $inv->id }}" {{ request('investor_id') == $inv->id ? 'selected' : '' }}>
                                        {{ $inv->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Fund</label>
                            <select name="fund_id" class="border p-1 rounded text-sm">
                                <option value="">All</option>
                                @foreach($funds as $fund)
                                    <option value="{{ $fund->id }}" {{ request('fund_id') == $fund->id ? 'selected' : '' }}>
                                        {{ $fund->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Status</label>
                            <select name="status" class="border p-1 rounded text-sm">
                                <option value="">All</option>
                                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">From</label>
                            <input type="date" name="start_date_from" value="{{ request('start_date_from') }}" class="border p-1 rounded text-sm">
                        </div>

                        <div>
                            <label class="block mb-1">To</label>
                            <input type="date" name="start_date_to" value="{{ request('start_date_to') }}" class="border p-1 rounded text-sm">
                        </div>

                        <button type="submit" class="px-3 py-1 bg-indigo-500 text-white font-semibold rounded hover:bg-indigo-600 transition text-sm">
                            Filter
                        </button>
                        <a href="{{ route('investments.index') }}" class="px-3 py-1 bg-gray-200 font-semibold rounded hover:bg-gray-300 transition text-sm">
                            Clear
                        </a>
                    </form>

                    <!-- Investments Table -->
                    <table class="w-full border text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-1">UID</th>
                                <th class="border p-1">Investor</th>
                                <th class="border p-1">Fund</th>
                                <th class="border p-1">Capital Amount (RM)</th>
                                <th class="border p-1">Status</th>
                                <th class="border p-1">Start Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($investments as $inv)
                                <tr>
                                    <td class="border p-1">{{ $inv->uid }}</td>
                                    <td class="border p-1">{{ $inv->investor->name ?? 'N/A' }}</td>
                                    <td class="border p-1">{{ $inv->fund->name ?? 'N/A' }}</td>
                                    <td class="border p-1">RM {{ number_format($inv->capital_amount ?? 0, 2) }}</td>
                                    <td class="border p-1">
                                        <span class="px-1 py-0.5 rounded font-semibold text-xs
                                            {{ strtolower($inv->status) == 'active' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ strtolower($inv->status) == 'closed' ? 'bg-gray-100 text-gray-600' : '' }}
                                            {{ strtolower($inv->status) == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                            {{ ucfirst($inv->status) }}
                                        </span>
                                    </td>
                                    <td class="border p-1">{{ $inv->start_date ? \Carbon\Carbon::parse($inv->start_date)->format('Y-m-d') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border p-2 text-center text-gray-500">
                                        No investments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-3 text-sm">
                        {{ $investments->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.getElementById('sync-investments').addEventListener('click', function() {
    const btn = this;
    btn.disabled = true;
    btn.textContent = 'Syncing...';

    fetch('{{ route("investments.sync") }}')
        .then(res => res.json())
        .then(data => {
            if(data.message){
                alert(`${data.message} (${data.count} investments)`);
                location.reload();
            } else alert('Sync completed but no data returned.');
        })
        .catch(() => alert('Failed to sync investments.'))
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'Sync Investments';
        });
});
</script>
