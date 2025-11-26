<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Client;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['client']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q) use ($search) {
                        $q->where('firstname', 'like', "%{$search}%")
                            ->orWhere('lastname', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Department filter
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // Client filter
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $tickets = $query->latest()->paginate(15)->withQueryString();
        $clients = Client::orderBy('firstname')->get();

        return view('tickets.index', compact('tickets', 'clients'));
    }

    public function create()
    {
        $clients = Client::orderBy('firstname')->get();
        $nextTicketNumber = 'TKT-'.date('Ymd').'-'.str_pad((Ticket::whereDate('created_at', today())->count() + 1), 4, '0', STR_PAD_LEFT);

        return view('tickets.create', compact('clients', 'nextTicketNumber'));
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->validated());

        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket created successfully.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['client', 'replies.user', 'replies.client', 'mergedTickets']);

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $clients = Client::orderBy('firstname')->get();

        return view('tickets.edit', compact('ticket', 'clients'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());

        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->replies()->create([
            'message' => $request->message,
            'is_staff_reply' => Auth::check(),
            'user_id' => Auth::id(),
            'client_id' => Auth::check() ? null : $ticket->client_id,
        ]);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Reply added successfully.');
    }

    public function merge(Request $request, Ticket $ticket)
    {
        $request->validate([
            'merge_to_ticket_id' => 'required|exists:tickets,id|different:'.$ticket->id,
        ]);

        $ticket->update([
            'merged_to_ticket_id' => $request->merge_to_ticket_id,
            'status' => 'Merged',
        ]);

        return redirect()->route('tickets.show', $request->merge_to_ticket_id)->with('success', 'Ticket merged successfully.');
    }
}
