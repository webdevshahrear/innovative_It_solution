@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title text-white">Record New Achievement</h1>
    <p class="page-subtitle text-v2-muted">Initialize a new milestone or award in the system archives.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="tech-card-v2 p-4">
            <form action="{{ route('admin.achievements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="v2-form-label">Achievement Title</label>
                        <input type="text" name="title" class="v2-admin-input @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g. Best Digital Agency 2026" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="v2-form-label">Short Description</label>
                        <textarea name="description" rows="3" class="v2-admin-input @error('description') is-invalid @enderror" placeholder="Briefly describe the reach or impact of this achievement...">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Icon Class (FontAwesome)</label>
                        <input type="text" name="icon_class" class="v2-admin-input" value="{{ old('icon_class', 'fas fa-award') }}" placeholder="fas fa-award">
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Visual Media (Optional)</label>
                        <input type="file" name="image" class="v2-admin-input">
                        <div class="small text-v2-muted mt-1">Recommended: PNG/JPG with transparent background.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Chronological Order</label>
                        <input type="number" name="display_order" class="v2-admin-input" value="{{ old('display_order', 0) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Deployment Status</label>
                        <select name="status" class="v2-admin-input">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>ACTIVE</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>INACTIVE / ARCHIVED</option>
                        </select>
                    </div>

                    <div class="col-12 mt-5">
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn-v2-primary py-3 px-5">
                                <i class="fas fa-save me-2"></i> Commit Record
                            </button>
                            <a href="{{ route('admin.achievements.index') }}" class="btn-v2-secondary py-3 px-5">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="tech-card-v2 p-4">
            <h4 class="text-white mb-3">Protocol Info</h4>
            <p class="text-v2-muted small">Achievements are displayed in the "Agency Success" section. Use high-impact titles to build instant credibility with potential clients.</p>
            <hr class="border-secondary opacity-10">
            <div class="d-flex align-items-center gap-3 text-v2-primary">
                <i class="fas fa-info-circle"></i>
                <span class="small fw-bold">Images will be resized to fit.</span>
            </div>
        </div>
    </div>
</div>
@endsection
