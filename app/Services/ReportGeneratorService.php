<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Battalion;
use App\Models\Member;
use App\Models\Activity;
use App\Models\AccountDeposit;
use App\Models\MaterialsRequest;

class ReportGeneratorService
{
    /**
     * Generate snapshot data for a company report.
     */
    public function generateCompanySnapshot(Company $company): array
    {
        $members = $company->members;
        $totalMembers = $members->count();
        $paidMembers = $members->where('registration_fee_paid', true)->count();
        $contributionPercentage = $totalMembers > 0 ? round(($paidMembers / $totalMembers) * 100, 2) : 0;

        $recentRequests = MaterialsRequest::where('company_id', $company->id)
            ->latest()
            ->take(5)
            ->get(['item_name', 'quantity', 'status', 'created_at']);

        return [
            'metrics' => [
                'total_members' => $totalMembers,
                'paid_members' => $paidMembers,
                'contribution_percentage' => $contributionPercentage,
            ],
            'members' => $members->map(function ($m) {
                return [
                    'id' => $m->id,
                    'name' => $m->name,
                    'rank' => $m->rank,
                    'registration_fee_paid' => $m->registration_fee_paid,
                ];
            })->toArray(),
            'recent_materials_requests' => $recentRequests->toArray(),
            'generated_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Generate snapshot data for a battalion report.
     */
    public function generateBattalionSnapshot(Battalion $battalion): array
    {
        $companies = $battalion->companies;
        $totalMembers = 0;
        $paidMembers = 0;
        $companyData = [];

        foreach ($companies as $company) {
            $cTotal = $company->members()->count();
            $cPaid = $company->members()->where('registration_fee_paid', true)->count();
            $cPerc = $cTotal > 0 ? round(($cPaid / $cTotal) * 100, 2) : 0;

            $totalMembers += $cTotal;
            $paidMembers += $cPaid;

            $companyData[] = [
                'id' => $company->id,
                'name' => $company->name,
                'total_members' => $cTotal,
                'paid_members' => $cPaid,
                'contribution_percentage' => $cPerc,
            ];
        }

        $contributionPercentage = $totalMembers > 0 ? round(($paidMembers / $totalMembers) * 100, 2) : 0;

        $deposits = AccountDeposit::where('level', 'battalion')
            ->where('entity_id', $battalion->id)
            ->sum('amount');

        return [
            'metrics' => [
                'total_members' => $totalMembers,
                'paid_members' => $paidMembers,
                'contribution_percentage' => $contributionPercentage,
                'total_deposits' => (float) $deposits,
            ],
            'companies' => $companyData,
            'generated_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Generate snapshot data for a global financial report.
     */
    public function generateFinancialSnapshot(): array
    {
        $totalDeposits = AccountDeposit::sum('amount');
        
        // Sum of all participation fees where fee_paid is true
        $totalActivityFees = \DB::table('activity_member')
            ->join('activities', 'activity_member.activity_id', '=', 'activities.id')
            ->where('activity_member.fee_paid', true)
            ->sum('activities.participation_fee');

        // Number of requests
        $materialRequestsStats = [
            'pending' => MaterialsRequest::where('status', 'pending')->count(),
            'approved' => MaterialsRequest::where('status', 'approved')->count(),
            'rejected' => MaterialsRequest::where('status', 'rejected')->count(),
            'fulfilled' => MaterialsRequest::where('status', 'fulfilled')->count(),
        ];

        return [
            'metrics' => [
                'total_deposits' => (float) $totalDeposits,
                'total_activity_fees_collected' => (float) $totalActivityFees,
                'total_income' => (float) ($totalDeposits + $totalActivityFees),
            ],
            'material_requests' => $materialRequestsStats,
            'generated_at' => now()->toIso8601String(),
        ];
    }
}
