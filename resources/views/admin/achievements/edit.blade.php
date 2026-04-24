@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title text-white">Recalibrate Achievement</h1>
    <p class="page-subtitle text-v2-muted">Modifying existing legacy record: {{ $achievement->title }}</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="tech-card-v2 p-4">
            <form action="{{ route('admin.achievements.update', $achievement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="v2-form-label">Achievement Title</label>
                        <input type="text" name="title" class="v2-admin-input @error('title') is-invalid @enderror" value="{{ old('title', $achievement->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="v2-form-label">Short Description</label>
                        <textarea name="description" rows="3" class="v2-admin-input @error('description') is-invalid @enderror">{{ old('description', $achievement->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Icon Class (FontAwesome)</label>
                        <input type="text" name="icon_class" class="v2-admin-input" value="{{ old('icon_class', $achievement->icon_class) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Update Visual Media</label>
                        <input type="file" name="image" class="v2-admin-input">
                        @if($achievement->image)
                            <div class="mt-2">
                                <span class="small text-v2-muted d-block mb-1">Current Image:</span>
                                <img src="{{ asset('uploads/achievements/' . $achievement->image) }}" alt="" style="height: 60px; border-radius: 8px;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Chronological Order</label>
                        <input type="number" name="display_order" class="v2-admin-input" value="{{ old('display_order', $achievement->display_order) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="v2-form-label">Deployment Status</label>
                        <select name="status" class="v2-admin-input">
                            <option value="active" {{ old('status', $achievement->status) === 'active' ? 'selected' : '' }}>ACTIVE</option>
                            <option value="inactive" {{ old('status', $achievement->status) === 'inactive' ? 'selected' : '' }}>INACTIVE / ARCHIVED</option>
                        </select>
                    </div>

                    <div class="col-12 mt-5">
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn-v2-primary py-3 px-5">
                                <i class="fas fa-sync me-2"></i> Update Record
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
</div>
@endsection
