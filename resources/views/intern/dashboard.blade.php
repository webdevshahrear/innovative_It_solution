@extends('layouts.dashboard')
@section('title', 'Intern Dashboard')
@section('panel_type', 'Intern Panel')

@section('sidebar')
    <a href="{{ route('intern.dashboard') }}" class="nav-link {{ request()->routeIs('intern.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('intern.tasks.index') }}" class="nav-link {{ request()->routeIs('intern.tasks.*') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> My Tasks
    </a>
    <a href="{{ route('intern.certification') }}" class="nav-link {{ request()->routeIs('intern.certification') ? 'active' : '' }}">
        <i class="fas fa-certificate"></i> Certification
    </a>
    <a href="{{ route('intern.profile') }}" class="nav-link {{ request()->routeIs('intern.profile') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> My Profile
    </a>
@endsection

@section('topbar')
    <div class="d-flex gap-3 align-items-center">
        @if($account->status === 'active')
            <span class="badge bg-success bg-opacity-10 text-success border border-success"><i class="fas fa-check-circle me-1"></i> Active Intern</span>
        @else
            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning"><i class="fas fa-exclamation-triangle me-1"></i> {{ ucfirst($account->status) }}</span>
        @endif
        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary" target="_blank"><i class="fas fa-external-link-alt"></i> Site</a>
    </div>
@endsection

@section('content')
<div class="mb-4" data-aos="fade-down">
    <h3 style="font-family:'Outfit';font-weight:800;margin:0;letter-spacing:-0.02em;color:var(--text-primary);display:flex;align-items:center;gap:10px;">
        Welcome back, {{ auth()->user()->name }}! <span style="font-size:1.8rem">🚀</span>
    </h3>
    <p style="color:var(--text-secondary);font-size:1.05rem;margin-top:8px;">Tracking your journey towards excellence.</p>
</div>

<div class="row g-4 mb-4" data-aos="fade-up">
    {{-- Stats --}}
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(145deg, rgba(16, 185, 129, 0.1), transparent); border-color: rgba(16, 185, 129, 0.2);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-uppercase" style="font-size:0.75rem;letter-spacing:1px;font-weight:700;color:var(--text-secondary);">Score</div>
                <div style="background:rgba(16,185,129,0.15);color:#10b981;padding:6px;border-radius:8px;"><i class="fas fa-chart-line"></i></div>
            </div>
            <h2 style="font-family:'Outfit';font-weight:800;color:{{ $account->performance_score >= 60 ? '#10b981' : '#f05223' }};line-height:1;margin:0;">
                {{ $account->performance_score }}%
            </h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(145deg, rgba(255, 255, 255, 0.05), transparent);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-uppercase" style="font-size:0.75rem;letter-spacing:1px;font-weight:700;color:var(--text-secondary);">Completed</div>
                <div style="background:rgba(255,255,255,0.1);color:#fff;padding:6px;border-radius:8px;"><i class="fas fa-check-circle"></i></div>
            </div>
            <h2 style="font-family:'Outfit';font-weight:800;color:#fff;line-height:1;margin:0;">{{ $stats['completed_tasks'] ?? 0 }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(145deg, rgba(245, 158, 11, 0.1), transparent); border-color: rgba(245, 158, 11, 0.2);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-uppercase" style="font-size:0.75rem;letter-spacing:1px;font-weight:700;color:var(--text-secondary);">Pending</div>
                <div style="background:rgba(245,158,11,0.15);color:#f59e0b;padding:6px;border-radius:8px;"><i class="fas fa-hourglass-half"></i></div>
            </div>
            <h2 style="font-family:'Outfit';font-weight:800;color:#f59e0b;line-height:1;margin:0;">{{ $stats['pending_tasks'] ?? 0 }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(145deg, rgba(59, 130, 246, 0.1), transparent); border-color: rgba(59, 130, 246, 0.2);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-uppercase" style="font-size:0.75rem;letter-spacing:1px;font-weight:700;color:var(--text-secondary);">Remaining</div>
                <div style="background:rgba(59,130,246,0.15);color:#3b82f6;padding:6px;border-radius:8px;"><i class="fas fa-calendar-alt"></i></div>
            </div>
            <h2 style="font-family:'Outfit';font-weight:800;color:#3b82f6;line-height:1;margin:0;">{{ $stats['days_remaining'] ?? 0 }} <small style="font-size:1rem;color:var(--text-secondary)">days</small></h2>
        </div>
    </div>
</div>

<div class="row g-4" data-aos="fade-up" data-aos-delay="100">
    {{-- Recent Tasks --}}
    <div class="col-lg-8">
        <div class="stat-card" style="padding:0; overflow:hidden;">
            <div class="px-4 py-4 border-bottom" style="border-color: rgba(255,255,255,0.05) !important; display:flex; justify-content:space-between; align-items:center;">
                <h5 style="margin:0;font-family:'Outfit';font-weight:700;color:#fff;display:flex;align-items:center;gap:10px;">
                    <i class="fas fa-tasks text-primary"></i> Recent Tasks
                </h5>
                <a href="{{ route('intern.tasks.index') }}" class="btn-premium-outline" style="padding:6px 14px; font-size:0.8rem; border-radius:8px;">View All Tasks</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-dark mb-0 table-hover" style="border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr>
                            <th style="background:rgba(255,255,255,0.02)">Task details</th>
                            <th style="background:rgba(255,255,255,0.02)">Deadline</th>
                            <th style="background:rgba(255,255,255,0.02)">Status</th>
                            <th style="background:rgba(255,255,255,0.02)" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTasks as $task)
                        <tr>
                            <td>
                                <strong class="d-block text-white" style="font-size:1.05rem;">{{ $task->title }}</strong>
                                <small style="color:var(--text-secondary);font-size:0.85rem;">{{ Str::limit($task->description, 45) }}</small>
                            </td>
                            <td>
                                <span class="{{ \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status == 'pending' ? 'text-danger fw-bold' : 'text-v2-muted' }}">
                                    <i class="far fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($task->deadline)->format('d M, Y') }}
                                </span>
                            </td>
                            <td>
                                @if($task->status === 'pending') 
                                    <span class="badge rounded-pill" style="background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.3);padding:6px 12px;font-weight:600;">Pending</span>
                                @elseif($task->status === 'submitted') 
                                    <span class="badge rounded-pill" style="background:rgba(56,189,248,0.15);color:#38bdf8;border:1px solid rgba(56,189,248,0.3);padding:6px 12px;font-weight:600;">Under Review</span>
                                @elseif($task->status === 'approved') 
                                    <span class="badge rounded-pill" style="background:rgba(16,185,129,0.15);color:#10b981;border:1px solid rgba(16,185,129,0.3);padding:6px 12px;font-weight:600;">Approved ({{ $task->score }}%)</span>
                                @else 
                                    <span class="badge rounded-pill" style="background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.3);padding:6px 12px;font-weight:600;">Rejected</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('intern.tasks.show', $task) }}" class="btn" style="background:rgba(255,255,255,0.05);color:#fff;border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:6px 16px;font-size:0.85rem;font-weight:600;transition:all 0.3s;">Open <i class="fas fa-chevron-right ms-1" style="font-size:0.75rem;"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div style="color:var(--text-secondary);font-size:2rem;margin-bottom:10px;"><i class="fas fa-inbox"></i></div>
                                <div style="color:var(--text-primary);font-weight:600;">No tasks assigned yet.</div>
                                <small style="color:var(--text-secondary);">Your mentor will assign tasks soon.</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    {{-- Profile / Mentor Details --}}
    <div class="col-lg-4">
        <div class="stat-card mb-4" style="background: linear-gradient(145deg, rgba(56, 189, 248, 0.05), transparent); border: 1px solid rgba(56, 189, 248, 0.15) !important;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 style="color:#38bdf8;font-size:0.75rem;text-transform:uppercase;margin:0;letter-spacing:0.1em;font-weight:800"><i class="fas fa-chalkboard-teacher me-2"></i>Your Mentor</h6>
                <div style="background:rgba(56,189,248,0.1);padding:4px 8px;border-radius:6px;font-size:0.7rem;color:#38bdf8;font-weight:700;">PRO</div>
            </div>
            
            @if($account->mentor)
                <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($account->mentor->name) }}&background=0ea5e9&color=fff&size=50" alt="" class="rounded-circle border border-2 border-secondary" style="width:50px;height:50px">
                    <div>
                        <div style="font-weight:700;color:#fff;font-size:1.05rem">{{ $account->mentor->name }}</div>
                        <div style="font-size:0.8rem;color:var(--text-secondary)"><i class="fas fa-envelope text-primary me-1"></i> {{ $account->mentor->email }}</div>
                    </div>
                </div>
            @else
                <div class="p-4 rounded-4" style="background:rgba(255,255,255,0.02);text-align:center;border:1px dashed rgba(255,255,255,0.1);">
                    <div style="color:var(--text-secondary);font-size:1.5rem;margin-bottom:10px;"><i class="fas fa-user-clock"></i></div>
                    <div style="color:var(--text-primary);font-weight:600;font-size:0.9rem;">Assigning Mentor...</div>
                    <small style="color:var(--text-secondary);font-size:0.8rem;">A senior member will be assigned shortly.</small>
                </div>
            @endif
        </div>
        
        <div class="stat-card" style="background: linear-gradient(145deg, rgba(255, 255, 255, 0.03), transparent);">
            <h6 style="color:var(--text-secondary);font-size:0.75rem;text-transform:uppercase;margin-bottom:20px;letter-spacing:0.1em;font-weight:800"><i class="fas fa-id-badge me-2 text-white"></i>Internship Info</h6>
            <div class="d-flex justify-content-between py-3 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                <span class="text-v2-muted" style="font-size:0.9rem;">Specialization</span>
                <span class="text-white fw-bold" style="font-size:0.95rem;">{{ $account->category->name }}</span>
            </div>
            <div class="d-flex justify-content-between py-3 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                <span class="text-v2-muted" style="font-size:0.9rem;">Commencement</span>
                <span class="text-white fw-bold" style="font-size:0.95rem;">{{ \Carbon\Carbon::parse($account->start_date)->format('d M, Y') }}</span>
            </div>
            <div class="d-flex justify-content-between py-3">
                <span class="text-v2-muted" style="font-size:0.9rem;">Completion</span>
                <span class="text-white fw-bold" style="font-size:0.95rem;">{{ \Carbon\Carbon::parse($account->end_date)->format('d M, Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
