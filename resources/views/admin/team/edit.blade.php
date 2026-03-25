@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Modify Operative</h1>
        <p class="page-subtitle">Update parameters and clearance for the existing team unit.</p>
    </div>
    <a href="{{ route('admin.team.index') }}" class="btn-tech-outline">
        <i class="fas fa-arrow-left me-2"></i> Back to Hub
    </a>
</div>

<div class="tech-card">
    <form action="{{ route('admin.team.update', $team) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-4">
                    <label for="name" class="v2-form-label">OPERATIVE IDENTITY</label>
                    <input type="text" class="v2-form-control" id="name" name="name" value="{{ old('name', $team->name) }}" placeholder="Full legal or alias identity" required>
                </div>

                <div class="mb-4">
                    <label for="position" class="v2-form-label">FUNCTIONAL ROLE</label>
                    <input type="text" class="v2-form-control" id="position" name="position" value="{{ old('position', $team->position) }}" placeholder="e.g. Lead Cyber Architect" required>
                </div>
                
                <div class="mb-4">
                    <label for="bio" class="v2-form-label">BIOGRAPHICAL DATA</label>
                    <textarea class="v2-form-control" id="bio" name="bio" rows="4" placeholder="Technical background and expertise keywords...">{{ old('bio', $team->bio) }}</textarea>
                </div>

                <div class="row g-4 d-flex justify-content-between">
                    <div class="col-md-3">
                        <label for="facebook_url" class="v2-form-label">FACEBOOK LINK</label>
                        <input type="url" class="v2-form-control" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $team->facebook_url) }}" placeholder="https://...">
                    </div>
                    <div class="col-md-3">
                        <label for="twitter_url" class="v2-form-label">TWITTER LINK</label>
                        <input type="url" class="v2-form-control" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $team->twitter_url) }}" placeholder="https://...">
                    </div>
                     <div class="col-md-3">
                        <label for="instagram_url" class="v2-form-label">INSTAGRAM LINK</label>
                        <input type="url" class="v2-form-control" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $team->instagram_url) }}" placeholder="https://...">
                    </div>
                    <div class="col-md-3">
                        <label for="linkedin_url" class="v2-form-label">LINKEDIN LINK</label>
                        <input type="url" class="v2-form-control" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $team->linkedin_url) }}" placeholder="https://...">
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                 <div class="mb-4">
                    <label for="status" class="v2-form-label">ACTIVE STATUS</label>
                    <select class="v2-form-control" id="status" name="status">
                        <option value="active" {{ old('status', $team->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $team->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                 <div class="mb-4">
                    <label for="display_order" class="v2-form-label">PRIORITY SEQUENCE</label>
                    <input type="number" class="v2-form-control" id="display_order" name="display_order" value="{{ old('display_order', $team->display_order) }}">
                </div>

                <div class="mb-4">
                    <label class="v2-form-label">PROFILE ASSET SELECTION</label>
                    @php
                        $isUrl = filter_var($team->image, FILTER_VALIDATE_URL);
                        $previewSrc = $team->image
                            ? ($isUrl ? $team->image : asset('uploads/team/' . $team->image))
                            : '';
                    @endphp

                    <div class="asset-preview-v2 member mb-3" id="imgPreviewWrap" style="{{ $previewSrc ? '' : 'border: 2px dashed rgba(255,255,255,0.15);' }}">
                        <img id="imgPreview"
                             src="{{ $previewSrc }}"
                             alt="Preview"
                             style="{{ $previewSrc ? '' : 'display:none;' }}">
                        @if(!$previewSrc)
                            <span id="previewPlaceholder" style="font-size:0.7rem;color:var(--v2-text-muted);">.preview</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="image" class="small text-v2-muted mb-2 d-block">OPTION A: UPLOAD LOCAL MEDIA</label>
                        <div class="v2-file-upload">
                            <input type="file" id="image" name="image" accept="image/*" onchange="previewFile(this)">
                            <div class="v2-file-info"><i class="fas fa-upload me-2"></i> Update Asset</div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label for="image_url" class="small text-v2-muted mb-2 d-block">OPTION B: REMOTE SIGNAL (IMAGE URL)</label>
                        <input type="url" class="v2-form-control" id="image_url" name="image_url" value="{{ old('image_url', $isUrl ? $team->image : '') }}" placeholder="https://external-host.io/avatar.png">
                    </div>
                    <small class="text-v2-muted mt-2 d-block">System prioritizes Uploaded Media if both are provided.</small>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn-tech-primary px-5 py-3">
                <i class="fas fa-sync-alt me-2"></i> UPDATE PARAMETERS
            </button>
        </div>
    </form>
</div>

<style>
    .v2-form-label { display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v2-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; }
    .v2-form-control { width: 100%; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--v2-border); border-radius: 12px; padding: 0.75rem 1rem; color: white; font-size: 0.9rem; transition: all 0.3s; }
    .v2-form-control:focus { outline: none; background: rgba(255, 255, 255, 0.05); border-color: var(--v2-primary); box-shadow: 0 0 15px rgba(240, 82, 35, 0.1); }
    .v2-form-control::placeholder { color: rgba(255,255,255,0.2); }

    .v2-file-upload { position: relative; height: 45px; background: rgba(255, 255, 255, 0.03); border: 1px dashed var(--v2-border); border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: 0.3s; }
    .v2-file-upload:hover { border-color: var(--v2-primary); background: rgba(255, 255, 255, 0.05); }
    .v2-file-upload input { position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
    .v2-file-info { font-size: 0.8rem; color: var(--v2-text-muted); font-weight: 600; }

    .asset-preview-v2.member { width: 120px; height: 120px; border-radius: 50%; border: 2px solid var(--v2-primary); margin: 0 auto; overflow: hidden; display: flex; align-items: center; justify-content: center; }
    .asset-preview-v2.member img { width: 100%; height: 100%; object-fit: cover; }

    .btn-tech-outline { display: inline-flex; padding: 0.6rem 1.2rem; background: transparent; border: 1px solid var(--v2-border); color: var(--v2-text-muted); text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; transition: 0.3s; }
    .btn-tech-outline:hover { border-color: white; color: white; background: rgba(255,255,255,0.05); }
</style>

<script>
function previewFile(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('imgPreview');
            const placeholder = document.getElementById('previewPlaceholder');
            img.src = e.target.result;
            img.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
            document.getElementById('imgPreviewWrap').style.border = '2px solid var(--v2-primary)';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
