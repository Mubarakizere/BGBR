<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DominationController;
use App\Http\Controllers\BattalionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserApprovalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuditLogController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
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
    Route::delete('/admin/users/{user}/reject', [UserApprovalController::class, 'reject'])->name('users.reject')->middleware('can:manage users');

    // Members
    Route::resource('members', MemberController::class);

    // Activities
    Route::resource('activities', ActivityController::class);

    // Reports
    Route::resource('reports', \App\Http\Controllers\ReportController::class)->except(['edit', 'update']);
    Route::post('reports/{report}/submit', [\App\Http\Controllers\ReportController::class, 'submit'])->name('reports.submit');
    Route::post('reports/{report}/approve', [\App\Http\Controllers\ReportController::class, 'approve'])->name('reports.approve');
    Route::post('reports/{report}/reject', [\App\Http\Controllers\ReportController::class, 'reject'])->name('reports.reject');
    Route::get('reports/{report}/pdf', [\App\Http\Controllers\ReportController::class, 'downloadPdf'])->name('reports.pdf');
    Route::get('reports/{report}/excel', [\App\Http\Controllers\ReportController::class, 'downloadExcel'])->name('reports.excel');

    // Participation
    Route::post('activities/{activity}/participants', [ParticipationController::class, 'store'])
        ->name('activities.participants.store');
    Route::patch('activities/{activity}/participants/{member}/pay', [ParticipationController::class, 'markPaid'])
        ->name('activities.participants.pay');
    Route::delete('activities/{activity}/participants/{member}', [ParticipationController::class, 'remove'])
        ->name('activities.participants.remove');

    // Announcements
    Route::resource('announcements', AnnouncementController::class);

    // Notifications
    Route::patch('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::patch('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // User Management (Super Admin + Domination Admin)
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index')->middleware('can:manage users');
    Route::patch('/admin/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active')->middleware('can:manage users');
    Route::patch('/admin/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.update-role')->middleware('can:manage users');

    // Role & Permission Management (Super Admin only)
    Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index')->middleware('can:manage system settings');
    Route::post('/admin/roles', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store')->middleware('can:manage system settings');
    Route::put('/admin/roles/{role}/permissions', [App\Http\Controllers\RoleController::class, 'updatePermissions'])->name('roles.permissions.update')->middleware('can:manage system settings');

    // Audit Logs (Super Admin only)
    Route::get('/admin/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index')->middleware('can:view audit logs');
});

require __DIR__.'/auth.php';

