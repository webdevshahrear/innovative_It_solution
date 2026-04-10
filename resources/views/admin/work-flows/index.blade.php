@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Strategic Workflows</h1>
        <p class="page-subtitle text-v2-muted">Configure the circular operational steps displayed on the home page.</p>
    </div>
    <a href="{{ route('admin.work-flows.create') }}" class="btn-v2-primary">
        <i class="fas fa-plus me-2"></i> Initialise Step
    </a>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="width: 100px;">SIGNAL</th>
                    <th>STEP IDENTIFIER</th>
                    <th>DESCRIPTION</th>
                    <th>ORDER</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @if($workFlows->count() > 0)
                    @foreach($workFlows as $step)
                    <tr>
                        <td>
                            <div class="metric-icon-v2">
                                <i class="{{ $step->icon_class }}"></i>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-v2-main">{{ $step->title }}</div>
                            <div class="small text-v2-muted">Workflow Node</div>
                        </td>
                        <td><div class="text-v2-muted text-truncate" style="max-width: 240px;">{{ $step->description }}</div></td>
                        <td>
                            <span class="badge bg-dark border border-secondary px-3 py-2 rounded-pill shadow-sm">
                                {{ $step->display_order }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <form action="{{ route('admin.work-flows.duplicate', $step->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn-v2" title="Duplicate Node">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.work-flows.edit', $step->id) }}" class="action-btn-v2" title="Recalibrate">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.work-flows.destroy', $step->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Purge workflow step?');">
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
                                <i class="fas fa-dharmachakra fs-1 mb-3 text-v2-muted"></i>
                                <p class="text-v2-muted">No workflow nodes detected in data stream.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
