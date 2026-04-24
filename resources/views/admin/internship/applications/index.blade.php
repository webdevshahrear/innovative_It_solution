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
        background: radial-gradient(circle at 20% 50%, rgba(240, 82, 35, 0.12), transparent 50%),
                    radial-gradient(circle at 80% 30%, rgba(167, 139, 250, 0.1), transparent 50%);
        animation: rotateGlow 25s linear infinite; pointer-events: none; z-index: 0;
    }
    .cyber-header > * { position: relative; z-index: 1; }
    @keyframes rotateGlow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
<div class="cyber-header" data-aos="fade-down">
    <div class="d-flex align-items-center gap-2 mb-3">
        <span style="width:10px;height:10px;background:var(--v2-primary);border-radius:50%; box-shadow: 0 0 12px var(--v2-primary); display:inline-block;"></span>
        <span class="text-uppercase fw-bold" style="color:var(--v2-primary); font-size:0.75rem; letter-spacing:2px">Applicant Pipeline</span>
    </div>
    <h1 class="text-white m-0" style="font-size: 3rem; font-weight: 900; font-family: 'Outfit'; letter-spacing: -0.03em;">Internship <span style="background: linear-gradient(135deg, #f05223, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Applications</span></h1>
    <p class="text-v2-muted mt-2 mb-0" style="font-size: 1.1rem;">Manage the talent pipeline, review candidate profiles, and monitor exam eligibility.</p>
</div>

<div class="tech-card-v2 mb-4" data-aos="fade-up">
    <form action="{{ route('admin.internship.applications.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Search Applicants</label>
            <div class="input-group">
                <span class="input-group-text bg-white bg-opacity-5 border-secondary text-v2-muted"><i class="fas fa-search"></i></span>
                <input type="text" name="search" class="form-control v2-admin-input" placeholder="Name, email, or phone..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Track/Category</label>
            <select name="category" class="form-select v2-admin-input">
                <option value="">All Specializations</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Lifecycle Status</label>
            <select name="status" class="form-select v2-admin-input">
                <option value="">Full Lifecycle</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Assessment</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Passed & Registered</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Onboarding</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Terminated/Failed</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn-v2-primary w-100 py-3" style="border-radius: 12px;">
                <i class="fas fa-filter me-2"></i>Apply
            </button>
        </div>
    </form>
</div>

<div class="tech-card-v2 overflow-hidden px-0 py-0" data-aos="fade-up" data-aos-delay="100">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="padding-left: 2.25rem;">APPLICANT PIPELINE</th>
                    <th>TARGET DOMAIN</th>
                    <th>CREDENTIALS</th>
                    <th>REGISTRATION DATE</th>
                    <th>PHASE STATUS</th>
                    <th class="text-end" style="padding-right: 2.25rem;">CONTROLS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                <tr>
                    <td style="padding-left: 2.25rem;">
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($app->full_name) }}&background=f05223&color=fff" class="rounded-3" style="width: 38px; height: 38px;">
                            <div>
                                <div class="fw-bold text-v2-main">{{ $app->full_name }}</div>
                                <div class="small text-v2-muted">{{ $app->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-white fw-medium"><i class="fas fa-layer-group text-primary me-2 opacity-50"></i>{{ $app->preferredCategory->name }}</div>
                    </td>
                    <td>
                        <div class="text-v2-main small fw-bold">{{ $app->education }}</div>
                        <div class="small text-v2-muted" style="font-size: 0.75rem;">{{ ucfirst($app->current_status) }}</div>
                    </td>
                    <td>
                        <div class="text-v2-muted small"><i class="far fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($app->created_at)->format('d M, Y') }}</div>
                    </td>
                    <td>
                        @if($app->status == 'pending') 
                            <span class="badge border border-warning text-warning bg-warning bg-opacity-10 px-3 py-2" style="font-size: 0.7rem; border-radius: 6px;">
                                <i class="fas fa-hourglass-half me-1"></i> PENDING EXAM
                            </span>
                        @elseif($app->status == 'paid') 
                            <span class="badge border border-info text-info bg-info bg-opacity-10 px-3 py-2" style="font-size: 0.7rem; border-radius: 6px;">
                                <i class="fas fa-check-double me-1"></i> PASSED / REG
                            </span>
                        @elseif($app->status == 'active') 
                            <span class="badge border border-success text-success bg-success bg-opacity-10 px-3 py-2" style="font-size: 0.7rem; border-radius: 6px;">
                                <i class="fas fa-user-check me-1"></i> ACCOUNT ACTIVE
                            </span>
                        @elseif($app->status == 'rejected') 
                            <span class="badge border border-danger text-danger bg-danger bg-opacity-10 px-3 py-2" style="font-size: 0.7rem; border-radius: 6px;">
                                <i class="fas fa-times-circle me-1"></i> REJECTED
                            </span>
                        @else 
                            <span class="badge bg-secondary px-3 py-2" style="font-size: 0.7rem; border-radius: 6px;">{{ strtoupper($app->status) }}</span>
                        @endif
                    </td>
                    <td class="text-end" style="padding-right: 2.25rem;">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.internship.applications.show', $app) }}" class="action-btn-v2" title="View Full Dossier">
                                <i class="fas fa-id-badge"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="opacity-25 mb-3">
                            <i class="fas fa-users-slash" style="font-size: 3rem;"></i>
                        </div>
                        <p class="text-v2-muted mb-0">No internship applications align with the current filters.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-between align-items-center">
    <div class="text-v2-muted small">Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of {{ $applications->total() }} applications</div>
    <div class="pagination-v2">
        {{ $applications->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
