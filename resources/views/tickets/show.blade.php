<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Ticket #{{ $ticket->ticket_number }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('tickets.edit', $ticket) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Edit
                </a>
                <a href="{{ route('tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Ticket Details -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold mb-2">{{ $ticket->subject }}</h3>
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($ticket->status === 'Open') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                            @elseif($ticket->status === 'In Progress') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                            @elseif($ticket->status === 'Closed') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                            @elseif($ticket->status === 'Merged') bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200
                                            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @endif">
                                            {{ $ticket->status }}
                                        </span>
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($ticket->priority === 'Urgent') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @elseif($ticket->priority === 'High') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                            @elseif($ticket->priority === 'Medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @endif">
                                            {{ $ticket->priority }}
                                        </span>
                                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs font-semibold rounded-full">
                                            {{ $ticket->department }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                                {{ substr($ticket->client->fullname, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $ticket->client->fullname }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $ticket->created_at->format('M d, Y h:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                                {!! nl2br(e($ticket->message)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Replies -->
                    @if($ticket->replies->count() > 0)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h4 class="text-lg font-semibold mb-4">Replies ({{ $ticket->replies->count() }})</h4>
                                <div class="space-y-4">
                                    @foreach($ticket->replies as $reply)
                                        <div class="border-l-4 {{ $reply->is_staff_reply ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' }} p-4 rounded">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="h-8 w-8 rounded-full {{ $reply->is_staff_reply ? 'bg-green-500' : 'bg-blue-500' }} flex items-center justify-center text-white text-xs font-bold">
                                                        @if($reply->is_staff_reply && $reply->user)
                                                            {{ substr($reply->user->name, 0, 1) }}
                                                        @else
                                                            {{ substr($ticket->client->fullname, 0, 1) }}
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <div class="flex justify-between items-start">
                                                        <div>
                                                            <p class="text-sm font-medium">
                                                                @if($reply->is_staff_reply && $reply->user)
                                                                    {{ $reply->user->name }} <span class="text-xs text-gray-500">(Staff)</span>
                                                                @else
                                                                    {{ $ticket->client->fullname }}
                                                                @endif
                                                            </p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                {{ $reply->created_at->format('M d, Y h:i A') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 text-sm">
                                                        {!! nl2br(e($reply->message)) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Reply Form -->
                    @if($ticket->status !== 'Closed' && $ticket->status !== 'Merged')
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h4 class="text-lg font-semibold mb-4">Add Reply</h4>
                                <form method="POST" action="{{ route('tickets.reply', $ticket) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <textarea name="message" rows="4" required
                                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            placeholder="Type your reply..."></textarea>
                                        @error('message')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                        Send Reply
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Client Info -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Client Information</h4>
                            <div class="space-y-2">
                                <p class="font-semibold">{{ $ticket->client->fullname }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->client->email }}</p>
                                @if($ticket->client->phonenumber)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->client->phonenumber }}</p>
                                @endif
                                <a href="{{ route('clients.show', $ticket->client) }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    View Client Profile →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Info -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Ticket Information</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-xs text-gray-500 dark:text-gray-400">Created</dt>
                                    <dd class="text-sm">{{ $ticket->created_at->format('M d, Y h:i A') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500 dark:text-gray-400">Last Updated</dt>
                                    <dd class="text-sm">{{ $ticket->updated_at->format('M d, Y h:i A') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500 dark:text-gray-400">Replies</dt>
                                    <dd class="text-sm">{{ $ticket->replies->count() }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Merge Ticket -->
                    @if($ticket->status !== 'Merged' && $ticket->status !== 'Closed')
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Merge Ticket</h4>
                                <form method="POST" action="{{ route('tickets.merge', $ticket) }}" onsubmit="return confirm('Are you sure you want to merge this ticket?');">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="merge_to_ticket_id" class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Merge into ticket ID</label>
                                        <input type="number" name="merge_to_ticket_id" id="merge_to_ticket_id" required
                                            class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('merge_to_ticket_id')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-3 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                        Merge Ticket
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Merged Tickets -->
                    @if($ticket->mergedTickets->count() > 0)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Merged Tickets</h4>
                                <ul class="space-y-2">
                                    @foreach($ticket->mergedTickets as $mergedTicket)
                                        <li>
                                            <a href="{{ route('tickets.show', $mergedTicket) }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                                #{{ $mergedTicket->ticket_number }}
                                            </a>
                                            <p class="text-xs text-gray-500">{{ $mergedTicket->subject }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if($ticket->merged_to_ticket_id)
                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                            <p class="text-sm text-amber-800 dark:text-amber-200">
                                This ticket has been merged into
                                <a href="{{ route('tickets.show', $ticket->mergedTo) }}" class="font-semibold underline">
                                    #{{ $ticket->mergedTo->ticket_number }}
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
