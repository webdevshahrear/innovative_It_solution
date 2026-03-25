@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title text-v2-white">Security & Identity</h1>
        <p class="page-subtitle text-v2-muted">Manage your administrative credentials and secure your account access.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Profile Info -->
        <div class="tech-card-v2 mb-4">
            <h5 class="fw-bold mb-4 pb-2 border-bottom border-v2" style="color: var(--v2-text-main);">
                <i class="fas fa-user-circle me-2 text-v2-primary"></i> Profile Information
            </h5>
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="tech-card-v2 mb-4">
            <h5 class="fw-bold mb-4 pb-2 border-bottom border-v2" style="color: var(--v2-text-main);">
                <i class="fas fa-key me-2 text-v2-secondary"></i> Update Password
            </h5>
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="tech-card-v2 border-danger-subtle">
            <h5 class="fw-bold mb-4 pb-2 border-bottom border-v2 text-danger">
                <i class="fas fa-exclamation-triangle me-2"></i> Danger Zone
            </h5>
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="tech-card-v2 sticky-top" style="top: 2rem;">
            <h6 class="fw-bold mb-3 text-v2-white">Account Security</h6>
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="status-glow active">MFA: ENFORCED</div>
            </div>
            <p class="small text-v2-muted">Your account is currently shielded with enterprise-grade encryption and multi-factor authentication protocols.</p>
            <hr class="border-v2 my-4">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-history text-v2-primary"></i>
                <span class="small text-v2-white">Last Activity: Just now</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-globe text-v2-secondary"></i>
                <span class="small text-v2-white">Access Level: Super Admin</span>
            </div>
        </div>
    </div>
</div>

<style>
    .text-v2-white { color: #fff; }
    .text-v2-muted { color: var(--v2-text-muted); }
    .border-v2 { border-color: var(--v2-border) !important; }
    .status-glow { font-size: 0.65rem; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 100px; display: inline-flex; align-items: center; gap: 0.5rem; }
    .status-glow::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    .status-glow.active { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .status-glow.active::before { background: #10b981; box-shadow: 0 0 8px #10b981; }
</style>
@endsection
