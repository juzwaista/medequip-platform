<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function create(Distributor $distributor)
    {
        return view('owner.license.create', compact('distributor'));
    }

    public function store(Request $request, Distributor $distributor)
    {
        $request->validate([
            'type' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('file')->store('licenses', 'public');

        License::create([
            'distributor_id' => $distributor->id,
            'type' => $request->type,
            'file_path' => $path,
        ]);

        return redirect()
            ->route('owner.distributors.index')
            ->with('success', 'License submitted for verification.');
    }
}
