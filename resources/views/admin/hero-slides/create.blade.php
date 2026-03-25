@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Initialize Slide</h1>
        <p class="page-subtitle">Configure parameters for a new high-impact visual component.</p>
    </div>
    <a href="{{ route('admin.hero-slides.index') }}" class="btn-tech-outline">
        <i class="fas fa-arrow-left me-2"></i> Back to Hub
    </a>
</div>

<div class="tech-card">
    <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-4">
                    <label for="title" class="v2-form-label">SLIDE IDENTIFIER (TITLE)</label>
                    <input type="text" class="v2-form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Primary attention-grabbing headline" required>
                </div>

                <div class="mb-4">
                    <label for="subtitle" class="v2-form-label">CAPTION LOGIC (SUBTITLE)</label>
                    <textarea class="v2-form-control" id="subtitle" name="subtitle" rows="3" placeholder="Secondary technical briefing...">{{ old('subtitle') }}</textarea>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="button_text" class="v2-form-label">ACTION LABEL</label>
                        <input type="text" class="v2-form-control" id="button_text" name="button_text" value="{{ old('button_text', 'Learn More') }}" placeholder="Button Display Text">
                    </div>
                    <div class="col-md-6">
                        <label for="button_link" class="v2-form-label">TARGET UPLINK (URL)</label>
                        <input type="text" class="v2-form-control" id="button_link" name="button_link" value="{{ old('button_link', '#') }}" placeholder="e.g. /services or https://...">
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="mb-4">
                    <label for="status" class="v2-form-label">DEPLOYMENT STATUS</label>
                    <select class="v2-form-control" id="status" name="status">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="display_order" class="v2-form-label">SEQUENCE PRIORITY</label>
                    <input type="number" class="v2-form-control" id="display_order" name="display_order" value="{{ old('display_order', 0) }}">
                </div>

                <div class="mb-4">
                    <label class="v2-form-label">VISUAL ASSET SELECTION</label>
                    <div class="mb-3">
                        <label for="image_path" class="small text-v2-muted mb-2 d-block">OPTION A: UPLOAD LOCAL MEDIA</label>
                        <div class="v2-file-upload">
                            <input type="file" id="image_path" name="image_path">
                            <div class="v2-file-info"><i class="fas fa-upload me-2"></i> Uplink Media</div>
                        </div>
                    </div>
                    
                    <div class="mb-0">
                        <label for="image_url" class="small text-v2-muted mb-2 d-block">OPTION B: REMOTE SIGNAL (IMAGE URL)</label>
                        <input type="url" class="v2-form-control" id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="https://external-host.io/image.png">
                    </div>
                    <small class="text-v2-muted mt-2 d-block">System prioritizes Uploaded Media if both are provided.</small>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn-tech-primary px-5 py-3">
                <i class="fas fa-rocket me-2"></i> DEPLOY COMPONENT
            </button>
        </div>
    </form>
</div>

<style>
<style>
    .v2-form-label { display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v2-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; }
    .v2-form-control { width: 100%; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--v2-border); border-radius: 12px; padding: 0.75rem 1rem; color: white; font-size: 0.9rem; transition: all 0.3s; }
    .v2-form-control:focus { outline: none; background: rgba(255, 255, 255, 0.05); border-color: var(--v2-primary); box-shadow: 0 0 15px rgba(240, 82, 35, 0.1); }
    .v2-form-control::placeholder { color: rgba(255,255,255,0.2); }

    .v2-file-upload { position: relative; height: 45px; background: rgba(255, 255, 255, 0.03); border: 1px dashed var(--v2-border); border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: 0.3s; }
    .v2-file-upload:hover { border-color: var(--v2-primary); background: rgba(255, 255, 255, 0.05); }
    .v2-file-upload input { position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
    .v2-file-info { font-size: 0.8rem; color: var(--v2-text-muted); font-weight: 600; }

    .btn-tech-outline { display: inline-flex; padding: 0.6rem 1.2rem; background: transparent; border: 1px solid var(--v2-border); color: var(--v2-text-muted); text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; transition: 0.3s; }
    .btn-tech-outline:hover { border-color: white; color: white; background: rgba(255,255,255,0.05); }
    .text-v2-muted { color: rgba(255,255,255,0.4); font-size: 0.75rem; }
</style>
</style>
@endsection
