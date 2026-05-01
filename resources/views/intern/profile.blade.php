@extends('layouts.dashboard')
@section('title', 'My Profile')
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
        @endif
    </div>
@endsection

@section('content')
<div class="mb-4" data-aos="fade-down">
    <h3 style="font-family:'Outfit';font-weight:800;margin:0;letter-spacing:-0.02em;color:var(--text-primary);">
        <i class="fas fa-user-circle text-primary me-2"></i> My Profile
    </h3>
    <p style="color:var(--text-secondary);font-size:1.05rem;margin-top:8px;">Manage your account and view internship details.</p>
</div>

<div class="row g-4" data-aos="fade-up">
    {{-- Left Column --}}
    <div class="col-lg-4">
        <div class="stat-card text-center mb-4" style="background: linear-gradient(145deg, rgba(255,255,255,0.03), transparent);">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f05223&color=fff&size=120" alt="" class="rounded-circle border border-4 border-secondary mb-3 shadow-lg">
            <h4 style="font-family:'Outfit';font-weight:700;color:#fff;">{{ $user->name }}</h4>
            <p style="color:var(--text-secondary);margin-bottom:15px;">{{ $user->email }}</p>
            <div class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary px-3 py-2">
                {{ $account->category->name }} Intern
            </div>
        </div>

        <div class="stat-card" style="background: linear-gradient(145deg, rgba(56, 189, 248, 0.05), transparent); border: 1px solid rgba(56, 189, 248, 0.15) !important;">
            <h6 style="color:#38bdf8;font-size:0.75rem;text-transform:uppercase;margin-bottom:20px;letter-spacing:0.1em;font-weight:800"><i class="fas fa-chalkboard-teacher me-2"></i>Assigned Mentor</h6>
            @if($account->mentor)
                <div class="d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($account->mentor->name) }}&background=0ea5e9&color=fff&size=50" alt="" class="rounded-circle border border-2 border-secondary" style="width:50px;height:50px">
                    <div>
                        <div style="font-weight:700;color:#fff;font-size:1.05rem">{{ $account->mentor->name }}</div>
                        <div style="font-size:0.8rem;color:var(--text-secondary)"><i class="fas fa-envelope text-primary me-1"></i> {{ $account->mentor->email }}</div>
                    </div>
                </div>
            @else
                <div class="p-3 rounded-4 text-center" style="background:rgba(255,255,255,0.02);border:1px dashed rgba(255,255,255,0.1);">
                    <small style="color:var(--text-secondary);">No mentor assigned yet.</small>
                </div>
            @endif
        </div>
    </div>

    {{-- Right Column --}}
    <div class="col-lg-8">

        {{-- Edit Profile Form --}}
        <div class="stat-card mb-4" style="border:1px solid rgba(240,82,35,0.2) !important;">
            <h5 style="font-family:'Outfit';font-weight:700;color:#fff;margin-bottom:24px;border-bottom:1px solid rgba(255,255,255,0.05);padding-bottom:15px;">
                <i class="fas fa-edit me-2" style="color:#f05223;"></i>Edit Profile
            </h5>

            @if($errors->any())
                <div class="alert alert-danger rounded-3 border-0 bg-danger bg-opacity-10 text-danger mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('intern.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-12">
                        <label style="color:var(--text-secondary);font-size:0.8rem;text-transform:uppercase;letter-spacing:1px;font-weight:600;margin-bottom:6px;display:block;">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="form-control"
                            style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:10px;padding:12px 16px;"
                            required>
                    </div>
                    <div class="col-md-12">
                        <label style="color:var(--text-secondary);font-size:0.8rem;text-transform:uppercase;letter-spacing:1px;font-weight:600;margin-bottom:6px;display:block;">Email Address</label>
                        <input type="email" value="{{ $user->email }}" disabled
                            class="form-control"
                            style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);color:var(--text-secondary);border-radius:10px;padding:12px 16px;cursor:not-allowed;">
                        <small style="color:var(--text-secondary);font-size:0.75rem;">Email cannot be changed.</small>
                    </div>
                    <div class="col-12">
                        <hr style="border-color:rgba(255,255,255,0.06);margin:10px 0;">
                        <p style="color:#f05223;font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px;">
                            <i class="fas fa-lock me-1"></i> Change Password (optional)
                        </p>
                    </div>
                    <div class="col-md-12">
                        <label style="color:var(--text-secondary);font-size:0.8rem;text-transform:uppercase;letter-spacing:1px;font-weight:600;margin-bottom:6px;display:block;">Current Password</label>
                        <input type="password" name="current_password"
                            class="form-control"
                            style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:10px;padding:12px 16px;"
                            placeholder="Enter current password">
                    </div>
                    <div class="col-md-6">
                        <label style="color:var(--text-secondary);font-size:0.8rem;text-transform:uppercase;letter-spacing:1px;font-weight:600;margin-bottom:6px;display:block;">New Password</label>
                        <input type="password" name="password"
                            class="form-control"
                            style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:10px;padding:12px 16px;"
                            placeholder="Min 8 characters">
                    </div>
                    <div class="col-md-6">
                        <label style="color:var(--text-secondary);font-size:0.8rem;text-transform:uppercase;letter-spacing:1px;font-weight:600;margin-bottom:6px;display:block;">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                            class="form-control"
                            style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:10px;padding:12px 16px;"
                            placeholder="Repeat new password">
                    </div>
                    <div class="col-12 mt-2">
                        <button type="submit" class="btn-premium px-4 py-2" style="border:none;cursor:pointer;">
                            <i class="fas fa-save me-2"></i> Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Internship Timeline --}}
        <div class="stat-card">
            <h5 style="font-family:'Outfit';font-weight:700;color:#fff;margin-bottom:24px;border-bottom:1px solid rgba(255,255,255,0.05);padding-bottom:15px;">Internship Timeline</h5>
            
            <div class="d-flex align-items-center gap-4 mb-4">
                <div class="text-center">
                    <div style="width:50px;height:50px;border-radius:50%;background:rgba(16,185,129,0.1);color:#10b981;display:flex;align-items:center;justify-content:center;font-size:1.2rem;margin:0 auto 10px;">
                        <i class="fas fa-play"></i>
                    </div>
                    <div style="color:var(--text-secondary);font-size:0.8rem;text-transform:uppercase;letter-spacing:1px;font-weight:700;">Start Date</div>
                    <div style="color:#fff;font-weight:600;">{{ \Carbon\Carbon::parse($account->start_date)->format('d M, Y') }}</div>
                </div>
                
                <div style="flex-grow:1;height:2px;background:linear-gradient(to right, rgba(16,185,129,0.3), rgba(240,82,35,0.3));position:relative;">
                    <div style="position:absolute;top:-4px;left:50%;width:10px;height:10px;background:#fff;border-radius:50%;transform:translateX(-50%);box-shadow:0 0 10px rgba(255,255,255,0.5);"></div>
                </div>
                
                <div class="text-center">
                    <div style="width:50px;height:50px;border-radius:50%;background:rgba(240,82,35,0.1);color:#f05223;display:flex;align-items:center;justify-content:center;font-size:1.2rem;margin:0 auto 10px;">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                    <div style="color:var(--text-secondary);font-size:0.8rem;text-transform:uppercase;letter-spacing:1px;font-weight:700;">End Date</div>
                    <div style="color:#fff;font-weight:600;">{{ \Carbon\Carbon::parse($account->end_date)->format('d M, Y') }}</div>
                </div>
            </div>
            
            <div class="alert mt-4 mb-0 rounded-3 border-0" style="background:rgba(59,130,246,0.1);color:#3b82f6;">
                <i class="fas fa-info-circle me-2"></i> Ensure you submit all your tasks before the completion date to be eligible for certification.
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-control::placeholder { color: rgba(255,255,255,0.3); }
    .form-control:focus { background: rgba(255,255,255,0.06) !important; border-color: #f05223 !important; box-shadow: 0 0 0 3px rgba(240,82,35,0.15) !important; color: #fff !important; outline: none; }
</style>
@endpush
@endsection
