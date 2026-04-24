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
    <a href="#" class="nav-link">
        <i class="fas fa-certificate"></i> Certification
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

@@section('content')
<div class="mb-4" data-aos="fade-down">
    <h3 style="font-family:'Outfit';font-weight:700;margin:0;letter-spacing:-0.02em;">Welcome back, {{ auth()->user()->name }}! 👋</h3>
    <p class="text-v2-muted">Tracking your progress and upcoming tasks.</p>
</div>

<div class="row g-4 mb-4" data-aos="fade-up">
    {{-- Stats --}}
    <div class="col-md-3">
        <div class="stat-card">
            <div class="text-v2-muted text-uppercase mb-2" style="font-size:0.75rem;letter-spacing:1px;font-weight:700">Performance Score</div>
            <h2 style="font-family:'Outfit';font-weight:800;color:{{ $account->performance_score >= 60 ? '#10b981' : '#f05223' }};line-height:1">
                {{ $account->performance_score }}%
            </h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="text-v2-muted text-uppercase mb-2" style="font-size:0.75rem;letter-spacing:1px;font-weight:700">Completed Tasks</div>
            <h2 style="font-family:'Outfit';font-weight:800;color:#fff;line-height:1">{{ $stats['completed_tasks'] }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="text-v2-muted text-uppercase mb-2" style="font-size:0.75rem;letter-spacing:1px;font-weight:700">Pending Tasks</div>
            <h2 style="font-family:'Outfit';font-weight:800;color:#f59e0b;line-height:1">{{ $stats['pending_tasks'] }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="text-v2-muted text-uppercase mb-2" style="font-size:0.75rem;letter-spacing:1px;font-weight:700">Days Remaining</div>
            <h2 style="font-family:'Outfit';font-weight:800;color:#3b82f6;line-height:1">{{ $stats['days_remaining'] }}</h2>
        </div>
    </div>
</div>

<div class="row g-4" data-aos="fade-up" data-aos-delay="100">
    {{-- Recent Tasks --}}
    <div class="col-lg-8">
        <div class="stat-card" style="padding:0; overflow:hidden;">
            <div class="px-4 py-3 border-bottom border-secondary bg-white bg-opacity-5 d-flex justify-content-between align-items-center">
                <h6 style="margin:0;font-family:'Outfit';font-weight:700;color:#fff">Recent Tasks</h6>
                <a href="{{ route('intern.tasks.index') }}" class="text-decoration-none" style="font-size:0.85rem;color:#f05223;font-weight:600">View All</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-dark mb-0">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTasks as $task)
                        <tr>
                            <td>
                                <strong class="d-block text-white">{{ $task->title }}</strong>
                                <small class="text-v2-muted">{{ Str::limit($task->description, 40) }}</small>
                            </td>
                            <td>
                                <span class="{{ \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status == 'pending' ? 'text-danger fw-bold' : 'text-v2-muted' }}">
                                    {{ \Carbon\Carbon::parse($task->deadline)->format('d M, Y') }}
                                </span>
                            </td>
                            <td>
                                @if($task->status === 'pending') <span class="badge bg-warning text-dark px-2">Pending</span>
                                @elseif($task->status === 'submitted') <span class="badge bg-info text-dark px-2">Under Review</span>
                                @elseif($task->status === 'approved') <span class="badge bg-success px-2">Approved ({{ $task->score }}%)</span>
                                @else <span class="badge bg-danger px-2">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('intern.tasks.show', $task) }}" class="btn-premium-outline" style="padding:6px 16px; font-size:0.85rem;">Open</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-v2-muted py-5">No tasks assigned yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    {{-- Profile / Mentor Details --}}
    <div class="col-lg-4">
        <div class="stat-card mb-4 border-info bg-info bg-opacity-5" style="border-color:rgba(14,165,233,0.3) !important;">
            <h6 style="color:#38bdf8;font-size:0.8rem;text-transform:uppercase;margin-bottom:20px;letter-spacing:0.1em;font-weight:700"><i class="fas fa-user-tie me-2"></i>Your Mentor</h6>
            @if($account->mentor)
                <div class="d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($account->mentor->name) }}&background=0ea5e9&color=fff&size=50" alt="" class="rounded-circle border border-2 border-secondary" style="width:56px;height:56px">
                    <div>
                        <div style="font-weight:700;color:#fff;font-size:1.1rem">{{ $account->mentor->name }}</div>
                        <div style="font-size:0.85rem;color:var(--text-secondary)"><i class="fas fa-envelope me-1"></i> {{ $account->mentor->email }}</div>
                    </div>
                </div>
            @else
                <div class="p-3 rounded-4" style="background:rgba(255,255,255,0.03);text-align:center;color:var(--text-secondary);font-size:0.85rem;border:1px dashed rgba(255,255,255,0.1)">
                    A mentor will be assigned to you soon.
                </div>
            @endif
        </div>
        
        <div class="stat-card">
            <h6 style="color:var(--text-secondary);font-size:0.8rem;text-transform:uppercase;margin-bottom:20px;letter-spacing:0.1em;font-weight:700">Internship Info</h6>
            <div class="d-flex justify-content-between py-3 border-bottom border-secondary mb-1">
                <span class="text-v2-muted">Specialization</span>
                <span class="text-white fw-bold">{{ $account->category->name }}</span>
            </div>
            <div class="d-flex justify-content-between py-3 border-bottom border-secondary mb-1">
                <span class="text-v2-muted">Commencement</span>
                <span class="text-white fw-bold">{{ \Carbon\Carbon::parse($account->start_date)->format('d M, Y') }}</span>
            </div>
            <div class="d-flex justify-content-between py-3">
                <span class="text-v2-muted">Completion Date</span>
                <span class="text-white fw-bold">{{ \Carbon\Carbon::parse($account->end_date)->format('d M, Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsectionion
