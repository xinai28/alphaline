<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            Investments for {{ $investor->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-4 text-gray-900">

                    <!-- Back Button -->
                    <div class="mb-3">
                        <a href="{{ route('investors.index') }}"
                           class="bg-gray-500 text-white px-3 py-1.5 rounded hover:bg-gray-600 text-sm">
                            ← Back to Investors
                        </a>
                    </div>

                    <!-- Investor Info -->
                    <div class="mb-4 text-sm">
                        <p><strong>Email:</strong> {{ $investor->email }}</p>
                        <p><strong>Contact:</strong> {{ $investor->contact_number ?? '-' }}</p>
                    </div>

                    <!-- Total Invested -->
                    @isset($totalInvested)
                        <div class="mb-4 bg-blue-50 p-3 rounded text-sm">
                            <p class="font-semibold">
                                Total Invested: 
                                <span class="text-blue-700">
                                    RM {{ number_format($totalInvested, 2) }}
                                </span>
                            </p>
                        </div>
                    @endisset

                    <!-- Investments Table -->
                    <table class="w-full border text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-1">Fund</th>
                                <th class="border p-1">Amount (RM)</th>
                                <th class="border p-1">Investment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($investments as $investment)
                                <tr>
                                    <td class="border p-1">{{ $investment->fund->name ?? 'N/A' }}</td>
                                    <td class="border p-1">{{ number_format($investment->capital_amount, 2) }}</td>
                                    <td class="border p-1">{{ \Carbon\Carbon::parse($investment->investment_date)->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="border p-2 text-center text-gray-500">
                                        No investments found for this investor.
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
