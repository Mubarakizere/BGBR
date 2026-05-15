<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DominationController;
use App\Http\Controllers\BattalionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserApprovalController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ParticipationController;
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
    Route::post('companies/{company}/officers', [CompanyController::class, 'assignOfficer'])->name('companies.officers.assign');
    Route::delete('companies/{company}/officers/{user}', [CompanyController::class, 'removeOfficer'])->name('companies.officers.remove');

    // Requests and Deposits
    Route::resource('materials-requests', App\Http\Controllers\MaterialsRequestController::class);
    Route::resource('account-deposits', App\Http\Controllers\AccountDepositController::class);

    // User Approvals
    Route::get('/admin/users/pending', [UserApprovalController::class, 'index'])->name('users.pending')->middleware('can:manage users');
    Route::patch('/admin/users/{user}/approve', [UserApprovalController::class, 'update'])->name('users.approve')->middleware('can:manage users');

    // Members
    Route::resource('members', MemberController::class);

    // Activities
    Route::resource('activities', ActivityController::class);

    // Participation
    Route::post('activities/{activity}/participants', [ParticipationController::class, 'store'])
        ->name('activities.participants.store');
    Route::patch('activities/{activity}/participants/{member}/pay', [ParticipationController::class, 'markPaid'])
        ->name('activities.participants.pay');
    Route::delete('activities/{activity}/participants/{member}', [ParticipationController::class, 'remove'])
        ->name('activities.participants.remove');
});

require __DIR__.'/auth.php';

