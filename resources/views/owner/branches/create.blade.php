@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold">Add Branch</h1>
            <p class="text-gray-500">Adding branch for: {{ $distributor->company_name }}</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('owner.distributors.branches.store', $distributor) }}" class="space-y-4">
                @csrf

                <!-- Branch Name -->
                <div>
                    <label class="block text-sm font-medium mb-1">Branch Name</label>
                    <input type="text" name="branch_name" required
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium mb-1">Address</label>
                    <textarea name="address" required rows="3"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"></textarea>
                </div>

                <!-- Contact Number -->
                <div>
                    <label class="block text-sm font-medium mb-1">Contact Number</label>
                    <input type="text" name="contact_number" required
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4 pt-4">
                    <a href="{{ route('owner.distributors.branches.index', $distributor) }}"
                        class="text-gray-600 hover:text-gray-900">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Save Branch
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection