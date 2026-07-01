<x-app-layout>
    <x-slot name="header">
        Reports Management
    </x-slot>

    <div class="px-6 py-8">
        {{-- Actions --}}
        <div class="mb-8 bg-surface rounded-2xl shadow-sm border border-border p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-black text-text mb-1">Generate New Report</h2>
                <p class="text-sm text-muted">Create a new point-in-time snapshot report.</p>
            </div>
            <div class="flex gap-4">
                @if(auth()->user()->hasRole(['Company Captain', 'Company Officer']) && auth()->user()->company_id)
                <form action="{{ route('reports.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="company_summary">
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-primary/20">
                        Generate Company Report
                    </button>
                </form>
                @endif

                @if(auth()->user()->hasRole('Battalion Commander') && auth()->user()->battalion_id)
                <form action="{{ route('reports.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="battalion_summary">
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-primary/20">
                        Generate Battalion Report
                    </button>
                </form>
                @endif

                @if(auth()->user()->hasRole(['Denomination Admin', 'Super Admin']))
                <form action="{{ route('reports.store') }}" method="POST" class="flex gap-2 items-center">
                    @csrf
                    <input type="hidden" name="type" value="battalion_summary">
                    <select name="battalion_id" required class="rounded-xl border-border bg-background focus:ring-primary focus:border-primary text-sm py-2.5 px-3">
                        <option value="">Select Battalion</option>
                        @foreach($battalions as $battalion)
                            <option value="{{ $battalion->id }}">{{ $battalion->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-primary/20">
                        Generate Battalion Report
                    </button>
                </form>

                <form action="{{ route('reports.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="financial">
                    <button type="submit" class="bg-success hover:bg-success/90 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-success/20">
                        Generate Financial Report
                    </button>
                </form>
                @endif
            </div>
        </div>

        {{-- Filters --}}
        <div class="mb-8 bg-surface rounded-2xl shadow-sm border border-border p-6">
            <form action="{{ route('reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label for="date_from" class="block text-sm font-medium text-text mb-1">Date From</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full rounded-xl border-border bg-background focus:ring-primary focus:border-primary text-sm">
                </div>
                <div>
                    <label for="date_to" class="block text-sm font-medium text-text mb-1">Date To</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full rounded-xl border-border bg-background focus:ring-primary focus:border-primary text-sm">
                </div>
                
                @if($battalions->count() > 0)
                <div>
                    <label for="battalion_id" class="block text-sm font-medium text-text mb-1">Battalion</label>
                    <select name="battalion_id" id="battalion_id" class="w-full rounded-xl border-border bg-background focus:ring-primary focus:border-primary text-sm">
                        <option value="">All Battalions</option>
                        @foreach($battalions as $battalion)
                            <option value="{{ $battalion->id }}" {{ request('battalion_id') == $battalion->id ? 'selected' : '' }}>
                                {{ $battalion->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if($companies->count() > 0)
                <div>
                    <label for="company_id" class="block text-sm font-medium text-text mb-1">Company</label>
                    <select name="company_id" id="company_id" class="w-full rounded-xl border-border bg-background focus:ring-primary focus:border-primary text-sm">
                        <option value="">All Companies</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="flex gap-2">
                    <button type="submit" class="bg-secondary hover:bg-secondary/90 text-white font-bold py-2.5 px-4 rounded-xl transition-all shadow-lg shadow-secondary/20 flex-1">
                        Filter
                    </button>
                    <a href="{{ route('reports.index') }}" class="bg-background hover:bg-gray-100 text-text font-bold py-2.5 px-4 rounded-xl transition-all border border-border text-center flex-1">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        {{-- Reports List --}}
        <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-background/50 text-xs text-muted uppercase font-black tracking-wider border-b border-border">
                        <tr>
                            <th class="px-6 py-4">Title</th>
                            <th class="px-6 py-4">Level / Type</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($reports as $report)
                            <tr class="hover:bg-background/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-text">{{ $report->title }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary/10 text-primary uppercase">
                                        {{ str_replace('_', ' ', $report->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-muted">{{ $report->created_at->format('M d, Y h:i A') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'draft' => 'bg-gray-100 text-gray-800',
                                            'submitted' => 'bg-blue-100 text-blue-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                        $color = $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide {{ $color }}">
                                        {{ $report->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('reports.show', $report) }}" class="font-bold text-secondary hover:text-secondary/80 transition-colors">View</a>
                                    <a href="{{ route('reports.pdf', $report) }}" class="font-bold text-muted hover:text-text transition-colors">PDF</a>
                                    @if(in_array($report->status, ['draft', 'rejected']))
                                    <button type="button" 
                                        @click="$dispatch('open-delete-modal', { action: '{{ route('reports.destroy', $report) }}', message: 'Are you sure you want to delete this report? This action cannot be undone.' })"
                                        class="font-bold text-danger hover:text-danger/80 transition-colors ml-3">Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-background mb-4">
                                        <svg class="w-8 h-8 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="text-muted font-medium">No reports generated yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($reports->hasPages())
                <div class="p-6 border-t border-border">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
