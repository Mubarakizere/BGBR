@extends(isset($isExcel) && $isExcel ? 'reports.pdf.excel_layout' : 'reports.pdf.layout')

@section('content')
    @if(isset($isExcel))
        <table>
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Total Members</th>
                    <th>Paid Members</th>
                    <th>Contribution %</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->content['companies'] as $company)
                <tr>
                    <td>{{ $company['name'] }}</td>
                    <td>{{ $company['total_members'] }}</td>
                    <td>{{ $company['paid_members'] }}</td>
                    <td>{{ $company['contribution_percentage'] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <table class="metrics-grid">
            <tr>
                <td>
                    <div class="metric-label">Total Members</div>
                    <div class="metric-value">{{ $report->content['metrics']['total_members'] }}</div>
                </td>
                <td>
                    <div class="metric-label">Paid Members</div>
                    <div class="metric-value">{{ $report->content['metrics']['paid_members'] }}</div>
                </td>
                <td>
                    <div class="metric-label">Total Deposits</div>
                    <div class="metric-value">RWF {{ number_format($report->content['metrics']['total_deposits'], 2) }}</div>
                </td>
            </tr>
        </table>

        <h3>Company Breakdown</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Total Members</th>
                    <th>Paid Members</th>
                    <th>Contribution %</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->content['companies'] as $company)
                <tr>
                    <td>{{ $company['name'] }}</td>
                    <td>{{ $company['total_members'] }}</td>
                    <td>{{ $company['paid_members'] }}</td>
                    <td>{{ $company['contribution_percentage'] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
