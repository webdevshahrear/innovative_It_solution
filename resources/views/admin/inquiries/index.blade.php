@extends('layouts.admin')

@use('Illuminate\Support\Str')

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="page-title text-white">Lead Pipeline</h1>
        <p class="page-subtitle text-v2-muted">Track and manage your agency sales funnel from initial signal to conversion.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.inquiries.index', ['view' => 'list']) }}" class="btn-neo-glass {{ request('view', 'list') === 'list' ? 'active' : '' }}" style="{{ request('view', 'list') === 'list' ? 'background: var(--v2-gradient); color: white;' : '' }}">
            <i class="fas fa-list me-2"></i> List View
        </a>
        <a href="{{ route('admin.inquiries.index', ['view' => 'board']) }}" class="btn-neo-glass {{ request('view') === 'board' ? 'active' : '' }}" style="{{ request('view') === 'board' ? 'background: var(--v2-gradient); color: white;' : '' }}">
            <i class="fas fa-th-large me-2"></i> Kanban Board
        </a>
    </div>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th>LEAD IDENTITY</th>
                    <th>LINKS</th>
                    <th>PIPELINE STAGE</th>
                    <th>EST. VALUE</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @if($inquiries->count() > 0)
                    @foreach($inquiries as $inquiry)
                    <tr>
                        <td>
                            <div class="fw-bold text-white">{{ $inquiry->name }}</div>
                            <div class="small text-v2-muted d-flex align-items-center gap-1">
                                <i class="fas fa-envelope-open small opacity-50"></i> {{ $inquiry->email }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                @if($inquiry->linkedin_url)
                                    <a href="{{ $inquiry->linkedin_url }}" target="_blank" class="action-btn-v2" title="LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a>
                                @endif
                                @if($inquiry->website_url)
                                    <a href="{{ $inquiry->website_url }}" target="_blank" class="action-btn-v2" title="Website"><i class="fas fa-globe"></i></a>
                                @endif
                                @if(!$inquiry->linkedin_url && !$inquiry->website_url)
                                    <span class="text-v2-muted opacity-30 small">-- No Links --</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'new' => ['#3b82f6', 'rgba(59, 130, 246, 0.1)'],
                                    'contacted' => ['#f59e0b', 'rgba(245, 158, 11, 0.1)'],
                                    'qualified' => ['#8b5cf6', 'rgba(139, 92, 246, 0.1)'],
                                    'proposal_sent' => ['#06b6d4', 'rgba(6, 182, 212, 0.1)'],
                                    'won' => ['#10b981', 'rgba(16, 185, 129, 0.1)'],
                                    'lost' => ['#ef4444', 'rgba(239, 68, 68, 0.1)']
                                ];
                                $color = $statusColors[$inquiry->status] ?? ['#94a3b8', 'rgba(148, 163, 184, 0.1)'];
                            @endphp
                            <span class="status-glow-v2" style="background: {{ $color[1] }}; color: {{ $color[0] }}; border-color: rgba({{ hexdec(substr($color[0], 1, 2)) }}, {{ hexdec(substr($color[0], 3, 2)) }}, {{ hexdec(substr($color[0], 5, 2)) }}, 0.2)">
                                <span class="status-dot" style="background: {{ $color[0] }}; box-shadow: 0 0 10px {{ $color[0] }};"></span>
                                {{ strtoupper(str_replace('_', ' ', $inquiry->status)) }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold text-v2-primary">${{ number_format($inquiry->lead_value, 2) }}</div>
                            <div class="small text-v2-muted">{{ $inquiry->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="action-btn-v2" title="Decode Packet">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.inquiries.duplicate', $inquiry->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn-v2" title="Duplicate Signal">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>
                                @if($inquiry->status === 'new')
                                <form action="{{ route('admin.inquiries.update-status', $inquiry->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="contacted">
                                    <button type="submit" class="action-btn-v2" title="Mark as Contacted" style="color: #10b981;">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Purge data packet?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn-v2 delete" title="Erase">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="opacity-30">
                                <i class="fas fa-satellite-dish fs-1 mb-3 text-v2-muted"></i>
                                <p class="text-v2-muted">No active transmissions detected on this frequency.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@if($inquiries->hasPages())
<div class="pagination-v2 mt-4 d-flex justify-content-center">
    {{ $inquiries->links('pagination::bootstrap-5') }}
</div>
@endif

@endsection
