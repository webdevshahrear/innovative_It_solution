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
<div class="cyber-header d-flex justify-content-between align-items-center" data-aos="fade-down">
    <div>
        <div class="d-flex align-items-center gap-2 mb-3">
            <span style="width:10px;height:10px;background:#10b981;border-radius:50%; box-shadow: 0 0 12px #10b981; display:inline-block;"></span>
            <span class="text-uppercase fw-bold" style="color:#10b981; font-size:0.75rem; letter-spacing:2px">Dossier Access Granted</span>
        </div>
        <h1 class="text-white m-0" style="font-size: 2.5rem; font-weight: 900; font-family: 'Outfit'; letter-spacing: -0.03em;">Intelligence <span style="background: linear-gradient(135deg, #10b981, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Dossier</span></h1>
        <p class="text-white-50 mt-2 mb-0" style="font-size: 1.1rem; opacity: 0.9;">{{ $account->application->full_name }} — Performance, milestones & mentorship logs.</p>
    </div>
    <a href="{{ route('admin.internship.interns.index') }}" class="btn-neo-glass py-3 px-4" style="border-radius: 20px;">
        <i class="fas fa-arrow-left me-2 text-primary"></i> Back to Network
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-4" data-aos="fade-right">
        {{-- Profile Card --}}
        <div class="tech-card-v2 mb-4 text-center overflow-hidden" style="background: rgba(255,255,255,0.02)">
            <div class="position-absolute top-0 start-0 w-100" style="height:80px; background: var(--v2-gradient); opacity:0.1; z-index:0"></div>
            
            <div class="position-relative z-index-1 mt-3">
                <div class="position-relative d-inline-block mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($account->application->full_name) }}&background=f05223&color=fff&size=120" class="rounded-circle border border-4 border-white border-opacity-10 shadow-lg" alt="">
                    <div class="position-absolute bottom-0 end-0 bg-success border border-white border-opacity-20 rounded-circle" style="width:24px; height:24px; box-shadow:0 0 15px rgba(16,185,129,0.5)"></div>
                </div>
                
                <h4 class="fw-bold text-white mb-1">{{ $account->application->full_name }}</h4>
                <div class="text-v2-primary small text-uppercase fw-bold letter-spacing-1 mb-4">{{ $account->category->name }} Specialist</div>
                
                <div class="d-flex justify-content-center gap-3 mb-4">
                    <div class="px-3 py-2 rounded-3 border border-secondary" style="min-width: 100px; background: rgba(255, 255, 255, 0.05);">
                        <div class="text-v2-muted small text-uppercase fw-bold" style="font-size:0.6rem; opacity: 0.8;">Performance</div>
                        <div class="text-white fw-bold">{{ $account->performance_score }}%</div>
                    </div>
                    <div class="px-3 py-2 rounded-3 border border-secondary" style="min-width: 100px; background: rgba(255, 255, 255, 0.05);">
                        <div class="text-v2-muted small text-uppercase fw-bold" style="font-size:0.6rem; opacity: 0.8;">Account</div>
                        <div class="{{ $account->status == 'active' ? 'text-success' : ($account->status == 'suspended' ? 'text-danger' : 'text-info') }} fw-bold text-uppercase" style="font-size: 0.75rem;">{{ $account->status }}</div>
                    </div>
                </div>
            </div>

            <div class="text-start p-4 rounded-4 border border-white border-opacity-5 small mb-4" style="background: rgba(255, 255, 255, 0.03);">
                <div class="mb-3 d-flex align-items-center gap-3">
                    <div class="metric-icon-v2" style="width:32px; height:32px; font-size:0.9rem"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="text-v2-muted fw-bold" style="font-size:0.7rem; letter-spacing: 0.5px; opacity: 0.7;">PRIMARY EMAIL</div>
                        <div class="text-white">{{$account->application->email}}</div>
                    </div>
                </div>
                <div class="mb-3 d-flex align-items-center gap-3">
                    <div class="metric-icon-v2" style="width:32px; height:32px; font-size:0.9rem; background:rgba(59,130,246,0.1); color:#3b82f6; border-color:rgba(59,130,246,0.2)"><i class="fas fa-phone"></i></div>
                    <div>
                        <div class="text-v2-muted fw-bold" style="font-size:0.7rem; letter-spacing: 0.5px; opacity: 0.7;">CONTACT LINE</div>
                        <div class="text-white">{{$account->application->phone}}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="metric-icon-v2" style="width:32px; height:32px; font-size:0.9rem; background:rgba(16,185,129,0.1); color:#10b981; border-color:rgba(16,185,129,0.2)"><i class="fas fa-calendar-check"></i></div>
                    <div>
                        <div class="text-v2-muted fw-bold" style="font-size:0.7rem; letter-spacing: 0.5px; opacity: 0.7;">PROGRAM WINDOW</div>
                        <div class="text-white">{{\Carbon\Carbon::parse($account->start_date)->format('d M')}} — {{\Carbon\Carbon::parse($account->end_date)->format('d M, Y')}}</div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.internship.interns.toggle-status', $account) }}" method="POST">
                @csrf
                <button type="submit" class="btn-premium w-100 py-3 {{ $account->status == 'active' ? '' : 'bg-success' }}" style="border-radius:12px; font-size:0.85rem; background:{{ $account->status == 'active' ? 'linear-gradient(135deg, #ef4444, #dc2626)' : 'linear-gradient(135deg, #10b981, #059669)' }}" onclick="return confirm('Please confirm this account status adjustment.')">
                    @if($account->status == 'active')
                        <i class="fas fa-user-slash me-2 text-white"></i> SUSPEND ACCESS
                    @else
                        <i class="fas fa-user-check me-2 text-white"></i> RESTORE ACCESS
                    @endif
                </button>
            </form>
        </div>

        {{-- Mentor Card --}}
        <div class="tech-card-v2">
            <h5 class="text-white fw-bold mb-4 d-flex align-items-center">
                <i class="fas fa-chalkboard-teacher me-2 text-primary"></i> Mentorship Control
            </h5>
            <form action="{{ route('admin.internship.interns.assign-mentor', $account) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Assigned Executive Mentor</label>
                    <select name="mentor_id" class="form-select v2-admin-input">
                        <option value="">-- No Expert Assigned --</option>
                        @foreach($mentors as $mentor)
                        <option value="{{ $mentor->id }}" {{ $account->mentor_id == $mentor->id ? 'selected' : '' }}>{{ $mentor->name }} ({{ $mentor->email }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-v2-primary w-100 py-3" style="border-radius:12px">
                    <i class="fas fa-sync-alt me-2"></i>Update Assignment
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-8" data-aos="fade-left">
        {{-- Tasks Overview --}}
        <div class="tech-card-v2 position-relative overflow-hidden mb-4 p-0">
            <div class="px-4 py-4 border-bottom border-white border-opacity-5 d-flex justify-content-between align-items-center">
                <h5 class="text-white fw-bold mb-0"><i class="fas fa-tasks me-2 text-warning"></i> Program Milestone Log</h5>
                <span class="badge bg-white bg-opacity-5 border border-secondary text-v2-muted px-3 py-2">TOTAL TASKS: {{ $account->tasks->count() }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-v2 mb-0">
                    <thead>
                        <tr>
                            <th style="padding-left:1.5rem; color: #94a3b8 !important; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">MILESTONE / OBJECTIVE</th>
                            <th style="color: #94a3b8 !important; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">RELEASE DATE</th>
                            <th style="color: #94a3b8 !important; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">PHASE STATUS</th>
                            <th class="text-end" style="padding-right:1.5rem; color: #94a3b8 !important; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">QUALITY SCORE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($account->tasks as $task)
                        <tr>
                            <td style="padding-left:1.5rem">
                                <div class="fw-bold text-white mb-1">{{ $task->title }}</div>
                                <div class="small text-v2-muted d-flex align-items-center gap-1">
                                    <i class="fas fa-user-circle" style="font-size:0.7rem"></i> 
                                    <span>Issued by {{ $task->assignedBy->name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="text-v2-muted small">{{ \Carbon\Carbon::parse($task->created_at)->format('d M, Y') }}</div>
                            </td>
                            <td>
                                @if($task->status == 'pending') 
                                    <span class="text-warning small fw-bold"><i class="fas fa-clock-rotate-left me-1"></i> WAITING</span>
                                @elseif($task->status == 'submitted') 
                                    <span class="text-info small fw-bold"><i class="fas fa-search-nodes me-1"></i> EVALUATING</span>
                                @elseif($task->status == 'approved') 
                                    <span class="text-success small fw-bold"><i class="fas fa-check-double me-1"></i> COMPLETED</span>
                                @else 
                                    <span class="text-danger small fw-bold"><i class="fas fa-circle-exclamation me-1"></i> REVISIONS</span>
                                @endif
                            </td>
                            <td class="text-end" style="padding-right:1.5rem">
                                @if($task->score)
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <div class="fw-bold text-white">{{ $task->score }}%</div>
                                        <div class="rounded-circle" style="width:8px; height:8px; background:{{ $task->score >= 80 ? '#10b981' : ($task->score >= 60 ? '#f59e0b' : '#ef4444') }}"></div>
                                    </div>
                                @else
                                    <span class="text-v2-muted opacity-50">UNGRADED</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="opacity-25 mb-2"><i class="fas fa-inbox" style="font-size:2.5rem"></i></div>
                                <p class="text-v2-muted mb-0 small">No tasks have been initialized for this specialist track.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Certification --}}
        <div class="tech-card-v2" style="border: 1px solid rgba(16,185,129,0.3); background: radial-gradient(circle at 100% 0%, rgba(16,185,129,0.08) 0%, transparent 50%)">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="text-white fw-bold mb-0"><i class="fas fa-certificate me-2 text-success"></i> Graduation Credentials</h5>
                @if($account->certificate)
                    <span class="badge border border-success text-success bg-success bg-opacity-10 px-3 py-2" style="font-size:0.7rem">CERTIFICATE ISSUED</span>
                @elseif($account->performance_score >= 60)
                    <span class="badge border border-success text-success bg-success bg-opacity-10 px-3 py-2" style="font-size:0.7rem">ELIGIBLE FOR GRADUATION</span>
                @else
                    <span class="badge border border-warning text-warning bg-warning bg-opacity-10 px-3 py-2" style="font-size:0.7rem">REQUIREMENTS PENDING</span>
                @endif
            </div>

            @if($account->certificate)
                <div class="p-4 rounded-4 d-flex align-items-center gap-4" style="background: rgba(16,185,129,0.05); border: 1px solid rgba(16,185,129,0.2)">
                    <div class="metric-icon-v2" style="width:60px; height:60px; font-size:2rem; background:rgba(16,185,129,0.1); color:#10b981; border-color:rgba(16,185,129,0.3)">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="text-white fw-bold fs-5">Internship Certificate Issued</div>
                        <div class="text-v2-muted small">Reg ID: <span class="text-success fw-mono">{{ $account->certificate->certificate_number }}</span></div>
                        <div class="mt-3 d-flex gap-2">
                             <a href="{{ route('admin.internship.interns.view-certificate', $account) }}" target="_blank" class="btn btn-sm btn-v2-primary py-2 px-3" style="font-size:0.8rem; border-radius:8px">
                                <i class="fas fa-eye me-1"></i> View / Print Certificate
                             </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-4 rounded-4 d-flex align-items-center justify-content-between" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1)">
                    <div class="d-flex align-items-center gap-3">
                        <div class="metric-icon-v2" style="width:48px; height:48px; font-size:1.4rem; color: #64748b; border-color: rgba(255,255,255,0.1)">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div>
                            <div class="text-white fw-bold">Manual Certificate Override</div>
                            <div class="text-v2-muted small">Status: {{ $account->performance_score >= 60 ? 'Requirements Met' : 'Instant Issue Available' }}</div>
                        </div>
                    </div>
                    <form action="{{ route('admin.internship.interns.issue-certificate', $account) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-premium" style="padding: 10px 22px; font-size:0.85rem; border: none; cursor: pointer;">
                            <i class="fas fa-magic me-2"></i>Issue Certificate Now
                        </button>
                    </form>
                </div>
                <div class="mt-3 px-2 d-flex align-items-center gap-2 text-white-50 small">
                    <i class="fas fa-shield-alt text-primary"></i>
                    <span>Admin Override: You can issue a certificate even if the intern hasn't reached the 60% score threshold.</span>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
