<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-background border border-border p-4 rounded-xl">
            <p class="text-sm text-muted font-bold uppercase mb-1">Total Members</p>
            <p class="text-2xl font-black text-primary">{{ $content['metrics']['total_members'] }}</p>
        </div>
        <div class="bg-background border border-border p-4 rounded-xl">
            <p class="text-sm text-muted font-bold uppercase mb-1">Paid Members</p>
            <p class="text-2xl font-black text-success">{{ $content['metrics']['paid_members'] }}</p>
        </div>
        <div class="bg-background border border-border p-4 rounded-xl">
            <p class="text-sm text-muted font-bold uppercase mb-1">Contribution %</p>
            <p class="text-2xl font-black text-secondary">{{ $content['metrics']['contribution_percentage'] }}%</p>
        </div>
        <div class="bg-background border border-border p-4 rounded-xl">
            <p class="text-sm text-muted font-bold uppercase mb-1">Total Deposits</p>
            <p class="text-2xl font-black text-text">RWF {{ number_format($content['metrics']['total_deposits'], 2) }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-bold text-text mb-4 border-b border-border pb-2">Company Breakdown</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-background/50 text-xs text-muted uppercase font-bold">
                    <tr>
                        <th class="px-4 py-3">Company Name</th>
                        <th class="px-4 py-3 text-right">Total Members</th>
                        <th class="px-4 py-3 text-right">Paid Members</th>
                        <th class="px-4 py-3 text-right">Contribution %</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($content['companies'] as $company)
                    <tr>
                        <td class="px-4 py-2 text-text font-bold">{{ $company['name'] }}</td>
                        <td class="px-4 py-2 text-right text-muted">{{ $company['total_members'] }}</td>
                        <td class="px-4 py-2 text-right text-muted">{{ $company['paid_members'] }}</td>
                        <td class="px-4 py-2 text-right font-medium {{ $company['contribution_percentage'] < 50 ? 'text-danger' : 'text-success' }}">
                            {{ $company['contribution_percentage'] }}%
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
