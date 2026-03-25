@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Write New Post</h1>
        <p class="page-subtitle">Initialize a new digital transmission for the global network.</p>
    </div>
    <a href="{{ route('admin.blog.index') }}" class="btn-tech-outline">
        <i class="fas fa-arrow-left me-2"></i> Back to Archive
    </a>
</div>

<div class="tech-card">
    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-md-9">
                <div class="mb-4">
                    <label for="title" class="v2-form-label">ARTICLE IDENTITY</label>
                    <input type="text" class="v2-form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Enter transmission subject..." required>
                </div>

                <div class="mb-4">
                    <label for="content" class="v2-form-label">CONTENT DATA</label>
                    <textarea class="v2-form-control" id="content" name="content" rows="15" placeholder="Initialize content sequence...">{{ old('content') }}</textarea>
                </div>
            </div>
            
            <div class="col-md-3">
                 <div class="mb-4">
                    <label for="status" class="v2-form-label">TRANSMISSION STATUS</label>
                    <select class="v2-form-control" id="status" name="status">
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="category" class="v2-form-label">SECTOR / CATEGORY</label>
                    <select class="v2-form-control" id="category" name="category">
                        @foreach(['Technology', 'Design', 'Development', 'Business', 'Marketing'] as $cat)
                             <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                 <div class="v2-switch-item mb-4">
                    <div class="v2-switch">
                        <input type="checkbox" id="is_featured" name="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                        <label for="is_featured"></label>
                    </div>
                    <label class="v2-form-label mb-0" for="is_featured">PRIORITY SIGNAL</label>
                </div>

                <div class="mb-4">
                    <label for="image" class="v2-form-label">VISUAL ASSET</label>
                    <div class="v2-file-upload">
                        <input type="file" id="image" name="image">
                        <div class="v2-file-info"><i class="fas fa-upload me-2"></i> Uplink Media</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn-tech-primary px-5 py-3">
                <i class="fas fa-rocket me-2"></i> DEPLOY TRANSMISSION
            </button>
        </div>
    </form>
</div>

<style>
    .v2-form-label { display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v2-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; }
    .v2-form-control { width: 100%; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--v2-border); border-radius: 12px; padding: 0.75rem 1rem; color: white; font-size: 0.9rem; transition: all 0.3s; }
    .v2-form-control:focus { outline: none; background: rgba(255, 255, 255, 0.05); border-color: var(--v2-primary); box-shadow: 0 0 15px rgba(240, 82, 35, 0.1); }
    .v2-form-control::placeholder { color: rgba(255,255,255,0.2); }

    .v2-switch-item { display: flex; align-items: center; gap: 1rem; background: rgba(255,255,255,0.02); padding: 1rem; border-radius: 12px; border: 1px solid var(--v2-border); }
    .v2-switch { position: relative; width: 44px; height: 22px; }
    .v2-switch input { opacity: 0; width: 0; height: 0; }
    .v2-switch label { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(255,255,255,0.1); transition: .4s; border-radius: 22px; }
    .v2-switch label:before { position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    .v2-switch input:checked + label { background: var(--v2-primary); }
    .v2-switch input:checked + label:before { transform: translateX(22px); }

    .v2-file-upload { position: relative; height: 45px; background: rgba(255, 255, 255, 0.03); border: 1px dashed var(--v2-border); border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: 0.3s; }
    .v2-file-upload:hover { border-color: var(--v2-primary); background: rgba(255, 255, 255, 0.05); }
    .v2-file-upload input { position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
    .v2-file-info { font-size: 0.8rem; color: var(--v2-text-muted); font-weight: 600; }

    .btn-tech-outline { display: inline-flex; padding: 0.6rem 1.2rem; background: transparent; border: 1px solid var(--v2-border); color: var(--v2-text-muted); text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; transition: 0.3s; }
    .btn-tech-outline:hover { border-color: white; color: white; background: rgba(255,255,255,0.05); }
</style>
@endsection
