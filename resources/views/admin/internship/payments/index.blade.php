@extends('layouts.admin')

@push('styles')
<style>
    .cyber-header {
        position: relative; padding: 50px; border-radius: 36px;
        background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.08);
        margin-bottom: 50px; overflow: hidden; backdrop-filter: blur(24px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.1);
    }
    .cyber-header::before {
        content: ''; position: absolute; inset: -50%; 
        background: radial-gradient(circle at 30% 50%, rgba(226, 19, 110, 0.12), transparent 50%),
                    radial-gradient(circle at 80% 30%, rgba(245, 158, 11, 0.1), transparent 50%);
        animation: rotateGlow 25s linear infinite; pointer-events: none; z-index: 0;
    }
    .cyber-header > * { position: relative; z-index: 1; }
    @keyframes rotateGlow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
<div class="cyber-header" data-aos="fade-down">
    <div class="d-flex align-items-center gap-2 mb-3">
        <span style="width:10px;height:10px;background:#E2136E;border-radius:50%; box-shadow: 0 0 12px #E2136E; display:inline-block;"></span>
        <span class="text-uppercase fw-bold" style="color:#E2136E; font-size:0.75rem; letter-spacing:2px">Financial Ledger Active</span>
    </div>
    <h1 class="text-white m-0" style="font-size: 3rem; font-weight: 900; font-family: 'Outfit'; letter-spacing: -0.03em;">Security <span style="background: linear-gradient(135deg, #E2136E, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Deposits</span></h1>
    <p class="text-v2-muted mt-2 mb-0" style="font-size: 1.1rem;">Audit automated gateway transactions and verify manual bKash mobilization records.</p>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-5" data-aos="fade-up">
    <div class="col-md-3">
        <div class="tech-card-v2 text-center p-4">
            <div class="metric-icon-v2 mb-3 mx-auto"><i class="fas fa-vault"></i></div>
            <div class="text-v2-muted small mb-1 text-uppercase fw-bold letter-spacing-1">Capital Liquidity</div>
            <div class="fs-2 fw-bold text-white">৳{{ number_format($stats['total_collected']) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="tech-card-v2 text-center p-4">
            <div class="metric-icon-v2 mb-3 mx-auto" style="background:rgba(16,185,129,0.1); color:#10b981; border-color:rgba(16,185,129,0.2)"><i class="fas fa-circle-check"></i></div>
            <div class="text-v2-muted small mb-1 text-uppercase fw-bold letter-spacing-1">Settled Assets</div>
            <div class="fs-2 fw-bold text-success">{{ $stats['success'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="tech-card-v2 text-center p-4" style="border-top: 2px solid #E2136E">
            <div class="metric-icon-v2 mb-3 mx-auto" style="background:rgba(226,19,110,0.1); color:#E2136E; border-color:rgba(226,19,110,0.2)"><i class="fas fa-mobile-screen-button"></i></div>
            <div class="text-v2-muted small mb-1 text-uppercase fw-bold letter-spacing-1">Pending bKash</div>
            <div class="fs-2 fw-bold" style="color: #E2136E">{{ $stats['bkash_pending'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="tech-card-v2 text-center p-4">
            <div class="metric-icon-v2 mb-3 mx-auto" style="background:rgba(245,158,11,0.1); color:#f59e0b; border-color:rgba(245,158,11,0.2)"><i class="fas fa-clock-rotate-left"></i></div>
            <div class="text-v2-muted small mb-1 text-uppercase fw-bold letter-spacing-1">Awaiting Clearance</div>
            <div class="fs-2 fw-bold text-warning">{{ $stats['pending'] }}</div>
        </div>
    </div>
</div>

<div class="tech-card-v2 mb-4" data-aos="fade-up">
    <form action="{{ route('admin.internship.payments.index') }}" method="GET" class="row g-3">
        <div class="col-md-5">
            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Transaction Status</label>
            <select name="status" class="form-select v2-admin-input">
                <option value="">All Lifecycle States</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Awaiting Verification</option>
                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Verified & Settled</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Aborted / Rejected</option>
            </select>
        </div>
        <div class="col-md-5">
            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Mobilization Method</label>
            <select name="method" class="form-select v2-admin-input">
                <option value="">All Payment Vectors</option>
                <option value="ssl" {{ request('method') == 'ssl' ? 'selected' : '' }}>SSLCommerz (Automated)</option>
                <option value="bkash" {{ request('method') == 'bkash' ? 'selected' : '' }}>bKash (Manual Injection)</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn-v2-primary w-100 py-3" style="border-radius:12px">
                <i class="fas fa-filter me-2"></i>Filter Ledger
            </button>
        </div>
    </form>
</div>

<div class="tech-card-v2 overflow-hidden px-0 py-0" data-aos="fade-up" data-aos-delay="100">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="padding-left:2.25rem">TRANSACTION IDENTIFIER</th>
                    <th>APPLICANT</th>
                    <th>VECTORED VIA</th>
                    <th>LIQUID AMOUNT</th>
                    <th>STATUS</th>
                    <th>TEMPORAL LOG</th>
                    <th class="text-end" style="padding-right:2.25rem">CONTROLS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td style="padding-left:2.25rem">
                        <span class="text-white font-monospace fw-bold" style="letter-spacing: 1px">{{ $payment->transaction_id }}</span>
                        @if($payment->payment_method == 'bkash' && $payment->bkash_number)
                            <div class="small text-v2-muted mt-1 opacity-75"><i class="fas fa-mobile-alt me-1 text-primary"></i> {{ $payment->bkash_number }}</div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-bold text-v2-main">{{ $payment->application->full_name ?? 'UNKNOWN SENDER' }}</div>
                    </td>
                    <td>
                        @if($payment->payment_method == 'bkash')
                            <span class="badge" style="background:rgba(226,19,110,0.1); color:#E2136E; border:1px solid rgba(226,19,110,0.2); font-size:0.65rem">
                                <i class="fas fa-mobile-button me-1"></i> BKASH MANUAL
                            </span>
                        @else
                            <span class="badge border border-info text-info bg-info bg-opacity-10" style="font-size:0.65rem">
                                <i class="fas fa-shield-halved me-1"></i> SSL SECURE
                            </span>
                        @endif
                    </td>
                    <td><span class="text-white fw-bold">৳{{ number_format($payment->amount) }}</span></td>
                    <td>
                        @if($payment->status == 'success') 
                            <span class="badge border border-success text-success bg-success bg-opacity-10 px-3 py-1" style="font-size:0.65rem; border-radius:100px">SETTLED</span>
                        @elseif($payment->status == 'pending') 
                            <span class="badge border border-warning text-warning bg-warning bg-opacity-10 px-3 py-1" style="font-size:0.65rem; border-radius:100px">PENDING</span>
                        @else 
                            <span class="badge border border-danger text-danger bg-danger bg-opacity-10 px-3 py-1" style="font-size:0.65rem; border-radius:100px">REJECTED</span>
                        @endif
                    </td>
                    <td><div class="small text-v2-muted">{{ \Carbon\Carbon::parse($payment->created_at)->format('d M, Y h:iA') }}</div></td>
                    <td class="text-end" style="padding-right:2.25rem">
                        @if($payment->payment_method == 'bkash' && $payment->status == 'pending')
                            <button type="button" class="btn-neo-glass py-1 px-3" style="font-size:0.75rem" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $payment->id }}">
                                <i class="fas fa-shield-check me-1 text-primary"></i> VERIFY
                            </button>

                            <!-- Verification Modal -->
                            <div class="modal fade" id="verifyModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content bg-v2-sidebar border border-secondary text-white" style="backdrop-filter: blur(40px); border-radius:20px">
                                        <div class="modal-header border-secondary p-4">
                                            <h5 class="modal-title fw-bold">Transaction Authentication</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.internship.payments.verify', $payment) }}" method="POST">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <div class="p-3 mb-4 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid var(--v2-border)">
                                                     <div class="text-v2-muted small text-uppercase fw-bold letter-spacing-1 mb-3">Segment Analysis:</div>
                                                     <div class="row g-3">
                                                         <div class="col-6">
                                                             <div class="small opacity-50">Origin Number</div>
                                                             <div class="text-v2-primary fw-bold">{{ $payment->bkash_number }}</div>
                                                         </div>
                                                         <div class="col-6">
                                                             <div class="small opacity-50">Amount</div>
                                                             <div class="text-white fw-bold">৳{{ number_format($payment->amount) }}</div>
                                                         </div>
                                                         <div class="col-12">
                                                             <div class="small opacity-50">Transaction Hash</div>
                                                             <div class="text-warning fw-mono">{{ $payment->transaction_id }}</div>
                                                         </div>
                                                     </div>
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Authentication Decision</label>
                                                    <select name="action" class="form-select v2-admin-input" required>
                                                        <option value="">-- Choose Resolution --</option>
                                                        <option value="approve">AUTHORIZE — Payment Verified, Proceed to Lifecycle Activation</option>
                                                        <option value="reject">ABORT — Hash Mismatch / Refund Required</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-secondary p-4">
                                                <button type="button" class="btn-neo-glass py-2 px-4" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn-v2-primary py-2 px-5">Confirm Pulse</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <i class="fas fa-circle-check text-success opacity-50" title="Settled"></i>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="opacity-25 mb-3"><i class="fas fa-cash-register" style="font-size:3.5rem"></i></div>
                        <p class="text-v2-muted mb-0">No transaction records found in the financial ledger.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-between align-items-center">
    <div class="text-v2-muted small">Showing {{ $payments->firstItem() ?? 0 }} to {{ $payments->lastItem() ?? 0 }} of {{ $payments->total() }} transaction records</div>
    <div class="pagination-v2">
        {{ $payments->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
