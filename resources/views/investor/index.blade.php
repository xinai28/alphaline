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

                    <!-- Success message -->
                    @if(session('success'))
                        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Create New Investor Button -->
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
                            @foreach($investors as $investor)
                                <tr>
                                    <td class="border p-2">{{ $investor->name }}</td>
                                    <td class="border p-2">{{ $investor->email }}</td>
                                    <td class="border p-2">{{ $investor->contact_number }}</td>
                                    <td class="border p-2">
    <div class="flex gap-2 justify-center">
        <!-- View Investments -->
        <a href="{{ route('investors.investments', $investor->id) }}"
           class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-md hover:bg-indigo-100 transition duration-150 text-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            View Investments
        </a>

        <!-- Edit -->
        <a href="{{ route('investors.edit', $investor->id) }}"
           class="inline-flex items-center px-3 py-1.5 bg-amber-50 text-amber-700 rounded-md hover:bg-amber-100 transition duration-150 text-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit
        </a>
    </div>
</td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
