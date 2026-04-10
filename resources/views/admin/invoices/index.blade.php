@extends('layouts.admin')

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="page-title text-white">Financial Ledger</h1>
        <p class="page-subtitle text-v2-muted">Track agency revenue, invoices, and payment statuses.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.invoices.create') }}" class="btn-v2-primary">
            <i class="fas fa-plus me-2"></i> Issue New Invoice
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card-v2 tech-card-v2 p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="metric-icon-v2"><i class="fas fa-file-invoice-dollar"></i></div>
                <div class="badge-v2 turquoise">MONTHLY</div>
            </div>
            <div class="stat-label text-v2-muted small fw-bold">TOTAL PENDING</div>
            <div class="stat-value text-white h3 fw-bold mb-0">${{ number_format($invoices->where('status', 'pending')->sum('amount'), 2) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card-v2 tech-card-v2 p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="metric-icon-v2" style="background: rgba(16, 185, 129, 0.1); color: #10b981;"><i class="fas fa-check-circle"></i></div>
                <div class="badge-v2 indigo">COLLECTED</div>
            </div>
            <div class="stat-label text-v2-muted small fw-bold">TOTAL PAID</div>
            <div class="stat-value text-white h3 fw-bold mb-0">${{ number_format($invoices->where('status', 'paid')->sum('amount'), 2) }}</div>
        </div>
    </div>
</div>

<div class="tech-card-v2">
    <div class="table-responsive">
        <table class="table-v2">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Client</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td><span class="fw-bold text-white">{{ $invoice->invoice_no }}</span></td>
                    <td>
                        <div class="text-white fw-bold">{{ $invoice->client->name }}</div>
                        <div class="small text-v2-muted">{{ $invoice->client->company_name ?? 'Individual' }}</div>
                    </td>
                    <td>
                        <div class="text-white fw-bold">${{ number_format($invoice->amount, 2) }}</div>
                        <div class="small text-v2-muted">+ ${{ number_format($invoice->tax, 2) }} tax</div>
                    </td>
                    <td>
                        <div class="text-v2-muted small"><i class="far fa-calendar-alt me-1"></i> {{ $invoice->due_date->format('M d, Y') }}</div>
                    </td>
                    <td>
                        @php
                            $statusColors = [
                                'pending' => ['bg' => 'rgba(245, 158, 11, 0.1)', 'text' => '#f59e0b'],
                                'paid' => ['bg' => 'rgba(16, 185, 129, 0.1)', 'text' => '#10b981'],
                                'cancelled' => ['bg' => 'rgba(239, 68, 68, 0.1)', 'text' => '#ef4444'],
                            ];
                            $color = $statusColors[$invoice->status] ?? $statusColors['pending'];
                        @endphp
                        <span class="status-glow-v2" style="background: {{ $color['bg'] }}; color: {{ $color['text'] }}; border-color: {{ $color['text'] }}30;">
                            <span class="status-dot" style="background: {{ $color['text'] }}; box-shadow: 0 0 10px {{ $color['text'] }};"></span>
                            {{ strtoupper($invoice->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.invoices.print', $invoice->id) }}" target="_blank" class="action-btn-v2" title="Print Invoice">
                                <i class="fas fa-print"></i>
                            </a>
                            <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="action-btn-v2" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-4 pagination-v2">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
