<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
    $totalDistributors = auth()->user()->distributors()->count();
    $verified = auth()->user()->distributors()->where('is_verified', 1)->count();
    $pending = auth()->user()->distributors()->where('is_verified', 0)->count();

    return view('owner.dashboard', compact(
        'totalDistributors',
        'verified',
        'pending'
    ));
    }
}
