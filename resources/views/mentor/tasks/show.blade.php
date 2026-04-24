@extends('layouts.dashboard')
@section('title', 'Review Task')
@section('panel_type', 'Mentor Panel')

@section('sidebar')
    <a href="{{ route('mentor.dashboard') }}" class="nav-link">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('mentor.tasks.index') }}" class="nav-link active">
        <i class="fas fa-tasks"></i> Task Reviews
    </a>
@endsection

@section('content')
<div class="mb-4">
    <a href="{{ route('mentor.tasks.index') }}" class="btn-premium-outline mb-4" style="padding:8px 20px; font-size:0.9rem;">
        <i class="fas fa-arrow-left me-2"></i>Back to Tasks
    </a>
    <div class="d-flex justify-content-between align-items-center">
        <h2 style="font-family:'Outfit';font-weight:700;color:#fff;margin:0;letter-spacing:-0.02em;">{{ $task->title }}</h2>
        <div class="badge-v2">
            @if($task->status === 'pending') <span class="badge border border-warning text-warning bg-warning bg-opacity-10 px-3 py-2">Pending Submission</span>
            @elseif($task->status === 'submitted') <span class="badge border border-info text-info bg-info bg-opacity-10 px-3 py-2">Needs Review</span>
            @elseif($task->status === 'approved') <span class="badge border border-success text-success bg-success bg-opacity-10 px-3 py-2">Approved</span>
            @else <span class="badge border border-danger text-danger bg-danger bg-opacity-10 px-3 py-2">Rejected</span>
            @endif
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        {{-- Task Brief --}}
        <div class="stat-card mb-4" style="background:rgba(255,255,255,0.02)">
            <h6 style="color:var(--text-secondary);font-size:0.8rem;text-transform:uppercase;margin-bottom:12px;letter-spacing:0.1em;font-weight:700">Task Brief</h6>
            <div style="font-size:1rem;color:#cbd5e1;white-space:pre-wrap;line-height:1.6">{{ $task->description }}</div>
        </div>

        {{-- Submission Info --}}
        @if($task->submission)
            <div class="stat-card mb-4" style="border-color:rgba(14,165,233,0.3); background:rgba(14,165,233,0.05); box-shadow:0 15px 35px rgba(0,0,0,0.2)">
                <h5 style="font-family:'Outfit';font-weight:700;margin-bottom:20px;color:#38bdf8"><i class="fas fa-laptop-code me-2"></i>Intern's Submission</h5>
                <div class="text-white mb-4" style="font-size:1.05rem;white-space:pre-wrap;line-height:1.6">{{ $task->submission->submission_text }}</div>
                
                <div class="d-flex flex-wrap gap-3 mt-4 pt-4 border-top border-secondary">
                    @if($task->submission->live_url)
                        <a href="{{ $task->submission->live_url }}" target="_blank" class="btn-premium" style="background:linear-gradient(135deg, #0ea5e9, #0284c7); box-shadow:0 10px 20px rgba(14,165,233,0.2)">
                            <i class="fas fa-external-link-alt me-2"></i>View Live Demo
                        </a>
                    @endif
                    @if($task->submission->github_url)
                        <a href="{{ $task->submission->github_url }}" target="_blank" class="btn-premium-outline">
                            <i class="fab fa-github me-2"></i>Source Code
                        </a>
                    @endif
                </div>
            </div>

            {{-- Review Form --}}
            @if(in_array($task->status, ['submitted', 'rejected', 'approved']))
            <div class="stat-card border-top border-5" style="border-top-color:#10b981 !important;">
                <h5 style="font-family:'Outfit';font-weight:700;margin-bottom:24px"><i class="fas fa-gavel me-2 text-success"></i>Assess Submission</h5>
                
                <form action="{{ route('mentor.tasks.review', $task) }}" method="POST">
                    @csrf
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Decision</label>
                            <select name="status" class="form-select bg-white bg-opacity-5 text-white border-secondary rounded-3 p-3" required>
                                <option value="approved" class="bg-dark" {{ $task->status=='approved'?'selected':'' }}>Approve Submission (Pass)</option>
                                <option value="rejected" class="bg-dark" {{ $task->status=='rejected'?'selected':'' }}>Reject (Request Revisions)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Task Score (0-100) *</label>
                            <input type="number" name="score" class="form-control bg-white bg-opacity-5 text-white border-secondary rounded-3 p-3" min="0" max="100" value="{{ $task->score }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Feedback / Guidance *</label>
                        <textarea name="mentor_feedback" class="form-control bg-white bg-opacity-5 text-white border-secondary rounded-3 p-3" rows="4" required placeholder="Tell the intern what they did well and where to improve...">{{ $task->mentor_feedback }}</textarea>
                    </div>

                    <button type="submit" class="btn-premium px-5 py-3" style="background:linear-gradient(135deg, #10b981, #059669); box-shadow:0 10px 25px rgba(16,185,129,0.3)">
                        <i class="fas fa-check-circle me-2"></i>Submit Professional Review
                    </button>
                </form>
            </div>
            @endif
        @else
            <div class="stat-card text-center py-5 border-dashed" style="border-style:dashed !important;">
                <div class="mb-3">
                    <span class="fa-stack fa-2x">
                        <i class="fas fa-circle fa-stack-2x text-v2-muted opacity-10"></i>
                        <i class="fas fa-clock fa-stack-1x text-v2-muted opacity-50"></i>
                    </span>
                </div>
                <h5 class="text-white mb-2">Awaiting Submission</h5>
                <p class="text-v2-muted mb-0">The intern has not yet submitted their work for this task.</p>
            </div>
        @endif
    </div>

    <div class="col-lg-5">
        {{-- Intern Info --}}
        <div class="stat-card mb-4">
            <h6 style="color:var(--text-secondary);font-size:0.8rem;text-transform:uppercase;margin-bottom:16px;letter-spacing:0.1em;font-weight:700">Assigned Intern</h6>
            <div class="d-flex align-items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($task->internAccount->application->full_name) }}&background=3b82f6&color=fff" alt="" class="rounded-circle border border-2 border-secondary" style="width:56px;height:56px">
                <div>
                    <div style="font-weight:700;color:#fff;font-size:1.1rem">{{ $task->internAccount->application->full_name }}</div>
                    <div style="font-size:0.9rem;color:var(--text-secondary)"><i class="fas fa-layer-group me-1"></i> {{ $task->internAccount->category->name }} Specialist</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
             <h6 style="color:var(--text-secondary);font-size:0.8rem;text-transform:uppercase;margin-bottom:16px;letter-spacing:0.1em;font-weight:700">Internship Summary</h6>
             <div class="d-flex justify-content-between py-3 border-bottom border-secondary mb-1">
                <span class="text-v2-muted">Current Perf. Score</span>
                <span class="text-white fw-bold">{{ $task->internAccount->performance_score }}%</span>
            </div>
            <div class="d-flex justify-content-between py-3">
                <span class="text-v2-muted">Category</span>
                <span class="text-white fw-bold">{{ $task->internAccount->category->name }}</span>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
