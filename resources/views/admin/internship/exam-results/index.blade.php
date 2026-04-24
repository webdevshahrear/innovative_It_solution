@extends('layouts.admin')

@push('styles')
<style>
    .cyber-header {
        position: relative; padding: 50px; border-radius: 36px;
        background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.08);
        margin-bottom: 50px; overflow: hidden; backdrop-filter: blur(24px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.1);
    }
    .cyber-header::before {
        content: ''; position: absolute; inset: -50%;
        background: radial-gradient(circle at 25% 50%, rgba(59, 130, 246, 0.12), transparent 50%),
                    radial-gradient(circle at 75% 30%, rgba(16, 185, 129, 0.1), transparent 50%);
        animation: rotateGlow 25s linear infinite; pointer-events: none; z-index: 0;
    }
    .cyber-header > * { position: relative; z-index: 1; }
    @keyframes rotateGlow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
<div class="cyber-header" data-aos="fade-down">
    <div class="d-flex align-items-center gap-2 mb-3">
        <span style="width:10px;height:10px;background:#3b82f6;border-radius:50%; box-shadow: 0 0 12px #3b82f6; display:inline-block;"></span>
        <span class="text-uppercase fw-bold" style="color:#3b82f6; font-size:0.75rem; letter-spacing:2px">Telemetry Feed Live</span>
    </div>
    <h1 class="text-white m-0" style="font-size: 3rem; font-weight: 900; font-family: 'Outfit'; letter-spacing: -0.03em;">Assessment <span style="background: linear-gradient(135deg, #3b82f6, #10b981); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Analytics</span></h1>
    <p class="text-v2-muted mt-2 mb-0" style="font-size: 1.1rem;">Monitor candidate performance, integrity logs, and anti-cheat enforcement metrics.</p>
</div>

<div class="row g-4 mb-5" data-aos="fade-up">
    <div class="col-md-3">
        <div class="tech-card-v2 text-center p-4">
            <div class="metric-icon-v2 mb-3 mx-auto"><i class="fas fa-file-signature"></i></div>
            <div class="text-v2-muted small mb-1 text-uppercase fw-bold letter-spacing-1">Attempt Volume</div>
            <div class="fs-2 fw-bold text-white">{{ $stats['total'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="tech-card-v2 text-center p-4">
            <div class="metric-icon-v2 mb-3 mx-auto" style="background:rgba(16,185,129,0.1); color:#10b981; border-color:rgba(16,185,129,0.2)"><i class="fas fa-user-check"></i></div>
            <div class="text-v2-muted small mb-1 text-uppercase fw-bold letter-spacing-1">Success Units</div>
            <div class="fs-2 fw-bold text-success">{{ $stats['passed'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="tech-card-v2 text-center p-4">
            <div class="metric-icon-v2 mb-3 mx-auto" style="background:rgba(245,158,11,0.1); color:#f59e0b; border-color:rgba(245,158,11,0.2)"><i class="fas fa-user-xmark"></i></div>
            <div class="text-v2-muted small mb-1 text-uppercase fw-bold letter-spacing-1">Sub-Threshold</div>
            <div class="fs-2 fw-bold text-warning">{{ $stats['failed'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="tech-card-v2 text-center p-4" style="border-top: 2px solid #ef4444">
            <div class="metric-icon-v2 mb-3 mx-auto" style="background:rgba(239,68,68,0.1); color:#ef4444; border-color:rgba(239,68,68,0.2)"><i class="fas fa-shield-virus"></i></div>
            <div class="text-v2-muted small mb-1 text-uppercase fw-bold letter-spacing-1">Integrity Breaches</div>
            <div class="fs-2 fw-bold text-danger">{{ $stats['terminated'] }}</div>
        </div>
    </div>
</div>

<div class="tech-card-v2 overflow-hidden px-0 py-0" data-aos="fade-up" data-aos-delay="100">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="padding-left:2.25rem">CANDIDATE IDENTITY</th>
                    <th>DOMAIN</th>
                    <th>DIAGNOSTIC LOG</th>
                    <th>PRECISION</th>
                    <th>TEMPORAL LOG</th>
                    <th class="text-end" style="padding-right:2.25rem">RESULT STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $attempt)
                <tr>
                    <td style="padding-left:2.25rem">
                        <div class="fw-bold text-white mb-1">{{ $attempt->application->full_name }}</div>
                        <div class="small text-v2-muted opacity-75"><i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($attempt->created_at)->format('d M, h:i A') }}</div>
                    </td>
                    <td>
                        <span class="badge border border-secondary text-white bg-dark bg-opacity-50 px-2 py-1" style="font-size:0.7rem">{{ $attempt->category->name }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                             <div class="text-v2-muted small fw-bold">{{ $attempt->total_questions }} SEGMENTS</div>
                             <div class="d-flex gap-1" style="font-size:0.75rem">
                                <span class="text-success"><i class="fas fa-circle-check"></i> {{ $attempt->correct_answers }}</span>
                                <span class="text-danger"><i class="fas fa-circle-xmark"></i> {{ $attempt->wrong_answers }}</span>
                             </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold {{ $attempt->status == 'passed' ? 'text-success' : 'text-danger' }}" style="font-size:1.1rem">
                            {{ round($attempt->score_percentage) }}%
                        </div>
                    </td>
                    <td>
                        <div class="text-v2-muted small">
                            <i class="fas fa-hourglass-half me-1"></i> {{ \Carbon\Carbon::parse($attempt->end_time)->diffInMinutes(\Carbon\Carbon::parse($attempt->start_time)) }} MINS
                        </div>
                    </td>
                    <td class="text-end" style="padding-right:2.25rem">
                        @if($attempt->status == 'passed') 
                            <span class="badge border border-success text-success bg-success bg-opacity-10 px-3 py-2" style="font-size:0.7rem; border-radius:100px"><i class="fas fa-trophy me-1"></i> PASSED</span>
                        @elseif($attempt->status == 'failed') 
                            <span class="badge border border-warning text-warning bg-warning bg-opacity-10 px-3 py-2" style="font-size:0.7rem; border-radius:100px"><i class="fas fa-circle-xmark me-1"></i> FAILED</span>
                        @elseif($attempt->status == 'terminated')
                            <span class="badge border border-danger text-danger bg-danger bg-opacity-10 px-3 py-2 cursor-pointer" style="font-size:0.7rem; border-radius:100px" title="{{ $attempt->tabViolations->count() }} detected violations"><i class="fas fa-ban me-1"></i> TERMINATED</span>
                        @else 
                            <span class="badge bg-secondary px-3 py-2" style="font-size:0.7rem; border-radius:100px">IN PROGRESS</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="opacity-25 mb-3"><i class="fas fa-magnifying-glass-chart" style="font-size:3rem"></i></div>
                        <p class="text-v2-muted mb-0">No assessment records found in the telemetry logs.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-between align-items-center">
    <div class="text-v2-muted small">Showing {{ $results->firstItem() ?? 0 }} to {{ $results->lastItem() ?? 0 }} of {{ $results->total() }} assessment records</div>
    <div class="pagination-v2">
        {{ $results->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
