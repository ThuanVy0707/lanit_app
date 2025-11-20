<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-indigo-800 dark:text-gray-200 leading-tight">
                {{ __('Client Details') }} - {{ $client->fullname }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('clients.edit', $client) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('clients.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Back') }}
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

            <!-- Client Information -->
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Client Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $client->fullname }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $client->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $client->companyname ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $client->phonenumber ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $client->address1 }}
                                @if($client->address2), {{ $client->address2 }}@endif
                                @if($client->city || $client->state || $client->postcode)
                                    <br>{{ $client->city }}@if($client->state), {{ $client->state }}@endif {{ $client->postcode }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($client->status === 'Active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($client->status === 'Inactive') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ $client->status }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Credit Balance</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ formatCurrencyVND($client->credit) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">UUID</label>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 font-mono">{{ $client->uuid }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50 p-6">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Invoices</h4>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['numdueinvoices'] ?? 0 }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Due</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50 p-6">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Products</h4>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['productsnumactive'] ?? 0 }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Active</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50 p-6">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Domains</h4>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['numactivedomains'] ?? 0 }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Active</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50 p-6">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tickets</h4>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['numactivetickets'] ?? 0 }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Open</p>
                </div>
            </div>

            <!-- Invoices -->
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Invoices</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Invoice #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($client->invoices->take(5) as $invoice)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $invoice->invoice_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $invoice->date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $invoice->duedate->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ formatCurrencyVND($invoice->total) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($invoice->status === 'Paid') bg-green-100 text-green-800
                                                @elseif($invoice->status === 'Unpaid') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ $invoice->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No invoices found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Products/Services -->
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Products & Services</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Billing Cycle</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($client->products as $product)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $product->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($product->type) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ formatCurrencyVND($product->amount) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($product->billing_cycle ?? '-') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($product->status === 'Active') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ $product->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Domains -->
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-indigo-100/50">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Domains</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Domain Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Registrar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Registration Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Expiry Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($client->domains as $domain)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $domain->domain_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $domain->registrar ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $domain->registration_date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $domain->expiry_date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($domain->status === 'Active') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ $domain->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No domains found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

