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
                    <th>Members List</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->content['companies'] as $company)
                <tr>
                    <td>{{ $company['name'] }}</td>
                    <td>{{ $company['total_members'] }}</td>
                    <td>{{ $company['paid_members'] }}</td>
                    <td>{{ $company['contribution_percentage'] }}%</td>
                    <td>
                        @if(isset($company['members']))
                            @foreach($company['members'] as $member)
                                {{ $member['name'] }} ({{ $member['rank'] }} - {{ $member['registration_fee_paid'] ? 'Paid' : 'Unpaid' }}){{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        @endif
                    </td>
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

        <h3>Company Breakdown & Members</h3>
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
                <tr style="background-color: #f8fafc; font-weight: bold;">
                    <td>{{ $company['name'] }}</td>
                    <td>{{ $company['total_members'] }}</td>
                    <td>{{ $company['paid_members'] }}</td>
                    <td>{{ $company['contribution_percentage'] }}%</td>
                </tr>
                @if(isset($company['members']) && count($company['members']) > 0)
                <tr>
                    <td colspan="4">
                        <div style="font-size: 10px; margin-top: 4px; margin-bottom: 8px;">
                            <strong>Members:</strong> 
                            @foreach($company['members'] as $member)
                                {{ $member['name'] }} <span style="color: #64748b;">({{ $member['rank'] }}, {{ $member['registration_fee_paid'] ? 'Paid' : 'Unpaid' }})</span>{{ !$loop->last ? ' • ' : '' }}
                            @endforeach
                        </div>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
