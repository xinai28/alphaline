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
                        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Create Investor Form -->
                    <form action="{{ route('investors.store') }}" method="POST" class="mb-6 space-y-2">
                        @csrf
                        <input type="text" name="name" placeholder="Name" class="border p-2 w-full" required>
                        <input type="email" name="email" placeholder="Email" class="border p-2 w-full" required>
                        <input type="text" name="contact_number" placeholder="Contact Number" class="border p-2 w-full">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
                    </form>

                    <!-- Investor Table -->
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">Name</th>
                                <th class="border p-2">Email</th>
                                <th class="border p-2">Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($investors as $investor)
                                <tr>
                                    <td class="border p-2">{{ $investor->name }}</td>
                                    <td class="border p-2">{{ $investor->email }}</td>
                                    <td class="border p-2">{{ $investor->contact_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
