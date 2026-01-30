<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Investments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Sync Investments Button -->
                    <div class="flex justify-start mb-4">
                        <button id="sync-investments"
                            class="inline-flex items-center px-5 py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-150 font-bold">
                            Sync Investments
                        </button>
                    </div>

                    <!-- Filters -->
                    <form method="GET" class="mb-4 flex flex-wrap gap-3 items-end">
                        <div>
                            <label class="block text-sm font-medium mb-1">Investor</label>
                            <select name="investor_id" class="border p-2 rounded">
                                <option value="">All</option>
                                @foreach($investors as $inv)
                                    <option value="{{ $inv->id }}" {{ request('investor_id') == $inv->id ? 'selected' : '' }}>
                                        {{ $inv->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Fund</label>
                            <select name="fund_id" class="border p-2 rounded">
                                <option value="">All</option>
                                @foreach($funds as $fund)
                                    <option value="{{ $fund->id }}" {{ request('fund_id') == $fund->id ? 'selected' : '' }}>
                                        {{ $fund->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Status</label>
                            <select name="status" class="border p-2 rounded">
                                <option value="">All</option>
                                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">From</label>
                            <input type="date" name="start_date_from" value="{{ request('start_date_from') }}" class="border p-2 rounded">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">To</label>
                            <input type="date" name="start_date_to" value="{{ request('start_date_to') }}" class="border p-2 rounded">
                        </div>

                        <button type="submit" class="px-4 py-2 bg-indigo-500 text-white font-bold rounded hover:bg-indigo-600 transition">
                            Filter
                        </button>
                        <a href="{{ route('investments.index') }}" class="px-4 py-2 bg-gray-200 font-bold rounded hover:bg-gray-300 transition">
                            Clear
                        </a>
                    </form>

                    <!-- Investments Table -->
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">UID</th>
                                <th class="border p-2">Investor</th>
                                <th class="border p-2">Fund</th>
                                <th class="border p-2">Capital Amount (RM)</th>
                                <th class="border p-2">Status</th>
                                <th class="border p-2">Start Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($investments as $inv)
                                <tr>
                                    <td class="border p-2">{{ $inv->uid }}</td>
                                    <td class="border p-2">{{ $inv->investor->name ?? 'N/A' }}</td>
                                    <td class="border p-2">{{ $inv->fund->name ?? 'N/A' }}</td>
                                    <td class="border p-2">RM {{ number_format($inv->capital_amount ?? 0, 2) }}</td>
                                    <td class="border p-2">
                                        <span class="px-2 py-1 rounded font-bold
                                            {{ strtolower($inv->status) == 'active' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ strtolower($inv->status) == 'closed' ? 'bg-gray-100 text-gray-600' : '' }}
                                            {{ strtolower($inv->status) == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                            {{ ucfirst($inv->status) }}
                                        </span>
                                    </td>
                                    <td class="border p-2">{{ $inv->start_date ? \Carbon\Carbon::parse($inv->start_date)->format('Y-m-d') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border p-4 text-center text-gray-500">
                                        No investments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
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
        .then(response => response.json())
        .then(data => {
            if(data.message){
                alert(`${data.message} (${data.count} investments)`);
                location.reload(); // reload page to show updated data
            } else {
                alert('Sync completed but no data returned.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Failed to sync investments.');
        })
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'Sync Investments';
        });
});
</script>
