<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-gray-200 leading-tight">
            {{ __('messages.msg_dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ trans("messages.msg_you_are_logged_in") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

