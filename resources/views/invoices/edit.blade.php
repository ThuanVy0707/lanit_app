<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.msg_edit_invoice') }}
            </h2>
            <a href="{{ route('invoices.show', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('messages.msg_back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('invoices.update', $invoice) }}">
                        @csrf
                        @method('PUT')

                        <!-- Client -->
                        <div class="mb-4">
                            <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.msg_client') }} <span class="text-red-500">*</span>
                            </label>
                            <select id="client_id" name="client_id" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('client_id') border-red-500 @enderror">
                                <option value="">{{ __('messages.msg_select_client') }}</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ (old('client_id', $invoice->client_id) == $client->id) ? 'selected' : '' }}>
                                        {{ $client->fullname }} - {{ $client->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Invoice Number -->
                        <div class="mb-4">
                            <label for="invoice_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.msg_invoice_number_label') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', $invoice->invoice_number) }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('invoice_number') border-red-500 @enderror">
                            @error('invoice_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date and Due Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_invoice_date_label') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="date" name="date" value="{{ old('date', $invoice->date->format('Y-m-d')) }}" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('date') border-red-500 @enderror">
                                @error('date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="duedate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_due_date') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="duedate" name="duedate" value="{{ old('duedate', $invoice->duedate->format('Y-m-d')) }}" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('duedate') border-red-500 @enderror">
                                @error('duedate')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Amounts -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="subtotal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_subtotal') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="subtotal" name="subtotal" value="{{ old('subtotal', $invoice->subtotal) }}" data-currency="vnd" required
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('subtotal') border-red-500 @enderror">
                                </div>
                                @error('subtotal')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tax" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_tax') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="tax" name="tax" value="{{ old('tax', $invoice->tax) }}" data-currency="vnd" required
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tax') border-red-500 @enderror">
                                </div>
                                @error('tax')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="credit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_credit') }}
                                </label>
                                <div class="relative">
                                    <input type="text" id="credit" name="credit" value="{{ old('credit', $invoice->credit) }}" data-currency="vnd"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('credit') border-red-500 @enderror">
                                </div>
                                @error('credit')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Total (calculated) -->
                        <div class="mb-4">
                            <label for="total" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.msg_total') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="total" name="total" value="{{ old('total', $invoice->total) }}" data-currency="vnd" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('total') border-red-500 @enderror">
                            </div>
                            @error('total')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('messages.msg_total_calculation') }}</p>
                        </div>

                        <!-- Status and Payment Method -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_status') }} <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('status') border-red-500 @enderror">
                                    <option value="Draft" {{ old('status', $invoice->status) === 'Draft' ? 'selected' : '' }}>{{ __('messages.msg_draft') }}</option>
                                    <option value="Unpaid" {{ old('status', $invoice->status) === 'Unpaid' ? 'selected' : '' }}>{{ __('messages.msg_unpaid') }}</option>
                                    <option value="Paid" {{ old('status', $invoice->status) === 'Paid' ? 'selected' : '' }}>{{ __('messages.msg_paid') }}</option>
                                    <option value="Cancelled" {{ old('status', $invoice->status) === 'Cancelled' ? 'selected' : '' }}>{{ __('messages.msg_cancelled') }}</option>
                                    <option value="Refunded" {{ old('status', $invoice->status) === 'Refunded' ? 'selected' : '' }}>{{ __('messages.msg_refunded') }}</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_payment_method_label') }}
                                </label>
                                <input type="text" id="payment_method" name="payment_method" value="{{ old('payment_method', $invoice->payment_method) }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('payment_method') border-red-500 @enderror"
                                    placeholder="{{ __('messages.msg_payment_method_placeholder') }}">
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('messages.msg_notes') }}
                            </label>
                            <textarea id="notes" name="notes" rows="4"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('notes') border-red-500 @enderror">{{ old('notes', $invoice->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('invoices.show', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('messages.msg_cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('messages.msg_update_invoice') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-calculate total
        document.addEventListener('DOMContentLoaded', function() {
            const subtotalInput = document.getElementById('subtotal');
            const taxInput = document.getElementById('tax');
            const creditInput = document.getElementById('credit');
            const totalInput = document.getElementById('total');

            // Function to parse VND formatted string to number
            function parseVND(value) {
                return parseFloat(value.replace(/\./g, '')) || 0;
            }

            // Function to format number to VND format
            function formatToVND(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function calculateTotal() {
                const subtotal = parseVND(subtotalInput.value);
                const tax = parseVND(taxInput.value);
                const credit = parseVND(creditInput.value);
                const total = subtotal + tax - credit;
                totalInput.value = formatToVND(total);
            }

            subtotalInput.addEventListener('input', calculateTotal);
            taxInput.addEventListener('input', calculateTotal);
            creditInput.addEventListener('input', calculateTotal);
        });
    </script>
</x-app-layout>
