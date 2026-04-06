@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title text-white">Initialise Workflow Step</h1>
        <p class="page-subtitle text-v2-muted">Configure parameters for a new circular operational component.</p>
    </div>
    <a href="{{ route('admin.work-flows.index') }}" class="btn-tech-outline">
        <i class="fas fa-arrow-left me-2"></i> Back to Hub
    </a>
</div>

<div class="tech-card-v2 p-4">

    <form action="{{ route('admin.work-flows.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-4">
                    <label class="v2-form-label">STEP TITLE</label>
                    <input type="text" name="title" class="v2-admin-input w-100" required placeholder="e.g. Discovery">

                </div>
                <div class="mb-4">
                    <label class="v2-form-label">DESCRIPTION</label>
                    <textarea name="description" class="v2-admin-input w-100" rows="4" required placeholder="Describe the workflow step..."></textarea>

                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="v2-form-label">DISPLAY ORDER</label>
                    <input type="number" name="display_order" class="v2-admin-input w-100" required value="0">

                    <small class="text-v2-muted mt-2 d-block">Position in the 6-node circle (1-6 recommended)</small>
                </div>
                <div class="mb-0">
                    <label class="v2-form-label">VISUAL SIGNAL (ICON CLASS)</label>
                    <div class="input-group-v2">
                        <div class="v2-icon-preview" id="iconPreview">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <input type="text" name="icon_class" id="iconInput" class="v2-admin-input flex-1" required placeholder="fas fa-desktop" value="fas fa-rocket">

                    </div>
                    <small class="text-v2-muted mt-2 d-block">Use <a href="https://fontawesome.com/v6/icons" target="_blank" class="text-v2-primary">FontAwesome 6</a></small>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn-v2-primary px-5 py-3">
                <i class="fas fa-rocket me-2"></i> DEPLOY STEP
            </button>
        </div>
    </form>
</div>

<style>
    .tech-card-v2 { background: var(--v2-card); backdrop-filter: blur(10px); border: 1px solid var(--v2-border); border-radius: 24px; transition: all 0.4s; }
    .v2-form-label { display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v2-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; }
    .input-group-v2 { display: flex; gap: 1rem; align-items: center; }
    .v2-icon-preview { width: 48px; height: 48px; background: rgba(240, 82, 35, 0.1); border: 1px solid var(--v2-border); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--v2-primary); font-size: 1.5rem; transition: all 0.3s; }
    .btn-tech-outline { display: inline-flex; padding: 0.6rem 1.2rem; background: transparent; border: 1px solid var(--v2-border); color: var(--v2-text-muted); text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; transition: 0.3s; }
    .btn-tech-outline:hover { border-color: white; color: white; background: rgba(255,255,255,0.05); }
    .text-v2-muted { color: var(--v2-text-muted); font-size: 0.75rem; }
    .text-v2-primary { color: var(--v2-primary); text-decoration: none; }
    
    [data-theme="light"] .tech-card-v2 { background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    [data-theme="light"] .text-white { color: #1e293b !important; }
    [data-theme="light"] .btn-tech-outline:hover { color: var(--v2-primary); border-color: var(--v2-primary); }
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
