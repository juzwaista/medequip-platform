@extends('layouts.app')

@section('content')
<div class="max-w-3xl space-y-8">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold">Upload License</h1>
        <p class="text-gray-500">
            Submit accreditation documents for verification
        </p>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded p-4 text-sm text-blue-700">
        Uploaded licenses will be reviewed by an administrator before approval.
    </div>

    <!-- Upload Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST"
              action="{{ route('owner.licenses.store', $distributor->id) }}"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">
                    License Type
                </label>
                <select name="type" required
                        class="w-full border rounded px-3 py-2">
                    <option value="">Select license type</option>
                    <option value="FDA">FDA License</option>
                    <option value="DOH">DOH Accreditation</option>
                    <option value="Business">Business Permit</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Upload File (PDF / Image)
                </label>
                <input type="file" name="file" required
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('owner.distributors.index') }}"
                   class="text-gray-600 hover:underline">
                    Cancel
                </a>

                <button
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Submit License
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
