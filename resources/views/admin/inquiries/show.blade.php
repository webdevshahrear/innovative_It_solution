@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Packet Analysis</h1>
        <p class="page-subtitle">Deciphering communication transmission from {{ $inquiry->name }}.</p>
    </div>
    <a href="{{ route('admin.inquiries.index') }}" class="btn-tech-outline">
        <i class="fas fa-satellite-dish me-2"></i> Signal Archive
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="tech-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-v2">
                <h5 class="fw-bold mb-0 text-white">Signal Transcript</h5>
                <span class="status-glow {{ $inquiry->status === 'new' ? 'active alert-v2' : 'inactive' }}">
                    {{ strtoupper($inquiry->status) }}
                </span>
            </div>
            
            <div class="mb-4">
                <label class="v2-form-label">SIGNAL SUBJECT</label>
                <div class="v2-static-info fw-bold">{{ $inquiry->subject }}</div>
            </div>

            <div class="mb-4">
                <label class="v2-form-label">DATA PAYLOAD (MESSAGE)</label>
                <div class="v2-message-box">
                    {{ $inquiry->message }}
                </div>
            </div>
            
            <div class="d-flex gap-3">
                <a href="mailto:{{ $inquiry->email }}" class="btn-tech-primary px-4 py-2">
                    <i class="fas fa-reply me-2"></i> TRANSMIT REPLY
                </a>
                @if($inquiry->status === 'new')
                <form action="{{ route('admin.inquiries.mark-read', $inquiry->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-tech-outline px-4 py-2">
                        <i class="fas fa-check-double me-2 text-success"></i> ACKNOWLEDGE SIGNAL
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="tech-card">
            <h5 class="fw-bold mb-4 text-white">Source Metadata</h5>
            
            <div class="d-flex align-items-center mb-5">
                <div class="operative-avatar-v2 text-uppercase d-flex align-items-center justify-content-center fw-bold fs-4 text-v2-primary" style="background: rgba(240, 82, 35, 0.1);">
                    {{ substr($inquiry->name, 0, 1) }}
                </div>
                <div class="ms-3">
                    <div class="fw-bold text-white fs-5">{{ $inquiry->name }}</div>
                    <div class="text-v2-muted small">External Operative</div>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="mb-4 pb-3 border-bottom border-v2">
                    <label class="v2-form-label">ELECTRONIC UPLINK (EMAIL)</label>
                    <a href="mailto:{{ $inquiry->email }}" class="text-decoration-none fw-bold text-v2-primary d-flex align-items-center">
                        <i class="far fa-envelope me-2"></i> {{ $inquiry->email }}
                    </a>
                </div>
                <div class="mb-4 pb-3 border-bottom border-v2">
                    <label class="v2-form-label">TEMPORAL COORDINATES</label>
                    <div class="text-white fw-bold d-flex align-items-center">
                        <i class="far fa-calendar-alt me-2 text-v2-muted"></i> {{ $inquiry->created_at->format('M d, Y') }}
                    </div>
                    <div class="text-v2-muted small ps-4">{{ $inquiry->created_at->format('H:i A') }} ({{ $inquiry->created_at->diffForHumans() }})</div>
                </div>
                <div class="mb-0">
                    <label class="v2-form-label">DESTRUCTIVE ACTIONS</label>
                    <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Purge signal history?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100 border-v2 py-2 text-danger opacity-75 hover-opacity-100">
                            <i class="fas fa-trash-alt me-2"></i> PURGE PACKET
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-v2 { border-color: var(--v2-border) !important; }
    .v2-form-label { display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v2-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; }
    .v2-static-info { background: rgba(255,255,255,0.03); border: 1px solid var(--v2-border); border-radius: 10px; padding: 0.75rem 1rem; color: white; }
    .v2-message-box { background: rgba(255,255,255,0.03); border: 1px solid var(--v2-border); border-radius: 12px; padding: 1.5rem; color: #e2e8f0; line-height: 1.8; white-space: pre-wrap; font-size: 0.95rem; }
    
    .operative-avatar-v2 { width: 56px; height: 56px; border-radius: 50%; border: 2px solid var(--v2-border); box-shadow: 0 0 15px rgba(240, 82, 35, 0.1); }
    
    .status-glow { font-size: 0.65rem; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 100px; display: inline-flex; align-items: center; gap: 0.5rem; }
    .status-glow::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    .status-glow.active { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .status-glow.active::before { background: #10b981; box-shadow: 0 0 8px #10b981; }
    .status-glow.active.alert-v2 { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .status-glow.active.alert-v2::before { background: #f59e0b; box-shadow: 0 0 8px #f59e0b; }
    .status-glow.inactive { background: rgba(148, 163, 184, 0.1); color: #94a3b8; }
    .status-glow.inactive::before { background: #94a3b8; }

    .btn-tech-outline { display: inline-flex; padding: 0.6rem 1.2rem; background: transparent; border: 1px solid var(--v2-border); color: var(--v2-text-muted); text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; transition: 0.3s; cursor: pointer; }
    .btn-tech-outline:hover { border-color: white; color: white; background: rgba(255,255,255,0.05); }
    .text-v2-muted { color: rgba(255,255,255,0.4); }
    .hover-opacity-100:hover { opacity: 1 !important; background: rgba(239, 68, 68, 0.1) !important; }
</style>
@endsection
