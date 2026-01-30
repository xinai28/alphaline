<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Funds') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">Fund Name</th>
                                <th class="border p-2">Total Invested (RM)</th>
                                <th class="border p-2">Total Investors</th>
                                <th class="border p-2">Updated At</th>
                                <th class="border p-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($funds as $fund)
                                <tr>
                                    <td class="border p-2 text-center">{{ $fund->name }}</td>
                                    <td class="border p-2 text-center">RM {{ number_format($fund->total_invested ?? 0, 2) }}</td>
                                    <td class="border p-2 text-center">{{ $fund->total_investors ?? 0 }}</td>
                                    <td class="border p-2">{{ $fund->updated_at }}</td>
                                    <td class="border p-2 text-center">
                                    <div class="flex justify-center gap-4">
                                        <a href="{{ route('investments.index') }}?fund_id={{ $fund->id }}"
                                        class="px-5 py-2 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100 transition duration-150 font-bold">
                                        View Investments
                                        </a>
                                </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border p-4 text-center text-gray-500">
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
