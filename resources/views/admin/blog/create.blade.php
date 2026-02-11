@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">Write New Post</h1>
    <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-left me-2"></i> Back to Blog
    </a>
</div>

<div class="card-glass">
    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="mb-3">
                    <label for="title" class="form-label">Post Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="15">{{ old('content') }}</textarea>
                </div>
            </div>
            
            <div class="col-md-3">
                 <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select form-control" id="status" name="status">
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select form-control" id="category" name="category">
                        <option value="Technology">Technology</option>
                        <option value="Design">Design</option>
                        <option value="Development">Development</option>
                        <option value="Business">Business</option>
                        <option value="Marketing">Marketing</option>
                    </select>
                </div>

                 <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label text-white" for="is_featured">Featured Post</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Featured Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary px-4">Publish Post</button>
        </div>
    </form>
</div>
@endsection
