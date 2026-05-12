<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Super Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome, Super Admin! You have full access to the BGBR Rwanda management system.") }}
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-indigo-50 dark:bg-indigo-900/30 p-6 rounded-lg shadow-sm border border-indigo-100 dark:border-indigo-800">
                    <h3 class="text-lg font-bold text-indigo-800 dark:text-indigo-300">Total Dominations</h3>
                    <p class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-2">0</p>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/30 p-6 rounded-lg shadow-sm border border-blue-100 dark:border-blue-800">
                    <h3 class="text-lg font-bold text-blue-800 dark:text-blue-300">Total Battalions</h3>
                    <p class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 mt-2">0</p>
                </div>
                <div class="bg-teal-50 dark:bg-teal-900/30 p-6 rounded-lg shadow-sm border border-teal-100 dark:border-teal-800">
                    <h3 class="text-lg font-bold text-teal-800 dark:text-teal-300">Pending Approvals</h3>
                    <p class="text-3xl font-extrabold text-teal-600 dark:text-teal-400 mt-2">0</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
