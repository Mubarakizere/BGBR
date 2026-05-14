<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Account Deposits (National Level)') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
                <button @click="openModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                    + Record Deposit
                </button>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Level</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Description</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($deposits as $deposit)
                            <tr>
                                <td class="px-6 py-4">{{ $deposit->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    {{ ucfirst($deposit->level) }}
                                    @if($deposit->level === 'battalion')
                                        ({{ $deposit->entity->name ?? 'Unknown Battalion' }})
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-bold text-green-600 dark:text-green-400">{{ number_format($deposit->amount, 2) }} RWF</td>
                                <td class="px-6 py-4">{{ $deposit->description ?? '-' }}</td>
                                <td class="px-6 py-4 text-right">
                                    @can('delete', $deposit)
                                    <form action="{{ route('account-deposits.destroy', $deposit) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Delete this deposit?')">Delete</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Modal -->
        <div x-show="openModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;" x-data="{ level: 'national' }">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 opacity-75" @click="openModal = false"></div>
                <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full z-10 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Record Deposit</h3>
                    <form action="/account-deposits" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount (RWF)</label>
                            <input type="number" step="0.01" name="amount" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Level</label>
                            <select name="level" x-model="level" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black">
                                <option value="national">National Level</option>
                                <option value="battalion">Battalion Level</option>
                            </select>
                        </div>
                        
                        <!-- Entity ID will be same as auth user's UUID for national level, or selected battalion UUID -->
                        <div class="mb-4" x-show="level === 'battalion'">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Battalion</label>
                            <select name="entity_id" :required="level === 'battalion'" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black" :disabled="level !== 'battalion'">
                                <option value="">-- Select Battalion --</option>
                                @foreach($battalions as $btn)
                                    <option value="{{ $btn->id }}">{{ $btn->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div x-show="level === 'national'">
                            <input type="hidden" name="entity_id" value="{{ auth()->id() }}" :disabled="level !== 'national'">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <input type="text" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black">
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="button" @click="openModal = false" class="mr-2 px-4 py-2 text-gray-700 bg-gray-200 rounded">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
