<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Invoice Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('invoices.edit', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('invoices.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Invoice Header -->
                    <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-bold mb-2">{{ $invoice->invoice_number }}</h3>
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                    @if($invoice->status === 'Paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($invoice->status === 'Unpaid') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @elseif($invoice->status === 'Draft') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ $invoice->status }}
                                </span>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Invoice Date</p>
                                <p class="text-lg font-semibold">{{ $invoice->date->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Client Information -->
                    <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <h4 class="text-lg font-semibold mb-3">Bill To</h4>
                        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-md">
                            <p class="font-semibold text-lg">{{ $invoice->client->fullname }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->companyname }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->email }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->client->phonenumber }}</p>
                            @if($invoice->client->address1)
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                    {{ $invoice->client->address1 }}<br>
                                    @if($invoice->client->address2)
                                        {{ $invoice->client->address2 }}<br>
                                    @endif
                                    {{ $invoice->client->city }}, {{ $invoice->client->state }} {{ $invoice->client->postcode }}<br>
                                    {{ $invoice->client->country }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Invoice Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Invoice Details</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Invoice Number:</dt>
                                    <dd class="text-sm font-medium">{{ $invoice->invoice_number }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Invoice Date:</dt>
                                    <dd class="text-sm font-medium">{{ $invoice->date->format('M d, Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Due Date:</dt>
                                    <dd class="text-sm font-medium">{{ $invoice->duedate->format('M d, Y') }}</dd>
                                </div>
                                @if($invoice->payment_method)
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-600 dark:text-gray-400">Payment Method:</dt>
                                        <dd class="text-sm font-medium">{{ $invoice->payment_method }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Amount Details</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Subtotal:</dt>
                                    <dd class="text-sm font-medium">${{ number_format($invoice->subtotal, 2) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Tax:</dt>
                                    <dd class="text-sm font-medium">${{ number_format($invoice->tax, 2) }}</dd>
                                </div>
                                @if($invoice->credit > 0)
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-600 dark:text-gray-400">Credit:</dt>
                                        <dd class="text-sm font-medium text-green-600 dark:text-green-400">-${{ number_format($invoice->credit, 2) }}</dd>
                                    </div>
                                @endif
                                <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <dt class="text-base font-semibold">Total:</dt>
                                    <dd class="text-base font-bold text-blue-600 dark:text-blue-400">${{ number_format($invoice->total, 2) }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($invoice->notes)
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Notes</h4>
                            <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-md">
                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $invoice->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Metadata -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
                            <p>Created: {{ $invoice->created_at->format('M d, Y h:i A') }}</p>
                            <p>Last Updated: {{ $invoice->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
