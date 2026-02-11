@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Incoming Transmissions</h1>
        <p class="page-subtitle">Monitor and analyze communication packets from external sources.</p>
    </div>
</div>

<div class="tech-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v3 mb-0">
            <thead>
                <tr>
                    <th>SOURCE IDENTITY</th>
                    <th>SIGNAL TARGET (SUBJECT)</th>
                    <th>UPLINK DATE</th>
                    <th>STATUS INDICATOR</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inquiries as $inquiry)
                <tr>
                    <td>
                        <div class="fw-bold text-white">{{ $inquiry->name }}</div>
                        <div class="small text-v3-muted">{{ $inquiry->email }}</div>
                    </td>
                    <td>
                        <div class="text-white" title="{{ $inquiry->subject }}">
                            {{ Str::limit($inquiry->subject, 40) }}
                        </div>
                    </td>
                    <td><span class="text-v3-muted">{{ $inquiry->created_at->format('M d, Y') }}</span></td>
                    <td>
                        <span class="status-glow {{ $inquiry->status === 'new' ? 'active alert-v3' : 'inactive' }}">
                            {{ strtoupper($inquiry->status) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="action-btn-v3 edit" title="Decode Packet">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($inquiry->status === 'new')
                            <form action="{{ route('admin.inquiries.mark-read', $inquiry->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="action-btn-v3 check" title="Acknowledge">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Purge data packet?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-v3 delete" title="Erase">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="opacity-50">
                            <i class="fas fa-satellite-dish fs-1 mb-3"></i>
                            <p>No active transmissions detected on this frequency.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($inquiries->hasPages())
<div class="mt-4">
    {{ $inquiries->links() }}
</div>
@endif

<style>
    .table-v3 { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-v3 th { background: rgba(255, 255, 255, 0.02); padding: 1.25rem 1.5rem; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v3-text-muted); border-bottom: 1px solid var(--v3-border); }
    .table-v3 td { padding: 1.25rem 1.5rem; vertical-align: middle; border-bottom: 1px solid var(--v3-border); background: transparent; transition: background 0.3s; }
    .table-v3 tr:hover td { background: rgba(255, 255, 255, 0.01); }

    .status-glow { font-size: 0.65rem; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 100px; display: inline-flex; align-items: center; gap: 0.5rem; }
    .status-glow::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    .status-glow.active { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .status-glow.active::before { background: #10b981; box-shadow: 0 0 8px #10b981; }
    .status-glow.active.alert-v3 { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .status-glow.active.alert-v3::before { background: #f59e0b; box-shadow: 0 0 8px #f59e0b; }
    .status-glow.inactive { background: rgba(148, 163, 184, 0.1); color: #94a3b8; }
    .status-glow.inactive::before { background: #94a3b8; }

    .action-btn-v3 { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--v3-border); background: rgba(255, 255, 255, 0.03); color: var(--v3-text-muted); transition: all 0.3s; text-decoration: none !important; }
    .action-btn-v3:hover { transform: translateY(-2px); border-color: var(--v3-accent); color: var(--v3-accent); }
    .action-btn-v3.check:hover { border-color: #10b981; color: #10b981; }
    .action-btn-v3.delete:hover { border-color: #ef4444; color: #ef4444; }
    .text-v3-muted { color: rgba(255,255,255,0.4); font-size: 0.85rem; }
</style>
@endsection
