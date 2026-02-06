<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\OrderController;
use App\Http\Controllers\Owner\DistributorController;
use App\Http\Controllers\Owner\LicenseController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/products');
})->name('landing');


// Product Routes (Public)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/category/{category}', [ProductController::class, 'byCategory'])->name('products.category');

// Cart Routes
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{productId}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{productId}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [\App\Http\Controllers\CartController::class, 'count'])->name('cart.count');

// Checkout and Orders (Auth required)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'placeOrder'])->name('orders.place');
    Route::get('/orders/confirmation/{order}', [\App\Http\Controllers\OrderController::class, 'confirmation'])->name('orders.confirmation');

    // Customer order tracking
    Route::get('/my-orders', [\App\Http\Controllers\CustomerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\CustomerOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [\App\Http\Controllers\CustomerOrderController::class, 'cancel'])->name('orders.cancel');
    
    // Saved Addresses
    Route::get('/addresses', [\App\Http\Controllers\CustomerAddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [\App\Http\Controllers\CustomerAddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [\App\Http\Controllers\CustomerAddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [\App\Http\Controllers\CustomerAddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/default', [\App\Http\Controllers\CustomerAddressController::class, 'setDefault'])->name('addresses.setDefault');
});

// Public Seller Profile
Route::get('/seller/{slug}', [\App\Http\Controllers\DistributorProfileController::class, 'show'])->name('seller.profile');

/*
|--------------------------------------------------------------------------
| Default Auth Dashboard (Breeze default)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return redirect('/products');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/password', [ProfileController::class, 'updatePassword'])
        ->name('password.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Account Settings
    Route::get('/settings', [ProfileController::class, 'edit'])
        ->name('settings');

    // Privacy Settings (placeholder)
    Route::get('/privacy', function () {
        return \Inertia\Inertia::render('Settings/Privacy');
    })->name('privacy');
});

/*
|--------------------------------------------------------------------------
| DISTRIBUTOR ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:distributor'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        // Owner Dashboard
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])
            ->name('dashboard');

        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('/orders/{order}/note', [OrderController::class, 'addNote'])->name('orders.addNote');

        // Distributor Management
        Route::get('/distributors', [DistributorController::class, 'index'])
            ->name('distributors.index');

        Route::get('/distributor/create', [DistributorController::class, 'create'])
            ->name('distributors.create');

        Route::post('/distributor/store', [DistributorController::class, 'store'])
            ->name('distributors.store');

        // License Upload
        Route::get(
            '/distributor/{distributor}/license/create',
            [LicenseController::class, 'create']
        )->name('licenses.create');

        Route::post(
            '/distributor/{distributor}/license/store',
            [LicenseController::class, 'store']
        )->name('licenses.store');

        // Inventory Management (Unified Product + Stock)
        Route::resource('inventory', \App\Http\Controllers\Owner\InventoryController::class, [
            'names' => [
                'index' => 'inventory.index',
                'create' => 'inventory.create',
                'store' => 'inventory.store',
                'edit' => 'inventory.edit',
                'update' => 'inventory.update',
                'destroy' => 'inventory.destroy',
            ]
        ]);
        
        // Stock adjustment endpoint
        Route::post('/inventory/{id}/adjust', [\App\Http\Controllers\Owner\InventoryController::class, 'adjustStock'])
            ->name('inventory.adjust');

        // Redirect old product routes to inventory
        Route::redirect('/products', '/owner/inventory');
        Route::redirect('/products/create', '/owner/inventory/create');
        
        // Profile Management
        Route::get('/profile/edit', [\App\Http\Controllers\Owner\ProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Owner\ProfileController::class, 'update'])
            ->name('profile.update');
        Route::post('/profile/check-slug', [\App\Http\Controllers\Owner\ProfileController::class, 'checkSlug'])
            ->name('profile.checkSlug');

        // Product Management (legacy - keeping for now)
        Route::resource('products', \App\Http\Controllers\Owner\ProductController::class, [
            'names' => [
                'index' => 'products.index',
                'create' => 'products.create',
                'store' => 'products.store',
                'edit' => 'products.edit',
                'update' => 'products.update',
                'destroy' => 'products.destroy',
            ]
        ]);

        // Branch Management
        Route::get('/distributor/{distributor}/branches', function () {
            return \Inertia\Inertia::render('Owner/Branches/Index', [
                'message' => 'Branch management is coming soon!'
            ]);
        })->name('distributors.branches.index');

        Route::get('/distributor/{distributor}/branches/create', function () {
            return \Inertia\Inertia::render('Owner/Branches/Create');
        })->name('distributors.branches.create');

        // Route::post('/distributor/{distributor}/branches', [BranchController::class, 'store'])
        //     ->name('distributors.branches.store');
    });

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // Distributor Verification
        Route::post('/distributors/{id}/approve', [\App\Http\Controllers\Admin\DashboardController::class, 'approveDistributor'])
            ->name('distributors.approve');

        Route::post('/distributors/{id}/reject', [\App\Http\Controllers\Admin\DashboardController::class, 'rejectDistributor'])
            ->name('distributors.reject');

        // TODO: Implement VerificationController for advanced features
        // Route::get('/verifications', [VerificationController::class, 'index'])
        //     ->name('verifications.index');
        // Route::post('/verifications/{distributor}/approve', [VerificationController::class, 'approve'])
        //     ->name('verifications.approve');
        // Route::post('/verifications/{distributor}/reject', [VerificationController::class, 'reject'])
        //     ->name('verifications.reject');
    });

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
