<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-text leading-tight">
            {{ __('Registration Fees') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data="{ viewModalOpen: false, currentFileUrl: '', currentFileType: '', approveModalOpen: false, rejectModalOpen: false, selectedFeeApproveUrl: '', selectedFeeRejectUrl: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                <div class="p-6 border-b border-border flex justify-between items-center bg-background/50">
                    <h3 class="text-xl font-bold text-text">Fee Submissions</h3>
                </div>

                @if(session('success'))
                    <div class="m-6 p-4 rounded-xl bg-success/10 border border-success/20 text-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-background/50 border-b border-border">
                                <th class="py-4 px-6 text-xs font-bold text-muted uppercase tracking-wider">User</th>
                                <th class="py-4 px-6 text-xs font-bold text-muted uppercase tracking-wider">Amount</th>
                                <th class="py-4 px-6 text-xs font-bold text-muted uppercase tracking-wider">Date</th>
                                <th class="py-4 px-6 text-xs font-bold text-muted uppercase tracking-wider">Status</th>
                                <th class="py-4 px-6 text-xs font-bold text-muted uppercase tracking-wider">Proof</th>
                                <th class="py-4 px-6 text-xs font-bold text-muted uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($fees as $fee)
                                <tr class="hover:bg-background/30 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            @if($fee->user->photo_path)
                                                <img src="{{ Storage::url($fee->user->photo_path) }}" alt="{{ $fee->user->name }}" class="w-8 h-8 rounded-full object-cover mr-3">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold mr-3">
                                                    {{ substr($fee->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-medium text-text">{{ $fee->user->name }}</div>
                                                <div class="text-xs text-muted">{{ $fee->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 font-medium">{{ number_format($fee->amount) }} RWF</td>
                                    <td class="py-4 px-6 text-sm text-muted">{{ $fee->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-6">
                                        @if($fee->status === 'pending')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-secondary/10 text-secondary border border-secondary/20">Pending</span>
                                        @elseif($fee->status === 'approved')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-success/10 text-success border border-success/20">Approved</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-danger/10 text-danger border border-danger/20">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <button type="button" @click.prevent="currentFileUrl = '{{ Storage::url($fee->receipt_path) }}'; currentFileType = '{{ Str::endsWith(strtolower($fee->receipt_path), '.pdf') ? 'pdf' : 'image' }}'; viewModalOpen = true" class="text-primary hover:underline text-sm font-medium flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            View
                                        </button>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        @if($fee->status === 'pending')
                                            <div class="flex items-center justify-end gap-2">
                                                <button type="button" @click="selectedFeeApproveUrl = '{{ route('admin.fees.approve', $fee) }}'; approveModalOpen = true" class="p-2 bg-success/10 text-success hover:bg-success hover:text-white rounded-lg transition-colors tooltip-trigger" title="Approve">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                                <button type="button" @click="selectedFeeRejectUrl = '{{ route('admin.fees.reject', $fee) }}'; rejectModalOpen = true" class="p-2 bg-danger/10 text-danger hover:bg-danger hover:text-white rounded-lg transition-colors tooltip-trigger" title="Reject">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 px-6 text-center text-muted">No registration fees found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($fees->hasPages())
                    <div class="p-6 border-t border-border">
                        {{ $fees->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- View File Modal --}}
        <div x-show="viewModalOpen" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="viewModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black/75 backdrop-blur-sm" @click="viewModalOpen = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="viewModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-surface rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full border border-border z-10">
                    
                    <div class="p-4 border-b border-border flex justify-between items-center bg-background/50">
                        <h3 class="text-lg font-bold text-text">Proof of Payment</h3>
                        <button @click="viewModalOpen = false" class="text-muted hover:text-text transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="p-6 bg-background/30 flex justify-center items-center min-h-[50vh] max-h-[80vh] overflow-auto">
                        <template x-if="currentFileType === 'image'">
                            <img :src="currentFileUrl" class="max-w-full max-h-[75vh] rounded shadow-sm object-contain">
                        </template>
                        <template x-if="currentFileType === 'pdf'">
                            <iframe :src="currentFileUrl + '#toolbar=0'" class="w-full h-[75vh] rounded border border-border shadow-sm"></iframe>
                        </template>
                    </div>

                    <div class="p-4 border-t border-border bg-background/50 flex justify-end">
                        <a :href="currentFileUrl" download class="mr-3 px-4 py-2 border border-border rounded-lg text-text font-semibold text-sm hover:bg-background transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download
                        </a>
                        <button type="button" @click="viewModalOpen = false" class="px-5 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-colors text-sm shadow-md shadow-primary/20">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Approve Confirmation Modal --}}
        <div x-show="approveModalOpen" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div x-show="approveModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="approveModalOpen = false"></div>

                <div x-show="approveModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="relative bg-surface rounded-2xl shadow-2xl max-w-md w-full border border-border overflow-hidden z-10">

                    <form :action="selectedFeeApproveUrl" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="p-6 text-center">
                            <div class="mx-auto w-14 h-14 rounded-full bg-success/10 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h3 class="text-lg font-black text-text">Approve Fee?</h3>
                            <p class="text-sm text-muted mt-2">
                                Are you sure you want to approve this fee payment?
                            </p>
                        </div>

                        <div class="p-6 border-t border-border bg-background/50 flex items-center justify-center gap-3">
                            <button type="button" @click="approveModalOpen = false" class="px-5 py-2.5 rounded-xl border border-border text-muted font-bold hover:bg-background transition-colors text-sm">Cancel</button>
                            <button type="submit" class="bg-success hover:bg-success/90 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-success/20 text-sm inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Approve
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Reject Confirmation Modal --}}
        <div x-show="rejectModalOpen" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div x-show="rejectModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="rejectModalOpen = false"></div>

                <div x-show="rejectModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="relative bg-surface rounded-2xl shadow-2xl max-w-md w-full border border-border overflow-hidden z-10">

                    <form :action="selectedFeeRejectUrl" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="p-6 text-center">
                            <div class="mx-auto w-14 h-14 rounded-full bg-danger/10 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            <h3 class="text-lg font-black text-text">Decline Fee?</h3>
                            <p class="text-sm text-muted mt-2">
                                Are you sure you want to decline this fee payment?
                            </p>
                        </div>

                        <div class="p-6 border-t border-border bg-background/50 flex items-center justify-center gap-3">
                            <button type="button" @click="rejectModalOpen = false" class="px-5 py-2.5 rounded-xl border border-border text-muted font-bold hover:bg-background transition-colors text-sm">Cancel</button>
                            <button type="submit" class="bg-danger hover:bg-danger/90 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-danger/20 text-sm inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Decline
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
