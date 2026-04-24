@extends('layouts.dashboard')
@section('title', 'Mentor Dashboard')
@section('panel_type', 'Mentor Panel')

@section('sidebar')
    <a href="{{ route('mentor.dashboard') }}" class="nav-link {{ request()->routeIs('mentor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('mentor.tasks.index') }}" class="nav-link {{ request()->routeIs('mentor.tasks.*') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> Task Reviews
    </a>
@endsection

@section('topbar')
    <div class="d-flex gap-3 align-items-center">
        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary"><i class="fas fa-chalkboard-teacher me-1"></i> Mentor Account</span>
    </div>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 style="font-family:'Outfit';font-weight:700;margin:0">Mentor Dashboard</h3>
    <a href="{{ route('mentor.tasks.create') }}" class="btn-premium">
        <i class="fas fa-plus me-2"></i>Assign Task
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="text-v2-muted text-uppercase mb-2" style="font-size:0.75rem;letter-spacing:1px">My Interns</div>
            <h2 style="font-family:'Outfit';font-weight:800;color:#fff">{{ $stats['total_interns'] }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="text-v2-muted text-uppercase mb-2" style="font-size:0.75rem;letter-spacing:1px">Pending Reviews</div>
            <h2 style="font-family:'Outfit';font-weight:800;color:#f59e0b">{{ $stats['pending_reviews'] }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="text-v2-muted text-uppercase mb-2" style="font-size:0.75rem;letter-spacing:1px">Tasks Assigned</div>
            <h2 style="font-family:'Outfit';font-weight:800;color:#3b82f6">{{ $stats['tasks_assigned'] }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="text-v2-muted text-uppercase mb-2" style="font-size:0.75rem;letter-spacing:1px">Approved Tasks</div>
            <h2 style="font-family:'Outfit';font-weight:800;color:#10b981">{{ $stats['tasks_approved'] }}</h2>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Interns List --}}
    <div class="col-lg-4">
        <div class="stat-card" style="padding:0; overflow:hidden;">
            <div class="px-4 py-3 border-bottom border-secondary bg-white bg-opacity-5">
                <h6 style="margin:0;font-family:'Outfit';font-weight:600">My Assigned Interns</h6>
            </div>
            <div class="list-group list-group-flush bg-transparent">
                @forelse($interns as $intern)
                <div class="list-group-item bg-transparent border-secondary py-3 px-4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($intern->application->full_name) }}&background=3b82f6&color=fff&size=50" class="rounded-circle border border-2 border-secondary" alt="">
                        <div>
                            <div class="fw-bold text-white">{{ $intern->application->full_name }}</div>
                            <div style="font-size:0.8rem;color:var(--text-secondary)">{{ $intern->category->name }}</div>
                        </div>
                        <div class="ms-auto" style="text-align:right">
                            <span class="badge border border-success text-success bg-success bg-opacity-10 px-2">{{ $intern->performance_score }}%</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">No interns assigned to you yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Pending Reviews --}}
    <div class="col-lg-8">
        <div class="stat-card" style="padding:0; overflow:hidden;">
            <div class="px-4 py-3 border-bottom border-secondary bg-white bg-opacity-5 d-flex justify-content-between align-items-center">
                <h6 style="margin:0;font-family:'Outfit';font-weight:600">Recent Task Submissions</h6>
                <a href="{{ route('mentor.tasks.index') }}" class="text-decoration-none" style="font-size:0.85rem;color:#f05223">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-dark mb-0">
                    <thead>
                        <tr>
                            <th>Intern</th>
                            <th>Task Title</th>
                            <th>Submitted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingReviews as $review)
                        <tr>
                            <td>
                                <div class="fw-bold text-white">{{ $review->internAccount->application->full_name }}</div>
                            </td>
                            <td>
                                <span class="d-block text-v2-muted">{{ Str::limit($review->title, 40) }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($review->submission->submitted_at)->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('mentor.tasks.show', $review) }}" class="btn-premium-outline" style="padding:6px 14px; font-size:0.8rem;">Review</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-v2-muted py-5">
                                <i class="fas fa-check-circle fs-3 text-success mb-2 opacity-50"></i><br>
                                No pending task submissions.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
