<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Company;
use App\Models\Battalion;
use App\Services\ReportGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportGeneratorService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        $user = Auth::user();
        $query = Report::latest();

        if ($user->hasRole('Company Captain') || $user->hasRole('Company Officer')) {
            $query->where('level', 'company')->where('entity_id', $user->company_id);
        } elseif ($user->hasRole('Battalion Commander')) {
            $query->where(function($q) use ($user) {
                $q->where(function($q2) use ($user) {
                    $q2->where('level', 'battalion')->where('entity_id', $user->battalion_id);
                })->orWhere(function($q2) use ($user) {
                    $companyIds = Battalion::find($user->battalion_id)->companies->pluck('id');
                    $q2->where('level', 'company')->whereIn('entity_id', $companyIds);
                });
            });
        } elseif ($user->hasRole('Domination Admin') || $user->hasRole('Super Admin')) {
            // Can see everything generally, or filter as needed.
        } else {
            // Regular members shouldn't see reports.
            $query->where('id', null);
        }

        $reports = $query->paginate(15);
        return view('reports.index', compact('reports'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $type = $request->input('type');

        $report = new Report();
        $report->status = 'draft';
        
        if ($type === 'company_summary' && $user->company_id) {
            $company = Company::find($user->company_id);
            $report->title = 'Company Report: ' . $company->name;
            $report->level = 'company';
            $report->entity_id = $company->id;
            $report->type = 'company_summary';
            $report->content = $this->reportService->generateCompanySnapshot($company);
        } elseif ($type === 'battalion_summary' && $user->battalion_id) {
            $battalion = Battalion::find($user->battalion_id);
            $report->title = 'Battalion Report: ' . $battalion->name;
            $report->level = 'battalion';
            $report->entity_id = $battalion->id;
            $report->type = 'battalion_summary';
            $report->content = $this->reportService->generateBattalionSnapshot($battalion);
        } elseif ($type === 'financial' && ($user->hasRole('Super Admin') || $user->hasRole('Domination Admin'))) {
            $report->title = 'Global Financial Report';
            $report->level = 'financial';
            $report->entity_id = $user->id; // Placeholder
            $report->type = 'financial';
            $report->content = $this->reportService->generateFinancialSnapshot();
        } else {
            return back()->with('error', 'Unauthorized to generate this report type.');
        }

        $report->save();
        return redirect()->route('reports.show', $report)->with('success', 'Draft report generated.');
    }

    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    public function submit(Report $report)
    {
        $report->update([
            'status' => 'submitted',
            'submitted_by' => Auth::id(),
        ]);
        return back()->with('success', 'Report submitted for approval.');
    }

    public function approve(Request $request, Report $report)
    {
        $report->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'reviewer_notes' => $request->input('reviewer_notes'),
        ]);
        return back()->with('success', 'Report approved.');
    }

    public function reject(Request $request, Report $report)
    {
        $report->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'reviewer_notes' => $request->input('reviewer_notes'),
        ]);
        return back()->with('success', 'Report rejected.');
    }

    public function downloadPdf(Report $report)
    {
        $view = 'reports.pdf.' . str_replace('_summary', '', $report->type);
        $pdf = Pdf::loadView($view, ['report' => $report]);
        return $pdf->download(Str::slug($report->title) . '.pdf');
    }

    public function downloadExcel(Report $report)
    {
        return Excel::download(new ReportExport($report), Str::slug($report->title) . '.xlsx');
    }

    public function destroy(Report $report)
    {
        if (in_array($report->status, ['draft', 'rejected'])) {
            $report->delete();
            return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
        }
        return back()->with('error', 'Only draft or rejected reports can be deleted.');
    }
}
