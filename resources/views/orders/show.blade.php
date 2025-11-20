<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Order Details') }}: {{ $order->order_number }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('orders.edit', $order) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Order Information -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Order Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order Number</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Client</label>
                            <p class="mt-1 text-sm">
                                <a href="{{ route('clients.show', $order->client) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $order->client->fullname }} ({{ $order->client->email }})
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-bold text-lg">{{ formatCurrencyVND($order->amount) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Invoice</label>
                            <p class="mt-1 text-sm">
                                @if($order->invoice)
                                    <a href="{{ route('invoices.show', $order->invoice) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        #{{ $order->invoice->invoice_num }}
                                    </a>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($order->status === 'Active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($order->status === 'Pending') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @elseif($order->status === 'Completed') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                    @elseif($order->status === 'Fraud') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Status</label>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($order->payment_status === 'Paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($order->payment_status === 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ $order->payment_status }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->payment_method ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">IP Address</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->ip_address ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Created</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->created_at->format('M d, Y H:i:s') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">User</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->user?->name ?? 'System' }}</p>
                        </div>
                    </div>

                    @if($order->promo_code)
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="text-md font-semibold mb-3">Promo Code Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Code</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $order->promo_code }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->promo_type ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Value</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->promo_value ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($order->fraud_module || $order->fraud_output)
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="text-md font-semibold mb-3 text-red-600 dark:text-red-400">Fraud Detection</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($order->fraud_module)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fraud Module</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->fraud_module }}</p>
                                    </div>
                                @endif
                                @if($order->fraud_output)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fraud Output</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->fraud_output }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($order->notes)
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Line Items -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Order Line Items</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Product
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Domain
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Billing Cycle
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($order->lineItems as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $item->type }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $item->product ?? 'N/A' }}
                                            @if($item->product_type)
                                                <span class="text-xs text-gray-500 dark:text-gray-400">({{ $item->product_type }})</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $item->domain ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $item->billing_cycle ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ formatCurrencyVND($item->amount) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ $item->status ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            No line items found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($order->lineItems->count() > 0)
                                <tfoot class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <td colspan="4" class="px-6 py-3 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            Total:
                                        </td>
                                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-gray-100">
                                            {{ formatCurrencyVND($order->lineItems->sum('amount')) }}
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
