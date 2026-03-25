@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Recruit Operative</h1>
        <p class="page-subtitle">Configure parameters and clearance for a new team unit.</p>
    </div>
    <a href="{{ route('admin.team.index') }}" class="btn-tech-outline">
        <i class="fas fa-arrow-left me-2"></i> Back to Hub
    </a>
</div>

<div class="tech-card">
    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-4">
                    <label for="name" class="v2-form-label">OPERATIVE IDENTITY</label>
                    <input type="text" class="v2-form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Full legal or alias identity" required>
                </div>

                <div class="mb-4">
                    <label for="position" class="v2-form-label">FUNCTIONAL ROLE</label>
                    <input type="text" class="v2-form-control" id="position" name="position" value="{{ old('position') }}" placeholder="e.g. Lead Cyber Architect" required>
                </div>
                
                <div class="mb-4">
                    <label for="bio" class="v2-form-label">BIOGRAPHICAL DATA</label>
                    <textarea class="v2-form-control" id="bio" name="bio" rows="4" placeholder="Technical background and expertise keywords...">{{ old('bio') }}</textarea>
                </div>

                <div class="row g-4 d-flex justify-content-between">
                    <div class="col-md-3">
                        <label for="facebook_url" class="v2-form-label">FACEBOOK LINK</label>
                        <input type="url" class="v2-form-control" id="facebook_url" name="facebook_url" value="{{ old('facebook_url') }}" placeholder="https://...">
                    </div>
                    <div class="col-md-3">
                        <label for="twitter_url" class="v2-form-label">TWITTER LINK</label>
                        <input type="url" class="v2-form-control" id="twitter_url" name="twitter_url" value="{{ old('twitter_url') }}" placeholder="https://...">
                    </div>
                    <div class="col-md-3">
                        <label for="instagram_url" class="v2-form-label">INSTAGRAM LINK</label>
                        <input type="url" class="v2-form-control" id="instagram_url" name="instagram_url" value="{{ old('instagram_url') }}" placeholder="https://...">
                    </div>
                    <div class="col-md-3">
                        <label for="linkedin_url" class="v2-form-label">LINKEDIN LINK</label>
                        <input type="url" class="v2-form-control" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url') }}" placeholder="https://...">
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                 <div class="mb-4">
                    <label for="status" class="v2-form-label">ACTIVE STATUS</label>
                    <select class="v2-form-control" id="status" name="status">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                 <div class="mb-4">
                    <label for="display_order" class="v2-form-label">PRIORITY SEQUENCE</label>
                    <input type="number" class="v2-form-control" id="display_order" name="display_order" value="{{ old('display_order', 0) }}">
                </div>

                <div class="mb-4">
                    <label class="v2-form-label">PROFILE ASSET SELECTION</label>
                    <div class="mb-3">
                        <label for="image" class="small text-v2-muted mb-2 d-block">OPTION A: UPLOAD LOCAL MEDIA</label>
                        <div class="v2-file-upload">
                            <input type="file" id="image" name="image">
                            <div class="v2-file-info"><i class="fas fa-upload me-2"></i> Uplink Media</div>
                        </div>
                    </div>
                    
                    <div class="mb-0">
                        <label for="image_url" class="small text-v2-muted mb-2 d-block">OPTION B: REMOTE SIGNAL (IMAGE URL)</label>
                        <input type="url" class="v2-form-control" id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="https://external-host.io/avatar.png">
                    </div>
                    <small class="text-v2-muted mt-2 d-block">System prioritizes Uploaded Media if both are provided.</small>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn-tech-primary px-5 py-3">
                <i class="fas fa-rocket me-2"></i> DEPLOY OPERATIVE
            </button>
        </div>
    </form>
</div>

</style>
@endsection
