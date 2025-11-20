<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['client', 'invoice', 'lineItems']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
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

        // Payment Status filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Client filter
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        $clients = Client::orderBy('firstname')->get();

        return view('orders.index', compact('orders', 'clients'));
    }

    public function create()
    {
        $clients = Client::orderBy('firstname')->get();
        $invoices = Invoice::orderBy('invoice_number', 'desc')->get();
        $nextOrderNumber = 'ORD-'.date('Ymd').'-'.str_pad((Order::whereDate('created_at', today())->count() + 1), 4, '0', STR_PAD_LEFT);

        return view('orders.create', compact('clients', 'invoices', 'nextOrderNumber'));
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());

        // Create line items if provided
        if ($request->has('line_items')) {
            foreach ($request->line_items as $item) {
                $order->lineItems()->create($item);
            }
        }

        return redirect()->route('orders.show', $order)->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load(['client', 'invoice', 'user', 'lineItems']);

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $clients = Client::orderBy('firstname')->get();
        $invoices = Invoice::orderBy('invoice_number', 'desc')->get();
        $order->load('lineItems');

        return view('orders.edit', compact('order', 'clients', 'invoices'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());

        // Update line items if provided
        if ($request->has('line_items')) {
            // Delete existing line items and create new ones
            $order->lineItems()->delete();
            foreach ($request->line_items as $item) {
                $order->lineItems()->create($item);
            }
        }

        return redirect()->route('orders.show', $order)->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
