@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Modify Protocol</h1>
        <p class="page-subtitle">Update logic and parameters for the existing system service.</p>
    </div>
    <a href="{{ route('admin.services.index') }}" class="btn-tech-outline">
        <i class="fas fa-arrow-left me-2"></i> Back to Catalog
    </a>
</div>

<div class="tech-card">
    <form action="{{ route('admin.services.update', $service) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-4">
                    <label for="title" class="v3-form-label">PROTOCOL IDENTITY</label>
                    <input type="text" class="v3-form-control" id="title" name="title" value="{{ old('title', $service->title) }}" placeholder="e.g. Cloud Architecture Design" required>
                </div>

                <div class="mb-4">
                    <label for="icon_class" class="v3-form-label">ICON SIGNATURE (Font Awesome)</label>
                    <input type="text" class="v3-form-control" id="icon_class" name="icon_class" value="{{ old('icon_class', $service->icon_class) }}" placeholder="fas fa-code-branch">
                </div>
                
                <div class="mb-4">
                    <label for="short_description" class="v3-form-label">BRIEFING (SHORT DESC)</label>
                    <textarea class="v3-form-control" id="short_description" name="short_description" rows="3" placeholder="Truncated technical summary for listing...">{{ old('short_description', $service->short_description) }}</textarea>
                </div>

                 <div class="mb-4">
                    <label for="full_description" class="v3-form-label">CORE LOGIC (FULL DESCRIPTION)</label>
                    <textarea class="v3-form-control" id="full_description" name="full_description" rows="6" placeholder="Initialize detailed technical documentation (HTML support enabled)...">{{ old('full_description', $service->full_description) }}</textarea>
                </div>
            </div>
            
            <div class="col-md-4">
                 <div class="mb-4">
                    <label for="status" class="v3-form-label">OPERATIONAL STATUS</label>
                    <select class="v3-form-control" id="status" name="status">
                        <option value="active" {{ old('status', $service->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $service->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="display_order" class="v3-form-label">LOAD SEQUENCE (ORDER)</label>
                    <input type="number" class="v3-form-control" id="display_order" name="display_order" value="{{ old('display_order', $service->display_order) }}">
                </div>

                <div class="mb-4">
                    <label for="rating" class="v3-form-label">SYSTEM RANK (0-5.0)</label>
                    <input type="number" class="v3-form-control" id="rating" name="rating" value="{{ old('rating', $service->rating) }}" step="0.1" min="0" max="5">
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn-tech-primary px-5 py-3">
                <i class="fas fa-sync-alt me-2"></i> UPDATE PROTOCOL
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
</style>
@endsection
