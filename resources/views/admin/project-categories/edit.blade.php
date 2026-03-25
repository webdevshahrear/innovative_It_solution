@extends('layouts.admin')

@section('content')
<div class="v2-page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('admin.project-categories.index') }}" class="btn-link-glow mb-2 d-inline-block"><i class="fas fa-arrow-left me-1"></i> Back to Categories</a>
            <h2 class="v2-page-title m-0">Edit Category: <span class="text-v2-primary">{{ $project_category->name }}</span></h2>
            <p class="v2-page-subtitle mt-1 mb-0">Modify the taxonomy details below.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="tech-card">
            <form action="{{ route('admin.project-categories.update', $project_category->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="v2-form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control v2-form-control @error('name') is-invalid @enderror" value="{{ old('name', $project_category->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback text-v2-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="slug" class="v2-form-label">Custom Slug (Optional)</label>
                    <input type="text" name="slug" id="slug" class="form-control v2-form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $project_category->slug) }}">
                    @error('slug')
                        <div class="invalid-feedback text-v2-danger">{{ $message }}</div>
                    @enderror
                    <small class="text-v2-muted d-block mt-2"><i class="fas fa-info-circle me-1"></i> A URL-friendly version of the name. If left blank, it will generate automatically from the name.</small>
                </div>

                <div class="d-flex justify-content-end mt-5 border-top border-secondary pt-4" style="border-color: rgba(255,255,255,0.05) !important;">
                    <button type="submit" class="btn-tech-primary shadow-glow px-4 py-2">
                        <i class="fas fa-sync-alt me-2"></i> Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="tech-card" style="background: rgba(239, 68, 68, 0.05); border-color: rgba(239, 68, 68, 0.2);">
            <h5 class="text-white mb-3"><i class="fas fa-exclamation-triangle text-v2-danger me-2"></i> Warning</h5>
            <p class="text-v2-muted" style="font-size: 0.9rem; line-height: 1.6;">
                Changing the <strong class="text-v2-danger">slug</strong> of an active category will break any external links pointing directly to that category archive. Only change if absolutely necessary.
            </p>
        </div>
    </div>
</div>

<style>
    .btn-link-glow { 
        color: var(--v2-muted); text-decoration: none; font-size: 0.85rem; font-weight: 700; 
        transition: 0.3s; padding: 0.3rem 0;
    }
    .btn-link-glow:hover { color: white; text-shadow: 0 0 10px rgba(255,255,255,0.5); }
    
    .v2-form-label {
        font-weight: 800;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.1rem;
        color: var(--v2-text-muted);
        margin-bottom: 0.75rem;
        display: block;
    }

    .v2-form-control {
        width: 100%;
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid var(--v2-border) !important;
        color: white !important;
        border-radius: 12px;
        padding: 0.8rem 1.25rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .v2-form-control:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.05) !important;
        border-color: var(--v2-primary) !important;
        box-shadow: 0 0 15px rgba(240, 82, 35, 0.1) !important;
    }

    .v2-form-control::placeholder {
        color: rgba(255, 255, 255, 0.2);
    }
</style>
@endsection
