<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Company;
use App\Models\Battalion;
use App\Models\AccountDeposit;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // TenantScope automatically scopes these queries based on the user's role/domain.
        $totalMembers = Member::count();
        $totalCompanies = Company::count();
        $totalBattalions = Battalion::count();
        
        $totalFeesCollected = AccountDeposit::sum('amount');
        
        $pendingReports = Report::where('status', 'submitted')->count();
        $pendingUsers = User::where('is_approved', false)->count();

        // Premium graphics for admins (e.g. Member Growth Chart)
        $chartData = null;
        if ($request->user()->can('manage system settings')) {
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

        return view('dashboard', compact(
            'totalMembers',
            'totalCompanies',
            'totalBattalions',
            'totalFeesCollected',
            'pendingReports',
            'pendingUsers',
            'chartData'
        ));
    }
}
