@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title text-white">Index New Visual Asset</h1>
    <p class="page-subtitle text-v2-muted">Upload high-impact imagery for the agency showcase.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="tech-card-v2 p-4">
            <form action="{{ route('admin.gallery-items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="v2-form-label">Asset Title</label>
                        <input type="text" name="title" class="v2-admin-input @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g. Modern Workspace Collaboration" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Category</label>
                        <select name="category" class="v2-admin-input">
                            <option value="workspace">WORKSPACE</option>
                            <option value="team">TEAM LIFE</option>
                            <option value="projects">PROJECT SHOWCASE</option>
                            <option value="events">AGENCY EVENTS</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Visual Media (JPG/PNG/WEBP)</label>
                        <input type="file" name="image_path" class="v2-admin-input @error('image_path') is-invalid @enderror" required>
                        @error('image_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Display Priority</label>
                        <input type="number" name="display_order" class="v2-admin-input" value="{{ old('display_order', 0) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Asset Status</label>
                        <select name="status" class="v2-admin-input">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>VISIBLE</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>HIDDEN</option>
                        </select>
                    </div>

                    <div class="col-12 mt-5">
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn-v2-primary py-3 px-5">
                                <i class="fas fa-upload me-2"></i> Deploy Asset
                            </button>
                            <a href="{{ route('admin.gallery-items.index') }}" class="btn-v2-secondary py-3 px-5">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
