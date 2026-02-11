@extends('layouts.admin')

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
        <table class="table table-v3 mb-0">
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
                @forelse($services as $service)
                <tr>
                    <td class="text-center">
                         <div class="service-icon-v3">
                            <i class="{{ $service->icon }}"></i>
                         </div>
                    </td>
                    <td>
                        <div class="fw-bold text-white">{{ $service->title }}</div>
                        <div class="small text-muted">Rating: {{ $service->rating ?? 'N/A' }}/5.0</div>
                    </td>
                    <td>
                        <div class="text-v3-muted" title="{{ $service->short_description }}">
                            {{ Str::limit($service->short_description, 60) }}
                        </div>
                    </td>
                    <td>
                        <span class="status-glow {{ $service->status === 'active' ? 'active' : 'inactive' }}">
                            {{ strtoupper($service->status) }}
                        </span>
                    </td>
                    <td><span class="fw-bold text-v3-accent">{{ $service->display_order }}</span></td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.services.edit', $service) }}" class="action-btn-v3 edit" title="Modify Logic">
                                <i class="fas fa-microchip"></i>
                            </a>
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Decommission service protocol?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-v3 delete" title="Purge">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="opacity-50">
                            <i class="fas fa-box-open fs-1 mb-3"></i>
                            <p>No active protocols detected in repository.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .service-icon-v3 {
        width: 40px;
        height: 40px;
        background: rgba(99, 102, 241, 0.1);
        border: 1px solid rgba(99, 102, 241, 0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--v3-accent);
        margin: 0 auto;
        font-size: 1.1rem;
    }
    .table-v3 { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-v3 th { background: rgba(255, 255, 255, 0.02); padding: 1.25rem 1.5rem; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v3-text-muted); border-bottom: 1px solid var(--v3-border); }
    .table-v3 td { padding: 1.25rem 1.5rem; vertical-align: middle; border-bottom: 1px solid var(--v3-border); background: transparent; transition: background 0.3s; }
    .table-v3 tr:hover td { background: rgba(255, 255, 255, 0.01); }

    .status-glow { font-size: 0.65rem; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 100px; display: inline-flex; align-items: center; gap: 0.5rem; }
    .status-glow::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    .status-glow.active { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .status-glow.active::before { background: #10b981; box-shadow: 0 0 8px #10b981; }
    .status-glow.inactive { background: rgba(148, 163, 184, 0.1); color: #94a3b8; }
    .status-glow.inactive::before { background: #94a3b8; }

    .action-btn-v3 { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--v3-border); background: rgba(255, 255, 255, 0.03); color: var(--v3-text-muted); transition: all 0.3s; text-decoration: none !important; }
    .action-btn-v3:hover { transform: translateY(-2px); border-color: var(--v3-accent); color: var(--v3-accent); }
    .action-btn-v3.delete:hover { border-color: #ef4444; color: #ef4444; }
    .text-v3-muted { color: rgba(255,255,255,0.4); font-size: 0.85rem; }
</style>
@endsection
