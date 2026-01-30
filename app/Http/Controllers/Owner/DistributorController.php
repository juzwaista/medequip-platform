<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = Distributor::where('user_id', Auth::id())->get();

        return view('owner.distributor.index', compact('distributors'));
    }

    public function create()
    {
        return view('owner.distributor.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:50',
        ]);

        Distributor::create([
            'user_id' => auth()->id(),
            'company_name' => $validated['company_name'],
            'address' => $validated['address'],
            'contact_number' => $validated['contact_number'],
            'is_verified' => 0,
        ]);

        return redirect()
            ->route('owner.distributors.index')
            ->with('success', 'Distributor added successfully.');
    }

}
