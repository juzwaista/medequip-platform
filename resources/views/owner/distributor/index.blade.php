@extends('layouts.app')

@section('content')
    <div class="space-y-8">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Business Profile</h1>
                <p class="text-gray-500">
                    Manage your business profile and verification status
                </p>
            </div>

            <a href="{{ route('owner.distributors.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Create Business Profile
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded">
                {{ session('success') }}
            </div>
        @endif


        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">

            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-left">Company</th>
                        <th class="p-4 text-left">Contact</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($distributors as $distributor)
                        <tr class="border-t">
                            <td class="p-4 font-medium">
                                {{ $distributor->company_name }}
                            </td>

                            <td class="p-4 text-gray-600">
                                {{ $distributor->contact_number }}
                            </td>

                            <td class="p-4">
                                @if($distributor->is_verified)
                                    <span class="text-green-600 font-semibold">
                                        Verified
                                    </span>
                                @else
                                    <span class="text-yellow-600 font-semibold">
                                        Pending
                                    </span>
                                @endif
                            </td>

                            <td class="p-4 space-x-4">
                                <a href="{{ route('owner.distributors.branches.index', $distributor) }}"
                                    class="text-blue-600 hover:underline">
                                    Manage Branches
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">
                                No business profile created yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection