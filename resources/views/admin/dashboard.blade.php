@extends('layouts.app')

@section('content')
    <div class="space-y-8">

        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold">Admin Dashboard</h1>
            <p class="text-gray-500">
                Overview of marketplace compliance and verification
            </p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-500">Total Business Profiles</p>
                <p class="text-3xl font-bold mt-2">
                    {{ $totalDistributors }}
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-500">Pending Profiles</p>
                <p class="text-3xl font-bold text-yellow-600 mt-2">
                    {{ $pendingDistributors }}
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-500">Verified Profiles</p>
                <p class="text-3xl font-bold text-green-600 mt-2">
                    {{ $verifiedDistributors }}
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-500">Pending Licenses</p>
                <p class="text-3xl font-bold text-red-600 mt-2">
                    {{ $pendingLicenses }}
                </p>
            </div>

        </div>

        <!-- Primary Action -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-2">
                Pending Reviews
            </h2>
            <p class="text-sm text-gray-600 mb-4">
                Review distributor registrations and uploaded licenses.
            </p>

            <a href="{{ route('admin.verifications.index') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Go to Verification Queue
            </a>
        </div>

    </div>
@endsection