<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Materials Purchase Requests') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openModal: false, editing: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()->hasRole('Company Captain'))
            <div class="mb-4 flex justify-end">
                <button @click="editing = null; openModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                    + New Request
                </button>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Company</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Item Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($requests as $req)
                            <tr>
                                <td class="px-6 py-4">{{ $req->company->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $req->item_name }}</td>
                                <td class="px-6 py-4">{{ $req->quantity }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($req->status === 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($req->status === 'approved') bg-blue-100 text-blue-800
                                        @elseif($req->status === 'fulfilled') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @can('update', $req)
                                    <button @click="editing = {{ $req }}; openModal = true" class="text-blue-600 hover:text-blue-900 mx-2 text-sm">Update Status</button>
                                    @endcan
                                    @can('delete', $req)
                                    <form action="{{ route('materials-requests.destroy', $req) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Delete this request?')">Delete</button>
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

        <!-- Add/Edit Modal -->
        <div x-show="openModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 opacity-75" @click="openModal = false"></div>
                <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full z-10 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4" x-text="editing ? 'Update Request Status' : 'New Material Request'"></h3>
                    <form :action="editing ? '/materials-requests/' + editing.id : '/materials-requests'" method="POST">
                        @csrf
                        <template x-if="editing">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <template x-if="!editing">
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item Name</label>
                                    <input type="text" name="item_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                                    <input type="number" name="quantity" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black">
                                </div>
                            </div>
                        </template>

                        <template x-if="editing">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black" :value="editing ? editing.status : ''">
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="fulfilled">Fulfilled</option>
                                </select>
                            </div>
                        </template>

                        <div class="flex justify-end mt-4">
                            <button type="button" @click="openModal = false" class="mr-2 px-4 py-2 text-gray-700 bg-gray-200 rounded">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
