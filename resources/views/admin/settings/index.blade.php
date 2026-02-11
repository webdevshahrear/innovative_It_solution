@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Global Configuration</h1>
        <p class="page-subtitle">Adjust core system variables and external communication parameters.</p>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="row g-4">
        <!-- Contact Information -->
        <div class="col-md-6">
            <div class="tech-card h-100">
                <div class="d-flex align-items-center mb-4 pb-2 border-bottom border-v3">
                    <i class="fas fa-id-card me-3 fs-5 text-v3-accent"></i>
                    <h5 class="fw-bold mb-0 text-white">Contact Infrastructure</h5>
                </div>
                
                <div class="mb-4">
                    <label for="contact_email" class="v3-form-label">PRIMARY UPLINK EMAIL</label>
                    <input type="email" class="v3-form-control" id="contact_email" name="contact_email" 
                           value="{{ $settings['contact']->where('setting_key', 'contact_email')->first()->setting_value ?? '' }}" placeholder="system@uplink.io">
                </div>

                <div class="mb-4">
                    <label for="contact_phone" class="v3-form-label">VOICE SIGNAL FREQUENCY (PHONE)</label>
                    <input type="text" class="v3-form-control" id="contact_phone" name="contact_phone" 
                            value="{{ $settings['contact']->where('setting_key', 'contact_phone')->first()->setting_value ?? '' }}" placeholder="+1 (000) 000-0000">
                </div>

                <div class="mb-0">
                    <label for="contact_address" class="v3-form-label">GEOSPATIAL COORDINATES (ADDRESS)</label>
                    <textarea class="v3-form-control" id="contact_address" name="contact_address" rows="3" placeholder="Sector 7, Digital District...">{{ $settings['contact']->where('setting_key', 'contact_address')->first()->setting_value ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="col-md-6">
             <div class="tech-card h-100">
                <div class="d-flex align-items-center mb-4 pb-2 border-bottom border-v3">
                    <i class="fas fa-network-wired me-3 fs-5 text-v3-accent"></i>
                    <h5 class="fw-bold mb-0 text-white">Social Network Matrix</h5>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="social_facebook" class="v3-form-label"><i class="fab fa-facebook me-2"></i> FACEBOOK</label>
                        <input type="url" class="v3-form-control" id="social_facebook" name="social_facebook" 
                               value="{{ $settings['social']->where('setting_key', 'social_facebook')->first()->setting_value ?? '' }}" placeholder="https://fb.com/...">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="social_twitter" class="v3-form-label"><i class="fab fa-twitter me-2"></i> TWITTER / X</label>
                        <input type="url" class="v3-form-control" id="social_twitter" name="social_twitter" 
                               value="{{ $settings['social']->where('setting_key', 'social_twitter')->first()->setting_value ?? '' }}" placeholder="https://twitter.com/...">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="social_linkedin" class="v3-form-label"><i class="fab fa-linkedin me-2"></i> LINKEDIN</label>
                        <input type="url" class="v3-form-control" id="social_linkedin" name="social_linkedin" 
                               value="{{ $settings['social']->where('setting_key', 'social_linkedin')->first()->setting_value ?? '' }}" placeholder="https://linkedin.com/inc/...">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="social_instagram" class="v3-form-label"><i class="fab fa-instagram me-2"></i> INSTAGRAM</label>
                        <input type="url" class="v3-form-control" id="social_instagram" name="social_instagram" 
                               value="{{ $settings['social']->where('setting_key', 'social_instagram')->first()->setting_value ?? '' }}" placeholder="https://instagram.com/...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-5">
        <button type="submit" class="btn-tech-primary px-5 py-3">
            <i class="fas fa-save me-2"></i> COMMIT SYSTEM CHANGES
        </button>
    </div>
</form>

<style>
    .border-bottom.border-v3 { border-color: var(--v3-border) !important; }
    .v3-form-label { display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v3-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; }
    .v3-form-control { width: 100%; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--v3-border); border-radius: 12px; padding: 0.75rem 1rem; color: white; font-size: 0.9rem; transition: all 0.3s; }
    .v3-form-control:focus { outline: none; background: rgba(255, 255, 255, 0.05); border-color: var(--v3-accent); box-shadow: 0 0 15px rgba(99, 102, 241, 0.1); }
    .v3-form-control::placeholder { color: rgba(255,255,255,0.2); }
</style>
@endsection
