@extends('layouts.app')

@section('content')
    <div class="max-w-3xl space-y-8">

        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold">Create Business Profile</h1>
            <p class="text-gray-500">
                Register your business profile for medical equipment distribution
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('owner.distributors.store') }}" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Company Name
                    </label>
                    <input type="text" name="company_name" required class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Address
                    </label>
                    <input type="text" name="address" required class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Contact Number
                    </label>
                    <input type="text" name="contact_number" required class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Email Address
                    </label>
                    <input type="email" name="email" required class="w-full border rounded px-3 py-2">
                </div>

                <!-- Document Uploads -->
                <div class="border-t pt-4 mt-4">
                    <h3 class="font-medium mb-3">Required Documents</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Please upload the following documents for verification. Accepted formats: PDF, JPG, PNG (Max 2MB
                        each)
                    </p>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Valid ID <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="valid_id" required accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full border rounded px-3 py-2">
                            <p class="text-xs text-gray-500 mt-1">Government-issued ID (Driver's License, Passport, etc.)
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Business License <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="business_license" required accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full border rounded px-3 py-2">
                            <p class="text-xs text-gray-500 mt-1">FDA License, DTI Registration, or similar business permit
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <a href="{{ route('owner.distributors.index') }}" class="text-gray-600 hover:underline">
                        Cancel
                    </a>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Create Profile
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection