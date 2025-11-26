<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.msg_create_new_product') }}
            </h2>
            <a href="{{ route('products.index') }}" class="mx-2 inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-indigo-700 hover:to-purple-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('messages.msg_back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50">
                <div class="p-6">
                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Client -->
                            <div class="md:col-span-2">
                                <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_client') }} <span class="text-red-500">*</span></label>
                                <select name="client_id" id="client_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('messages.msg_select_a_client') }}</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->fullname }} - {{ $client->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Product Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_product_name') }} <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_type') }} <span class="text-red-500">*</span></label>
                                <select name="type" id="type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="hostingaccount" {{ old('type') === 'hostingaccount' ? 'selected' : '' }}>{{ __('messages.msg_hosting_account') }}</option>
                                    <option value="domain" {{ old('type') === 'domain' ? 'selected' : '' }}>{{ __('messages.msg_domain') }}</option>
                                    <option value="addon" {{ old('type') === 'addon' ? 'selected' : '' }}>{{ __('messages.msg_addon') }}</option>
                                    <option value="other" {{ old('type') === 'other' ? 'selected' : '' }}>{{ __('messages.msg_other') }}</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_status') }} <span class="text-red-500">*</span></label>
                                <select name="status" id="status" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>{{ __('messages.msg_pending') }}</option>
                                    <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>{{ __('messages.msg_active') }}</option>
                                    <option value="Suspended" {{ old('status') === 'Suspended' ? 'selected' : '' }}>{{ __('messages.msg_suspended') }}</option>
                                    <option value="Terminated" {{ old('status') === 'Terminated' ? 'selected' : '' }}>{{ __('messages.msg_terminated') }}</option>
                                    <option value="Cancelled" {{ old('status') === 'Cancelled' ? 'selected' : '' }}>{{ __('messages.msg_cancelled') }}</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Billing Cycle -->
                            <div>
                                <label for="billing_cycle" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_billing_cycle') }} <span class="text-red-500">*</span></label>
                                <select name="billing_cycle" id="billing_cycle" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="monthly" {{ old('billing_cycle', 'monthly') === 'monthly' ? 'selected' : '' }}>{{ __('messages.msg_monthly') }}</option>
                                    <option value="quarterly" {{ old('billing_cycle') === 'quarterly' ? 'selected' : '' }}>{{ __('messages.msg_quarterly') }}</option>
                                    <option value="semiannually" {{ old('billing_cycle') === 'semiannually' ? 'selected' : '' }}>{{ __('messages.msg_semi_annually') }}</option>
                                    <option value="annually" {{ old('billing_cycle') === 'annually' ? 'selected' : '' }}>{{ __('messages.msg_annually') }}</option>
                                    <option value="biennially" {{ old('billing_cycle') === 'biennially' ? 'selected' : '' }}>{{ __('messages.msg_biennially') }}</option>
                                    <option value="triennially" {{ old('billing_cycle') === 'triennially' ? 'selected' : '' }}>{{ __('messages.msg_triennially') }}</option>
                                    <option value="onetime" {{ old('billing_cycle') === 'onetime' ? 'selected' : '' }}>{{ __('messages.msg_one_time') }}</option>
                                </select>
                                @error('billing_cycle')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_amount') }} <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                    </div>
                                    <input type="text" step="0.01" min="0" name="amount" id="amount" value="{{ old('amount') }}" data-currency="vnd" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Next Due Date -->
                            <div>
                                <label for="next_due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_next_due_date') }}</label>
                                <input type="date" name="next_due_date" id="next_due_date" value="{{ old('next_due_date') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('next_due_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.msg_description') }}</label>
                                <textarea name="description" id="description" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('messages.msg_cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-indigo-700 hover:to-purple-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('messages.msg_create_product') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

