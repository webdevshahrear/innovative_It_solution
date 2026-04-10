@extends('layouts.admin')

@use('Illuminate\Support\Str')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title text-white">Incoming Transmissions</h1>
        <p class="page-subtitle text-v2-muted">Monitor and analyze communication packets from external sources.</p>
    </div>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
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
                @if($inquiries->count() > 0)
                    @foreach($inquiries as $inquiry)
                    <tr>
                        <td>
                            <div class="fw-bold text-white">{{ $inquiry->name }}</div>
                            <div class="small text-v2-muted">{{ $inquiry->email }}</div>
                        </td>
                        <td>
                            <div class="text-white" title="{{ $inquiry->subject }}">
                                {{ Str::limit($inquiry->subject, 40) }}
                            </div>
                        </td>
                        <td><span class="text-v2-muted">{{ $inquiry->created_at->format('M d, Y') }}</span></td>
                        <td>
                            <span class="status-glow-v2 {{ $inquiry->status === 'new' ? 'active alert-v2' : 'inactive' }}">
                                <span class="status-dot"></span>
                                {{ strtoupper($inquiry->status) }}
                            </span>
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
                                <form action="{{ route('admin.inquiries.mark-read', $inquiry->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn-v2" title="Acknowledge" style="color: #10b981;">
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
