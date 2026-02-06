<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Distributor;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Distributor $distributor)
    {
        // Ensure user owns the distributor
        if ($distributor->user_id !== auth()->id()) {
            abort(403);
        }

        $branches = $distributor->branches()->paginate(10);
        return view('owner.branches.index', compact('distributor', 'branches'));
    }

    public function create(Distributor $distributor)
    {
        if ($distributor->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$distributor->is_verified) {
            return redirect()->route('owner.distributors.branches.index', $distributor)
                ->with('error', 'You must be verified before you can add branches.');
        }

        return view('owner.branches.create', compact('distributor'));
    }

    public function store(Request $request, Distributor $distributor)
    {
        if ($distributor->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$distributor->is_verified) {
            abort(403, 'Distributor must be verified to add branches.');
        }

        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:50',
        ]);

        $distributor->branches()->create($validated);

        return redirect()->route('owner.distributors.branches.index', $distributor)
            ->with('success', 'Branch added successfully');
    }
}
