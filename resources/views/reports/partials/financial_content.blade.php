<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-background border border-border p-4 rounded-xl">
            <p class="text-sm text-muted font-bold uppercase mb-1">Total Deposits</p>
            <p class="text-2xl font-black text-primary">RWF {{ number_format($content['metrics']['total_deposits'], 2) }}</p>
        </div>
        <div class="bg-background border border-border p-4 rounded-xl">
            <p class="text-sm text-muted font-bold uppercase mb-1">Activity Fees</p>
            <p class="text-2xl font-black text-success">RWF {{ number_format($content['metrics']['total_activity_fees_collected'], 2) }}</p>
        </div>
        <div class="bg-background border border-border p-4 rounded-xl">
            <p class="text-sm text-muted font-bold uppercase mb-1">Total Income</p>
            <p class="text-2xl font-black text-text">RWF {{ number_format($content['metrics']['total_income'], 2) }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-bold text-text mb-4 border-b border-border pb-2">Material Requests Overview</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-background border border-border p-4 rounded-xl text-center">
                <p class="text-2xl font-black text-muted">{{ $content['material_requests']['pending'] }}</p>
                <p class="text-xs text-muted uppercase font-bold mt-1">Pending</p>
            </div>
            <div class="bg-background border border-border p-4 rounded-xl text-center">
                <p class="text-2xl font-black text-blue-600">{{ $content['material_requests']['approved'] }}</p>
                <p class="text-xs text-muted uppercase font-bold mt-1">Approved</p>
            </div>
            <div class="bg-background border border-border p-4 rounded-xl text-center">
                <p class="text-2xl font-black text-success">{{ $content['material_requests']['fulfilled'] }}</p>
                <p class="text-xs text-muted uppercase font-bold mt-1">Fulfilled</p>
            </div>
            <div class="bg-background border border-border p-4 rounded-xl text-center">
                <p class="text-2xl font-black text-danger">{{ $content['material_requests']['rejected'] }}</p>
                <p class="text-xs text-muted uppercase font-bold mt-1">Rejected</p>
            </div>
        </div>
    </div>
</div>
