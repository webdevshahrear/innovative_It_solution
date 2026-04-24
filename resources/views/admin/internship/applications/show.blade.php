@extends('layouts.admin')

@push('styles')
<style>
    .cyber-header {
        position: relative; padding: 50px; border-radius: 36px;
        background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.08);
        margin-bottom: 50px; overflow: hidden; backdrop-filter: blur(24px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.1);
    }
    .cyber-header::before {
        content: ''; position: absolute; inset: -50%;
        background: radial-gradient(circle at 20% 50%, rgba(240, 82, 35, 0.12), transparent 50%),
                    radial-gradient(circle at 80% 30%, rgba(167, 139, 250, 0.1), transparent 50%);
        animation: rotateGlow 25s linear infinite; pointer-events: none; z-index: 0;
    }
    .cyber-header > * { position: relative; z-index: 1; }
    @keyframes rotateGlow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
<div class="cyber-header d-flex justify-content-between align-items-center" data-aos="fade-down">
    <div>
        <div class="d-flex align-items-center gap-2 mb-3">
            <span style="width:10px;height:10px;background:var(--v2-primary);border-radius:50%; box-shadow: 0 0 12px var(--v2-primary); display:inline-block;"></span>
            <span class="text-uppercase fw-bold" style="color:var(--v2-primary); font-size:0.75rem; letter-spacing:2px">Applicant Dossier</span>
        </div>
        <h1 class="text-white m-0" style="font-size: 2.5rem; font-weight: 900; font-family: 'Outfit'; letter-spacing: -0.03em;">Candidate <span style="background: linear-gradient(135deg, #f05223, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Profile</span></h1>
        <p class="text-v2-muted mt-2 mb-0" style="font-size: 1rem;">{{ $application->full_name }} — Biometrics, diagnostics & lifecycle management.</p>
    </div>
    <a href="{{ route('admin.internship.applications.index') }}" class="btn-neo-glass py-3 px-4" style="border-radius: 20px;">
        <i class="fas fa-arrow-left me-2 text-primary"></i> Back to Pipeline
    </a>
</div>

<div class="row g-4 pb-5">
    <div class="col-lg-8" data-aos="fade-up">
        {{-- Profile Dossier --}}
        <div class="tech-card-v2 mb-4 p-4 p-md-5">
            <div class="d-flex align-items-center gap-3 mb-4 border-bottom border-secondary border-opacity-25 pb-4">
                <div class="metric-icon-v2"><i class="fas fa-user-shield"></i></div>
                <h5 class="text-v2-main m-0 fw-bold letter-spacing-1">CANDIDATE BIOMETRICS</h5>
            </div>
            
            <div class="row g-4 text-white">
                <div class="col-md-6">
                    <span class="text-v2-muted d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Personal Dossier</span>
                    <div class="fw-bold d-flex flex-column gap-2">
                        <span><i class="fas fa-user-friends text-primary small me-2"></i> F: {{ $application->father_name }}</span>
                        <span><i class="fas fa-venus-mars text-primary small me-2"></i> M: {{ $application->mother_name }}</span>
                        <span><i class="fas fa-cake-candles text-primary small me-2"></i> DOB: {{ optional($application->dob)->format('d M, Y') }} ({{ \Carbon\Carbon::parse($application->dob)->age }} yrs)</span>
                        <span><i class="fas fa-droplet text-primary small me-2"></i> Blood: {{ $application->blood_group }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="text-v2-muted d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Secure Identity</span>
                    <div class="fw-bold d-flex flex-column gap-2">
                        <span><i class="fas fa-envelope text-primary small me-2"></i> {{ $application->email }}</span>
                        <span><i class="fas fa-phone text-primary small me-2"></i> {{ $application->phone }}</span>
                        <span><i class="fas fa-hashtag text-primary small me-2"></i> NID/BC: {{ $application->nid_birth_number }}</span>
                        <span class="text-info"><i class="fab fa-linkedin text-info small me-2"></i> <a href="{{ $application->linkedin_url }}" target="_blank" class="text-info text-decoration-none">LinkedIn Profile</a></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="text-v2-muted d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Deployment Location</span>
                    <div class="opacity-75 d-flex flex-column gap-1">
                        <div><i class="fas fa-map-location-dot me-2 text-primary small"></i> <strong>District:</strong> {{ $application->district }}</div>
                        <div class="small"><i class="fas fa-location-dot me-2 text-primary small"></i> <strong>Current:</strong> {{ $application->address }}</div>
                        <div class="small"><i class="fas fa-house-user me-2 text-primary small"></i> <strong>Permanent:</strong> {{ $application->permanent_address }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="text-v2-muted d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Educational Stratum</span>
                    <div class="opacity-75 d-flex flex-column gap-1">
                        <div><i class="fas fa-graduation-cap me-2 text-primary small"></i> {{ $application->education }} ({{ ucfirst($application->current_status) }})</div>
                        <div class="small"><i class="fas fa-university me-2 text-primary small"></i> {{ $application->institute_name }}</div>
                        <div class="small"><i class="fas fa-calendar-check me-2 text-primary small"></i> <strong>Passing:</strong> {{ $application->passing_year }}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 rounded-4" style="background:rgba(239,68,68,0.05); border:1px solid rgba(239,68,68,0.1)">
                        <span class="text-danger d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Emergency Mobilization Vector</span>
                        <div class="row">
                            <div class="col-md-4"><strong>Name:</strong> {{ $application->emergency_contact_name }}</div>
                            <div class="col-md-4"><strong>Rel:</strong> {{ $application->emergency_contact_relationship }}</div>
                            <div class="col-md-4"><strong>Phone:</strong> {{ $application->emergency_contact_phone }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 mb-4 mt-5 border-bottom border-secondary border-opacity-25 pb-4">
                <div class="metric-icon-v2" style="background:rgba(16,185,129,0.1); color:#10b981; border-color:rgba(16,185,129,0.2)"><i class="fas fa-microchip"></i></div>
                <h5 class="text-v2-main m-0 fw-bold letter-spacing-1">TECHNICAL SPECTRUM</h5>
            </div>
            
            <div class="row g-4 text-white">
                <div class="col-md-6">
                    <span class="text-v2-muted d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Primary Vector</span>
                    <div class="fw-bold text-primary" style="font-size: 1.1rem">{{ $application->preferredCategory->name }}</div>
                </div>
                <div class="col-md-6">
                    <span class="text-v2-muted d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Secondary Vector</span>
                    <div class="opacity-75">{{ $application->secondaryCategory ? $application->secondaryCategory->name : 'N/A' }}</div>
                </div>
                <div class="col-12">
                    <span class="text-v2-muted d-block small mb-3 text-uppercase fw-bold letter-spacing-1">Skill Matrix</span>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(explode(',', $application->skills) as $skill)
                            <span class="badge border border-secondary bg-dark bg-opacity-50 px-3 py-2" style="font-size:0.7rem; border-radius:100px">{{ trim($skill) }}</span>
                        @endforeach
                    </div>
                </div>
                @if($application->portfolio_url)
                <div class="col-md-6">
                    <span class="text-v2-muted d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Digital Footprint</span>
                    <a href="{{ $application->portfolio_url }}" target="_blank" class="text-info text-decoration-none d-flex align-items-center gap-2">
                        <i class="fas fa-external-link-alt small"></i> Open Portfolio
                    </a>
                </div>
                @endif
                @if($application->cv_path)
                <div class="col-md-6">
                    <span class="text-v2-muted d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Verification Asset</span>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn-neo-glass py-2 px-3 small" style="font-size: 0.75rem" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal">
                            <i class="fas fa-eye me-2 text-primary"></i> PREVIEW ASSET
                        </button>
                        <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="btn-neo-glass py-2 px-3 small border-0 bg-primary bg-opacity-10" style="font-size: 0.75rem">
                            <i class="fas fa-download me-2"></i>
                        </a>
                    </div>
                </div>

                <!-- PDF Preview Modal -->
                <div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content bg-v2-card-glass border-v2" style="backdrop-filter: blur(20px);">
                            <div class="modal-header border-bottom border-secondary border-opacity-25 py-3">
                                <h5 class="modal-title text-v2-main fw-bold small text-uppercase letter-spacing-1">
                                    <i class="fas fa-file-pdf me-2 text-primary"></i> Professional CV Preview
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0" style="height: 80vh;">
                                <iframe src="{{ asset('storage/' . $application->cv_path) }}#toolbar=0" width="100%" height="100%" style="border: none;"></iframe>
                            </div>
                            <div class="modal-footer border-top border-secondary border-opacity-25 py-2">
                                <span class="text-v2-muted small me-auto">Secure Diagnostic Viewer v2.0</span>
                                <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="btn btn-sm btn-primary px-3 rounded-pill">
                                    <i class="fas fa-external-link-alt me-1"></i> Open in New Tab
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-12">
                    <span class="text-v2-muted d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Cognitive Motivation</span>
                    <div class="p-4 rounded-4" style="background:rgba(255,255,255,0.02); border:1px solid var(--v2-border); line-height:1.6; opacity:0.8; font-style:italic">
                        "{{ $application->motivation }}"
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded-4 border border-secondary border-opacity-10 text-center" style="background:rgba(255,255,255,0.01)">
                        <span class="text-v2-muted d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Temporal Bandwidth</span>
                        <div class="fw-bold">{{ $application->available_hours }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded-4 border border-secondary border-opacity-10 text-center" style="background:rgba(255,255,255,0.01)">
                        <span class="text-v2-muted d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Hardware Audit</span>
                        <div class="fw-bold">{!! $application->has_laptop ? '<span class="text-success">MATCHED</span>' : '<span class="text-danger">MISSING</span>' !!}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded-4 border border-secondary border-opacity-10 text-center" style="background:rgba(255,255,255,0.01)">
                        <span class="text-v2-muted d-block small mb-2 text-uppercase fw-bold letter-spacing-1">Protocol Stability</span>
                        <div class="fw-bold">{!! $application->has_internet ? '<span class="text-success">STABLE</span>' : '<span class="text-danger">UNSTABLE</span>' !!}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Diagnostic History --}}
        <div class="tech-card-v2 p-4 p-md-5">
            <div class="d-flex align-items-center gap-3 mb-4 border-bottom border-secondary border-opacity-25 pb-4">
                <div class="metric-icon-v2" style="background:rgba(245,158,11,0.1); color:#f59e0b; border-color:rgba(245,158,11,0.2)"><i class="fas fa-brain"></i></div>
                <h5 class="text-v2-main m-0 fw-bold letter-spacing-1">DIAGNOSTIC TELEMETRY</h5>
            </div>
            
            @if($application->examAttempts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-v2 mb-0">
                        <thead>
                            <tr>
                                <th>TEMPORAL STAMP</th>
                                <th>PRECISION</th>
                                <th>DURATION</th>
                                <th>INTEGRITY</th>
                                <th class="text-end">FINAL STATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($application->examAttempts as $attempt)
                            <tr>
                                <td class="small opacity-75 font-monospace">{{ \Carbon\Carbon::parse($attempt->created_at)->format('d M, Y H:i') }}</td>
                                <td class="fw-bold">{{ round($attempt->score_percentage) }}%</td>
                                <td class="small">{{ \Carbon\Carbon::parse($attempt->end_time ?? now())->diffInMinutes(\Carbon\Carbon::parse($attempt->start_time)) }} MINS</td>
                                <td>
                                    @if($attempt->tabViolations->count() > 0)
                                        <span class="text-danger fw-bold"><i class="fas fa-triangle-exclamation me-1"></i> {{ $attempt->tabViolations->count() }} BREACHES</span>
                                    @else
                                        <span class="text-success small"><i class="fas fa-shield-halved me-1"></i> SECURE</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if($attempt->status == 'passed') <span class="badge border border-success text-success bg-success bg-opacity-10 px-3 py-1" style="font-size:0.6rem; border-radius:100px">PASSED</span>
                                    @elseif($attempt->status == 'failed') <span class="badge border border-warning text-warning bg-warning bg-opacity-10 px-3 py-1" style="font-size:0.6rem; border-radius:100px">FAILED</span>
                                    @elseif($attempt->status == 'terminated') <span class="badge border border-danger text-danger bg-danger bg-opacity-10 px-3 py-1" style="font-size:0.6rem; border-radius:100px">TERMINATED</span>
                                    @else <span class="badge bg-secondary px-3 py-1" style="font-size:0.6rem; border-radius:100px">ACTIVE</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 bg-dark bg-opacity-25 rounded-4 border border-dashed border-secondary">
                    <p class="text-v2-muted mb-0"><i class="fas fa-ghost me-2 opacity-50"></i> No diagnostic records synchronized yet.</p>
                </div>
            @endif
        </div>
        
    </div>

    <div class="col-lg-4" data-aos="fade-left" data-aos-delay="100">
        {{-- Lifecycle Management --}}
        <div class="tech-card-v2 mb-4 p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="metric-icon-v2 small"><i class="fas fa-sliders"></i></div>
                <h6 class="text-v2-main m-0 fw-bold letter-spacing-1">LIFECYCLE CONTROL</h6>
            </div>
            
            <form action="{{ route('admin.internship.applications.status', $application) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Decision Vector</label>
                    <select name="status" class="form-select v2-admin-input shadow-none">
                        <option value="pending" {{ $application->status=='pending'?'selected':'' }}>Awaiting Diagnosis</option>
                        <option value="reviewed" {{ $application->status=='reviewed'?'selected':'' }}>Manual Review Phase</option>
                        <option value="active" {{ $application->status=='active'?'selected':'' }}>Lifecycle Activation</option>
                        <option value="rejected" {{ $application->status=='rejected'?'selected':'' }}>Abort / Suspension</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Telemetry Logs (Internal)</label>
                    <textarea name="admin_notes" class="form-control v2-admin-input shadow-none" rows="4" placeholder="Log internal observations here...">{{ $application->admin_notes }}</textarea>
                </div>
                <button type="submit" class="btn-v2-primary w-100 py-3 font-weight-bold shadow-lg">SYNCHRONIZE STATE</button>
            </form>
        </div>

        {{-- Financial Mobilization --}}
        <div class="tech-card-v2 p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="metric-icon-v2 small"><i class="fas fa-vault"></i></div>
                <h6 class="text-v2-main m-0 fw-bold letter-spacing-1">MOBILIZATION AUDIT</h6>
            </div>

            @if($application->payments->where('status', 'success')->count() > 0)
                <div class="p-4 rounded-4" style="background:rgba(16,185,129,0.05); border: 1px solid rgba(16,185,129,0.2)">
                    <div class="d-flex align-items-center gap-3 text-success fw-bold mb-3">
                        <i class="fas fa-circle-check fs-4"></i> DEPOSIT SETTLED
                    </div>
                    <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.03)">
                        <div class="text-v2-muted small text-uppercase fw-bold mb-1">Vector Identification:</div>
                        <div class="text-white fw-bold">{{ strtoupper($application->payments->firstWhere('status','success')->payment_method) }} GATEWAY</div>
                    </div>
                </div>
            @else
                <div class="p-4 rounded-4 border border-dashed border-warning bg-warning bg-opacity-5 text-center">
                    <div class="metric-icon-v2 mx-auto mb-3" style="background:rgba(245,158,11,0.1); color:#f59e0b; border-color:rgba(245,158,11,0.2)"><i class="fas fa-triangle-exclamation"></i></div>
                    <div class="text-warning fw-bold small text-uppercase mb-1">Mobilization Pending</div>
                    <div class="text-v2-muted small opacity-75">No liquidity events found for this candidate.</div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
