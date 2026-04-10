@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Initialise Metric</h1>
        <p class="page-subtitle">Configure parameters for a new performance counter component.</p>
    </div>
    <a href="{{ route('admin.statistics.index') }}" class="btn-tech-outline">
        <i class="fas fa-arrow-left me-2"></i> Back to Hub
    </a>
</div>

<div class="tech-card-v2">
    <form action="{{ route('admin.statistics.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="v2-form-label">METRIC UNIQUE KEY</label>
                    <input type="text" name="stat_key" class="v2-admin-input w-100 @error('stat_key') is-invalid @enderror" required value="{{ old('stat_key') }}" placeholder="e.g. happy_clients">
                    @error('stat_key')
                        <div class="invalid-feedback text-danger small mt-2">{{ $message }}</div>
                    @enderror
                    <small class="text-v2-muted mt-2 d-block">System-level unique identifier (Slug style)</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="v2-form-label">DEPLOYMENT STATUS</label>
                    <select name="status" class="v2-admin-input w-100" required>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>ACTIVE</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>INACTIVE</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="v2-form-label">METRIC LABEL</label>
                    <input type="text" name="stat_label" class="v2-admin-input w-100 @error('stat_label') is-invalid @enderror" required value="{{ old('stat_label') }}" placeholder="e.g. Happy Clients">
                    @error('stat_label')
                        <div class="invalid-feedback text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="v2-form-label">TELEMETRY VALUE</label>
                    <input type="text" name="stat_value" class="v2-admin-input w-100 @error('stat_value') is-invalid @enderror" required value="{{ old('stat_value') }}" placeholder="e.g. 500+">
                    @error('stat_value')
                        <div class="invalid-feedback text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-0">
                    <label class="v2-form-label">VISUAL SIGNAL (ICON CLASS)</label>
                    <div class="input-group-v2">
                        <div class="v2-icon-preview" id="iconPreview">
                            <i class="{{ old('icon_class', 'fas fa-rocket') }}"></i>
                        </div>
                        <input type="text" name="icon_class" id="iconInput" class="v2-admin-input flex-1 @error('icon_class') is-invalid @enderror" required placeholder="fas fa-users" value="{{ old('icon_class', 'fas fa-rocket') }}">
                    </div>
                    @error('icon_class')
                        <div class="invalid-feedback text-danger small mt-2">{{ $message }}</div>
                    @enderror
                    <small class="text-v2-muted mt-2 d-block">Use <a href="https://fontawesome.com/v6/icons" target="_blank" class="text-v2-primary">FontAwesome 6 Reference</a></small>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn-tech-primary px-5 py-3">
                <i class="fas fa-rocket me-2"></i> DEPLOY METRIC
            </button>
        </div>
    </form>
</div>

<style>
    .tech-card-v2 { background: var(--v2-card); backdrop-filter: blur(10px); border: 1px solid var(--v2-border); border-radius: 24px; padding: 40px; transition: all 0.4s; }
    .v2-form-label { display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v2-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; }
    
    .input-group-v2 { display: flex; gap: 1rem; align-items: center; }
    .v2-icon-preview { width: 48px; height: 48px; background: rgba(240, 82, 35, 0.1); border: 1px solid var(--v2-border); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--v2-primary); font-size: 1.5rem; transition: all 0.3s; }

    .btn-tech-outline { display: inline-flex; padding: 0.6rem 1.2rem; background: transparent; border: 1px solid var(--v2-border); color: var(--v2-text-muted); text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; transition: 0.3s; }
    .btn-tech-outline:hover { border-color: white; color: white; background: rgba(255,255,255,0.05); }
    .text-v2-muted { color: var(--v2-text-muted); font-size: 0.75rem; }
    .text-v2-primary { color: var(--v2-primary); text-decoration: none; }

    [data-theme="light"] .tech-card-v2 { background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    [data-theme="light"] .page-title { color: #0f172a !important; }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const iconInput = document.getElementById('iconInput');
        const iconPreview = document.getElementById('iconPreview');

        iconInput.addEventListener('input', function() {
            const iconClass = this.value || 'fas fa-question';
            iconPreview.innerHTML = `<i class="${iconClass}"></i>`;
        });
    });
</script>
@endsection
