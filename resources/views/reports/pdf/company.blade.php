@extends(isset($isExcel) && $isExcel ? 'reports.pdf.excel_layout' : 'reports.pdf.layout')

@section('content')
    @if(isset($isExcel))
        <!-- Excel View just outputs a simple table structure -->
        <table>
            <thead>
                <tr>
                    <th colspan="3">Company Report: {{ $report->title }}</th>
                </tr>
                <tr>
                    <th>Total Members</th>
                    <th>Paid Members</th>
                    <th>Contribution %</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $report->content['metrics']['total_members'] }}</td>
                    <td>{{ $report->content['metrics']['paid_members'] }}</td>
                    <td>{{ $report->content['metrics']['contribution_percentage'] }}%</td>
                </tr>
            </tbody>
        </table>
        
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Fee Paid</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->content['members'] as $member)
                <tr>
                    <td>{{ $member['name'] }}</td>
                    <td>{{ $member['rank'] }}</td>
                    <td>{{ $member['registration_fee_paid'] ? 'Yes' : 'No' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <!-- PDF View -->
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
                    <div class="metric-label">Contribution %</div>
                    <div class="metric-value">{{ $report->content['metrics']['contribution_percentage'] }}%</div>
                </td>
            </tr>
        </table>

        <h3>Member List</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Fee Paid</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->content['members'] as $member)
                <tr>
                    <td>{{ $member['name'] }}</td>
                    <td>{{ $member['rank'] }}</td>
                    <td>{{ $member['registration_fee_paid'] ? 'Yes' : 'No' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
