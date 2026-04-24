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
        background: radial-gradient(circle at 30% 60%, rgba(16, 185, 129, 0.12), transparent 50%),
                    radial-gradient(circle at 75% 25%, rgba(167, 139, 250, 0.1), transparent 50%);
        animation: rotateGlow 25s linear infinite; pointer-events: none; z-index: 0;
    }
    .cyber-header > * { position: relative; z-index: 1; }
    @keyframes rotateGlow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
<div class="cyber-header" data-aos="fade-down">
    <div class="d-flex align-items-center gap-2 mb-3">
        <span style="width:10px;height:10px;background:#10b981;border-radius:50%; box-shadow: 0 0 12px #10b981; display:inline-block;"></span>
        <span class="text-uppercase fw-bold" style="color:#10b981; font-size:0.75rem; letter-spacing:2px">Network Status: Active</span>
    </div>
    <h1 class="text-white m-0" style="font-size: 3rem; font-weight: 900; font-family: 'Outfit'; letter-spacing: -0.03em;">Active Intern <span style="background: linear-gradient(135deg, #10b981, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Network</span></h1>
    <p class="text-v2-muted mt-2 mb-0" style="font-size: 1.1rem;">Monitor global performance metrics, manage mentor assignments, and track program milestones.</p>
</div>

<div class="tech-card-v2 mb-4" data-aos="fade-up">
    <form action="{{ route('admin.internship.interns.index') }}" method="GET" class="row g-3">
        <div class="col-md-5">
            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Filter by Specialization</label>
            <select name="category" class="form-select v2-admin-input">
                <option value="">All Career Tracks</option>
                @foreach(\App\Models\InternshipCategory::all() as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5">
            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Account Status</label>
            <select name="status" class="form-select v2-admin-input">
                <option value="">All Lifecycle States</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Engagement</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Graduated / Completed</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended / Inactive</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn-v2-primary w-100 py-3" style="border-radius:12px">
                <i class="fas fa-search me-2"></i>Apply Filters
            </button>
        </div>
    </form>
</div>

<div class="tech-card-v2 overflow-hidden px-0 py-0" data-aos="fade-up" data-aos-delay="100">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="padding-left:2.25rem">INTERN IDENTITY</th>
                    <th>CAREER TRACK</th>
                    <th>ASSIGNED MENTOR</th>
                    <th style="width:200px">CORE PERFORMANCE</th>
                    <th>MILESTONE LOG</th>
                    <th>STATUS</th>
                    <th class="text-end" style="padding-right:2.25rem">CONTROLS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accounts as $acc)
                <tr>
                    <td style="padding-left:2.25rem">
                        <div class="d-flex align-items-center gap-3">
                             <img src="https://ui-avatars.com/api/?name={{ urlencode($acc->application->full_name) }}&background=f05223&color=fff" class="rounded-3" style="width:38px;height:38px">
                             <div>
                                <div class="fw-bold text-v2-main">{{ $acc->application->full_name }}</div>
                                <div class="small text-v2-muted font-monospace opacity-50" style="font-size:0.7rem">ID: {{ substr($acc->registration_token, 0, 8) }}</div>
                             </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge border border-secondary text-white bg-dark bg-opacity-50 px-2 py-1" style="font-size:0.7rem">{{ $acc->category->name }}</span>
                    </td>
                    <td>
                        @if($acc->mentor)
                            <div class="text-white small fw-medium d-flex align-items-center gap-2">
                                <i class="fas fa-user-tie text-primary"></i> 
                                <span>{{ $acc->mentor->name }}</span>
                            </div>
                        @else
                            <button type="button" class="btn btn-sm btn-outline-warning border-opacity-25" style="font-size:0.7rem; border-radius:6px" data-bs-toggle="modal" data-bs-target="#assignMentorModal{{ $acc->id }}">
                                <i class="fas fa-plus-circle me-1"></i> Assign Expert
                            </button>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-column gap-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-bold {{ $acc->performance_score >= 60 ? 'text-success' : 'text-warning' }}" style="font-size:0.75rem">{{ $acc->performance_score }}%</span>
                            </div>
                            <div class="progress" style="height: 4px; background: rgba(255,255,255,0.05); border-radius: 10px;">
                                <div class="progress-bar {{ $acc->performance_score >= 60 ? 'bg-success' : 'bg-warning' }}" style="width: {{ $acc->performance_score }}%; box-shadow: 0 0 10px {{ $acc->performance_score >= 60 ? 'rgba(16,185,129,0.3)' : 'rgba(245,158,11,0.3)' }}"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="small d-flex flex-column" style="font-size:0.75rem">
                            <span class="text-v2-muted opacity-75"><i class="far fa-play-circle me-1"></i> {{ \Carbon\Carbon::parse($acc->start_date)->format('M d, Y') }}</span>
                            <span class="text-danger opacity-75"><i class="far fa-stop-circle me-1"></i> {{ \Carbon\Carbon::parse($acc->end_date)->format('M d, Y') }}</span>
                        </div>
                    </td>
                    <td>
                        @if($acc->status == 'active') 
                            <span class="badge border border-success text-success bg-success bg-opacity-10 px-3 py-1" style="font-size:0.65rem; border-radius:100px">ACTIVE</span>
                        @elseif($acc->status == 'suspended') 
                            <span class="badge border border-danger text-danger bg-danger bg-opacity-10 px-3 py-1" style="font-size:0.65rem; border-radius:100px">SUSPENDED</span>
                        @else 
                            <span class="badge border border-info text-info bg-info bg-opacity-10 px-3 py-1" style="font-size:0.65rem; border-radius:100px">GRADUATED</span>
                        @endif
                    </td>
                    <td class="text-end" style="padding-right:2.25rem">
                        <a href="{{ route('admin.internship.interns.show', $acc) }}" class="action-btn-v2" title="View Intern Profile"><i class="fas fa-fingerprint"></i></a>
                    </td>
                </tr>

                <!-- Mentor Modal -->
                @if(!$acc->mentor)
                <div class="modal fade" id="assignMentorModal{{ $acc->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-v2-sidebar border border-secondary text-white" style="backdrop-filter: blur(40px); border-radius:20px">
                            <div class="modal-header border-secondary p-4">
                                <h5 class="modal-title fw-bold">Assign Mentor: {{ $acc->application->full_name }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.internship.interns.assign-mentor', $acc) }}" method="POST">
                                @csrf
                                <div class="modal-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Select Lead Mentor</label>
                                        <select name="mentor_id" class="form-select v2-admin-input" required>
                                            <option value="">-- Choose Assigned Expert --</option>
                                            @foreach($mentors as $mentor)
                                            <option value="{{ $mentor->id }}">{{ $mentor->name }} ({{ $mentor->email }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="small text-v2-muted">The assigned mentor will be responsible for task management, performance evaluations, and program feedback for this intern.</p>
                                </div>
                                <div class="modal-footer border-secondary p-4">
                                    <button type="button" class="btn-neo-glass py-2" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn-v2-primary py-2 px-4">Confirm Assignment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="opacity-25 mb-3"><i class="fas fa-users-slash" style="font-size:3rem"></i></div>
                        <p class="text-v2-muted mb-0">No active intern accounts recorded.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-between align-items-center">
    <div class="text-v2-muted small">Showing {{ $accounts->firstItem() ?? 0 }} to {{ $accounts->lastItem() ?? 0 }} of {{ $accounts->total() }} interns</div>
    <div class="pagination-v2">
        {{ $accounts->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
