@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Deploy Project</h1>
        <p class="page-subtitle">Configure the metadata and assets for a new portfolio deployment.</p>
    </div>
    <a href="{{ route('admin.projects.index') }}" class="btn-tech-outline">
        <i class="fas fa-arrow-left me-2"></i> Back to Hub
    </a>
</div>

<div class="tech-card">
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-4">
                    <label for="title" class="v2-form-label">PROJECT TITLE</label>
                    <input type="text" class="v2-form-control" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Cyber Security Dashboard" required>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="v2-form-label">INTEL / DESCRIPTION</label>
                    <textarea class="v2-form-control" id="description" name="description" rows="6" placeholder="Project technical summary and highlights...">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="tags" class="v2-form-label">TECHNICAL TAGS (Comma Separated)</label>
                    <input type="text" class="v2-form-control" id="tags" name="tags" value="{{ old('tags') }}" placeholder="e.g. Elementor, WooCommerce, Payment">
                    <small style="color:rgba(255,255,255,0.3);font-size:0.75rem;">These tags appear on the public portfolio card.</small>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="client_name" class="v2-form-label">ENTITY / CLIENT</label>
                        <input type="text" class="v2-form-control" id="client_name" name="client_name" value="{{ old('client_name') }}" placeholder="Client organization name">
                    </div>
                    <div class="col-md-6">
                        <label for="project_url" class="v2-form-label">LIVE SECTOR URL</label>
                        <input type="url" class="v2-form-control" id="project_url" name="project_url" value="{{ old('project_url') }}" placeholder="https://project-link.com">
                    </div>
                    <div class="col-md-6">
                        <label for="display_order" class="v2-form-label">SEQUENCE ORDER</label>
                        <input type="number" class="v2-form-control" id="display_order" name="display_order" value="{{ old('display_order', 0) }}">
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                 <div class="mb-4">
                    <label for="status" class="v2-form-label">AVAILABILITY STATUS</label>
                    <select class="v2-form-control" id="status" name="status">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="v2-form-label">CAPABILITIES / CATEGORIES</label>
                    <div class="v2-checkbox-group">
                        @foreach($categories as $category)
                            <div class="v2-checkbox-item">
                                <input class="v2-checkbox-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat_{{ $category->id }}"
                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                <label class="v2-checkbox-label" for="cat_{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <label class="v2-form-label">DESKTOP ASSET SELECTION</label>
                    <div class="mb-3">
                        <label for="desktop_image" class="small text-v2-muted mb-2 d-block">OPTION A: UPLOAD LOCAL MEDIA</label>
                        <div class="v2-file-upload">
                            <input type="file" id="desktop_image" name="desktop_image">
                            <div class="v2-file-info"><i class="fas fa-upload me-2"></i> Uplink Media</div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label for="desktop_image_url" class="small text-v2-muted mb-2 d-block">OPTION B: REMOTE SIGNAL (URL)</label>
                        <input type="url" class="v2-form-control" id="desktop_image_url" name="desktop_image_url" value="{{ old('desktop_image_url') }}" placeholder="https://external-host.io/project-desktop.png">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="v2-form-label">MOBILE ASSET SELECTION</label>
                    <div class="mb-3">
                        <label for="mobile_image" class="small text-v2-muted mb-2 d-block">OPTION A: UPLOAD LOCAL MEDIA</label>
                        <div class="v2-file-upload">
                            <input type="file" id="mobile_image" name="mobile_image">
                            <div class="v2-file-info"><i class="fas fa-upload me-2"></i> Uplink Media</div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label for="mobile_image_url" class="small text-v2-muted mb-2 d-block">OPTION B: REMOTE SIGNAL (URL)</label>
                        <input type="url" class="v2-form-control" id="mobile_image_url" name="mobile_image_url" value="{{ old('mobile_image_url') }}" placeholder="https://external-host.io/project-mobile.png">
                    </div>
                    <small class="text-v2-muted mt-2 d-block">System prioritizes Uploaded Media if both are provided for a slot.</small>
                </div>

                <div class="v2-switch-item">
                    <div class="v2-switch">
                        <input type="checkbox" id="featured" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                        <label for="featured"></label>
                    </div>
                    <label class="v2-form-label mb-0" for="featured">PRIORITIZE AS FEATURED</label>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn-tech-primary px-5 py-3">
                <i class="fas fa-rocket me-2"></i> ACTIVATE DEPLOYMENT
            </button>
        </div>
    </form>
</div>

<style>
    .v2-form-label {
        display: block;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.1rem;
        color: var(--v2-text-muted);
        margin-bottom: 0.75rem;
        text-transform: uppercase;
    }

    .v2-form-control {
        width: 100%;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--v2-border);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s;
    }
    .v2-form-control:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--v2-primary);
        box-shadow: 0 0 15px rgba(240, 82, 35, 0.1);
    }
    .v2-form-control::placeholder { color: rgba(255,255,255,0.2); }

    .v2-checkbox-group {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--v2-border);
        border-radius: 12px;
        padding: 1rem;
        max-height: 200px;
        overflow-y: auto;
    }
    .v2-checkbox-item { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; }
    .v2-checkbox-input { cursor: pointer; accent-color: var(--v2-primary); }
    .v2-checkbox-label { color: rgba(255,255,255,0.7); font-size: 0.85rem; cursor: pointer; }

    .v2-file-upload {
        position: relative;
        height: 45px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px dashed var(--v2-border);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }
    .v2-file-upload:hover { border-color: var(--v2-primary); background: rgba(255, 255, 255, 0.05); }
    .v2-file-upload input { position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
    .v2-file-info { font-size: 0.8rem; color: var(--v2-text-muted); font-weight: 600; }

    .v2-switch-item { display: flex; align-items: center; gap: 1rem; background: rgba(255,255,255,0.02); padding: 1rem; border-radius: 12px; border: 1px solid var(--v2-border); }
    .v2-switch { position: relative; width: 44px; height: 22px; }
    .v2-switch input { opacity: 0; width: 0; height: 0; }
    .v2-switch label { 
        position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; 
        background-color: rgba(255,255,255,0.1); transition: .4s; border-radius: 22px; 
    }
    .v2-switch label:before { 
        position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px; 
        background-color: white; transition: .4s; border-radius: 50%;
    }
    .v2-switch input:checked + label { background: var(--v2-gradient); }
    .v2-switch input:checked + label:before { transform: translateX(22px); }

    .btn-tech-outline {
        display: inline-flex;
        padding: 0.6rem 1.2rem;
        background: transparent;
        border: 1px solid var(--v2-border);
        color: var(--v2-text-muted);
        text-decoration: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.8rem;
        transition: 0.3s;
    }
    .btn-tech-outline:hover { border-color: white; color: white; background: rgba(255,255,255,0.05); }
</style>
@endsection
