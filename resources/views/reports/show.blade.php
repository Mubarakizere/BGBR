<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('reports.index') }}" class="text-muted hover:text-text transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            Report Details
        </div>
    </x-slot>

    <div class="px-6 py-8 max-w-7xl mx-auto">
        {{-- Header & Status --}}
        <div class="flex flex-col md:flex-row gap-6 justify-between items-start mb-8 bg-surface p-8 rounded-2xl shadow-sm border border-border">
            <div>
                <h1 class="text-2xl font-black text-text mb-2">{{ $report->title }}</h1>
                <div class="flex flex-wrap items-center gap-4 text-sm font-medium text-muted">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary uppercase text-xs font-bold tracking-widest">
                        {{ str_replace('_', ' ', $report->type) }}
                    </span>
                    <span>Created: {{ $report->created_at->format('M d, Y h:i A') }}</span>
                    @if($report->submitter)
                        <span>Submitted by: {{ $report->submitter->name }}</span>
                    @endif
                </div>
            </div>

            <div class="flex flex-col items-end gap-4">
                @php
                    $statusColors = [
                        'draft' => 'bg-gray-100 text-gray-800 border-gray-200',
                        'submitted' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'approved' => 'bg-green-100 text-green-800 border-green-200',
                        'rejected' => 'bg-red-100 text-red-800 border-red-200',
                    ];
                    $color = $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <div class="px-4 py-2 rounded-xl border {{ $color }} font-black uppercase tracking-widest text-sm shadow-sm">
                    Status: {{ $report->status }}
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('reports.pdf', $report) }}" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-background border border-border hover:bg-muted/10 font-bold text-sm text-text transition-colors">
                        PDF
                    </a>
                    <a href="{{ route('reports.excel', $report) }}" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-success/10 text-success hover:bg-success/20 font-bold text-sm transition-colors">
                        Excel
                    </a>
                    @if(in_array($report->status, ['draft', 'rejected']))
                    <form action="{{ route('reports.destroy', $report) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this report?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-danger/10 text-danger hover:bg-danger/20 font-bold text-sm transition-colors">
                            Delete
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Workflow Actions --}}
        @if($report->status === 'draft' && auth()->id() === $report->submitter_id || $report->status === 'draft')
            {{-- Assuming anyone who can view it and it's draft can submit --}}
            <div class="mb-8 bg-blue-50 border border-blue-200 p-6 rounded-2xl flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-blue-900">Ready to submit?</h3>
                    <p class="text-sm text-blue-700">Submit this report for higher-level approval.</p>
                </div>
                <form action="{{ route('reports.submit', $report) }}" method="POST">
                    @csrf
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-xl shadow-sm transition-colors">
                        Submit Report
                    </button>
                </form>
            </div>
        @endif

        @if($report->status === 'submitted')
            @php
                $canApprove = false;
                if ($report->level === 'company' && auth()->user()->hasRole('Battalion Commander')) $canApprove = true;
                if ($report->level === 'battalion' && auth()->user()->hasRole(['Domination Admin', 'Super Admin'])) $canApprove = true;
                if ($report->level === 'financial' && auth()->user()->hasRole(['Super Admin'])) $canApprove = true;
            @endphp
            @if($canApprove)
                <div class="mb-8 bg-surface border border-border p-6 rounded-2xl shadow-sm">
                    <h3 class="font-black text-text mb-4">Review & Approval</h3>
                    <form action="{{ route('reports.approve', $report) }}" method="POST" class="inline-block mr-3">
                        @csrf
                        <input type="text" name="reviewer_notes" placeholder="Approval notes (optional)" class="w-64 px-4 py-2 rounded-xl bg-background border border-border focus:border-primary focus:ring-1 focus:ring-primary text-sm mb-4 block">
                        <button class="bg-success hover:bg-success/90 text-white font-bold py-2 px-6 rounded-xl shadow-sm transition-colors">
                            Approve Report
                        </button>
                    </form>
                    <form action="{{ route('reports.reject', $report) }}" method="POST" class="inline-block">
                        @csrf
                        <input type="hidden" name="reviewer_notes" value="Rejected by reviewer.">
                        <button class="bg-danger hover:bg-danger/90 text-white font-bold py-2 px-6 rounded-xl shadow-sm transition-colors">
                            Reject
                        </button>
                    </form>
                </div>
            @endif
        @endif

        @if($report->reviewer_notes)
            <div class="mb-8 bg-gray-50 border border-gray-200 p-6 rounded-2xl">
                <h3 class="font-bold text-gray-900 mb-1">Reviewer Notes</h3>
                <p class="text-sm text-gray-700">{{ $report->reviewer_notes }}</p>
            </div>
        @endif

        {{-- Snapshot Content --}}
        <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
            <div class="p-6 border-b border-border bg-background/50">
                <h2 class="text-lg font-black text-text">Report Data Snapshot</h2>
                <p class="text-xs text-muted">Generated at: {{ \Carbon\Carbon::parse($report->content['generated_at'])->format('M d, Y h:i:s A') }}</p>
            </div>
            <div class="p-8 prose prose-sm max-w-none text-text">
                {{-- Dynamic rendering based on type --}}
                @if($report->type === 'company_summary')
                    @include('reports.partials.company_content', ['content' => $report->content])
                @elseif($report->type === 'battalion_summary')
                    @include('reports.partials.battalion_content', ['content' => $report->content])
                @elseif($report->type === 'financial')
                    @include('reports.partials.financial_content', ['content' => $report->content])
                @else
                    <pre class="bg-background p-4 rounded-xl border border-border overflow-x-auto"><code>{{ json_encode($report->content, JSON_PRETTY_PRINT) }}</code></pre>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
