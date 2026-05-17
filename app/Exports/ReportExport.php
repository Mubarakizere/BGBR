<?php

namespace App\Exports;

use App\Models\Report;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportExport implements FromView, ShouldAutoSize
{
    protected $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function view(): View
    {
        $viewName = 'reports.pdf.' . str_replace('_summary', '', $this->report->type);
        return view($viewName, [
            'report' => $this->report,
            'isExcel' => true
        ]);
    }
}
