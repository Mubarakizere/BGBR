<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-text leading-tight">
            {{ __('Pay Registration Fee') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                <div class="p-8">
                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-success/10 border border-success/20 text-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($pendingFee)
                        <div class="text-center py-10">
                            <div class="w-20 h-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-text mb-2">Pending Approval</h3>
                            <p class="text-muted">Your payment proof for {{ number_format($pendingFee->amount) }} RWF is currently under review.</p>
                            <p class="text-sm text-muted mt-2">Submitted on {{ $pendingFee->created_at->format('d M Y') }}</p>
                        </div>
                    @else
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-text mb-2">Yearly Registration</h3>
                            <p class="text-muted">Your account requires an active yearly registration fee to continue using the system. Please submit your proof of payment.</p>
                        </div>

                        <form action="{{ route('fee.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <div>
                                <label for="amount" class="block font-medium text-sm text-text mb-1">Amount Paid (RWF)</label>
                                <input type="number" name="amount" id="amount" required min="0" class="w-full border-border bg-background focus:border-primary focus:ring-primary rounded-lg shadow-sm">
                                @error('amount') <span class="text-danger text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="receipt" class="block font-medium text-sm text-text mb-1">Proof of Payment (Image or PDF, Max 100MB)</label>
                                <input type="file" name="receipt" id="receipt" required accept=".jpg,.jpeg,.png,.pdf" class="w-full border border-border bg-background rounded-lg shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-surface hover:file:bg-primary/90">
                                @error('receipt') <span class="text-danger text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-lg font-semibold text-xs text-surface uppercase tracking-widest hover:bg-primary/90 active:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                                    Submit Payment Proof
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
