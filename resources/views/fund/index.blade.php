<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Funds') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-4 text-gray-900">

                    <!-- Sync Funds Button -->
                    <div class="flex justify-start mb-3">
                        <button id="sync-funds"
                            class="inline-flex items-center px-3 py-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 transition font-semibold text-sm">
                            Sync Funds
                        </button>
                    </div>

                    <!-- Funds Table -->
                    <table class="w-full border text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-1">Fund Name</th>
                                <th class="border p-1">Total Invested (RM)</th>
                                <th class="border p-1">Total Investors</th>
                                <th class="border p-1">Updated At</th>
                                <th class="border p-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($funds as $fund)
                                <tr>
                                    <td class="border p-1 text-center">{{ $fund->name }}</td>
                                    <td class="border p-1 text-center">RM {{ number_format($fund->total_invested ?? 0, 2) }}</td>
                                    <td class="border p-1 text-center">{{ $fund->total_investors ?? 0 }}</td>
                                    <td class="border p-1">{{ $fund->updated_at }}</td>
                                    <td class="border p-1 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('investments.index') }}?fund_id={{ $fund->id }}"
                                               class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100 transition font-semibold text-sm">
                                                View Investments
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border p-2 text-center text-gray-500">
                                        No funds found.
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

<script>
document.getElementById('sync-funds').addEventListener('click', function() {
    const btn = this;
    btn.disabled = true;
    btn.textContent = 'Syncing...';

    fetch('{{ route("funds.sync") }}')
        .then(response => response.json())
        .then(data => {
            if(data.message){
                alert(`${data.message} (${data.count} funds)`);
                location.reload();
            } else {
                alert('Sync completed but no data returned.');
            }
        })
        .catch(() => alert('Failed to sync funds.'))
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'Sync Funds';
        });
});
</script>
