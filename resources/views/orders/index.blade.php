<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.msg_orders') }}
            </h2>
            <a href="{{ route('orders.create') }}" class="mx-2 inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-indigo-700 hover:to-purple-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('messages.msg_create_order') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('orders.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <!-- Search -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.msg_search') }}</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="{{ __('messages.msg_search_placeholder') }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Client Filter -->
                            <div>
                                <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.msg_client') }}</label>
                                <select name="client_id" id="client_id"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('messages.msg_all_clients') }}</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->fullname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.msg_status') }}</label>
                                <select name="status" id="status"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('messages.msg_all_statuses') }}</option>
                                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>{{ __('messages.msg_pending') }}</option>
                                    <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>{{ __('messages.msg_active') }}</option>
                                    <option value="Cancelled" {{ request('status') === 'Cancelled' ? 'selected' : '' }}>{{ __('messages.msg_cancelled') }}</option>
                                    <option value="Fraud" {{ request('status') === 'Fraud' ? 'selected' : '' }}>{{ __('messages.msg_fraud') }}</option>
                                    <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>{{ __('messages.msg_completed') }}</option>
                                </select>
                            </div>

                            <!-- Payment Status Filter -->
                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.msg_payment') }}</label>
                                <select name="payment_status" id="payment_status"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('messages.msg_all') }}</option>
                                    <option value="Pending" {{ request('payment_status') === 'Pending' ? 'selected' : '' }}>{{ __('messages.msg_pending') }}</option>
                                    <option value="Paid" {{ request('payment_status') === 'Paid' ? 'selected' : '' }}>{{ __('messages.msg_paid') }}</option>
                                    <option value="Cancelled" {{ request('payment_status') === 'Cancelled' ? 'selected' : '' }}>{{ __('messages.msg_cancelled') }}</option>
                                    <option value="Refunded" {{ request('payment_status') === 'Refunded' ? 'selected' : '' }}>{{ __('messages.msg_refunded') }}</option>
                                </select>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="flex items-end space-x-2">
                                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-md hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                    {{ __('messages.msg_filter') }}
                                </button>
                                <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                    {{ __('messages.msg_reset') }}
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.msg_order_hash') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.msg_client') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.msg_amount') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.msg_payment') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.msg_status') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.msg_items') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.msg_date') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.msg_actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($orders as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $order->order_number }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-300">
                                                <a href="{{ route('clients.show', $order->client) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                    {{ $order->client->fullname }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-medium">
                                            {{ formatCurrencyVND($order->amount) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($order->payment_status === 'Paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($order->payment_status === 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @endif">
                                                {{ $order->payment_status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($order->status === 'Active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($order->status === 'Pending') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                @elseif($order->status === 'Completed') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                                @elseif($order->status === 'Fraud') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @else bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                                @endif">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $order->lineItems->count() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">{{ __('messages.msg_view') }}</a>
                                            <a href="{{ route('orders.edit', $order) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">{{ __('messages.msg_edit') }}</a>
                                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.msg_confirm_delete_order') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">{{ __('messages.msg_delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('messages.msg_no_orders_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
