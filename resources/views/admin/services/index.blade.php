@extends('layouts.admin')

@use('Illuminate\Support\Str')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Service Protocols</h1>
        <p class="page-subtitle">Configure the core utility modules offered in your digital catalog.</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="btn-tech-primary">
        <i class="fas fa-plus me-2"></i> New Protocol
    </a>
</div>

<div class="tech-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th class="text-center" style="width: 80px;">ICON</th>
                    <th>PROTOCOL TITLE</th>
                    <th>BRIEFING</th>
                    <th>STATUS</th>
                    <th>SEQUENCE</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @if($services->count() > 0)
                    @foreach($services as $service)
                    <tr>
                        <td class="text-center">
                             <div class="service-icon-v2">
                                <i class="{{ $service->icon }}"></i>
                             </div>
                        </td>
                        <td>
                            <div class="fw-bold text-white">{{ $service->title }}</div>
                            <div class="small text-muted">Rating: {{ $service->rating ?? 'N/A' }}/5.0</div>
                        </td>
                        <td>
                            <div class="text-v2-muted" title="{{ $service->short_description }}">
                                {{ Str::limit($service->short_description, 60) }}
                            </div>
                        </td>
                        <td>
                            <span class="status-glow {{ $service->status === 'active' ? 'active' : 'inactive' }}">
                                {{ strtoupper($service->status) }}
                            </span>
                        </td>
                        <td><span class="fw-bold text-v2-primary">{{ $service->display_order }}</span></td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.services.edit', $service) }}" class="action-btn-v2 edit" title="Modify Logic">
                                    <i class="fas fa-microchip"></i>
                                </a>
                                <form action="{{ route('admin.services.duplicate', $service) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn-v2 duplicate" title="Duplicate Protocol">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Decommission service protocol?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn-v2 delete" title="Purge">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="opacity-50">
                                <i class="fas fa-box-open fs-1 mb-3"></i>
                                <p>No active protocols detected in repository.</p>
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
    .service-icon-v2 {
        width: 40px;
        height: 40px;
        background: rgba(240, 82, 35, 0.1);
        border: 1px solid rgba(240, 82, 35, 0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--v2-primary);
        margin: 0 auto;
        font-size: 1.1rem;
    }
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

    .action-btn-v2 { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--v2-border); background: rgba(255, 255, 255, 0.03); color: var(--v2-text-muted); transition: all 0.3s; text-decoration: none !important; }
    .action-btn-v2:hover { transform: translateY(-2px); border-color: var(--v2-primary); color: var(--v2-primary); }
    .action-btn-v2.duplicate:hover { border-color: #3b82f6; color: #3b82f6; }
    .action-btn-v2.delete:hover { border-color: #ef4444; color: #ef4444; }
    .text-v2-muted { color: rgba(255,255,255,0.4); font-size: 0.85rem; }
</style>
</style>
@endsection
