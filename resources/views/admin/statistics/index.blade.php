@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title text-white">Performance Metrics</h1>
        <p class="page-subtitle text-v2-muted">Configure real-time counters and achievement telemetry for the frontend.</p>
    </div>
    <a href="{{ route('admin.statistics.create') }}" class="btn-v2-primary">
        <i class="fas fa-plus me-2"></i> Initialize Metric
    </a>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="width: 100px;">SIGNAL</th>
                    <th>METRIC IDENTIFIER</th>
                    <th>TELEMETRY VALUE</th>
                    <th>DEPLOYMENT</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @if($statistics->count() > 0)
                    @foreach($statistics as $stat)
                    <tr>
                        <td class="text-center">
                            <div class="metric-icon-v2 mx-auto">
                                <i class="{{ $stat->icon_class }}"></i>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-white">{{ $stat->stat_label }}</div>
                            <div class="small text-v2-muted">System Counter</div>
                        </td>
                        <td><span class="fs-5 fw-bold text-v2-primary">{{ $stat->stat_value }}</span></td>
                        <td>
                            <span class="status-glow-v2 {{ $stat->status === 'active' ? 'active' : 'inactive' }}">
                                <span class="status-dot"></span>
                                {{ strtoupper($stat->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.statistics.edit', $stat->id) }}" class="action-btn-v2" title="Recalibrate">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.statistics.destroy', $stat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Purge metric record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn-v2 delete" title="Decommission">
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
                                <i class="fas fa-chart-pie fs-1 mb-3 text-v2-muted"></i>
                                <p class="text-v2-muted">No metric records detected in data node.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
