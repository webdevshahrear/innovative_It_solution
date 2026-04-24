@extends('layouts.frontend')

@section('title', 'Apply for Internship - Innovative IT Solutions')

@push('styles')
<style>
/* Premium Form Design Upgrade - Fixed & Polished */
body {
    background: var(--navy-dark);
    background-image: var(--v2-mesh);
    background-attachment: fixed;
    transition: var(--transition-theme);
}

.apply-hero { padding: 140px 0 60px; position: relative; z-index: 1; }
.apply-hero h1 { font-family:'Outfit',sans-serif;font-weight:800;font-size:clamp(2.5rem,5vw,3.5rem);color:var(--white);letter-spacing:-0.03em; margin-bottom: 20px; }

.form-container {
    max-width: 1000px; margin: 0 auto;
}

.form-section-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 40px;
    margin-bottom: 30px;
    backdrop-filter: blur(20px);
    box-shadow: var(--glass-shadow);
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}
body.light-mode .form-section-card {
    background: #ffffff;
    box-shadow: 0 15px 35px rgba(0,0,0,0.04);
}
.form-section-card:hover { transform: translateY(-5px); border-color: rgba(240, 82, 35, 0.2); }

.section-header {
    display: flex; align-items: center; gap: 16px; margin-bottom: 32px;
    padding-bottom: 16px; border-bottom: 1px solid var(--border);
}
.section-icon {
    width: 48px; height: 48px; background: rgba(240,82,35,0.1); color: #f05223;
    display: flex; align-items: center; justify-content: center; border-radius: 14px;
    font-size: 1.25rem; border: 1px solid rgba(240,82,35,0.2); flex-shrink: 0;
}
.section-title {
    font-family:'Outfit',sans-serif; font-weight:700; font-size:1.25rem; color:var(--white); margin:0;
    text-transform: uppercase; letter-spacing: 0.1em;
}

.v2-input-group { margin-bottom: 24px; }
.v2-label { 
    display: block; font-weight: 700; font-size: 0.85rem; color: var(--text-muted);
    margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.05em;
}
.v2-input {
    width: 100%; padding: 16px 20px; background: rgba(255,255,255,0.03); 
    border: 1px solid var(--border); border-radius: 14px; color: var(--white);
    font-size: 1rem; transition: all 0.3s;
}
body.light-mode .v2-input { background: #f8fafc; border-color: #e2e8f0; color: #1e293b; }
.v2-input:focus {
    outline: none; background: rgba(240,82,35,0.05); border-color: #f05223;
    box-shadow: 0 0 0 4px rgba(240,82,35,0.1);
}
.v2-input::placeholder { color: rgba(255,255,255,0.3); }
body.light-mode .v2-input::placeholder { color: #94a3b8; }

.v2-select option { background: #0f172a; color: #fff; }
body.light-mode .v2-select option { background: #fff; color: #1e293b; }

.v2-select { appearance: none; cursor: pointer; }

.skill-tag-box {
    background: rgba(255,255,255,0.02); border: 2px dashed var(--border);
    border-radius: 16px; padding: 20px; margin-top: 10px;
}
body.light-mode .skill-tag-box { background: #f1f5f9; border-color: #cbd5e1; }

.v2-check-card {
    background: rgba(255,255,255,0.03); border: 1px solid var(--border);
    border-radius: 16px; padding: 20px; display: flex; align-items: center; 
    gap: 16px; cursor: pointer; transition: all 0.3s; width: 100%;
}
body.light-mode .v2-check-card { background: #f8fafc; }
.v2-check-card:hover { border-color: #f05223; background: rgba(240,82,35,0.02); }
.v2-check-card input:checked + .check-content { color: #f05223; }

/* File Preview Styles */
.file-preview-container {
    margin-top: 15px; display: none;
    background: rgba(255,255,255,0.02); border: 1px solid var(--border);
    border-radius: 14px; padding: 12px; align-items: center; gap: 15px;
}
body.light-mode .file-preview-container { background: #f1f5f9; }
.preview-thumb {
    width: 60px; height: 60px; border-radius: 10px; object-fit: cover;
    border: 2px solid var(--primary);
}
.preview-info { flex: 1; }
.preview-name { font-size: 0.9rem; font-weight: 600; color: var(--white); margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; }
.preview-meta { font-size: 0.75rem; color: var(--text-muted); }

.submit-btn-premium {
    width: 100%; padding: 20px; background: linear-gradient(135deg, #f05223, #ff7849);
    color: #fff !important; border: none; border-radius: 18px; font-weight: 800; font-size: 1.2rem;
    text-transform: uppercase; letter-spacing: 0.1em; cursor: pointer; transition: all 0.4s;
    box-shadow: 0 10px 30px rgba(240,82,35,0.3); display: flex; align-items: center; justify-content: center; gap: 12px;
}
.submit-btn-premium:hover { transform: translateY(-3px) scale(1.01); box-shadow: 0 20px 40px rgba(240,82,35,0.4); }

.error-msg { color: #ef4444; font-size: 0.8rem; margin-top: 8px; font-weight: 600; }
</style>
@endpush

@section('content')
<div class="apply-hero text-center" data-aos="fade-down">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-paper-plane me-2"></i> RECRUITMENT PHASE 2026</span>
        <h1>Join the <span class="text-v2-main">Tech Vanguard</span></h1>
        <p class="text-v2-muted">Complete your professional dossier to begin the diagnostic evaluation.</p>
    </div>
</div>

<div class="container pb-5">
    @if($errors->any())
        <div class="alert alert-danger mb-4 rounded-4 form-container shadow-lg border-0" style="background: rgba(239, 68, 68, 0.1); backdrop-filter: blur(10px);">
            <div class="d-flex align-items-center gap-3 mb-2">
                <i class="fas fa-exclamation-triangle text-danger fs-4"></i>
                <strong class="text-danger">Submission Refused: Please rectify errors</strong>
            </div>
            <ul class="mb-0 text-danger opacity-75">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('internship.apply.store') }}" method="POST" enctype="multipart/form-data" class="form-container">
        @csrf

        {{-- Section 1: Candidate Identity --}}
        <div class="form-section-card" data-aos="fade-up">
            <div class="section-header">
                <div class="section-icon"><i class="fas fa-id-card"></i></div>
                <h4 class="section-title">Candidate Identity</h4>
            </div>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="v2-input-group">
                        <label class="v2-label">Full Legal Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" class="v2-input" placeholder="Enter your full name" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 v2-input-group">
                            <label class="v2-label">Father's Name</label>
                            <input type="text" name="father_name" value="{{ old('father_name') }}" class="v2-input" placeholder="Father's full name" required>
                        </div>
                        
                        <div class="col-md-6 v2-input-group">
                            <label class="v2-label">Mother's Name</label>
                            <input type="text" name="mother_name" value="{{ old('mother_name') }}" class="v2-input" placeholder="Mother's full name" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 v2-input-group">
                    <label class="v2-label">Profile Photo</label>
                    <div class="text-center p-3 rounded-4 position-relative" style="background: rgba(255,255,255,0.02); border: 2px dashed var(--border);">
                        <div id="photoPreviewContainer" style="display:none" class="mb-3">
                            <img id="photoPreview" src="#" alt="Preview" class="rounded-circle shadow-lg" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid var(--primary);">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle shadow" style="width:30px; height:30px; padding:0;" onclick="removeImage('photoInput', 'photoPreviewContainer', 'photoUploadUI')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div id="photoUploadUI">
                            <i class="fas fa-user-circle fs-1 text-muted mb-2"></i>
                            <p class="small text-muted mb-3">Professional Portrait<br>(JPG/PNG, Max 2MB)</p>
                        </div>
                        <label class="btn btn-sm btn-outline-primary rounded-pill px-4">
                            Select Image
                            <input type="file" id="photoInput" name="photo" class="d-none" accept="image/*" onchange="previewImage(this)" required>
                        </label>
                    </div>
                </div>

                <div class="col-md-4 v2-input-group">
                    <label class="v2-label">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob') }}" class="v2-input" required>
                </div>

                <div class="col-md-4 v2-input-group">
                    <label class="v2-label">Gender</label>
                    <select name="gender" class="v2-input v2-select" required>
                        <option value="" disabled {{ !old('gender') ? 'selected' : '' }}>Select Gender</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="col-md-4 v2-input-group">
                    <label class="v2-label">Blood Group</label>
                    <select name="blood_group" class="v2-input v2-select" required>
                        <option value="" disabled {{ !old('blood_group') ? 'selected' : '' }}>Select Group</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                            <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Section 2: Identity & Demographics --}}
        <div class="form-section-card" data-aos="fade-up">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(59,130,246,0.1); color:#3b82f6; border-color:rgba(59,130,246,0.2)"><i class="fas fa-fingerprint"></i></div>
                <h4 class="section-title">Identity & Demographics</h4>
            </div>
            
            <div class="row">
                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">NID / Birth Certificate Number</label>
                    <input type="text" name="nid_birth_number" value="{{ old('nid_birth_number') }}" class="v2-input" placeholder="Enter identification number" required>
                </div>
                
                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">Home District</label>
                    <select name="district" class="v2-input v2-select" required>
                        <option value="" disabled {{ !old('district') ? 'selected' : '' }}>Select District</option>
                        @php
                            $districts = ['Bagerhat', 'Bandarban', 'Barguna', 'Barishal', 'Bhola', 'Bogura', 'Brahmanbaria', 'Chandpur', 'Chapainawabganj', 'Chattogram', 'Chuadanga', 'Cumilla', 'Cox\'s Bazar', 'Dhaka', 'Dinajpur', 'Faridpur', 'Feni', 'Gaibandha', 'Gazipur', 'Gopalganj', 'Habiganj', 'Jamalpur', 'Jashore', 'Jhalokathi', 'Jhenaidah', 'Joypurhat', 'Khagrachhari', 'Khulna', 'Kishoreganj', 'Kurigram', 'Kushtia', 'Lakshmipur', 'Lalmonirhat', 'Madaripur', 'Magura', 'Manikganj', 'Meherpur', 'Moulvibazar', 'Munshiganj', 'Mymensingh', 'Naogaon', 'Narail', 'Narayanganj', 'Narsingdi', 'Natore', 'Netrokona', 'Nilphamari', 'Noakhali', 'Pabna', 'Panchagarh', 'Patuakhali', 'Pirojpur', 'Rajbari', 'Rajshahi', 'Rangamati', 'Rangpur', 'Satkhira', 'Shariatpur', 'Sherpur', 'Sirajganj', 'Sunamganj', 'Sylhet', 'Tangail', 'Thakurgaon'];
                        @endphp
                        @foreach($districts as $d)
                            <option value="{{ $d }}" {{ old('district') == $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">Current Address</label>
                    <textarea name="address" class="v2-input" rows="2" placeholder="Street, City, Area" required>{{ old('address') }}</textarea>
                </div>

                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">Permanent Address</label>
                    <textarea name="permanent_address" class="v2-input" rows="2" placeholder="Full permanent address" required>{{ old('permanent_address') }}</textarea>
                </div>

                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">Contact Phone</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" class="v2-input" placeholder="+880 1XXX XXXXXX" required>
                </div>

                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">Valid Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="v2-input" placeholder="name@example.com" required>
                </div>
            </div>
        </div>

        {{-- Section 3: Academic Background --}}
        <div class="form-section-card" data-aos="fade-up">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(16,185,129,0.1); color:#10b981; border-color:rgba(16,185,129,0.2)"><i class="fas fa-graduation-cap"></i></div>
                <h4 class="section-title">Academic Stratum</h4>
            </div>
            
            <div class="row">
                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">Highest Qualification</label>
                    <select name="education" class="v2-input v2-select" required>
                        <option value="" disabled {{ !old('education') ? 'selected' : '' }}>Select Education</option>
                        <option value="SSC" {{ old('education') == 'SSC' ? 'selected' : '' }}>SSC / Equivalent</option>
                        <option value="HSC" {{ old('education') == 'HSC' ? 'selected' : '' }}>HSC / Equivalent</option>
                        <option value="Diploma" {{ old('education') == 'Diploma' ? 'selected' : '' }}>Diploma in Engineering</option>
                        <option value="Bachelor" {{ old('education') == 'Bachelor' ? 'selected' : '' }}>Bachelor / Honors</option>
                        <option value="Masters" {{ old('education') == 'Masters' ? 'selected' : '' }}>Masters / MBA</option>
                    </select>
                </div>

                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">Institute / University Name</label>
                    <input type="text" name="institute_name" value="{{ old('institute_name') }}" class="v2-input" placeholder="Name of your educational institution" required>
                </div>

                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">Passing / Current Year</label>
                    <input type="text" name="passing_year" value="{{ old('passing_year') }}" class="v2-input" placeholder="e.g. 2024 or 3rd Semester" required>
                </div>

                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">Current Professional Status</label>
                    <select name="current_status" class="v2-input v2-select" required>
                        <option value="" disabled {{ !old('current_status') ? 'selected' : '' }}>Select Status</option>
                        <option value="student" {{ old('current_status') == 'student' ? 'selected' : '' }}>Full-time Student</option>
                        <option value="job_holder" {{ old('current_status') == 'job_holder' ? 'selected' : '' }}>Job Holder</option>
                        <option value="freelancer" {{ old('current_status') == 'freelancer' ? 'selected' : '' }}>Active Freelancer</option>
                        <option value="other" {{ old('current_status') == 'other' ? 'selected' : '' }}>Other / Seeking Opportunities</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Section 4: Technical Spectrum --}}
        <div class="form-section-card" data-aos="fade-up">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(139,92,246,0.1); color:#8b5cf6; border-color:rgba(139,92,246,0.2)"><i class="fas fa-microchip"></i></div>
                <h4 class="section-title">Technical Spectrum</h4>
            </div>
            
            <div class="row">
                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">Primary Selection</label>
                    <select name="preferred_category_id" class="v2-input v2-select" required>
                        <option value="" disabled {{ !old('preferred_category_id') ? 'selected' : '' }}>Target Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('preferred_category_id') ?: request('category')) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">Secondary Selection (Optional)</label>
                    <select name="secondary_category_id" class="v2-input v2-select">
                        <option value="">None</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('secondary_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 v2-input-group">
                    <label class="v2-label">Skill Matrix (Comma Separated)</label>
                    <input type="text" name="skills" value="{{ old('skills') }}" class="v2-input" placeholder="e.g. Laravel, React, Photoshop, SEO, Python" required>
                </div>

                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">Portfolio / Github</label>
                    <input type="url" name="portfolio_url" value="{{ old('portfolio_url') }}" class="v2-input" placeholder="https://yourportfolio.com">
                </div>

                <div class="col-md-6 v2-input-group">
                    <label class="v2-label">LinkedIn Profile URL</label>
                    <input type="url" name="linkedin_url" value="{{ old('linkedin_url') }}" class="v2-input" placeholder="https://linkedin.com/in/username" required>
                </div>

                <div class="col-12 v2-input-group">
                    <label class="v2-label">Professional CV (PDF/DOC Only)</label>
                    <div class="position-relative">
                        <input type="file" id="cvInput" name="cv" class="v2-input" accept=".pdf,.doc,.docx" onchange="previewFile(this, 'cv-preview')" required>
                        <i class="fas fa-file-upload position-absolute" style="right: 20px; top: 18px; color: var(--primary);"></i>
                    </div>
                    
                    <div id="cv-preview" class="file-preview-container">
                        <i class="fas fa-file-pdf fs-3 text-danger"></i>
                        <div class="preview-info">
                            <div class="preview-name" id="cv-name">filename.pdf</div>
                            <div class="preview-meta" id="cv-size">0.0 MB</div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="openUserCVPreview()">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="removeFile('cvInput', 'cv-preview')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <i class="fas fa-check-circle text-success ms-2"></i>
                    </div>
                    <small class="text-v2-muted mt-2 d-block">Max File Size: 5MB</small>
                </div>
            </div>
        </div>

        {{-- Section 5: Supplemental Data --}}
        <div class="form-section-card" data-aos="fade-up">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(249,115,22,0.1); color:#f97316; border-color:rgba(249,115,22,0.2)"><i class="fas fa-brain"></i></div>
                <h4 class="section-title">Cognitive Context</h4>
            </div>
            
            <div class="v2-input-group">
                <label class="v2-label">Why should we recruit you? *</label>
                <textarea name="motivation" class="v2-input" rows="5" placeholder="Elaborate on your goals, vision, and how you can contribute." required>{{ old('motivation') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4 v2-input-group">
                    <label class="v2-label">Temporal Bandwidth</label>
                    <select name="available_hours" class="v2-input v2-select" required>
                        <option value="2-4 hours/day" {{ old('available_hours') == '2-4 hours/day' ? 'selected' : '' }}>2-4 Hours / Day</option>
                        <option value="4-6 hours/day" {{ old('available_hours') == '4-6 hours/day' ? 'selected' : '' }}>4-6 Hours / Day</option>
                        <option value="6-8 hours/day" {{ old('available_hours') == '6-8 hours/day' ? 'selected' : '' }}>6-8 Hours / Day</option>
                    </select>
                </div>

                <div class="col-md-4 v2-input-group">
                    <label class="v2-label">Hardware</label>
                    <label class="v2-check-card">
                        <input type="checkbox" name="has_laptop" value="1" {{ old('has_laptop') ? 'checked' : '' }}>
                        <span class="check-content fw-bold text-white"><i class="fas fa-laptop me-2"></i> Dedicated Laptop</span>
                    </label>
                </div>

                <div class="col-md-4 v2-input-group">
                    <label class="v2-label">Internet</label>
                    <label class="v2-check-card">
                        <input type="checkbox" name="has_internet" value="1" {{ old('has_internet') ? 'checked' : '' }}>
                        <span class="check-content fw-bold text-white"><i class="fas fa-wifi me-2"></i> Stable Internet</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Section 6: Emergency Contact --}}
        <div class="form-section-card" data-aos="fade-up">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(239,68,68,0.1); color:#ef4444; border-color:rgba(239,68,68,0.2)"><i class="fas fa-house-medical"></i></div>
                <h4 class="section-title">Emergency Contact</h4>
            </div>
            
            <div class="row">
                <div class="col-md-4 v2-input-group">
                    <label class="v2-label">Contact Name</label>
                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" class="v2-input" placeholder="Full name of contact" required>
                </div>
                
                <div class="col-md-4 v2-input-group">
                    <label class="v2-label">Relationship</label>
                    <input type="text" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship') }}" class="v2-input" placeholder="e.g. Father, Brother" required>
                </div>

                <div class="col-md-4 v2-input-group">
                    <label class="v2-label">Contact Phone</label>
                    <input type="tel" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" class="v2-input" placeholder="Emergency phone" required>
                </div>
            </div>
        </div>

        <button type="submit" class="submit-btn-premium" data-aos="zoom-in">
            Submit Application <i class="fas fa-chevron-right"></i>
        </button>

    </form>
</div>

<!-- Local CV Preview Modal -->
<div class="modal fade" id="userCvModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary border-opacity-25 shadow-lg" style="backdrop-filter: blur(20px);">
            <div class="modal-header border-bottom border-secondary border-opacity-10 py-3">
                <h5 class="modal-title font-monospace small text-primary text-uppercase letter-spacing-1">
                    <i class="fas fa-microchip me-2"></i> User Verification: Document Stream
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="height: 80vh;">
                <iframe id="userCvFrame" width="100%" height="100%" style="border: none;"></iframe>
            </div>
            <div class="modal-footer border-top border-secondary border-opacity-10 py-2">
                <span class="small text-muted me-auto">Local Integrity Check Active</span>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Close Terminal</button>
            </div>
        </div>
    </div>
</div>

<script>
let localCVBlob = null;

function previewImage(input) {
    const preview = document.getElementById('photoPreview');
    const container = document.getElementById('photoPreviewContainer');
    const uploadUI = document.getElementById('photoUploadUI');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
            uploadUI.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage(inputId, containerId, uiId) {
    document.getElementById(inputId).value = '';
    document.getElementById(containerId).style.display = 'none';
    document.getElementById(uiId).style.display = 'block';
}

function previewFile(input, targetId) {
    const container = document.getElementById(targetId);
    const nameEl = container.querySelector('.preview-name');
    const sizeEl = container.querySelector('.preview-meta');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        nameEl.textContent = file.name;
        sizeEl.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
        container.style.display = 'flex';
        
        // Store blob for preview
        if (localCVBlob) URL.revokeObjectURL(localCVBlob);
        localCVBlob = URL.createObjectURL(file);
    }
}

function removeFile(inputId, containerId) {
    document.getElementById(inputId).value = '';
    document.getElementById(containerId).style.display = 'none';
    if (localCVBlob) {
        URL.revokeObjectURL(localCVBlob);
        localCVBlob = null;
    }
}

function openUserCVPreview() {
    if (localCVBlob) {
        const frame = document.getElementById('userCvFrame');
        frame.src = localCVBlob;
        const modal = new bootstrap.Modal(document.getElementById('userCvModal'));
        modal.show();
    }
}
</script>
@endsection
