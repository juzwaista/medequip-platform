@extends('layouts.app')

@section('content')
<div class="max-w-3xl space-y-8">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold">Add Distributor</h1>
        <p class="text-gray-500">
            Register a new medical equipment distributor under your account
        </p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST"
              action="{{ route('owner.distributors.store') }}"
              class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">
                    Company Name
                </label>
                <input type="text" name="company_name" required
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Address
                </label>
                <input type="text" name="address" required
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Contact Number
                </label>
                <input type="text" name="contact_number" required
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('owner.distributors.index') }}"
                   class="text-gray-600 hover:underline">
                    Cancel
                </a>

                <button
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Save Distributor
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
