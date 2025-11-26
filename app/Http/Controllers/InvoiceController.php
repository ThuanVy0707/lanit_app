<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Invoice::with(['client']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q) use ($search) {
                        $q->where('firstname', 'like', "%{$search}%")
                            ->orWhere('lastname', 'like', "%{$search}%")
                            ->orWhere('companyname', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Client filter
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $invoices = $query->latest()->paginate(15)->withQueryString();
        $clients = Client::orderBy('firstname')->get();

        return view('invoices.index', compact('invoices', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $clients = Client::orderBy('firstname')->get();
        $invoiceNumber = 'INV-'.date('Ymd').'-'.str_pad(Invoice::count() + 1, 4, '0', STR_PAD_LEFT);

        return view('invoices.create', compact('clients', 'invoiceNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Parse VND formatted amounts
        if (isset($validated['subtotal'])) {
            $validated['subtotal'] = parseCurrencyVND($validated['subtotal']);
        }
        if (isset($validated['tax'])) {
            $validated['tax'] = parseCurrencyVND($validated['tax']);
        }
        if (isset($validated['credit'])) {
            $validated['credit'] = parseCurrencyVND($validated['credit']);
        }
        if (isset($validated['total'])) {
            $validated['total'] = parseCurrencyVND($validated['total']);
        }

        $invoice = Invoice::create($validated);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice): View
    {
        $invoice->load(['client']);

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice): View
    {
        $clients = Client::orderBy('firstname')->get();

        return view('invoices.edit', compact('invoice', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice): RedirectResponse
    {
        $validated = $request->validated();

        // Parse VND formatted amounts
        if (isset($validated['subtotal'])) {
            $validated['subtotal'] = parseCurrencyVND($validated['subtotal']);
        }
        if (isset($validated['tax'])) {
            $validated['tax'] = parseCurrencyVND($validated['tax']);
        }
        if (isset($validated['credit'])) {
            $validated['credit'] = parseCurrencyVND($validated['credit']);
        }
        if (isset($validated['total'])) {
            $validated['total'] = parseCurrencyVND($validated['total']);
        }

        $invoice->update($validated);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }
}
