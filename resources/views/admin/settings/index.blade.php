<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-text leading-tight">
            {{ __('System Settings') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                <div class="p-6 border-b border-border bg-background/50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-text">Global Configuration</h3>
                </div>

                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-success/10 border border-success/20 text-success font-medium">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('settings.update') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <!-- Fee Settings Section -->
                        <div>
                            <h4 class="text-md font-bold text-text mb-4 border-b border-border pb-2">Registration Fees</h4>
                            
                            <div class="space-y-5">
                                <div>
                                    <label for="fee_amount" class="block font-semibold text-sm text-text mb-1">Yearly Fee Amount (RWF)</label>
                                    <p class="text-xs text-muted mb-2">The amount members must pay annually for their registration.</p>
                                    <input type="text" name="settings[fee_amount]" id="fee_amount" 
                                           value="{{ old('settings.fee_amount', setting('fee_amount', '2,000')) }}" 
                                           class="w-full sm:w-1/2 border-border bg-background focus:border-primary focus:ring-primary rounded-xl shadow-sm">
                                </div>
                                
                                <div>
                                    <label for="payment_address" class="block font-semibold text-sm text-text mb-1">Fee Payment Address (MoMo, Bank, etc.)</label>
                                    <p class="text-xs text-muted mb-2">The instructions or address where members should send their payment.</p>
                                    <input type="text" name="settings[payment_address]" id="payment_address" 
                                           value="{{ old('settings.payment_address', setting('payment_address', 'MoMo Pay: *182*8*1*123456#')) }}" 
                                           class="w-full border-border bg-background focus:border-primary focus:ring-primary rounded-xl shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-border flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-primary text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
