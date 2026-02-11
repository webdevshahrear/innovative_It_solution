@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Modify Testimony</h1>
        <p class="page-subtitle">Update parameters and satisfied user metadata for the existing log.</p>
    </div>
    <a href="{{ route('admin.testimonials.index') }}" class="btn-tech-outline">
        <i class="fas fa-arrow-left me-2"></i> Back to Hub
    </a>
</div>

<div class="tech-card">
    <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-4">
                    <label for="client_name" class="v3-form-label">SOURCE IDENTITY (CLIENT)</label>
                    <input type="text" class="v3-form-control" id="client_name" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}" placeholder="Full legal or alias identity" required>
                </div>

                <div class="mb-4">
                    <label for="client_position" class="v3-form-label">DESIGNATION / COMPANY</label>
                    <input type="text" class="v3-form-control" id="client_position" name="client_position" value="{{ old('client_position', $testimonial->client_position) }}" placeholder="e.g. CEO at TechFlow">
                </div>
                
                <div class="mb-4">
                    <label for="content" class="v3-form-label">ENDORSEMENT DATA (CONTENT)</label>
                    <textarea class="v3-form-control" id="content" name="content" rows="4" placeholder="Update feedback sequence..." required>{{ old('content', $testimonial->content) }}</textarea>
                </div>
            </div>
            
            <div class="col-md-4">
                 <div class="mb-4">
                    <label for="status" class="v3-form-label">VISIBILITY STATUS</label>
                    <select class="v3-form-control" id="status" name="status">
                        <option value="active" {{ old('status', $testimonial->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $testimonial->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                 <div class="mb-4">
                    <label for="rating" class="v3-form-label">SATISFACTION RANK (1-5)</label>
                    <input type="number" class="v3-form-control" id="rating" name="rating" min="1" max="5" value="{{ old('rating', $testimonial->rating) }}">
                </div>

                <div class="mb-4">
                    <label for="display_order" class="v3-form-label">PRIORITY SEQUENCE</label>
                    <input type="number" class="v3-form-control" id="display_order" name="display_order" value="{{ old('display_order', $testimonial->display_order) }}">
                </div>

                <div class="mb-4">
                    <label for="client_image" class="v3-form-label">SOURCE ASSET (IMAGE)</label>
                     @if($testimonial->client_image)
                        <div class="asset-preview-v3 testimonial mb-3">
                             <img src="{{ filter_var($testimonial->client_image, FILTER_VALIDATE_URL) ? $testimonial->client_image : asset('uploads/testimonials/'.$testimonial->client_image) }}" alt="Preview">
                        </div>
                    @endif
                    <div class="v3-file-upload">
                        <input type="file" id="client_image" name="client_image">
                        <div class="v3-file-info"><i class="fas fa-upload me-2"></i> Update Asset</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn-tech-primary px-5 py-3">
                <i class="fas fa-sync-alt me-2"></i> UPDATE REGISTRY
            </button>
        </div>
    </form>
</div>

<style>
    .v3-form-label { display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v3-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; }
    .v3-form-control { width: 100%; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--v3-border); border-radius: 12px; padding: 0.75rem 1rem; color: white; font-size: 0.9rem; transition: all 0.3s; }
    .v3-form-control:focus { outline: none; background: rgba(255, 255, 255, 0.05); border-color: var(--v3-accent); box-shadow: 0 0 15px rgba(99, 102, 241, 0.1); }
    .v3-form-control::placeholder { color: rgba(255,255,255,0.2); }

    .v3-file-upload { position: relative; height: 45px; background: rgba(255, 255, 255, 0.03); border: 1px dashed var(--v3-border); border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: 0.3s; }
    .v3-file-upload:hover { border-color: var(--v3-accent); background: rgba(255, 255, 255, 0.05); }
    .v3-file-upload input { position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
    .v3-file-info { font-size: 0.8rem; color: var(--v3-text-muted); font-weight: 600; }

    .asset-preview-v3.testimonial { width: 80px; height: 80px; border-radius: 50%; border: 2px solid var(--v3-border); overflow: hidden; }
    .asset-preview-v3.testimonial img { width: 100%; height: 100%; object-fit: cover; }

    .btn-tech-outline { display: inline-flex; padding: 0.6rem 1.2rem; background: transparent; border: 1px solid var(--v3-border); color: var(--v3-text-muted); text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; transition: 0.3s; }
    .btn-tech-outline:hover { border-color: white; color: white; background: rgba(255,255,255,0.05); }
</style>
@endsection
