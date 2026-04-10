<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('client')->latest()->paginate(15);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create(Request $request)
    {
        $clients = Client::orderBy('name')->get();
        $selectedClientId = $request->get('client_id');
        return view('admin.invoices.create', compact('clients', 'selectedClientId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_no' => 'required|string|unique:invoices',
            'amount' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,paid,cancelled'
        ]);

        Invoice::create($validated);

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('client');
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $clients = Client::orderBy('name')->get();
        return view('admin.invoices.edit', compact('invoice', 'clients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_no' => 'required|string|unique:invoices,invoice_no,' . $invoice->id,
            'amount' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,paid,cancelled'
        ]);

        $invoice->update($validated);

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load('client');
        return view('admin.invoices.print', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
