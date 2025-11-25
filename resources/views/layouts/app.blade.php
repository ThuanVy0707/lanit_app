<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
            @include('layouts.navigation')

            <!-- Main Content -->
            <div class="flex-1 ml-0">
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center">
                            <div class="flex-1">
                                {{ $header }}
                            </div>
                            <div class="flex items-center space-x-2">
                                <!-- User Dropdown -->
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                            <div>{{ Auth::user()->name }}</div>

                                            <div class="ms-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('messages.msg_profile') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('lang.switch', 'en')">
                                            {{ __('messages.msg_english') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('lang.switch', 'vi')">
                                            {{ __('messages.msg_vietnamese') }}
                                        </x-dropdown-link>
                                        <div class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800">
                                            <button
                                                @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode ? 'dark' : 'light')"
                                                x-data="{ darkMode: localStorage.getItem('darkMode') === 'dark' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
                                                x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); darkMode ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')"
                                                class="flex items-center w-full text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md transition duration-150 ease-in-out"
                                            >
                                                {{-- <svg x-show="!darkMode" class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                </svg>
                                                <svg x-show="darkMode" class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                                </svg> --}}
                                                <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('messages.msg_log_out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
