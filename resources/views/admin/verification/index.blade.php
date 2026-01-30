@extends('layouts.app')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold">Verification Queue</h1>
        <p class="text-gray-500">
            Review distributor credentials and submitted licenses
        </p>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-4 text-left">Company</th>
                    <th class="p-4 text-left">Licenses</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($distributors as $d)
                <tr class="border-t">
                    <td class="p-4 font-medium">
                        {{ $d->company_name }}
                    </td>

                    <td class="p-4 space-y-1">
                        @foreach($d->licenses as $l)
                            <a href="{{ asset('storage/'.$l->file_path) }}"
                               target="_blank"
                               class="text-blue-600 hover:underline block">
                                {{ $l->type }} ({{ ucfirst($l->status) }})
                            </a>
                        @endforeach
                    </td>

                    <td class="p-4">
                        @if($d->is_verified)
                            <span class="text-green-600 font-semibold">
                                Verified
                            </span>
                        @else
                            <span class="text-yellow-600 font-semibold">
                                Pending
                            </span>
                        @endif
                    </td>

                    <td class="p-4 space-x-2">
                        @if(!$d->is_verified)
                            <form method="POST"
                                  action="{{ route('admin.verifications.approve', $d->id) }}"
                                  class="inline">
                                @csrf
                                <button
                                    class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                    Approve
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('admin.verifications.reject', $d->id) }}"
                                  class="inline">
                                @csrf
                                <button
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                    Reject
                                </button>
                            </form>
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-500">
                        No pending verifications.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
