<aside x-data="{ open: false }" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:static md:inset-0 md:translate-x-0 md:z-auto">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-700">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-2">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block">
                {{ __('messages.msg_dashboard') }}
            </x-nav-link>
            <x-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.*')" class="block">
                {{ __('messages.msg_clients') }}
            </x-nav-link>
            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="block">
                {{ __('messages.msg_users') }}
            </x-nav-link>
            <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="block">
                {{ __('messages.msg_products') }}
            </x-nav-link>
            <x-nav-link :href="route('invoices.index')" :active="request()->routeIs('invoices.*')" class="block">
                {{ __('messages.msg_invoices') }}
            </x-nav-link>
            <x-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.*')" class="block">
                {{ __('messages.msg_tickets') }}
            </x-nav-link>
            <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')" class="block">
                {{ __('messages.msg_orders') }}
            </x-nav-link>
            <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" class="block">
                {{ __('messages.msg_reports') }}
            </x-nav-link>
        </nav>
    </div>
</aside>

<!-- Mobile Overlay -->
<div x-show="open" @click="open = false" class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden" x-transition></div>

<!-- Mobile Toggle Button -->
<button @click="open = !open" class="fixed top-4 left-4 z-50 md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
</button>
