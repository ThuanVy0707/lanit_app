<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Order') }}: {{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('orders.update', $order) }}">
                        @csrf
                        @method('PUT')

                        <!-- Order Number -->
                        <div class="mb-4">
                            <label for="order_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order Number</label>
                            <input type="text" name="order_number" id="order_number" value="{{ old('order_number', $order->order_number) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('order_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Client -->
                        <div class="mb-4">
                            <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Client <span class="text-red-600">*</span></label>
                            <select name="client_id" id="client_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select a client...</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id', $order->client_id) == $client->id ? 'selected' : '' }}>
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
                                <label for="invoice_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Invoice</label>
                                <select name="invoice_id" id="invoice_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">No invoice</option>
                                    @foreach($invoices as $invoice)
                                        <option value="{{ $invoice->id }}" {{ old('invoice_id', $order->invoice_id) == $invoice->id ? 'selected' : '' }}>
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
                                <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount <span class="text-red-600">*</span></label>
                            <input type="text" name="amount" id="amount" value="{{ old('amount', $order->amount) }}" data-currency="vnd" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Payment Method -->
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                                <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method', $order->payment_method) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Status -->
                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Status <span class="text-red-600">*</span></label>
                                <select name="payment_status" id="payment_status" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Pending" {{ old('payment_status', $order->payment_status) === 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Paid" {{ old('payment_status', $order->payment_status) === 'Paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="Cancelled" {{ old('payment_status', $order->payment_status) === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="Refunded" {{ old('payment_status', $order->payment_status) === 'Refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                                @error('payment_status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status <span class="text-red-600">*</span></label>
                                <select name="status" id="status" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Pending" {{ old('status', $order->status) === 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Active" {{ old('status', $order->status) === 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Cancelled" {{ old('status', $order->status) === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="Fraud" {{ old('status', $order->status) === 'Fraud' ? 'selected' : '' }}>Fraud</option>
                                    <option value="Completed" {{ old('status', $order->status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- IP Address -->
                            <div>
                                <label for="ip_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">IP Address</label>
                                <input type="text" name="ip_address" id="ip_address" value="{{ old('ip_address', $order->ip_address) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('ip_address')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Fraud Detection Section -->
                        <div class="mb-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="text-md font-semibold mb-3">Fraud Detection (Optional)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="fraud_module" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fraud Module</label>
                                    <input type="text" name="fraud_module" id="fraud_module" value="{{ old('fraud_module', $order->fraud_module) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('fraud_module')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="fraud_output" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fraud Output</label>
                                    <input type="text" name="fraud_output" id="fraud_output" value="{{ old('fraud_output', $order->fraud_output) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('fraud_output')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Promo Code Section -->
                        <div class="mb-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="text-md font-semibold mb-3">Promo Code (Optional)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="promo_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Promo Code</label>
                                    <input type="text" name="promo_code" id="promo_code" value="{{ old('promo_code', $order->promo_code) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('promo_code')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="promo_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Promo Type</label>
                                    <input type="text" name="promo_type" id="promo_type" value="{{ old('promo_type', $order->promo_type) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('promo_type')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="promo_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Promo Value</label>
                                    <input type="text" name="promo_value" id="promo_value" value="{{ old('promo_value', $order->promo_value) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('promo_value')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Line Items Section -->
                        <div class="mb-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-md font-semibold">Order Line Items</h4>
                                <button type="button" id="add-line-item" class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    + Add Item
                                </button>
                            </div>

                            <div id="line-items-container" class="space-y-4">
                                @php
                                    $items = old('line_items', $order->lineItems->toArray());
                                @endphp
                                @foreach($items as $index => $item)
                                    <div class="line-item border border-gray-300 dark:border-gray-600 rounded-md p-4 relative">
                                        <button type="button" class="remove-line-item absolute top-2 right-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            ✕ Remove
                                        </button>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type <span class="text-red-600">*</span></label>
                                                <input type="text" name="line_items[{{ $index }}][type]" value="{{ is_array($item) ? ($item['type'] ?? '') : $item->type }}" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rel ID</label>
                                                <input type="number" name="line_items[{{ $index }}][relid]" value="{{ is_array($item) ? ($item['relid'] ?? '') : $item->relid }}"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Type</label>
                                                <input type="text" name="line_items[{{ $index }}][product_type]" value="{{ is_array($item) ? ($item['product_type'] ?? '') : $item->product_type }}"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product</label>
                                                <input type="text" name="line_items[{{ $index }}][product]" value="{{ is_array($item) ? ($item['product'] ?? '') : $item->product }}"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Domain</label>
                                                <input type="text" name="line_items[{{ $index }}][domain]" value="{{ is_array($item) ? ($item['domain'] ?? '') : $item->domain }}"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Billing Cycle</label>
                                                <input type="text" name="line_items[{{ $index }}][billing_cycle]" value="{{ is_array($item) ? ($item['billing_cycle'] ?? '') : $item->billing_cycle }}"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount <span class="text-red-600">*</span></label>
                                                <input type="text" name="line_items[{{ $index }}][amount]" value="{{ is_array($item) ? ($item['amount'] ?? '') : $item->amount }}" data-currency="vnd" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                            <input type="text" name="line_items[{{ $index }}][status]" value="{{ is_array($item) ? ($item['status'] ?? '') : $item->status }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('orders.show', $order) }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Update Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let itemIndex = {{ count($items) }};

        document.getElementById('add-line-item').addEventListener('click', function() {
            const container = document.getElementById('line-items-container');
            const newItem = document.createElement('div');
            newItem.className = 'line-item border border-gray-300 dark:border-gray-600 rounded-md p-4 relative';
            newItem.innerHTML = `
                <button type="button" class="remove-line-item absolute top-2 right-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                    ✕ Remove
                </button>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type <span class="text-red-600">*</span></label>
                        <input type="text" name="line_items[${itemIndex}][type]" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rel ID</label>
                        <input type="number" name="line_items[${itemIndex}][relid]"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Type</label>
                        <input type="text" name="line_items[${itemIndex}][product_type]"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product</label>
                        <input type="text" name="line_items[${itemIndex}][product]"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Domain</label>
                        <input type="text" name="line_items[${itemIndex}][domain]"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Billing Cycle</label>
                        <input type="text" name="line_items[${itemIndex}][billing_cycle]"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount <span class="text-red-600">*</span></label>
                        <input type="text" name="line_items[${itemIndex}][amount]" data-currency="vnd" step="0.01" min="0" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
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
