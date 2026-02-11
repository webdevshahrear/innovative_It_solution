@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Recalibrate Metric</h1>
        <p class="page-subtitle">Update parameters and telemetry values for the existing component.</p>
    </div>
    <a href="{{ route('admin.statistics.index') }}" class="btn-tech-outline">
        <i class="fas fa-arrow-left me-2"></i> Back to Hub
    </a>
</div>

<div class="tech-card">
    <form action="{{ route('admin.statistics.update', $statistic->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="v3-form-label">METRIC LABEL</label>
                    <input type="text" name="stat_label" class="v3-form-control" required value="{{ $statistic->stat_label }}" placeholder="Display name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="v3-form-label">TELEMETRY VALUE</label>
                    <input type="text" name="stat_value" class="v3-form-control" required value="{{ $statistic->stat_value }}" placeholder="e.g. 500+">
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-0">
                    <label class="v3-form-label">VISUAL SIGNAL (ICON CLASS)</label>
                    <input type="text" name="icon_class" class="v3-form-control" required value="{{ $statistic->icon_class }}" placeholder="fas fa-users">
                    <small class="text-v3-muted mt-2 d-block">Update signal identifier for frontend rendering.</small>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn-tech-primary px-5 py-3">
                <i class="fas fa-sync-alt me-2"></i> UPDATE METRIC
            </button>
        </div>
    </form>
</div>

<style>
    .v3-form-label { display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v3-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; }
    .v3-form-control { width: 100%; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--v3-border); border-radius: 12px; padding: 0.75rem 1rem; color: white; font-size: 0.9rem; transition: all 0.3s; }
    .v3-form-control:focus { outline: none; background: rgba(255, 255, 255, 0.05); border-color: var(--v3-accent); box-shadow: 0 0 15px rgba(99, 102, 241, 0.1); }
    .v3-form-control::placeholder { color: rgba(255,255,255,0.2); }

    .btn-tech-outline { display: inline-flex; padding: 0.6rem 1.2rem; background: transparent; border: 1px solid var(--v3-border); color: var(--v3-text-muted); text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; transition: 0.3s; }
    .btn-tech-outline:hover { border-color: white; color: white; background: rgba(255,255,255,0.05); }
    .text-v3-muted { color: rgba(255,255,255,0.4); font-size: 0.75rem; }
</style>
@endsection
