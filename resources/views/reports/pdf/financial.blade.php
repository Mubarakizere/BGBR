@extends(isset($isExcel) && $isExcel ? 'reports.pdf.excel_layout' : 'reports.pdf.layout')

@section('content')
    @if(isset($isExcel))
        <table>
            <thead>
                <tr>
                    <th>Total Deposits</th>
                    <th>Activity Fees</th>
                    <th>Total Income</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $report->content['metrics']['total_deposits'] }}</td>
                    <td>{{ $report->content['metrics']['total_activity_fees_collected'] }}</td>
                    <td>{{ $report->content['metrics']['total_income'] }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <table class="metrics-grid">
            <tr>
                <td>
                    <div class="metric-label">Total Deposits</div>
                    <div class="metric-value">RWF {{ number_format($report->content['metrics']['total_deposits'], 2) }}</div>
                </td>
                <td>
                    <div class="metric-label">Activity Fees</div>
                    <div class="metric-value">RWF {{ number_format($report->content['metrics']['total_activity_fees_collected'], 2) }}</div>
                </td>
                <td>
                    <div class="metric-label">Total Income</div>
                    <div class="metric-value">RWF {{ number_format($report->content['metrics']['total_income'], 2) }}</div>
                </td>
            </tr>
        </table>

        <h3>Material Requests Overview</h3>
        <table class="data-table" style="width: 50%;">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pending</td>
                    <td>{{ $report->content['material_requests']['pending'] }}</td>
                </tr>
                <tr>
                    <td>Approved</td>
                    <td>{{ $report->content['material_requests']['approved'] }}</td>
                </tr>
                <tr>
                    <td>Rejected</td>
                    <td>{{ $report->content['material_requests']['rejected'] }}</td>
                </tr>
                <tr>
                    <td>Fulfilled</td>
                    <td>{{ $report->content['material_requests']['fulfilled'] }}</td>
                </tr>
            </tbody>
        </table>
    @endif
@endsection
