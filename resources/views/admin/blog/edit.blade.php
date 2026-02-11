@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Modify Transmission</h1>
        <p class="page-subtitle">Update content and metadata for the existing digital article.</p>
    </div>
    <a href="{{ route('admin.blog.index') }}" class="btn-tech-outline">
        <i class="fas fa-arrow-left me-2"></i> Back to Archive
    </a>
</div>

<div class="tech-card">
    <form action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-9">
                <div class="mb-4">
                    <label for="title" class="v3-form-label">ARTICLE IDENTITY</label>
                    <input type="text" class="v3-form-control" id="title" name="title" value="{{ old('title', $blog->title) }}" placeholder="Enter transmission subject..." required>
                </div>

                <div class="mb-4">
                    <label for="content" class="v3-form-label">CONTENT DATA</label>
                    <textarea class="v3-form-control" id="content" name="content" rows="15" placeholder="Initialize content sequence...">{{ old('content', $blog->content) }}</textarea>
                </div>
            </div>
            
            <div class="col-md-3">
                 <div class="mb-4">
                    <label for="status" class="v3-form-label">TRANSMISSION STATUS</label>
                    <select class="v3-form-control" id="status" name="status">
                        <option value="published" {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="category" class="v3-form-label">SECTOR / CATEGORY</label>
                    <select class="v3-form-control" id="category" name="category">
                        @foreach(['Technology', 'Design', 'Development', 'Business', 'Marketing'] as $cat)
                             <option value="{{ $cat }}" {{ old('category', $blog->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="v3-switch-item mb-4">
                    <div class="v3-switch">
                        <input type="checkbox" id="is_featured" name="is_featured" {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}>
                        <label for="is_featured"></label>
                    </div>
                    <label class="v3-form-label mb-0" for="is_featured">PRIORITY SIGNAL</label>
                </div>

                <div class="mb-4">
                    <label for="image" class="v3-form-label">VISUAL ASSET</label>
                    @if($blog->image)
                        <div class="asset-preview-v3 mb-3">
                             <img src="{{ filter_var($blog->image, FILTER_VALIDATE_URL) ? $blog->image : asset('uploads/blog/'.$blog->image) }}" alt="Preview">
                        </div>
                    @endif
                    <div class="v3-file-upload">
                        <input type="file" id="image" name="image">
                        <div class="v3-file-info"><i class="fas fa-upload me-2"></i> Update Asset</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn-tech-primary px-5 py-3">
                <i class="fas fa-sync-alt me-2"></i> UPDATE BROADCAST
            </button>
        </div>
    </form>
</div>

<style>
    .v3-form-label { display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v3-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; }
    .v3-form-control { width: 100%; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--v3-border); border-radius: 12px; padding: 0.75rem 1rem; color: white; font-size: 0.9rem; transition: all 0.3s; }
    .v3-form-control:focus { outline: none; background: rgba(255, 255, 255, 0.05); border-color: var(--v3-accent); box-shadow: 0 0 15px rgba(99, 102, 241, 0.1); }
    .v3-form-control::placeholder { color: rgba(255,255,255,0.2); }

    .v3-switch-item { display: flex; align-items: center; gap: 1rem; background: rgba(255,255,255,0.02); padding: 1rem; border-radius: 12px; border: 1px solid var(--v3-border); }
    .v3-switch { position: relative; width: 44px; height: 22px; }
    .v3-switch input { opacity: 0; width: 0; height: 0; }
    .v3-switch label { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(255,255,255,0.1); transition: .4s; border-radius: 22px; }
    .v3-switch label:before { position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    .v3-switch input:checked + label { background: var(--v3-gradient); }
    .v3-switch input:checked + label:before { transform: translateX(22px); }

    .v3-file-upload { position: relative; height: 45px; background: rgba(255, 255, 255, 0.03); border: 1px dashed var(--v3-border); border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: 0.3s; }
    .v3-file-upload:hover { border-color: var(--v3-accent); background: rgba(255, 255, 255, 0.05); }
    .v3-file-upload input { position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
    .v3-file-info { font-size: 0.8rem; color: var(--v3-text-muted); font-weight: 600; }

    .asset-preview-v3 { border-radius: 12px; overflow: hidden; border: 1px solid var(--v3-border); background: rgba(0,0,0,0.2); }
    .asset-preview-v3 img { width: 100%; height: 150px; object-fit: cover; }

    .btn-tech-outline { display: inline-flex; padding: 0.6rem 1.2rem; background: transparent; border: 1px solid var(--v3-border); color: var(--v3-text-muted); text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; transition: 0.3s; }
    .btn-tech-outline:hover { border-color: white; color: white; background: rgba(255,255,255,0.05); }
</style>
@endsection
