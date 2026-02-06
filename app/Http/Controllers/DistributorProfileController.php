<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DistributorProfileController extends Controller
{
    /**
     * Display the public distributor profile
     */
    public function show($slug)
    {
        $distributor = Distributor::with(['owner', 'products.inventory', 'products.category'])
            ->where('slug', $slug)
            ->firstOrFail();
        
        // Get active products only (with stock)
        $products = $distributor->products()
            ->with(['inventory', 'category', 'images'])
            ->whereHas('inventory', function($query) {
                $query->where('quantity', '>', 0);
            })
            ->paginate(12);
        
        // Calculate stats
        $stats = [
            'total_products' => $distributor->products()->count(),
            'years_active' => now()->diffInYears($distributor->created_at),
            'active_since' => $distributor->created_at->format('Y'),
        ];
        
        return Inertia::render('Seller/Profile', [
            'distributor' => $distributor,
            'products' => $products,
            'stats' => $stats,
        ]);
    }
}
