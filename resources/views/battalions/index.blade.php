<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Battalions Management') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openModal: false, editing: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
                <button @click="editing = null; openModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                    + Add Battalion
                </button>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Domination</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($battalions as $battalion)
                            <tr>
                                <td class="px-6 py-4">{{ $battalion->name }}</td>
                                <td class="px-6 py-4">{{ $battalion->domination->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <button @click="editing = {{ $battalion }}; openModal = true" class="text-blue-600 hover:text-blue-900 mx-2">Edit</button>
                                    <form action="{{ route('battalions.destroy', $battalion) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Delete this battalion?')">Delete</button>
                                    </form>
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
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4" x-text="editing ? 'Edit Battalion' : 'Add Battalion'"></h3>
                    <form :action="editing ? '/battalions/' + editing.id : '/battalions'" method="POST">
                        @csrf
                        <template x-if="editing">
                            <input type="hidden" name="_method" value="PUT">
                        </template>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" name="name" :value="editing ? editing.name : ''" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Domination</label>
                            <select name="domination_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black" :value="editing ? editing.domination_id : ''">
                                <option value="">-- Select Domination --</option>
                                @foreach($dominations as $dom)
                                    <option value="{{ $dom->id }}">{{ $dom->name }}</option>
                                @endforeach
                            </select>
                        </div>
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
