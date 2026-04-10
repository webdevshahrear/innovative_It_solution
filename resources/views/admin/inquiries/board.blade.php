@extends('layouts.admin')

@section('content')
<style>
    .kanban-container {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        padding-bottom: 20px;
        min-height: calc(100vh - 250px);
    }
    .kanban-column {
        min-width: 320px;
        flex: 1;
        background: rgba(15, 23, 42, 0.3);
        border-radius: 20px;
        border: 1px solid var(--v2-border);
        display: flex;
        flex-direction: column;
    }
    .kanban-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--v2-border);
        display: flex;
        align-items: center;
        justify-content: justify;
        gap: 10px;
    }
    .kanban-list {
        padding: 1rem;
        flex: 1;
        overflow-y: auto;
    }
    .kanban-card {
        background: var(--v2-card);
        border: 1px solid var(--v2-border);
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s;
        cursor: grab;
    }
    .kanban-card:hover {
        transform: translateY(-5px);
        border-color: var(--v2-primary);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .status-badge {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 100px;
        text-transform: uppercase;
    }
    
    [data-theme="light"] .kanban-column { background: #f1f5f9; }
    [data-theme="light"] .kanban-card { background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
</style>

<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="page-title text-white">Sales Pipeline Board</h1>
        <p class="page-subtitle text-v2-muted">Visualize your lead flow and transaction stages.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.inquiries.index', ['view' => 'list']) }}" class="btn-neo-glass">
            <i class="fas fa-list me-2"></i> List View
        </a>
        <a href="{{ route('admin.inquiries.index', ['view' => 'board']) }}" class="btn-neo-glass active" style="background: var(--v2-gradient); color: white;">
            <i class="fas fa-th-large me-2"></i> Kanban Board
        </a>
    </div>
</div>

<div class="kanban-container">
    @php
        $columns = [
            'new' => ['label' => 'NEW LEADS', 'icon' => 'fa-satellite-dish', 'color' => '#3b82f6'],
            'contacted' => ['label' => 'CONTACTED', 'icon' => 'fa-comments', 'color' => '#f59e0b'],
            'qualified' => ['label' => 'QUALIFIED', 'icon' => 'fa-user-check', 'color' => '#8b5cf6'],
            'proposal_sent' => ['label' => 'PROPOSAL SENT', 'icon' => 'fa-file-invoice-dollar', 'color' => '#06b6d4'],
            'won' => ['label' => 'WON', 'icon' => 'fa-trophy', 'color' => '#10b981'],
            'lost' => ['label' => 'LOST', 'icon' => 'fa-times-circle', 'color' => '#ef4444'],
        ];
    @endphp

    @foreach($columns as $key => $col)
    <div class="kanban-column" data-status="{{ $key }}">
        <div class="kanban-header">
            <div class="metric-icon-v2" style="background: {{ $col['color'] }}20; color: {{ $col['color'] }};">
                <i class="fas {{ $col['icon'] }}"></i>
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold text-white small">{{ $col['label'] }}</div>
                <div class="small text-v2-muted counter-{{ $key }}">{{ $leadsByStatus[$key]->count() }} leads</div>
            </div>
        </div>
        <div class="kanban-list" id="list-{{ $key }}">
            @foreach($leadsByStatus[$key] as $lead)
            <div class="kanban-card" data-id="{{ $lead->id }}">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="text-white mb-0 fw-bold">{{ Str::limit($lead->name, 20) }}</h6>
                    <div class="text-v2-primary fw-bold small">${{ number_format($lead->lead_value, 0) }}</div>
                </div>
                <p class="text-v2-muted small mb-3">{{ Str::limit($lead->subject, 50) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-1">
                        @if($lead->linkedin_url) <i class="fab fa-linkedin small text-v2-muted"></i> @endif
                        @if($lead->website_url) <i class="fas fa-globe small text-v2-muted"></i> @endif
                    </div>
                    <a href="{{ route('admin.inquiries.show', $lead->id) }}" class="action-btn-v2" style="width: 28px; height: 28px; font-size: 0.8rem;">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const columns = document.querySelectorAll('.kanban-list');
    
    columns.forEach(column => {
        new Sortable(column, {
            group: 'kanban',
            animation: 150,
            ghostClass: 'bg-v2-primary-glow',
            onAdd: function (evt) {
                const leadId = evt.item.getAttribute('data-id');
                const newStatus = evt.to.closest('.kanban-column').getAttribute('data-status');
                
                // Visual feedback: adding a loading state
                evt.item.style.opacity = '0.5';
                
                updateLeadStatus(leadId, newStatus, evt.item);
            }
        });
    });

    async function updateLeadStatus(id, status, element) {
        try {
            const response = await fetch(`/admin/inquiries/${id}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: status })
            });

            if (!response.ok) throw new Error('Update failed');
            
            element.style.opacity = '1';
            // Optional: Show localized toast or update counters
            console.log(`Lead ${id} moved to ${status}`);
        } catch (error) {
            console.error(error);
            alert('Failed to update lead status. Reverting...');
            window.location.reload();
        }
    }
});
</script>
@endsection
