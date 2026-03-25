@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Performance Metrics</h1>
        <p class="page-subtitle">Configure real-time counters and achievement telemetry for the frontend.</p>
    </div>
    <a href="{{ route('admin.statistics.create') }}" class="btn-tech-primary">
        <i class="fas fa-plus me-2"></i> Initialise Metric
    </a>
</div>

<div class="tech-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">SIGNAL</th>
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
                        <td>
                            <div class="metric-icon-v2">
                                <i class="{{ $stat->icon_class }}"></i>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-white">{{ $stat->stat_label }}</div>
                            <div class="small text-v2-muted">System Counter</div>
                        </td>
                        <td><span class="fs-5 fw-bold text-v2-primary">{{ $stat->stat_value }}</span></td>
                        <td>
                            <span class="status-glow {{ $stat->status === 'active' ? 'active' : 'inactive' }}">
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
                            <div class="opacity-50">
                                <i class="fas fa-chart-pie fs-1 mb-3"></i>
                                <p>No metric records detected in data node.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<style>
<style>
    .metric-icon-v2 { width: 42px; height: 42px; border-radius: 10px; background: rgba(240, 82, 35, 0.1); border: 1px solid var(--v2-border); display: flex; align-items: center; justify-content: center; color: var(--v2-primary); font-size: 1.25rem; }
    
    .table-v2 { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-v2 th { background: rgba(255, 255, 255, 0.02); padding: 1.25rem 1.5rem; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v2-text-muted); border-bottom: 1px solid var(--v2-border); }
    .table-v2 td { padding: 1.25rem 1.5rem; vertical-align: middle; border-bottom: 1px solid var(--v2-border); background: transparent; transition: background 0.3s; }
    .table-v2 tr:hover td { background: rgba(255, 255, 255, 0.01); }

    .status-glow { font-size: 0.65rem; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 100px; display: inline-flex; align-items: center; gap: 0.5rem; }
    .status-glow::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    .status-glow.active { background: rgba(16, 185, 129, 0.1); color: #10b981; box-shadow: 0 0 15px rgba(16, 185, 129, 0.1); }
    .status-glow.active::before { background: #10b981; box-shadow: 0 0 8px #10b981; }
    .status-glow.inactive { background: rgba(148, 163, 184, 0.1); color: #94a3b8; }
    .status-glow.inactive::before { background: #94a3b8; }

    .action-btn-v2 { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--v2-border); background: rgba(255, 255, 255, 0.03); color: var(--v2-text-muted); transition: all 0.3s; text-decoration: none !important; }
    .action-btn-v2:hover { transform: translateY(-2px); border-color: var(--v2-primary); color: var(--v2-primary); }
    .action-btn-v2.delete:hover { border-color: #ef4444; color: #ef4444; }
    .text-v2-muted { color: rgba(255,255,255,0.4); font-size: 0.85rem; }
</style>
</style>
@endsection
