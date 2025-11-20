<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-indigo-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Client') }} - {{ $client->fullname }}
            </h2>
            <a href="{{ route('clients.show', $client) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50">
                <div class="p-6">
                    <form method="POST" action="{{ route('clients.update', $client) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <label for="firstname" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="firstname" id="firstname" value="{{ old('firstname', $client->firstname) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('firstname')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="lastname" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="lastname" id="lastname" value="{{ old('lastname', $client->lastname) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('lastname')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $client->email) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Company Name -->
                            <div>
                                <label for="companyname" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company Name</label>
                                <input type="text" name="companyname" id="companyname" value="{{ old('companyname', $client->companyname) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('companyname')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phonenumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                <input type="text" name="phonenumber" id="phonenumber" value="{{ old('phonenumber', $client->phonenumber) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('phonenumber')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Active" {{ old('status', $client->status) === 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status', $client->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="Closed" {{ old('status', $client->status) === 'Closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Source -->
                            <div>
                                <label for="source" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Source</label>
                                <select name="source" id="source"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select source...</option>
                                    <option value="Website" {{ old('source', $client->source) === 'Website' ? 'selected' : '' }}>Website</option>
                                    <option value="Referral" {{ old('source', $client->source) === 'Referral' ? 'selected' : '' }}>Referral</option>
                                    <option value="Social Media" {{ old('source', $client->source) === 'Social Media' ? 'selected' : '' }}>Social Media</option>
                                    <option value="Advertisement" {{ old('source', $client->source) === 'Advertisement' ? 'selected' : '' }}>Advertisement</option>
                                    <option value="Partner" {{ old('source', $client->source) === 'Partner' ? 'selected' : '' }}>Partner</option>
                                    <option value="Direct" {{ old('source', $client->source) === 'Direct' ? 'selected' : '' }}>Direct</option>
                                    <option value="Other" {{ old('source', $client->source) === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('source')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Credit -->
                            <div>
                                <label for="credit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Credit Balance</label>
                                <input type="text" step="0.01" name="credit" id="credit" value="{{ old('credit', $client->credit) }}" data-currency="vnd"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('credit')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Address Section -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Address Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Address 1 -->
                                <div class="md:col-span-2">
                                    <label for="address1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address Line 1</label>
                                    <input type="text" name="address1" id="address1" value="{{ old('address1', $client->address1) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('address1')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address 2 -->
                                <div class="md:col-span-2">
                                    <label for="address2" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address Line 2</label>
                                    <input type="text" name="address2" id="address2" value="{{ old('address2', $client->address2) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('address2')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- City -->
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                                    <input type="text" name="city" id="city" value="{{ old('city', $client->city) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- State -->
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300">State/Province</label>
                                    <input type="text" name="state" id="state" value="{{ old('state', $client->state) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('state')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Postcode -->
                                <div>
                                    <label for="postcode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postcode</label>
                                    <input type="text" name="postcode" id="postcode" value="{{ old('postcode', $client->postcode) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('postcode')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Country Code -->
                                <div>
                                    <label for="countrycode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country Code</label>
                                    <input type="text" name="countrycode" id="countrycode" value="{{ old('countrycode', $client->countrycode) }}" maxlength="2" placeholder="US"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('countrycode')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Options -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Additional Options</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <input type="checkbox" name="marketing_emails_opt_in" id="marketing_emails_opt_in" value="1" {{ old('marketing_emails_opt_in', $client->marketing_emails_opt_in) ? 'checked' : '' }}
                                        class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <label for="marketing_emails_opt_in" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Opt-in to marketing emails
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="email_verified" id="email_verified" value="1" {{ old('email_verified', $client->email_verified) ? 'checked' : '' }}
                                        class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <label for="email_verified" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Email verified
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="taxexempt" id="taxexempt" value="1" {{ old('taxexempt', $client->taxexempt) ? 'checked' : '' }}
                                        class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <label for="taxexempt" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Tax exempt
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $client->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('clients.show', $client) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-indigo-700 hover:to-purple-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Update Client
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

