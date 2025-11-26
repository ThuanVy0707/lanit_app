<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.msg_create_order') }}
            </h2>
            <a href="{{ route('orders.index') }}" class="mx-2 inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-indigo-700 hover:to-purple-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('messages.msg_back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf

                        <!-- Order Number -->
                        <div class="mb-4">
                            <label for="order_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_order_number') }}</label>
                            <input type="text" name="order_number" id="order_number" value="{{ old('order_number', $nextOrderNumber) }}" readonly
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100 dark:bg-gray-700">
                            @error('order_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Client -->
                        <div class="mb-4">
                            <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_client_required') }}</label>
                            <select name="client_id" id="client_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">{{ __('messages.msg_select_client') }}</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->fullname }} ({{ $client->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Invoice -->
                            <div>
                                <label for="invoice_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_invoice') }}</label>
                                <select name="invoice_id" id="invoice_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('messages.msg_no_invoice') }}</option>
                                    @foreach($invoices as $invoice)
                                        <option value="{{ $invoice->id }}" {{ old('invoice_id') == $invoice->id ? 'selected' : '' }}>
                                            #{{ $invoice->invoice_num }} - {{ formatCurrencyVND($invoice->total) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('invoice_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_amount_required') }}</label>
                            <input type="text" name="amount" id="amount" value="{{ old('amount') }}" data-currency="vnd" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Payment Method -->
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_payment_method_label') }}</label>
                                <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Status -->
                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_payment_status_required') }}</label>
                                <select name="payment_status" id="payment_status" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Pending" {{ old('payment_status') === 'Pending' ? 'selected' : '' }}>{{ __('messages.msg_pending') }}</option>
                                    <option value="Paid" {{ old('payment_status') === 'Paid' ? 'selected' : '' }}>{{ __('messages.msg_paid') }}</option>
                                    <option value="Cancelled" {{ old('payment_status') === 'Cancelled' ? 'selected' : '' }}>{{ __('messages.msg_cancelled') }}</option>
                                    <option value="Refunded" {{ old('payment_status') === 'Refunded' ? 'selected' : '' }}>{{ __('messages.msg_refunded') }}</option>
                                </select>
                                @error('payment_status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_status_required') }}</label>
                                <select name="status" id="status" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>{{ __('messages.msg_pending') }}</option>
                                    <option value="Active" {{ old('status') === 'Active' ? 'selected' : '' }}>{{ __('messages.msg_active') }}</option>
                                    <option value="Cancelled" {{ old('status') === 'Cancelled' ? 'selected' : '' }}>{{ __('messages.msg_cancelled') }}</option>
                                    <option value="Fraud" {{ old('status') === 'Fraud' ? 'selected' : '' }}>{{ __('messages.msg_fraud') }}</option>
                                    <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>{{ __('messages.msg_completed') }}</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- IP Address -->
                            <div>
                                <label for="ip_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_ip_address') }}</label>
                                <input type="text" name="ip_address" id="ip_address" value="{{ old('ip_address') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('ip_address')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Promo Code Section -->
                        <div class="mb-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="text-md font-semibold mb-3">{{ __('messages.msg_promo_code_optional') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="promo_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_promo_code') }}</label>
                                    <input type="text" name="promo_code" id="promo_code" value="{{ old('promo_code') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('promo_code')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="promo_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_promo_type') }}</label>
                                    <input type="text" name="promo_type" id="promo_type" value="{{ old('promo_type') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('promo_type')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="promo_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_promo_value') }}</label>
                                    <input type="text" name="promo_value" id="promo_value" value="{{ old('promo_value') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('promo_value')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_notes') }}</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Line Items Section -->
                        <div class="mb-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-md font-semibold">{{ __('messages.msg_order_line_items') }}</h4>
                                <button type="button" id="add-line-item" class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    {{ __('messages.msg_add_item') }}
                                </button>
                            </div>

                            <div id="line-items-container" class="space-y-4">
                                @if(old('line_items'))
                                    @foreach(old('line_items') as $index => $item)
                                        <div class="line-item border border-gray-300 dark:border-gray-600 rounded-md p-4 relative">
                                            <button type="button" class="remove-line-item absolute top-2 right-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                ✕ Remove
                                            </button>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_type_required') }}</label>
                                                    <input type="text" name="line_items[{{ $index }}][type]" value="{{ $item['type'] ?? '' }}" required
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_rel_id') }}</label>
                                                    <input type="number" name="line_items[{{ $index }}][relid]" value="{{ $item['relid'] ?? '' }}"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_product_type') }}</label>
                                                    <input type="text" name="line_items[{{ $index }}][product_type]" value="{{ $item['product_type'] ?? '' }}"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_product') }}</label>
                                                    <input type="text" name="line_items[{{ $index }}][product]" value="{{ $item['product'] ?? '' }}"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_domain') }}</label>
                                                    <input type="text" name="line_items[{{ $index }}][domain]" value="{{ $item['domain'] ?? '' }}"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_billing_cycle') }}</label>
                                                    <input type="text" name="line_items[{{ $index }}][billing_cycle]" value="{{ $item['billing_cycle'] ?? '' }}"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_amount_required') }}</label>
                                                <input type="text" name="line_items[{{ $index }}][amount]" value="{{ $item['amount'] ?? '' }}" data-currency="vnd" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_status') }}</label>
                                                <input type="text" name="line_items[{{ $index }}][status]" value="{{ $item['status'] ?? '' }}"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                {{ __('messages.msg_cancel') }}
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                {{ __('messages.msg_create_order') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let itemIndex = {{ old('line_items') ? count(old('line_items')) : 0 }};

        document.getElementById('add-line-item').addEventListener('click', function() {
            const container = document.getElementById('line-items-container');
            const newItem = document.createElement('div');
            newItem.className = 'line-item border border-gray-300 dark:border-gray-600 rounded-md p-4 relative';
            newItem.innerHTML = `
                <button type="button" class="remove-line-item absolute top-2 right-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                    {{ __('messages.msg_remove') }}
                </button>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_type_required') }}</label>
                        <input type="text" name="line_items[${itemIndex}][type]" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_rel_id') }}</label>
                        <input type="number" name="line_items[${itemIndex}][relid]"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_product_type') }}</label>
                        <input type="text" name="line_items[${itemIndex}][product_type]"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_product') }}</label>
                        <input type="text" name="line_items[${itemIndex}][product]"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_domain') }}</label>
                        <input type="text" name="line_items[${itemIndex}][domain]"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_billing_cycle') }}</label>
                        <input type="text" name="line_items[${itemIndex}][billing_cycle]"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_amount_required') }}</label>
                        <input type="text" name="line_items[${itemIndex}][amount]" data-currency="vnd" step="0.01" min="0" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_status') }}</label>
                    <input type="text" name="line_items[${itemIndex}][status]"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            `;
            container.appendChild(newItem);
            itemIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-line-item')) {
                e.target.closest('.line-item').remove();
            }
        });
    </script>
</x-app-layout>
