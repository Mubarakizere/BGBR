<x-app-layout>
    <x-slot name="header">
        Search Results
    </x-slot>

    <div class="px-6 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-black text-text tracking-tight">Search Results</h1>
            <p class="text-sm text-muted mt-1">Showing results for "<span class="font-bold text-primary">{{ $query }}</span>"</p>
        </div>

        @if(empty($query))
            <div class="bg-surface rounded-2xl shadow-sm border border-border p-12 text-center">
                <svg class="w-12 h-12 text-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <h3 class="text-lg font-bold text-text mb-1">Enter a search term</h3>
                <p class="text-muted text-sm">Use the search bar above to find battalions, companies, and members.</p>
            </div>
        @elseif(count($battalions) === 0 && count($companies) === 0 && count($members) === 0)
            <div class="bg-surface rounded-2xl shadow-sm border border-border p-12 text-center">
                <svg class="w-12 h-12 text-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-lg font-bold text-text mb-1">No results found</h3>
                <p class="text-muted text-sm">We couldn't find anything matching "{{ $query }}".</p>
            </div>
        @else
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                
                {{-- Battalions Section --}}
                @if(count($battalions) > 0)
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-text">Battalions <span class="text-sm font-bold text-muted bg-background px-2 py-0.5 rounded-md border border-border ml-2">{{ count($battalions) }}</span></h2>
                    </div>
                    <div class="bg-surface rounded-2xl shadow-sm border border-border divide-y divide-border overflow-hidden">
                        @foreach($battalions as $battalion)
                        <a href="{{ route('battalions.show', $battalion) }}" class="flex items-center justify-between p-4 hover:bg-primary/5 transition-colors group">
                            <div>
                                <h4 class="font-bold text-text group-hover:text-primary transition-colors text-base">{{ $battalion->name }}</h4>
                                <p class="text-xs font-semibold text-muted mt-1 uppercase tracking-wider">{{ $battalion->denomination->name ?? 'No Denomination' }}</p>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-background border border-border flex items-center justify-center text-muted group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Companies Section --}}
                @if(count($companies) > 0)
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-success/10 text-success flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-text">Companies <span class="text-sm font-bold text-muted bg-background px-2 py-0.5 rounded-md border border-border ml-2">{{ count($companies) }}</span></h2>
                    </div>
                    <div class="bg-surface rounded-2xl shadow-sm border border-border divide-y divide-border overflow-hidden">
                        @foreach($companies as $company)
                        <a href="{{ route('companies.show', $company) }}" class="flex items-center justify-between p-4 hover:bg-success/5 transition-colors group">
                            <div>
                                <h4 class="font-bold text-text group-hover:text-success transition-colors text-base">{{ $company->name }}</h4>
                                <p class="text-xs font-semibold text-muted mt-1 uppercase tracking-wider">{{ $company->battalion->name ?? 'Unknown Battalion' }}</p>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-background border border-border flex items-center justify-center text-muted group-hover:bg-success group-hover:text-white group-hover:border-success transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Members Section --}}
                @if(count($members) > 0)
                <div class="xl:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-text">Members <span class="text-sm font-bold text-muted bg-background px-2 py-0.5 rounded-md border border-border ml-2">{{ count($members) }}</span></h2>
                    </div>
                    <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-border">
                            @foreach($members as $index => $member)
                            <a href="{{ route('members.show', $member) }}" class="flex items-center gap-4 p-4 hover:bg-indigo-500/5 transition-colors group {{ $index >= 2 ? 'border-t border-border' : '' }}">
                                <div class="w-12 h-12 rounded-full bg-indigo-500/10 text-indigo-600 flex items-center justify-center font-black text-lg shadow-inner group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                                    {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-text group-hover:text-indigo-600 transition-colors text-base">{{ $member->first_name }} {{ $member->last_name }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs font-semibold text-muted uppercase tracking-wider">{{ $member->company->name ?? 'Unknown Company' }}</span>
                                        <span class="w-1 h-1 rounded-full bg-border"></span>
                                        <span class="text-[10px] font-black px-1.5 py-0.5 rounded-md bg-background border border-border text-muted">{{ $member->rank }}</span>
                                    </div>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-background border border-border flex items-center justify-center text-muted group-hover:bg-indigo-500 group-hover:text-white group-hover:border-indigo-500 transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
