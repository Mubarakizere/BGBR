<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Company Captain Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome, Captain! Here is an overview of your company.") }}
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 dark:bg-blue-900/30 p-6 rounded-lg shadow-sm border border-blue-100 dark:border-blue-800">
                    <h3 class="text-lg font-bold text-blue-800 dark:text-blue-300">Total Members</h3>
                    <p class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 mt-2">0</p>
                </div>
                <div class="bg-green-50 dark:bg-green-900/30 p-6 rounded-lg shadow-sm border border-green-100 dark:border-green-800">
                    <h3 class="text-lg font-bold text-green-800 dark:text-green-300">Active Activities</h3>
                    <p class="text-3xl font-extrabold text-green-600 dark:text-green-400 mt-2">0</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
