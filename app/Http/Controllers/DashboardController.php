<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Company;
use App\Models\Battalion;
use App\Models\AccountDeposit;
use App\Models\Report;
use App\Models\User;
use App\Models\Announcement;
use App\Models\Activity;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        // TenantScope automatically scopes these queries based on the user's role/domain.
        $totalMembers = Member::count();
        $totalCompanies = Company::count();
        $totalBattalions = Battalion::count();
        
        $totalFeesCollected = AccountDeposit::sum('amount');
        
        $pendingReports = Report::where('status', 'submitted')->count();
        $pendingUsers = User::where('is_approved', false)->count();

        // Premium graphics for admins (e.g. Member Growth Chart)
        $chartData = null;
        if ($user->can('manage system settings')) {
            $months = collect();
            $membersData = collect();
            
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $months->push($date->format('M Y'));
                
                // Tenant scope will still apply here, so it works securely
                $membersData->push(Member::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count());
            }

            $chartData = [
                'labels' => $months->toArray(),
                'series' => $membersData->toArray(),
            ];
        }

        // Dynamic Data Feeds based on Permissions
        
        // Announcements
        $latestAnnouncements = collect();
        if ($user->can('view announcements') || $user->can('view company announcements') || $user->can('create battalion announcements') || $user->can('create company announcements') || $user->can('create denomination announcements')) {
            $latestAnnouncements = Announcement::latest()->take(3)->get();
        }

        // Activities
        $upcomingActivities = collect();
        if ($user->can('participate in activities') || $user->can('manage activities')) {
            $upcomingActivities = Activity::where('date', '>=', now()->toDateString())->orderBy('date', 'asc')->take(3)->get();
        }

        // Recent Members
        $recentMembers = collect();
        if ($user->can('view members')) {
            $recentMembers = Member::latest()->take(3)->get();
        }

        // Pending Users
        $pendingUsersList = collect();
        if ($user->can('manage users')) {
            $pendingUsersList = User::where('is_approved', false)->latest()->take(3)->get();
        }

        // Pending Reports
        $pendingReportsList = collect();
        if ($user->can('view all reports') || $user->can('approve battalion reports') || $user->can('approve company reports')) {
            $pendingReportsList = Report::where('status', 'submitted')->latest()->take(3)->get();
        }

        // Calendar Activities (all activities for current month)
        $calendarActivities = Activity::whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->get(['id', 'title', 'date', 'location']);

        $myCommand = null;
        if ($user->hasRole('Battalion Commander') && $user->battalion_id) {
            $myCommand = Battalion::with('companies')->find($user->battalion_id);
            if ($myCommand) {
                $myCommand->type = 'Battalion';
            }
        } else {
            $officerCompany = $user->officeredCompanies()->first();
            if ($officerCompany) {
                $myCommand = Company::with('members')->find($officerCompany->id);
                if ($myCommand) {
                    $myCommand->type = 'Company';
                }
            }
        }

        return view('dashboard', compact(
            'totalMembers',
            'totalCompanies',
            'totalBattalions',
            'totalFeesCollected',
            'pendingReports',
            'pendingUsers',
            'chartData',
            'latestAnnouncements',
            'upcomingActivities',
            'recentMembers',
            'pendingUsersList',
            'pendingReportsList',
            'calendarActivities',
            'myCommand'
        ));
    }
}
