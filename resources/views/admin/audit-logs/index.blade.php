<x-app-layout>
    <x-slot name="header">
        Audit Logs
    </x-slot>

    <div class="px-6 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-black text-text">Audit Logs</h1>
            <p class="text-sm text-muted mt-1">Track all system changes and user actions across the platform.</p>
        </div>

        {{-- Filters --}}
        <div class="mb-6 bg-surface rounded-2xl shadow-sm border border-border p-4">
            <form method="GET" action="{{ route('audit-logs.index') }}" class="flex flex-wrap items-center gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by description..."
                       class="flex-1 min-w-[200px] px-4 py-2.5 rounded-xl bg-background border border-border text-sm text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                <select name="log_name" class="px-4 py-2.5 rounded-xl bg-background border border-border text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    <option value="">All Types</option>
                    @foreach($logNames as $logName)
                        <option value="{{ $logName }}" {{ request('log_name') === $logName ? 'selected' : '' }}>{{ ucfirst($logName) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-primary/10 text-primary font-bold py-2.5 px-5 rounded-xl hover:bg-primary/20 transition-colors text-sm">Filter</button>
                @if(request()->hasAny(['search', 'log_name']))
                <a href="{{ route('audit-logs.index') }}" class="text-sm text-muted hover:text-text font-medium">Clear</a>
                @endif
            </form>
        </div>

        {{-- Logs Table --}}
        <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-background/50 text-xs text-muted uppercase font-black tracking-wider border-b border-border">
                        <tr>
                            <th class="px-6 py-4">Timestamp</th>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Action</th>
                            <th class="px-6 py-4">Subject</th>
                            <th class="px-6 py-4">Changes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($logs as $log)
                        <tr class="hover:bg-background/50 transition-colors" x-data="{ showDetails: false }">
                            <td class="px-6 py-4 text-xs text-muted whitespace-nowrap">
                                <div class="font-semibold text-text">{{ $log->created_at->format('M d, Y') }}</div>
                                <div>{{ $log->created_at->format('h:i:s A') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($log->causer)
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-primary/80 to-primary flex items-center justify-center text-white font-bold text-[10px]">
                                        {{ strtoupper(substr($log->causer->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-text text-xs">{{ $log->causer->name }}</span>
                                </div>
                                @else
                                <span class="text-xs text-muted">System</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $eventColors = [
                                        'created' => 'bg-success/10 text-success',
                                        'updated' => 'bg-blue-100 text-blue-700',
                                        'deleted' => 'bg-danger/10 text-danger',
                                    ];
                                    $eventColor = $eventColors[$log->event ?? ''] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ $eventColor }}">
                                    {{ $log->event ?? 'action' }}
                                </span>
                                <p class="text-xs text-muted mt-1">{{ $log->description }}</p>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                @if($log->subject_type)
                                <span class="font-semibold text-text">{{ class_basename($log->subject_type) }}</span>
                                @if($log->subject)
                                    <span class="text-muted block">{{ $log->subject->name ?? $log->subject->title ?? Str::limit($log->subject_id, 8) }}</span>
                                @else
                                    <span class="text-muted block">ID: {{ Str::limit($log->subject_id, 8) }}</span>
                                @endif
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($log->properties && ($log->properties->has('old') || $log->properties->has('attributes')))
                                <button @click="showDetails = !showDetails" class="text-xs font-bold text-primary hover:text-primary/80 transition-colors">
                                    <span x-text="showDetails ? 'Hide' : 'View'"></span> Details
                                </button>
                                <div x-show="showDetails" x-cloak x-transition class="mt-2 p-3 bg-background rounded-lg border border-border text-[11px] max-w-xs overflow-x-auto">
                                    @if($log->properties->has('old'))
                                    <div class="mb-2">
                                        <span class="font-black text-danger uppercase text-[10px]">Before:</span>
                                        <pre class="text-muted mt-0.5 whitespace-pre-wrap">{{ json_encode($log->properties['old'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                    @endif
                                    @if($log->properties->has('attributes'))
                                    <div>
                                        <span class="font-black text-success uppercase text-[10px]">After:</span>
                                        <pre class="text-muted mt-0.5 whitespace-pre-wrap">{{ json_encode($log->properties['attributes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                    @endif
                                </div>
                                @else
                                <span class="text-xs text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-background mb-4">
                                    <svg class="w-8 h-8 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <p class="text-muted font-medium">No audit logs recorded yet.</p>
                                <p class="text-xs text-muted mt-1">Changes to system data will appear here automatically.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
            <div class="p-6 border-t border-border">
                {{ $logs->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
