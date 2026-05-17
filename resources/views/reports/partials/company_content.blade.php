<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
    </div>

    <div>
        <h3 class="text-lg font-bold text-text mb-4 border-b border-border pb-2">Member List</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-background/50 text-xs text-muted uppercase font-bold">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Rank</th>
                        <th class="px-4 py-3 text-center">Fee Paid</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($content['members'] as $member)
                    <tr>
                        <td class="px-4 py-2 text-text font-medium">{{ $member['name'] }}</td>
                        <td class="px-4 py-2 text-muted">{{ $member['rank'] }}</td>
                        <td class="px-4 py-2 text-center">
                            @if($member['registration_fee_paid'])
                                <span class="text-success font-bold">Yes</span>
                            @else
                                <span class="text-danger font-bold">No</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
