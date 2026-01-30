<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\DistributorController;
use App\Http\Controllers\Owner\LicenseController;
use App\Http\Controllers\Admin\VerificationController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Default Auth Dashboard (Breeze default)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
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

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| OWNER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        // Owner Dashboard
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])
            ->name('dashboard');

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

        // Admin Verification Dashboard
        Route::get('/verifications', [VerificationController::class, 'index'])
            ->name('verifications.index');

        Route::get('/dashboard', [VerificationController::class, 'dashboard'])
                ->name('dashboard');

        Route::post('/verifications/{distributor}/approve', [VerificationController::class, 'approve'])
            ->name('verifications.approve');

        Route::post('/verifications/{distributor}/reject', [VerificationController::class, 'reject'])
            ->name('verifications.reject');
    });

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
