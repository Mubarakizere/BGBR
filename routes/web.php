<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DominationController;
use App\Http\Controllers\BattalionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserApprovalController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/pending-approval', function () {
    return view('auth.pending-approval');
})->middleware(['auth'])->name('pending.approval');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'approved'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'approved'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Hierarchy Management
    Route::resource('dominations', DominationController::class)->middleware('can:manage dominations');
    Route::resource('battalions', BattalionController::class)->middleware('can:manage battalions');
    Route::resource('companies', CompanyController::class)->middleware('can:manage companies');

    // User Approvals
    Route::get('/admin/users/pending', [UserApprovalController::class, 'index'])->name('users.pending')->middleware('can:manage users');
    Route::patch('/admin/users/{user}/approve', [UserApprovalController::class, 'update'])->name('users.approve')->middleware('can:manage users');
});

require __DIR__.'/auth.php';
