@extends('layouts.dashboard')
@section('title', 'Task Details')
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

@section('content')
<div class="mb-5" data-aos="fade-down">
    <a href="{{ route('intern.tasks.index') }}" class="btn-premium-outline mb-4" style="padding:8px 20px; font-size:0.9rem;">
        <i class="fas fa-arrow-left me-2"></i>Back to Tasks
    </a>
    <h2 style="font-family:'Outfit';font-weight:700;color:#fff;margin:0;letter-spacing:-0.02em;">{{ $task->title }}</h2>
</div>

<div class="row g-4">
    <div class="col-lg-8" data-aos="fade-up">
        {{-- Task Details --}}
        <div class="stat-card mb-4" style="background:rgba(255,255,255,0.02)">
            <h5 style="font-family:'Outfit';font-weight:700;margin-bottom:20px;color:#fff"><i class="fas fa-file-alt me-2 text-warning"></i>Task Assignment Brief</h5>
            <div style="white-space:pre-wrap;color:#cbd5e1;font-size:1.05rem;line-height:1.7">{{ $task->description }}</div>
            
            @if($task->resources)
                <div class="mt-4 pt-4 border-top border-secondary">
                    <h6 style="color:#fff;font-weight:700;margin-bottom:12px;text-transform:uppercase;font-size:0.8rem;letter-spacing:0.1em;"><i class="fas fa-link me-2 text-primary"></i>Learning Resources & Reference Links</h6>
                    <div style="white-space:pre-wrap;color:#94a3b8;font-size:0.95rem;line-height:1.6">{{ $task->resources }}</div>
                </div>
            @endif
        </div>

        {{-- Submission Form or Status --}}
        <div class="stat-card">
            @if(in_array($task->status, ['submitted', 'approved', 'rejected']))
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 style="font-family:'Outfit';font-weight:700;margin:0"><i class="fas fa-check-circle me-2 text-success"></i>Your Submission History</h5>
                    <span class="badge border border-info text-info bg-info bg-opacity-10 px-3 py-2" style="text-transform:uppercase; font-size:0.7rem; letter-spacing:0.05em">Attempt #1</span>
                </div>
                
                <div class="p-4 rounded-4" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.05)">
                    <div style="font-size:0.75rem;color:var(--text-secondary);margin-bottom:12px;text-transform:uppercase;font-weight:800;letter-spacing:0.1em">Intern Submission Notes</div>
                    <div style="color:#fff;font-size:1.05rem;white-space:pre-wrap;margin-bottom:24px;line-height:1.6">{{ $task->submission->submission_text }}</div>
                    
                    @if($task->submission->live_url || $task->submission->github_url)
                        <div class="d-flex flex-wrap gap-3 mt-3">
                            @if($task->submission->live_url)
                                <a href="{{ $task->submission->live_url }}" target="_blank" class="btn-premium" style="background:linear-gradient(135deg, #0ea5e9, #0284c7); padding:8px 20px; font-size:0.9rem">
                                    <i class="fas fa-external-link-alt me-2"></i>Live Demo URL
                                </a>
                            @endif
                            @if($task->submission->github_url)
                                <a href="{{ $task->submission->github_url }}" target="_blank" class="btn-premium-outline" style="padding:8px 20px; font-size:0.9rem">
                                    <i class="fab fa-github me-2"></i>Source Code Repo
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                @if($task->status === 'approved' || $task->status === 'rejected')
                    <div class="mt-5 pt-4 border-top border-secondary">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                             <h5 style="font-family:'Outfit';font-weight:700;margin:0"><i class="fas fa-comment-dots me-2 text-warning"></i>Expert Mentor Review</h5>
                             <div class="text-white fw-bold px-3 py-2 rounded-pill bg-white bg-opacity-5 border border-secondary">
                                Score: <span style="font-size:1.2rem; color:{{ $task->status==='approved'?'#10b981':'#ef4444' }}">{{ $task->score ?? '0' }}</span> / 100
                             </div>
                        </div>
                        
                        <div class="p-4 rounded-4 {{ $task->status==='approved'?'border-success':'border-danger' }} border border-opacity-25" style="background:{{ $task->status==='approved'?'rgba(16,185,129,0.05)':'rgba(220,38,38,0.05)' }}">
                            <div style="white-space:pre-wrap;color:#cbd5e1;line-height:1.7;font-size:1rem">{{ $task->mentor_feedback }}</div>
                        </div>
                    </div>
                @endif
                
            @else
                <h5 style="font-family:'Outfit';font-weight:700;margin-bottom:24px"><i class="fas fa-upload me-2 text-primary"></i>Final Project Submission</h5>
                
                <form action="{{ route('intern.tasks.submit', $task) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">What have you accomplished? *</label>
                        <textarea name="submission_text" class="form-control bg-white bg-opacity-5 text-white border-secondary rounded-3 p-3" rows="5" required placeholder="Detail your solution, challenges faced, and any specific implementation details..."></textarea>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Live Project / Demo Link</label>
                            <input type="url" name="live_url" class="form-control bg-white bg-opacity-5 text-white border-secondary rounded-3 p-3" placeholder="https://your-site.vercel.app">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">GitHub / Code Repository</label>
                            <input type="url" name="github_url" class="form-control bg-white bg-opacity-5 text-white border-secondary rounded-3 p-3" placeholder="https://github.com/username/project">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-premium px-5 py-3">
                        <i class="fas fa-paper-plane me-2"></i>Send for Expert Review
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="col-lg-4" data-aos="fade-left">
        {{-- Metadata --}}
        <div class="stat-card mb-4 bg-white bg-opacity-5">
            <h6 style="color:var(--text-secondary);font-size:0.8rem;text-transform:uppercase;margin-bottom:20px;letter-spacing:0.1em;font-weight:700">Project Meta-Details</h6>
            
            <div class="mb-4">
                <span class="d-block text-v2-muted small text-uppercase fw-bold mb-2" style="font-size:0.65rem">Current Status</span>
                @if($task->status === 'pending') 
                    <span class="badge border border-warning text-warning bg-warning bg-opacity-10 px-3 py-2 w-100 text-start" style="font-size:0.85rem"><i class="fas fa-clock me-2"></i>Pending Submission</span>
                @elseif($task->status === 'submitted') 
                    <span class="badge border border-info text-info bg-info bg-opacity-10 px-3 py-2 w-100 text-start" style="font-size:0.85rem"><i class="fas fa-search me-2"></i>Under Evaluation</span>
                @elseif($task->status === 'approved') 
                    <span class="badge border border-success text-success bg-success bg-opacity-10 px-3 py-2 w-100 text-start" style="font-size:0.85rem"><i class="fas fa-check-double me-2"></i>Submission Approved</span>
                @else 
                    <span class="badge border border-danger text-danger bg-danger bg-opacity-10 px-3 py-2 w-100 text-start" style="font-size:0.85rem"><i class="fas fa-times-circle me-2"></i>Revisions Requested</span>
                @endif
            </div>

            <div class="mb-4">
                <span class="d-block text-v2-muted small text-uppercase fw-bold mb-2" style="font-size:0.65rem">Submission Deadline</span>
                <div class="text-white fw-bold p-3 rounded-3" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.05)">
                     <i class="fas fa-calendar-day me-2 text-primary"></i> {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y, h:i A') }}
                </div>
            </div>

            <div class="mb-4">
                <span class="d-block text-v2-muted small text-uppercase fw-bold mb-2" style="font-size:0.65rem">Priority Level</span>
                <div class="text-white fw-bold px-3 py-2 rounded-pill d-inline-block" style="background:{{ $task->priority == 'urgent' ? '#ef4444' : ($task->priority == 'high' ? '#f59e0b' : '#3b82f6') }}15; border:1px solid {{ $task->priority == 'urgent' ? '#ef4444' : ($task->priority == 'high' ? '#f59e0b' : '#3b82f6') }}30; color:{{ $task->priority == 'urgent' ? '#ef4444' : ($task->priority == 'high' ? '#f59e0b' : '#3b82f6') }} !important; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.05em">
                     <i class="fas fa-exclamation-circle me-1"></i> {{ $task->priority }}
                </div>
            </div>

            <div class="pt-3 border-top border-secondary mt-2">
                <span class="d-block text-v2-muted small text-uppercase fw-bold mb-3" style="font-size:0.65rem">Reviewer Info</span>
                <div class="d-flex align-items-center gap-2">
                     <img src="https://ui-avatars.com/api/?name={{ urlencode($task->assignedBy->name ?? 'Mentor') }}&background=f05223&color=fff" class="rounded-circle border border-secondary" style="width:32px;height:32px">
                     <span class="text-white fw-bold">{{ $task->assignedBy->name ?? 'Head Mentor' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
