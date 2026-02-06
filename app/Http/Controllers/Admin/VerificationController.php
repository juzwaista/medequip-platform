<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use App\Models\License;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        $distributors = Distributor::with('licenses')->get();

        return view('admin.verification.index', compact('distributors'));
    }

    public function approve(Distributor $distributor)
    {
        $distributor->update([
            'is_verified' => true,
        ]);

        $distributor->licenses()->update([
            'status' => 'approved',
        ]);

        return back()->with('success', 'Business profile approved.');
    }

    public function reject(Distributor $distributor)
    {
        $distributor->licenses()->update([
            'status' => 'rejected',
        ]);

        return back()->with('error', 'Business profile rejected.');
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalDistributors' => Distributor::count(),
            'pendingDistributors' => Distributor::where('is_verified', 0)->count(),
            'verifiedDistributors' => Distributor::where('is_verified', 1)->count(),
            'pendingLicenses' => License::where('status', 'pending')->count(),
        ]);
    }
}
