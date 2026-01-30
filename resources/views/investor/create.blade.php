<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Investor
        </h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Create Investor Form -->
            <form action="{{ route('investors.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Name -->
                <div class="flex flex-col">
                    <label for="name" class="mb-1 font-medium text-gray-700">Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        class="border rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        required
                    >
                </div>

                <!-- Email -->
                <div class="flex flex-col">
                    <label for="email" class="mb-1 font-medium text-gray-700">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        class="border rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        required
                    >
                </div>

                <!-- Contact Number -->
                <div class="flex flex-col">
                    <label for="contact_number" class="mb-1 font-medium text-gray-700">Contact Number</label>
                    <input 
                        type="text" 
                        id="contact_number" 
                        name="contact_number" 
                        value="{{ old('contact_number') }}" 
                        class="border rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    >
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('investors.index') }}" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Create</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
