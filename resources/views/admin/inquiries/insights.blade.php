@extends('layouts.admin')

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="page-title text-white">Sales Command Center</h1>
        <p class="page-subtitle text-v2-muted">Strategic analytics and lead conversion intelligence.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.inquiries.index') }}" class="btn-neo-glass">
            <i class="fas fa-list me-2"></i> Lead List
        </a>
        <a href="{{ route('admin.inquiries.board') }}" class="btn-v2-primary">
            <i class="fas fa-th-large me-2"></i> Pipeline Board
        </a>
    </div>
</div>

{{-- KPI Mini Stats --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card-v2 tech-card-v2 p-4">
            <div class="stat-label text-v2-muted small fw-bold">CONVERSION RATE</div>
            <div class="stat-value text-white h3 fw-bold mb-0">{{ number_format($conversionRate, 1) }}%</div>
            <div class="progress mt-2" style="height: 4px; background: rgba(255,255,255,0.05);">
                <div class="progress-bar bg-v2-primary" style="width: {{ $conversionRate }}%"></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-v2 tech-card-v2 p-4">
            <div class="stat-label text-v2-muted small fw-bold">PROJECTED REVENUE</div>
            <div class="stat-value text-white h3 fw-bold mb-0">${{ number_format($projectedRevenue, 0) }}</div>
            <p class="small text-v2-muted mt-2">Weighted Pipeline Value</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-v2 tech-card-v2 p-4">
            <div class="stat-label text-v2-muted small fw-bold">AVG. RESPONSE</div>
            <div class="stat-value text-white h3 fw-bold mb-0">{{ number_format($avgResponseHours, 1) }}h</div>
            <p class="small text-v2-muted mt-2">First Engagement Speed</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-v2 tech-card-v2 p-4">
            <div class="stat-label text-v2-muted small fw-bold">TOTAL PIPELINE</div>
            <div class="stat-value text-white h3 fw-bold mb-0">{{ $totalLeads }}</div>
            <p class="small text-v2-muted mt-2">Active Mission Packets</p>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Funnel Chart --}}
    <div class="col-lg-8">
        <div class="tech-card-v2 p-4 h-100">
            <h5 class="text-white fw-bold mb-4"><i class="fas fa-filter text-v2-primary me-2"></i> Conversion Funnel</h5>
            <div style="height: 350px;">
                <canvas id="funnelChart"></canvas>
            </div>
        </div>
    </div>
    
    {{-- Stagnant Leads --}}
    <div class="col-lg-4">
        <div class="tech-card-v2 p-4 h-100">
            <h5 class="text-white fw-bold mb-3"><i class="fas fa-exclamation-triangle text-warning me-2"></i> Stagnant Leads</h5>
            <p class="text-v2-muted small mb-4">No activity logged in the last 72 hours.</p>
            
            <div class="stagnant-list">
                @forelse($stagnantLeads as $lead)
                <div class="d-flex align-items-center gap-3 mb-3 p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="status-dot {{ $lead->status == 'proposal_sent' ? 'bg-info' : 'bg-warning' }}" style="width: 8px; height: 8px; border-radius: 50%;"></div>
                    <div class="flex-grow-1">
                        <div class="text-white fw-bold small">{{ $lead->name }}</div>
                        <div class="text-v2-muted" style="font-size: 0.7rem;">{{ ucfirst($lead->status) }} • ${{ number_format($lead->lead_value, 0) }}</div>
                    </div>
                    <a href="{{ route('admin.inquiries.show', $lead->id) }}" class="btn-neo-glass py-1 px-2 small">
                        <i class="fas fa-arrow-right" style="font-size: 0.7rem;"></i>
                    </a>
                </div>
                @empty
                <div class="text-center py-5 opacity-20">
                    <i class="fas fa-check-circle fs-1 mb-3"></i>
                    <p>All leads are moving!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('funnelChart').getContext('2d');
    const data = @json(array_values($funnelData));
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['NEW', 'CONTACTED', 'QUALIFIED', 'PROPOSAL', 'WON', 'LOST'],
            datasets: [{
                label: 'Lead Count',
                data: data,
                backgroundColor: [
                    'rgba(240, 82, 35, 0.4)',
                    'rgba(245, 158, 11, 0.4)',
                    'rgba(139, 92, 246, 0.4)',
                    'rgba(6, 182, 212, 0.4)',
                    'rgba(16, 185, 129, 0.4)',
                    'rgba(239, 68, 68, 0.4)'
                ],
                borderColor: [
                    '#f05223', '#f59e0b', '#8b5cf6', '#06b6d4', '#10b981', '#ef4444'
                ],
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { 
                    grid: { color: 'rgba(255,255,255,0.05)' },
                    ticks: { color: 'rgba(255,255,255,0.5)' }
                },
                y: {
                    grid: { display: false },
                    ticks: { color: '#fff', font: { weight: 'bold' } }
                }
            }
        }
    });
});
</script>
@endsection
