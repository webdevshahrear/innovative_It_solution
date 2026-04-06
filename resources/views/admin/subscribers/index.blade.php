@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title text-white">Newsletter Hub</h1>
        <p class="page-subtitle text-v2-muted">Manage decentralized subscriber lists and broadcast authorization.</p>
    </div>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="width: 400px;">SUBSCRIBER UPLINK (EMAIL)</th>
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
                                <div class="metric-icon-v2 me-3" style="width: 38px; height: 38px; font-size: 1rem;">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                {{ $subscriber->email }}
                            </div>
                        </td>
                        <td><span class="text-v2-muted">{{ $subscriber->created_at->format('M d, Y') }}</span></td>
                        <td>
                            <span class="status-glow-v2 {{ $subscriber->status === 'active' ? 'active' : 'inactive' }}">
                                <span class="status-dot"></span>
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
                            <div class="opacity-30">
                                <i class="fas fa-users-slash fs-1 mb-3 text-v2-muted"></i>
                                <p class="text-v2-muted">No active signals detected in the subscription registry.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@if($subscribers->hasPages())
<div class="pagination-v2 mt-4 d-flex justify-content-center">
    {{ $subscribers->links('pagination::bootstrap-5') }}
</div>
@endif

@endsection

@endsection
