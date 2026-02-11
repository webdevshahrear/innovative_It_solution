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
        <table class="table table-v3 mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">SIGNAL</th>
                    <th>METRIC IDENTIFIER</th>
                    <th>TELEMETRY VALUE</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($statistics as $stat)
                <tr>
                    <td>
                        <div class="metric-icon-v3">
                            <i class="{{ $stat->icon_class }}"></i>
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold text-white">{{ $stat->stat_label }}</div>
                        <div class="small text-v3-muted">System Counter</div>
                    </td>
                    <td><span class="fs-5 fw-bold text-v3-accent">{{ $stat->stat_value }}</span></td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.statistics.edit', $stat->id) }}" class="action-btn-v3 edit" title="Recalibrate">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.statistics.destroy', $stat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Purge metric record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-v3 delete" title="Decommission">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5">
                        <div class="opacity-50">
                            <i class="fas fa-tachometer-alt fs-1 mb-3"></i>
                            <p>No telemetry streams detected in current sequence.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .metric-icon-v3 { width: 42px; height: 42px; border-radius: 10px; background: rgba(99, 102, 241, 0.1); border: 1px solid var(--v3-border); display: flex; align-items: center; justify-content: center; color: var(--v3-accent); font-size: 1.25rem; }
    
    .table-v3 { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-v3 th { background: rgba(255, 255, 255, 0.02); padding: 1.25rem 1.5rem; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v3-text-muted); border-bottom: 1px solid var(--v3-border); }
    .table-v3 td { padding: 1.25rem 1.5rem; vertical-align: middle; border-bottom: 1px solid var(--v3-border); background: transparent; transition: background 0.3s; }
    .table-v3 tr:hover td { background: rgba(255, 255, 255, 0.01); }

    .action-btn-v3 { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--v3-border); background: rgba(255, 255, 255, 0.03); color: var(--v3-text-muted); transition: all 0.3s; text-decoration: none !important; }
    .action-btn-v3:hover { transform: translateY(-2px); border-color: var(--v3-accent); color: var(--v3-accent); }
    .action-btn-v3.delete:hover { border-color: #ef4444; color: #ef4444; }
    .text-v3-muted { color: rgba(255,255,255,0.4); font-size: 0.85rem; }
</style>
@endsection
