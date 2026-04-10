@extends('layouts.admin')

@use('Illuminate\Support\Str')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Service Protocols</h1>
        <p class="page-subtitle text-v2-muted">Configure the core utility modules offered in your digital catalog.</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="btn-v2-primary">
        <i class="fas fa-plus me-2"></i> New Protocol
    </a>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th class="text-center" style="width: 100px;">ICON</th>
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
                             <div class="metric-icon-v2 mx-auto">
                                <i class="{{ $service->icon_class }}"></i>
                             </div>
                        </td>
                        <td>
                            <div class="fw-bold text-v2-main">{{ $service->title }}</div>
                            <div class="small text-v2-muted">Performance: <span class="text-v2-primary">{{ $service->rating ?? 'N/A' }}/5.0</span></div>
                        </td>
                        <td>
                            <div class="text-v2-muted" title="{{ $service->short_description }}">
                                {{ Str::limit($service->short_description, 60) }}
                            </div>
                        </td>
                        <td>
                            <span class="status-glow-v2 {{ $service->status === 'active' ? 'active' : 'inactive' }}">
                                <span class="status-dot"></span>
                                {{ strtoupper($service->status) }}
                            </span>
                        </td>
                        <td><span class="fw-bold text-v2-primary">{{ $service->display_order }}</span></td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.services.edit', $service) }}" class="action-btn-v2" title="Modify Logic">
                                    <i class="fas fa-microchip"></i>
                                </a>
                                <form action="{{ route('admin.services.duplicate', $service) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn-v2" title="Duplicate Protocol">
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
                            <div class="opacity-30">
                                <i class="fas fa-box-open fs-1 mb-3 text-v2-muted"></i>
                                <p class="text-v2-muted">No active protocols detected in repository.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
