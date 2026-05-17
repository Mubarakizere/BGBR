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

                @if(auth()->user()->hasRole(['Domination Admin', 'Super Admin']))
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
                                    <form action="{{ route('reports.destroy', $report) }}" method="POST" class="inline-block ml-3" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-bold text-danger hover:text-danger/80 transition-colors">Delete</button>
                                    </form>
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
