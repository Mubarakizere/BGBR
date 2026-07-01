<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DenominationController;
use App\Http\Controllers\BattalionController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserApprovalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuditLogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Internal System Routes (bgbr.stockcenterapp.com)
|--------------------------------------------------------------------------
|
| All internal management routes run on the same domain as the public
| website. They use distinct paths (/login, /dashboard, /admin/...)
| that don't conflict with public pages.
|
*/

Route::get('/pending-approval', function () {
    return view('auth.pending-approval');
})->middleware(['auth'])->name('pending.approval');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'approved', 'fee_paid'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'approved', 'fee_paid'])->group(function () {
    // Registration Fee Routes
    Route::get('/pay-fee', [\App\Http\Controllers\RegistrationFeeController::class, 'create'])->name('fee.pay');
    Route::post('/pay-fee', [\App\Http\Controllers\RegistrationFeeController::class, 'store'])->name('fee.store');

    Route::prefix('admin')->middleware('can:approve fees')->group(function () {
        Route::get('/fees', [\App\Http\Controllers\Admin\RegistrationFeeController::class, 'index'])->name('admin.fees.index');
        Route::patch('/fees/{fee}/approve', [\App\Http\Controllers\Admin\RegistrationFeeController::class, 'approve'])->name('admin.fees.approve');
        Route::patch('/fees/{fee}/reject', [\App\Http\Controllers\Admin\RegistrationFeeController::class, 'reject'])->name('admin.fees.reject');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Hierarchy Management
    Route::resource('denominations', DenominationController::class)->middleware('can:manage denominations');
    Route::resource('zones', ZoneController::class)->middleware('can:manage denominations');
    Route::resource('battalions', BattalionController::class)->middleware('can:manage battalions');
    Route::resource('companies', CompanyController::class)->middleware('can:manage companies');
    Route::post('companies/{company}/officers', [CompanyController::class, 'assignOfficer'])->name('companies.officers.assign');
    Route::delete('companies/{company}/officers/{user}', [CompanyController::class, 'removeOfficer'])->name('companies.officers.remove');

    // Requests and Deposits
    Route::resource('materials-requests', App\Http\Controllers\MaterialsRequestController::class);
    Route::resource('account-deposits', App\Http\Controllers\AccountDepositController::class);

    // User Approvals
    Route::get('/admin/users/pending', [UserApprovalController::class, 'index'])->name('users.pending')->middleware('can:manage users');
    Route::post('/admin/users/bulk-approve', [UserApprovalController::class, 'bulkApprove'])->name('users.bulk-approve')->middleware('can:manage users');
    Route::patch('/admin/users/{user}/approve', [UserApprovalController::class, 'update'])->name('users.approve')->middleware('can:manage users');
    Route::delete('/admin/users/{user}/reject', [UserApprovalController::class, 'reject'])->name('users.reject')->middleware('can:manage users');

    // Members
    Route::post('/members/bulk-assign-company', [MemberController::class, 'bulkAssignCompany'])->name('members.bulk-assign-company');
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
    Route::post('activities/{activity}/participants/bulk', [ParticipationController::class, 'bulkStore'])
        ->name('activities.participants.bulk-store');
    Route::patch('activities/{activity}/participants/{member}/pay', [ParticipationController::class, 'markPaid'])
        ->name('activities.participants.pay');
    Route::patch('activities/{activity}/participants/bulk-pay', [ParticipationController::class, 'bulkMarkPaid'])
        ->name('activities.participants.bulk-pay');
    Route::delete('activities/{activity}/participants/{member}', [ParticipationController::class, 'remove'])
        ->name('activities.participants.remove');

    // Announcements
    Route::resource('announcements', AnnouncementController::class);
    Route::patch('announcements/{announcement}/approve', [AnnouncementController::class, 'approve'])->name('announcements.approve');

    // Notifications
    Route::patch('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::patch('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/fetch', [\App\Http\Controllers\NotificationController::class, 'fetchUnread'])->name('notifications.fetch');

    // User Management (Super Admin + Denomination Admin)
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index')->middleware('can:manage users');
    Route::patch('/admin/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active')->middleware('can:manage users');
    Route::patch('/admin/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.update-role')->middleware('can:manage users');

    // Role & Permission Management (Super Admin only)
    Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index')->middleware('can:manage system settings');
    Route::post('/admin/roles', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store')->middleware('can:manage system settings');
    Route::put('/admin/roles/{role}/permissions', [App\Http\Controllers\RoleController::class, 'updatePermissions'])->name('roles.permissions.update')->middleware('can:manage system settings');

    // Audit Logs (Super Admin only)
    Route::get('/admin/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index')->middleware('can:view audit logs');

    // ============================================================
    // Website CMS Management (Super Admin or 'manage website')
    // ============================================================
    Route::prefix('admin/website')->name('admin.website.')->middleware('can:manage website')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SiteDashboardController::class, 'index'])->name('dashboard');

        Route::resource('pages', App\Http\Controllers\Admin\SitePageController::class);
        Route::resource('leaders', App\Http\Controllers\Admin\SiteLeaderController::class);
        Route::resource('events', App\Http\Controllers\Admin\SiteEventController::class);
        Route::resource('news', App\Http\Controllers\Admin\SiteNewsController::class);
        Route::resource('gallery', App\Http\Controllers\Admin\SiteGalleryController::class);
        Route::resource('faqs', App\Http\Controllers\Admin\SiteFaqController::class);

        Route::get('contacts', [App\Http\Controllers\Admin\SiteContactController::class, 'index'])->name('contacts.index');
        Route::get('contacts/{contact}', [App\Http\Controllers\Admin\SiteContactController::class, 'show'])->name('contacts.show');
        Route::patch('contacts/{contact}/read', [App\Http\Controllers\Admin\SiteContactController::class, 'markRead'])->name('contacts.read');
        Route::delete('contacts/{contact}', [App\Http\Controllers\Admin\SiteContactController::class, 'destroy'])->name('contacts.destroy');
    });
});

require __DIR__.'/auth.php';
