@extends('layouts.app')

@section('content')
<div class="space-y-8">

    <!-- Page Header -->
    <div>
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <p class="text-gray-500">
            Overview of your distributors and verification status
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-500">Total Distributors</p>
            <p class="text-3xl font-bold mt-2">
                {{ $totalDistributors }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-500">Verified</p>
            <p class="text-3xl font-bold text-green-600 mt-2">
                {{ $verified }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-500">Pending Verification</p>
            <p class="text-3xl font-bold text-yellow-600 mt-2">
                {{ $pending }}
            </p>
        </div>

    </div>

    <!-- Next Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Next Actions</h2>

        @if($pending > 0)
            <p class="text-sm text-gray-600 mb-4">
                Some distributors are still pending verification.
                Upload required licenses to proceed.
            </p>
        @else
            <p class="text-sm text-gray-600 mb-4">
                All distributors are verified and ready.
            </p>
        @endif

        <a href="{{ route('owner.distributors.index') }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Manage Distributors
        </a>
    </div>

</div>
@endsection
