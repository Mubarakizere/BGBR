<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Domination Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome, Domination Admin! You are viewing analytics for your region.") }}
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-purple-50 dark:bg-purple-900/30 p-6 rounded-lg shadow-sm border border-purple-100 dark:border-purple-800">
                    <h3 class="text-lg font-bold text-purple-800 dark:text-purple-300">Battalions</h3>
                    <p class="text-3xl font-extrabold text-purple-600 dark:text-purple-400 mt-2">0</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
