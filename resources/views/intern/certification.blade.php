@extends('layouts.dashboard')
@section('title', 'Certification')
@section('panel_type', 'Intern Panel')

@section('sidebar')
    <a href="{{ route('intern.dashboard') }}" class="nav-link {{ request()->routeIs('intern.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('intern.tasks.index') }}" class="nav-link {{ request()->routeIs('intern.tasks.*') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> My Tasks
    </a>
    <a href="{{ route('intern.certification') }}" class="nav-link {{ request()->routeIs('intern.certification') ? 'active' : '' }}">
        <i class="fas fa-certificate"></i> Certification
    </a>
    <a href="{{ route('intern.profile') }}" class="nav-link {{ request()->routeIs('intern.profile') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> My Profile
    </a>
@endsection

@section('topbar')
    <div class="d-flex gap-3 align-items-center">
        @if($account->status === 'active')
            <span class="badge bg-success bg-opacity-10 text-success border border-success"><i class="fas fa-check-circle me-1"></i> Active Intern</span>
        @endif
    </div>
@endsection

@section('content')
<div class="mb-4" data-aos="fade-down">
    <h3 style="font-family:'Outfit';font-weight:800;margin:0;letter-spacing:-0.02em;color:var(--text-primary);">
        <i class="fas fa-award text-warning me-2"></i> Certification Status
    </h3>
    <p style="color:var(--text-secondary);font-size:1.05rem;margin-top:8px;">Track your eligibility to receive the official completion certificate.</p>
</div>

<div class="row g-4" data-aos="fade-up">
    <div class="col-lg-8 mx-auto">
        <div class="stat-card position-relative overflow-hidden" style="padding:40px;">
            <!-- Decorative Background Elements -->
            <div style="position:absolute; top:-50px; right:-50px; width:150px; height:150px; background:radial-gradient(circle, rgba(245,158,11,0.2) 0%, transparent 70%); border-radius:50%;"></div>
            <div style="position:absolute; bottom:-50px; left:-50px; width:200px; height:200px; background:radial-gradient(circle, rgba(16,185,129,0.1) 0%, transparent 70%); border-radius:50%;"></div>
            
            <div class="text-center position-relative z-1 mb-5">
                <div style="font-size:5rem; color: {{ $certEligible ? '#10b981' : '#475569' }}; margin-bottom:20px; text-shadow: 0 10px 30px {{ $certEligible ? 'rgba(16,185,129,0.4)' : 'rgba(0,0,0,0.2)' }}; transition: all 0.5s;">
                    <i class="fas fa-certificate"></i>
                </div>
                <h2 style="font-family:'Outfit';font-weight:800;color:#fff;">Official Internship Certificate</h2>
                <p style="color:var(--text-secondary);font-size:1.1rem;">
                    @if($certEligible)
                        Congratulations! You have met all the requirements for certification.
                    @else
                        Complete the following requirements to unlock your certificate.
                    @endif
                </p>
            </div>
            
            <div class="bg-dark bg-opacity-25 rounded-4 p-4 border" style="border-color: rgba(255,255,255,0.05) !important;">
                <h5 class="text-white fw-bold mb-4" style="font-family:'Outfit';"><i class="fas fa-list-check me-2 text-primary"></i> Eligibility Requirements</h5>
                
                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3" style="border-color: rgba(255,255,255,0.05) !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:40px;height:40px;border-radius:10px;background:{{ $account->performance_score >= 60 ? 'rgba(16,185,129,0.1)' : 'rgba(255,255,255,0.05)' }};color:{{ $account->performance_score >= 60 ? '#10b981' : 'var(--text-secondary)' }};display:flex;align-items:center;justify-content:center;font-size:1.2rem;">
                            <i class="{{ $account->performance_score >= 60 ? 'fas fa-check' : 'fas fa-chart-bar' }}"></i>
                        </div>
                        <div>
                            <div style="color:#fff;font-weight:600;font-size:1.05rem;">Performance Score &ge; 60%</div>
                            <div style="color:var(--text-secondary);font-size:0.85rem;">Current score: <strong class="{{ $account->performance_score >= 60 ? 'text-success' : 'text-warning' }}">{{ $account->performance_score }}%</strong></div>
                        </div>
                    </div>
                    <div>
                        @if($account->performance_score >= 60)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2"><i class="fas fa-check-circle me-1"></i> Passed</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-3 py-2"><i class="fas fa-clock me-1"></i> Pending</span>
                        @endif
                    </div>
                </div>
                
                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3" style="border-color: rgba(255,255,255,0.05) !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:40px;height:40px;border-radius:10px;background:{{ $stats['approved'] >= 5 ? 'rgba(16,185,129,0.1)' : 'rgba(255,255,255,0.05)' }};color:{{ $stats['approved'] >= 5 ? '#10b981' : 'var(--text-secondary)' }};display:flex;align-items:center;justify-content:center;font-size:1.2rem;">
                            <i class="{{ $stats['approved'] >= 5 ? 'fas fa-check' : 'fas fa-tasks' }}"></i>
                        </div>
                        <div>
                            <div style="color:#fff;font-weight:600;font-size:1.05rem;">Approved Tasks &ge; 5</div>
                            <div style="color:var(--text-secondary);font-size:0.85rem;">Currently approved: <strong class="{{ $stats['approved'] >= 5 ? 'text-success' : 'text-warning' }}">{{ $stats['approved'] }} tasks</strong></div>
                        </div>
                    </div>
                    <div>
                        @if($stats['approved'] >= 5)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2"><i class="fas fa-check-circle me-1"></i> Passed</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-3 py-2"><i class="fas fa-clock me-1"></i> Pending</span>
                        @endif
                    </div>
                </div>
                
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:40px;height:40px;border-radius:10px;background:{{ $account->status === 'active' ? 'rgba(16,185,129,0.1)' : 'rgba(255,255,255,0.05)' }};color:{{ $account->status === 'active' ? '#10b981' : 'var(--text-secondary)' }};display:flex;align-items:center;justify-content:center;font-size:1.2rem;">
                            <i class="{{ $account->status === 'active' ? 'fas fa-check' : 'fas fa-user-shield' }}"></i>
                        </div>
                        <div>
                            <div style="color:#fff;font-weight:600;font-size:1.05rem;">Account Status Active</div>
                            <div style="color:var(--text-secondary);font-size:0.85rem;">Current status: <strong class="{{ $account->status === 'active' ? 'text-success' : 'text-warning' }}">{{ ucfirst($account->status) }}</strong></div>
                        </div>
                    </div>
                    <div>
                        @if($account->status === 'active')
                            <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2"><i class="fas fa-check-circle me-1"></i> Passed</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-3 py-2"><i class="fas fa-times-circle me-1"></i> Failed</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="mt-5 text-center">
                @if($certEligible)
                    <a href="{{ route('intern.certificate.download') }}" target="_blank"
                        class="btn btn-premium btn-lg rounded-pill shadow-lg px-5 mb-3"
                        style="font-size:1.1rem; width:300px; display:inline-flex; align-items:center; justify-content:center; text-decoration:none;">
                        <i class="fas fa-download me-2"></i> Download Certificate
                    </a>
                    <br>
                    <button class="btn btn-outline-info rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#certificateModal">
                        <i class="fas fa-eye me-2"></i> Preview Certificate
                    </button>
                    <p class="mt-3 small text-v2-muted">Your certificate is ready. Click above to download or preview.</p>
                @else
                    <button class="btn btn-outline-secondary btn-lg rounded-pill px-5 mb-3" style="font-size:1.1rem;opacity:0.6;cursor:not-allowed; width: 300px;" disabled>
                        <i class="fas fa-lock me-2"></i> Certificate Locked
                    </button>
                    <br>
                    <button class="btn btn-outline-warning rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#certificateModal">
                        <i class="fas fa-eye me-2"></i> Preview Locked Certificate
                    </button>
                    <p class="mt-3 small text-v2-muted">You must meet all requirements to unlock your certificate.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Certificate Preview Modal -->
<div class="modal fade" id="certificateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="background: transparent; border: none;">
            <div class="modal-header border-0 pb-0 justify-content-end">
                <button type="button" class="btn-close btn-close-white bg-dark p-2 rounded-circle" data-bs-dismiss="modal" aria-label="Close" style="opacity: 1; z-index: 10;"></button>
            </div>
            <div class="modal-body d-flex justify-content-center p-0">
                <!-- Certificate Wrapper -->
                <div class="position-relative shadow-lg" style="width: 100%; max-width: 900px; aspect-ratio: 1.414 / 1; background: #ffffff; border: 15px solid #1e293b; padding: 20px; overflow: hidden;">
                    <!-- Inner Border -->
                    <div style="border: 2px solid #f05223; height: 100%; padding: 40px; position: relative; background: url('https://www.transparenttextures.com/patterns/cubes.png'); z-index: 1;">
                        
                        <!-- Corner Ornaments -->
                        <div style="position:absolute; top: 10px; left: 10px; border-top: 3px solid #f05223; border-left: 3px solid #f05223; width: 40px; height: 40px;"></div>
                        <div style="position:absolute; top: 10px; right: 10px; border-top: 3px solid #f05223; border-right: 3px solid #f05223; width: 40px; height: 40px;"></div>
                        <div style="position:absolute; bottom: 10px; left: 10px; border-bottom: 3px solid #f05223; border-left: 3px solid #f05223; width: 40px; height: 40px;"></div>
                        <div style="position:absolute; bottom: 10px; right: 10px; border-bottom: 3px solid #f05223; border-right: 3px solid #f05223; width: 40px; height: 40px;"></div>

                        <!-- Header -->
                        <div class="text-center mb-4">
                            @php
                                $certLogo = \App\Models\SiteSetting::getValue('site_logo', 'logo.png');
                            @endphp
                            @if(file_exists(public_path('uploads/settings/'.$certLogo)))
                                <img src="{{ asset('uploads/settings/'.$certLogo) }}" alt="Logo" style="max-height: 80px; margin-bottom: 10px;">
                            @else
                                <h2 style="font-family:'Outfit'; font-weight: 900; color: #1e293b; font-size: 2.5rem; letter-spacing: 2px; margin-bottom: 0;">INNOVATIVE<span style="color:#f05223;">IT</span> SOLUTIONS</h2>
                            @endif
                            <p style="color: #64748b; font-size: 0.9rem; letter-spacing: 4px; text-transform: uppercase;">Certificate of Completion</p>
                        </div>

                        <!-- Body -->
                        <div class="text-center" style="margin-top: 50px;">
                            <p style="font-family: 'Inter', serif; font-style: italic; color: #475569; font-size: 1.2rem; margin-bottom: 15px;">This is proudly presented to</p>
                            
                            @if($certEligible)
                                <h1 style="font-family: 'Outfit'; font-weight: 700; color: #0f172a; font-size: 3.5rem; border-bottom: 1px solid #cbd5e1; display: inline-block; padding-bottom: 10px; margin-bottom: 20px;">
                                    {{ $user->name }}
                                </h1>
                            @else
                                <h1 style="font-family: 'Outfit'; font-weight: 700; color: #cbd5e1; font-size: 3.5rem; border-bottom: 1px dashed #cbd5e1; display: inline-block; padding-bottom: 10px; margin-bottom: 20px; filter: blur(4px); user-select: none;">
                                    Student Name
                                </h1>
                            @endif

                            <p style="font-family: 'Inter'; color: #475569; font-size: 1.1rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                                For successfully completing the rigorous <strong>{{ $account->category->name }}</strong> Internship Program. 
                                During this period, the candidate demonstrated outstanding skills, dedication, and professional excellence.
                            </p>
                        </div>

                        <!-- Footer / Signatures -->
                        <div class="d-flex justify-content-between align-items-end" style="position: absolute; bottom: 50px; left: 50px; right: 50px;">
                            <div class="text-center">
                                <div style="border-bottom: 1px solid #1e293b; width: 180px; margin-bottom: 5px;"></div>
                                <p style="margin:0; font-family: 'Outfit'; font-weight: 600; color: #1e293b;">Jane Doe</p>
                                <small style="color: #64748b; font-size: 0.8rem;">Head of Operations</small>
                            </div>
                            
                            <!-- QR Code & Seal -->
                            <div class="text-center position-relative">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=InnovativeIT-Cert-{{ $account->id }}" alt="QR Code" style="border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-radius: 8px;">
                                <div style="position: absolute; top: -15px; right: -25px; background: #f59e0b; color: #fff; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                                    <i class="fas fa-award"></i>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <div style="border-bottom: 1px solid #1e293b; width: 180px; margin-bottom: 5px;"></div>
                                <p style="margin:0; font-family: 'Outfit'; font-weight: 600; color: #1e293b;">John Smith</p>
                                <small style="color: #64748b; font-size: 0.8rem;">Lead {{ $account->category->name }} Mentor</small>
                            </div>
                        </div>

                        <!-- Locked Overlay -->
                        @if(!$certEligible)
                            <div style="position: absolute; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(5px); z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: inherit;">
                                <div style="font-size: 5rem; color: #f59e0b; margin-bottom: 20px; text-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <h3 style="font-family: 'Outfit'; font-weight: 800; color: #fff; letter-spacing: 2px; text-transform: uppercase;">Certificate Locked</h3>
                                <p style="color: #cbd5e1; max-width: 400px; text-align: center;">Complete all internship requirements to unlock your official certificate and reveal your name.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
