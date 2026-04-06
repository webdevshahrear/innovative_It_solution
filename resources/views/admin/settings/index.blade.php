@extends('layouts.admin')

@section('content')
<style>
    /* Ultra-Premium V2+ Settings Tabs */
    .settings-sidebar {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 1rem;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.02);
    }

    .list-group-item {
        background: transparent !important;
        border: 1px solid transparent !important;
        color: var(--v2-text-muted) !important;
        margin-bottom: 0.5rem;
        border-radius: 14px !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 600;
        cursor: pointer;
        padding: 1rem 1.25rem !important;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }

    .list-group-item:hover {
        background: rgba(255, 255, 255, 0.03) !important;
        color: var(--v2-text-white) !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
        transform: translateX(5px);
    }

    .list-group-item.active {
        background: linear-gradient(135deg, rgba(240, 82, 35, 0.15), rgba(240, 82, 35, 0.05)) !important;
        color: white !important;
        border-color: rgba(240, 82, 35, 0.3) !important;
        box-shadow: inset 0 0 20px rgba(240, 82, 35, 0.1);
    }

    .list-group-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 10%;
        height: 80%;
        width: 4px;
        background: var(--v2-primary);
        border-radius: 0 4px 4px 0;
        box-shadow: 0 0 10px var(--v2-primary);
    }
    
    .list-group-item i {
        transition: all 0.3s;
        opacity: 0.7;
        width: 24px;
        text-align: center;
    }

    .list-group-item:hover i, .list-group-item.active i {
        opacity: 1;
        transform: scale(1.1);
    }

    .list-group-item.active i {
        color: var(--v2-primary) !important;
        text-shadow: 0 0 10px var(--v2-primary-glow);
    }

    /* Premium Form Cards */
    .settings-card {
        background: rgba(30, 41, 59, 0.3);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 2.5rem;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255,255,255,0.1);
        position: relative;
        overflow: hidden;
    }

    .settings-card::before {
        content: '';
        position: absolute;
        top: -50%; left: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle at center, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }

    .settings-card > * {
        position: relative;
        z-index: 1;
    }

    .settings-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .settings-icon-wrapper {
        width: 48px; height: 48px;
        border-radius: 14px;
        background: rgba(240, 82, 35, 0.1);
        border: 1px solid rgba(240, 82, 35, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--v2-primary);
        box-shadow: 0 0 20px rgba(240, 82, 35, 0.1);
    }
</style>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title text-white">Global Configuration</h1>
        <p class="page-subtitle text-v2-muted">Adjust core system variables and external communication parameters.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4 mb-md-0">
         <div class="settings-sidebar">
            <div class="list-group list-group-flush bg-transparent">
                <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#general">
                    <i class="fas fa-sliders-h me-3"></i> General Identity
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#hero">
                    <i class="fas fa-tv me-3"></i> Hero Section
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#company">
                    <i class="fas fa-building me-3"></i> Company Info
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#contact">
                    <i class="fas fa-address-book me-3"></i> Contact
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#social">
                    <i class="fas fa-share-alt me-3"></i> Social Media
                </a>
                 <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#footer">
                    <i class="fas fa-columns me-3"></i> Footer Config
                </a>
                 <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#seo">
                    <i class="fas fa-search me-3"></i> SEO & Scripts
                </a>
            </div>
         </div>
    </div>
    
    <div class="col-md-9">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="tab-content" id="nav-tabContent">
                
                <!-- General Identity -->
                <div class="tab-pane show active" id="general">
                     <div class="settings-card">
                        <div class="settings-header">
                            <div class="settings-icon-wrapper"><i class="fas fa-sliders-h"></i></div>
                            <div>
                                <h4 class="fw-bold mb-1 text-white">General Identity</h4>
                                <p class="text-v2-muted small mb-0">Core branding and site-wide metadata.</p>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="v2-form-label">Site Title</label>
                            <input type="text" class="v2-form-control" name="site_title" value="{{ $allSettings['site_title'] ?? '' }}" placeholder="Innovative IT Solutions">
                        </div>
                        
                        <div class="mb-5">
                            <label class="v2-form-label">Site Tagline / Description</label>
                            <input type="text" class="v2-form-control" name="site_description" value="{{ $allSettings['site_description'] ?? '' }}" placeholder="A Premium Web Agency">
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="v2-form-label">Main Logo (Dark Mode)</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" class="v2-form-control" name="site_logo">
                                </div>
                                @if(isset($allSettings['site_logo']))
                                    <div class="mt-3 p-3 text-center rounded-4" style="background: rgba(255,255,255,0.05); border: 1px dashed rgba(255,255,255,0.1);">
                                        <img src="{{ asset('uploads/settings/' . $allSettings['site_logo']) }}" style="max-height: 40px; background: rgba(255,255,255,0.1); padding: 5px; border-radius: 8px;">
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="v2-form-label">Light Mode Logo</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" class="v2-form-control" name="site_logo_light">
                                </div>
                                @if(isset($allSettings['site_logo_light']))
                                    <div class="mt-3 p-3 text-center rounded-4" style="background: #f8fafc; border: 1px dashed rgba(0,0,0,0.1);">
                                        <img src="{{ asset('uploads/settings/' . $allSettings['site_logo_light']) }}" style="max-height: 40px; padding: 5px; border-radius: 8px;">
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-6">
                                <label class="v2-form-label">Favicon</label>
                                 <div class="file-upload-wrapper">
                                    <input type="file" class="v2-form-control" name="site_favicon">
                                 </div>
                                 @if(isset($allSettings['site_favicon']))
                                    <div class="mt-3 p-3 text-center rounded-4" style="background: rgba(255,255,255,0.05); border: 1px dashed rgba(255,255,255,0.1);">
                                        <img src="{{ asset('uploads/settings/' . $allSettings['site_favicon']) }}" style="max-height: 32px; border-radius: 4px;">
                                    </div>
                                @endif
                            </div>
                            
                             <div class="col-md-6">
                                <label class="v2-form-label">Footer Logo</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" class="v2-form-control" name="footer_logo">
                                </div>
                                 @if(isset($allSettings['footer_logo']))
                                    <div class="mt-3 p-3 text-center rounded-4" style="background: rgba(255,255,255,0.05); border: 1px dashed rgba(255,255,255,0.1);">
                                        <img src="{{ asset('uploads/settings/' . $allSettings['footer_logo']) }}" style="max-height: 40px; background: rgba(255,255,255,0.1); padding: 5px; border-radius: 8px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                     </div>
                </div>

                <!-- Hero Section -->
                <div class="tab-pane" id="hero">
                    <div class="settings-card">
                        <div class="settings-header">
                            <div class="settings-icon-wrapper" style="color: #6366f1; background: rgba(99, 102, 241, 0.1); border-color: rgba(99, 102, 241, 0.2); box-shadow: 0 0 20px rgba(99, 102, 241, 0.1);"><i class="fas fa-tv"></i></div>
                            <div>
                                <h4 class="fw-bold mb-1 text-white">Hero Configuration</h4>
                                <p class="text-v2-muted small mb-0">Control the primary landing sequence.</p>
                            </div>
                        </div>
                         
                         <div class="mb-4">
                            <label class="v2-form-label">Hero Mode</label>
                            <select class="v2-form-control" name="hero_mode">
                                <option value="slider" {{ ($allSettings['hero_mode'] ?? '') == 'slider' ? 'selected' : '' }}>Dynamic Slider</option>
                                <option value="static" {{ ($allSettings['hero_mode'] ?? '') == 'static' ? 'selected' : '' }}>Static Masterpost</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="v2-form-label">Static Hero Title</label>
                            <input type="text" class="v2-form-control" name="hero_title" value="{{ $allSettings['hero_title'] ?? '' }}">
                        </div>

                         <div class="mb-0">
                            <label class="v2-form-label">Static Hero Subtitle</label>
                            <textarea class="v2-form-control" name="hero_subtitle" rows="3">{{ $allSettings['hero_subtitle'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="tab-pane" id="company">
                    <div class="settings-card">
                        <div class="settings-header">
                            <div class="settings-icon-wrapper" style="color: #10b981; background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); box-shadow: 0 0 20px rgba(16, 185, 129, 0.1);"><i class="fas fa-building"></i></div>
                            <div>
                                <h4 class="fw-bold mb-1 text-white">Company Information</h4>
                                <p class="text-v2-muted small mb-0">Organizational philosophy and core tenets.</p>
                            </div>
                        </div>
                         
                         <div class="mb-4">
                            <label class="v2-form-label">Mission Statement</label>
                            <textarea class="v2-form-control" name="company_mission" rows="4">{{ $allSettings['company_mission'] ?? '' }}</textarea>
                        </div>

                         <div class="mb-0">
                            <label class="v2-form-label">Vision Statement</label>
                            <textarea class="v2-form-control" name="company_vision" rows="4">{{ $allSettings['company_vision'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="tab-pane" id="contact">
                    <div class="settings-card">
                        <div class="settings-header">
                            <div class="settings-icon-wrapper" style="color: #f59e0b; background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2); box-shadow: 0 0 20px rgba(245, 158, 11, 0.1);"><i class="fas fa-satellite-dish"></i></div>
                            <div>
                                <h4 class="fw-bold mb-1 text-white">Contact Infrastructure</h4>
                                <p class="text-v2-muted small mb-0">Endpoints for incoming external communications.</p>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="v2-form-label">PRIMARY UPLINK EMAIL</label>
                            <input type="email" class="v2-form-control" name="contact_email" 
                                   value="{{ $allSettings['contact_email'] ?? '' }}" placeholder="system@uplink.io">
                        </div>

                        <div class="mb-4">
                            <label class="v2-form-label">VOICE SIGNAL FREQUENCY (PHONE)</label>
                            <input type="text" class="v2-form-control" name="contact_phone" 
                                    value="{{ $allSettings['contact_phone'] ?? '' }}" placeholder="+1 (000) 000-0000">
                        </div>

                        <div class="mb-0">
                            <label class="v2-form-label">GEOSPATIAL COORDINATES (ADDRESS)</label>
                            <textarea class="v2-form-control" name="contact_address" rows="3" placeholder="Sector 7, Digital District...">{{ $allSettings['contact_address'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Social -->
                 <div class="tab-pane" id="social">
                    <div class="settings-card">
                        <div class="settings-header">
                            <div class="settings-icon-wrapper" style="color: #ec4899; background: rgba(236, 72, 153, 0.1); border-color: rgba(236, 72, 153, 0.2); box-shadow: 0 0 20px rgba(236, 72, 153, 0.1);"><i class="fas fa-network-wired"></i></div>
                            <div>
                                <h4 class="fw-bold mb-1 text-white">Social Network Matrix</h4>
                                <p class="text-v2-muted small mb-0">Links to external planetary networks.</p>
                            </div>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="v2-form-label"><i class="fab fa-facebook me-2 text-primary"></i> FACEBOOK</label>
                                <input type="url" class="v2-form-control" name="social_facebook" 
                                       value="{{ $allSettings['social_facebook'] ?? '' }}" placeholder="https://...">
                            </div>

                            <div class="col-md-6">
                                <label class="v2-form-label"><i class="fab fa-twitter me-2 text-info"></i> TWITTER / X</label>
                                <input type="url" class="v2-form-control" name="social_twitter" 
                                       value="{{ $allSettings['social_twitter'] ?? '' }}" placeholder="https://...">
                            </div>

                            <div class="col-md-6">
                                <label class="v2-form-label"><i class="fab fa-linkedin me-2 text-primary"></i> LINKEDIN</label>
                                <input type="url" class="v2-form-control" name="social_linkedin" 
                                       value="{{ $allSettings['social_linkedin'] ?? '' }}" placeholder="https://...">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="v2-form-label"><i class="fab fa-instagram me-2 text-danger"></i> INSTAGRAM</label>
                                <input type="url" class="v2-form-control" name="social_instagram" 
                                       value="{{ $allSettings['social_instagram'] ?? '' }}" placeholder="https://...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Config -->
                <div class="tab-pane" id="footer">
                    <div class="settings-card">
                        <div class="settings-header">
                            <div class="settings-icon-wrapper" style="color: #6366f1; background: rgba(99, 102, 241, 0.1); border-color: rgba(99, 102, 241, 0.2); box-shadow: 0 0 20px rgba(99, 102, 241, 0.1);"><i class="fas fa-columns"></i></div>
                            <div>
                                <h4 class="fw-bold mb-1 text-white">Footer Configuration</h4>
                                <p class="text-v2-muted small mb-0">Customize global footer elements and labels.</p>
                            </div>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <h6 class="text-white fw-bold mb-3"><i class="fas fa-ruler-combined me-2 text-v2-muted"></i>Header Logo Size</h6>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="v2-form-label">Width (px)</label>
                                        <input type="number" class="v2-form-control" name="logo_width" value="{{ $allSettings['logo_width'] ?? '180' }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="v2-form-label">Height (px)</label>
                                        <input type="number" class="v2-form-control" name="logo_height" value="{{ $allSettings['logo_height'] ?? '60' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-white fw-bold mb-3"><i class="fas fa-ruler-combined me-2 text-v2-muted"></i>Footer Logo Size</h6>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="v2-form-label">Width (px)</label>
                                        <input type="number" class="v2-form-control" name="footer_logo_width" value="{{ $allSettings['footer_logo_width'] ?? '180' }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="v2-form-label">Height (px)</label>
                                        <input type="number" class="v2-form-control" name="footer_logo_height" value="{{ $allSettings['footer_logo_height'] ?? '60' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="v2-form-label">Footer Description</label>
                            <textarea class="v2-form-control" name="footer_description" rows="3">{{ $allSettings['footer_description'] ?? 'Elevating brands through high-impact design and innovative technology. We create digital experiences that resonate on a global scale.' }}</textarea>
                        </div>

                        <div class="mb-5">
                            <label class="v2-form-label">Footer Copyright Text (HTML allowed)</label>
                            <input type="text" class="v2-form-control" name="footer_copyright" value="{{ $allSettings['footer_copyright'] ?? 'Crafted with Precision & <i class=\'fas fa-heart\'></i> by Innovative It Solutions.' }}">
                        </div>

                        <h6 class="text-white fw-bold mb-3"><i class="fas fa-heading me-2 text-v2-muted"></i>Column Titles</h6>
                        <div class="row g-4 mb-5">
                            <div class="col-md-4">
                                <label class="v2-form-label">Column 1 Title</label>
                                <input type="text" class="v2-form-control" name="footer_col1_title" value="{{ $allSettings['footer_col1_title'] ?? 'Agency' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="v2-form-label">Column 2 Title</label>
                                <input type="text" class="v2-form-control" name="footer_col2_title" value="{{ $allSettings['footer_col2_title'] ?? 'Support' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="v2-form-label">Column 3 Title</label>
                                <input type="text" class="v2-form-control" name="footer_col3_title" value="{{ $allSettings['footer_col3_title'] ?? 'Get In Touch' }}">
                            </div>
                        </div>

                        <h6 class="text-white fw-bold mb-3"><i class="fas fa-tags me-2 text-v2-muted"></i>Contact Labels</h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="v2-form-label">Email Label</label>
                                <input type="text" class="v2-form-control" name="footer_email_label" value="{{ $allSettings['footer_email_label'] ?? 'Email Inquiry' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="v2-form-label">Phone Label</label>
                                <input type="text" class="v2-form-control" name="footer_phone_label" value="{{ $allSettings['footer_phone_label'] ?? 'Phone Support' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO -->
                 <div class="tab-pane" id="seo">
                    <div class="settings-card">
                        <div class="settings-header">
                            <div class="settings-icon-wrapper" style="color: #06b6d4; background: rgba(6, 182, 212, 0.1); border-color: rgba(6, 182, 212, 0.2); box-shadow: 0 0 20px rgba(6, 182, 212, 0.1);"><i class="fas fa-search"></i></div>
                            <div>
                                <h4 class="fw-bold mb-1 text-white">SEO & Metadata</h4>
                                <p class="text-v2-muted small mb-0">Search engine optimization and tracking scripts.</p>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="v2-form-label">Meta Keywords (Comma separated)</label>
                            <input type="text" class="v2-form-control" name="site_keywords" value="{{ $allSettings['site_keywords'] ?? '' }}" placeholder="tech, innovation, web...">
                        </div>

                         <div class="mb-0">
                            <label class="v2-form-label">Custom Header Scripts <span class="text-warning text-lowercase float-end" style="font-size: 0.6rem;"><i class="fas fa-exclamation-triangle"></i> proceed with caution</span></label>
                            <textarea class="v2-form-control font-monospace" name="custom_header_scripts" rows="6" placeholder="<script>...</script>" style="background: rgba(0,0,0,0.2) !important;">{{ $allSettings['custom_header_scripts'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-end mt-4 mb-2">
                <button type="submit" class="btn-v2-primary px-5 py-3 shadow-lg" style="letter-spacing: 0.1rem; font-size: 0.95rem; border: none;">
                    <i class="fas fa-save me-2"></i> COMMIT CHANGES
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Premium Input Overrides */
    .v2-form-label { 
        display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; 
        color: var(--v2-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; 
    }
    
    .v2-form-control { 
        width: 100% !important; 
        background: rgba(15, 23, 42, 0.4) !important; 
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important; 
        border-radius: 12px !important; 
        padding: 0.9rem 1.25rem !important; 
        color: var(--v2-text-main) !important; 
        font-size: 0.95rem !important; 
        font-weight: 500 !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important; 
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .v2-form-control:focus { 
        outline: none !important; 
        background: rgba(15, 23, 42, 0.8) !important; 
        border-color: var(--v2-primary) !important; 
        box-shadow: 0 0 0 4px rgba(240, 82, 35, 0.1), inset 0 2px 4px rgba(0,0,0,0.1) !important; 
    }
    
    .v2-form-control::placeholder { 
        color: rgba(255,255,255,0.2) !important; 
        font-weight: 400 !important;
    }

    /* File upload specific styling */
    input[type="file"].v2-form-control {
        padding: 0.7rem 1rem !important;
        cursor: pointer;
    }
    
    input[type="file"]::file-selector-button {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.1);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        margin-right: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    input[type="file"]::file-selector-button:hover {
        background: rgba(255,255,255,0.15);
    }

    /* Light mode specific overrides for better visibility */
    [data-theme="light"] .settings-card {
        background: rgba(255, 255, 255, 0.8) !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important;
    }
    [data-theme="light"] .settings-sidebar {
        background: rgba(255, 255, 255, 0.8) !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02) !important;
    }
    
    [data-theme="light"] h4.text-white {
        color: var(--v2-text-main) !important;
    }
    
    [data-theme="light"] .v2-form-control {
        background: #ffffff !important;
        border-color: #cbd5e1 !important;
        color: #0f172a !important;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02) !important;
    }
    
    [data-theme="light"] .v2-form-control::placeholder {
        color: #94a3b8 !important;
    }
    
    [data-theme="light"] input[type="file"]::file-selector-button {
        color: #0f172a;
        background: #f1f5f9;
        border-color: #e2e8f0;
    }
</style>
@endsection

