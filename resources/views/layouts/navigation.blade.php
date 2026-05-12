<nav class="w-64 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 flex-shrink-0 min-h-screen">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b border-gray-100 dark:border-gray-700">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800 dark:text-white">
            BGBR Rwanda
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="py-4 space-y-1">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ __('Dashboard') }}
        </x-nav-link>

        @can('manage dominations')
        <div class="px-4 py-2 mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Super Admin</div>
        <x-nav-link :href="route('users.pending')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ __('Pending Approvals') }}
        </x-nav-link>
        <x-nav-link :href="route('dominations.index')" :active="request()->routeIs('dominations.*')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ __('Dominations') }}
        </x-nav-link>
        <x-nav-link href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ __('System Settings') }}
        </x-nav-link>
        @endcan

        @can('manage battalions')
        <div class="px-4 py-2 mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Battalion</div>
        <x-nav-link :href="route('battalions.index')" :active="request()->routeIs('battalions.*')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ __('Battalions') }}
        </x-nav-link>
        <x-nav-link href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ __('Approve Battalion Reports') }}
        </x-nav-link>
        @endcan

        @can('manage companies')
        <div class="px-4 py-2 mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Company</div>
        <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ __('Companies') }}
        </x-nav-link>
        <x-nav-link href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ __('Company Reports') }}
        </x-nav-link>
        @endcan

        @can('register members')
        <div class="px-4 py-2 mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Members</div>
        <x-nav-link href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ __('Members List') }}
        </x-nav-link>
        <x-nav-link href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ __('Activities') }}
        </x-nav-link>
        @endcan

        @can('view announcements')
        <div class="px-4 py-2 mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Public</div>
        <x-nav-link href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ __('Announcements') }}
        </x-nav-link>
        @endcan
        
        <div class="px-4 py-2 mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Account</div>
        <x-nav-link :href="route('profile.edit')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ __('Profile') }}
        </x-nav-link>
    </div>
</nav>
