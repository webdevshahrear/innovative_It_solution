@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title text-white">Modify Visual Asset</h1>
    <p class="page-subtitle text-v2-muted">Updating configuration for: {{ $gallery_item->title }}</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="tech-card-v2 p-4">
            <form action="{{ route('admin.gallery-items.update', $gallery_item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="v2-form-label">Asset Title</label>
                        <input type="text" name="title" class="v2-admin-input @error('title') is-invalid @enderror" value="{{ old('title', $gallery_item->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Category</label>
                        <select name="category" class="v2-admin-input">
                            <option value="workspace" {{ $gallery_item->category === 'workspace' ? 'selected' : '' }}>WORKSPACE</option>
                            <option value="team" {{ $gallery_item->category === 'team' ? 'selected' : '' }}>TEAM LIFE</option>
                            <option value="projects" {{ $gallery_item->category === 'projects' ? 'selected' : '' }}>PROJECT SHOWCASE</option>
                            <option value="events" {{ $gallery_item->category === 'events' ? 'selected' : '' }}>AGENCY EVENTS</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Change Visual Media</label>
                        <input type="file" name="image_path" class="v2-admin-input @error('image_path') is-invalid @enderror">
                        <div class="mt-2 gallery-preview-small">
                            <span class="small text-v2-muted d-block mb-1">Current Version:</span>
                            <img src="{{ asset('uploads/gallery/' . $gallery_item->image_path) }}" alt="" style="height: 100px; border-radius: 8px; border: 1px solid var(--v2-border);">
                        </div>
                        @error('image_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Display Priority</label>
                        <input type="number" name="display_order" class="v2-admin-input" value="{{ old('display_order', $gallery_item->display_order) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Asset Status</label>
                        <select name="status" class="v2-admin-input">
                            <option value="active" {{ old('status', $gallery_item->status) === 'active' ? 'selected' : '' }}>VISIBLE</option>
                            <option value="inactive" {{ old('status', $gallery_item->status) === 'inactive' ? 'selected' : '' }}>HIDDEN</option>
                        </select>
                    </div>

                    <div class="col-12 mt-5">
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn-v2-primary py-3 px-5">
                                <i class="fas fa-sync me-2"></i> Update Asset
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
