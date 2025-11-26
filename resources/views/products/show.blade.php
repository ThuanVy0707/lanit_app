<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl dark:text-gray-200 leading-tight">
                {{ __('messages.msg_product_details') }} - {{ $product->name }}
            </h2>
            <div class="flex space-x-2 mx-2">
                <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-indigo-700 hover:to-purple-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('messages.msg_edit') }}
                </a>
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('messages.msg_back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Product Information -->
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.msg_product_information') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_product_name') }}</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $product->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_client') }}</label>
                            <p class="mt-1 text-sm">
                                <a href="{{ route('clients.show', $product->client) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $product->client->fullname }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_type') }}</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 capitalize">{{ $product->type }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_status') }}</label>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($product->status === 'Active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($product->status === 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @elseif($product->status === 'Suspended') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ $product->status }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_billing_cycle') }}</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 capitalize">{{ $product->billing_cycle }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_amount') }}</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-medium">{{ formatCurrencyVND($product->amount) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_next_due_date') }}</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $product->next_due_date ? $product->next_due_date->format('M d, Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_created') }}</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $product->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    @if($product->description)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.msg_description') }}</label>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $product->description }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Client Summary -->
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.msg_client_summary') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_company') }}</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $product->client->companyname ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_email') }}</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $product->client->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_phone') }}</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $product->client->phonenumber ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_client_status') }}</label>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($product->client->status === 'Active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($product->client->status === 'Inactive') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ $product->client->status }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

