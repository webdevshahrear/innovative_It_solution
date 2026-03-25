@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Newsletter Hub</h1>
        <p class="page-subtitle">Manage decentralized subscriber lists and broadcast authorization.</p>
    </div>
</div>

<div class="tech-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th>SUBSCRIBER UPLINK (EMAIL)</th>
                    <th>REGISTRATION DATE</th>
                    <th>STATUS INDICATOR</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @if($subscribers->count() > 0)
                    @foreach($subscribers as $subscriber)
                    <tr>
                        <td>
                            <div class="fw-bold text-white d-flex align-items-center">
                                <i class="fas fa-paper-plane me-3 text-v2-primary opacity-50"></i>
                                {{ $subscriber->email }}
                            </div>
                        </td>
                        <td><span class="text-v2-muted">{{ $subscriber->created_at->format('M d, Y') }}</span></td>
                        <td>
                            <span class="status-glow {{ $subscriber->status === 'active' ? 'active' : 'inactive' }}">
                                {{ strtoupper($subscriber->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <form action="{{ route('admin.subscribers.update', $subscriber->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="{{ $subscriber->status === 'active' ? 'unsubscribed' : 'active' }}">
                                    <button type="submit" class="action-btn-v2" title="Toggle Authorization">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Purge subscriber record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn-v2 delete" title="Terminal Purge">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="opacity-50">
                                <i class="fas fa-users-slash fs-1 mb-3"></i>
                                <p>No active signals detected in the subscription registry.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@if($subscribers->hasPages())
<div class="mt-4">
    {{ $subscribers->links() }}
</div>
@endif

<style>
    .table-v2 { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-v2 th { background: rgba(255, 255, 255, 0.02); padding: 1.25rem 1.5rem; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v2-text-muted); border-bottom: 1px solid var(--v2-border); }
    .table-v2 td { padding: 1.25rem 1.5rem; vertical-align: middle; border-bottom: 1px solid var(--v2-border); background: transparent; transition: background 0.3s; }
    .table-v2 tr:hover td { background: rgba(255, 255, 255, 0.01); }

    .status-glow { font-size: 0.65rem; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 100px; display: inline-flex; align-items: center; gap: 0.5rem; }
    .status-glow::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    .status-glow.active { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .status-glow.active::before { background: #10b981; box-shadow: 0 0 8px #10b981; }
    .status-glow.inactive { background: rgba(148, 163, 184, 0.1); color: #94a3b8; }
    .status-glow.inactive::before { background: #94a3b8; }

    .action-btn-v2 { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--v2-border); background: rgba(255, 255, 255, 0.03); color: var(--v2-text-muted); transition: all 0.3s; text-decoration: none !important; cursor: pointer; }
    .action-btn-v2:hover { transform: translateY(-2px); border-color: var(--v2-primary); color: var(--v2-primary); }
    .action-btn-v2.delete:hover { border-color: #ef4444; color: #ef4444; }
    .text-v2-muted { color: rgba(255,255,255,0.4); font-size: 0.85rem; }
</style>
@endsection
