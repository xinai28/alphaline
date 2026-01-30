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
                                    <td class="border p-2">{{ ucfirst($inv->status) }}</td>
                                    <td class="border p-2">{{ $inv->start_date }}</td>
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

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
