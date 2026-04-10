@extends('layouts.admin')

@section('content')
<div class="page-header d-flex flex-column mb-4">
    <h1 class="page-title text-white">Create New Invoice</h1>
    <p class="page-subtitle text-v2-muted">Generate a formal billing statement for a client.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="tech-card-v2">
            <form action="{{ route('admin.invoices.store') }}" method="POST">
                @csrf
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label text-v2-muted fw-bold">Select Client</label>
                        <select name="client_id" class="v2-admin-input form-select" required>
                            <option value="">-- Select Client --</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ ($selectedClientId == $client->id) ? 'selected' : '' }}>
                                    {{ $client->name }} ({{ $client->company_name ?? 'Individual' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-v2-muted fw-bold">Invoice Number</label>
                        <input type="text" name="invoice_no" class="v2-admin-input form-control" 
                               value="INV-{{ date('Y') }}-{{ strtoupper(Str::random(6)) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-v2-muted fw-bold">Base Amount ($)</label>
                        <input type="number" step="0.01" name="amount" class="v2-admin-input form-control" placeholder="0.00" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-v2-muted fw-bold">Tax Amount ($)</label>
                        <input type="number" step="0.01" name="tax" class="v2-admin-input form-control" value="0.00">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-v2-muted fw-bold">Due Date</label>
                        <input type="date" name="due_date" class="v2-admin-input form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-v2-muted fw-bold">Status</label>
                        <select name="status" class="v2-admin-input form-select" required>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label text-v2-muted fw-bold">Notes / Description</label>
                        <textarea name="notes" class="v2-admin-input form-control" rows="4" placeholder="Service details, bank info, terms..."></textarea>
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <a href="{{ route('admin.invoices.index') }}" class="btn-neo-glass me-2">Cancel</a>
                        <button type="submit" class="btn-v2-primary">
                            <i class="fas fa-check-circle me-2"></i> Generate Invoice
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="tech-card-v2 glass-panel p-4">
            <h5 class="text-white fw-bold mb-3"><i class="fas fa-info-circle text-v2-primary me-2"></i> Invoicing Tips</h5>
            <ul class="text-v2-muted small" style="line-height: 2;">
                <li>Standard terms are usually <strong>Net 7 or Net 15</strong>.</li>
                <li>Ensure the <strong>Invoice Number</strong> is unique.</li>
                <li>Tax is added on top of the base amount.</li>
                <li>"Won" leads in the CRM can be quickly invoiced from their profile.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
