@extends('layouts.frontend')

@section('title', 'Internship Program — Innovative IT Solutions')
@section('meta_description', 'Join our 3-month internship program in web development, design, digital marketing, and more. Apply today!')

@push('styles')
<style>
/* ── Premium Hero: The Cyber-Vanguard ── */
.int-hero {
    min-height: 90vh;
    display: flex;
    align-items: center;
    background: radial-gradient(circle at 70% 30%, rgba(240, 82, 35, 0.12) 0%, transparent 60%),
                radial-gradient(circle at 20% 70%, rgba(59, 130, 246, 0.12) 0%, transparent 60%),
                var(--navy-dark);
    padding: 140px 0 100px;
    position: relative;
    overflow: hidden;
    z-index: 1;
}
body.light-mode .int-hero {
    background: radial-gradient(circle at 70% 30%, rgba(240, 82, 35, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 20% 70%, rgba(59, 130, 246, 0.05) 0%, transparent 50%),
                #fcfdfe;
}

.hero-badge {
    display: inline-flex; align-items: center; gap: 10px;
    background: rgba(240,82,35,0.08); border: 1px solid rgba(240,82,35,0.2);
    color: #f05223; border-radius: 50px; padding: 10px 24px; font-size: 0.85rem;
    font-weight: 800; letter-spacing: 0.08em; margin-bottom: 28px;
    box-shadow: 0 0 30px rgba(240,82,35,0.1);
    backdrop-filter: blur(12px); text-transform: uppercase;
}

.hero-title {
    font-family: 'Outfit', sans-serif; font-weight: 800;
    font-size: clamp(3rem, 6vw, 4.8rem); line-height: 1.0;
    background: linear-gradient(135deg, #ffffff 40%, rgba(255,255,255,0.5) 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    margin-bottom: 28px; letter-spacing: -0.04em;
}
body.light-mode .hero-title {
    background: linear-gradient(135deg, #0f172a 40%, #475569 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
}

.hero-sub {
    font-size: 1.2rem; color: var(--text-muted); max-width: 600px;
    line-height: 1.7; margin-bottom: 45px; font-weight: 400; opacity: 0.9;
}

/* ── Interactive Categories Bento ── */
.cat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
}

.cat-card-premium {
    background: var(--card-bg);
    border: 1px solid transparent;
    background-clip: padding-box;
    border-radius: 32px;
    padding: 45px 35px;
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(30px);
    display: flex;
    flex-direction: column;
    height: 100%;
}
body.light-mode .cat-card-premium { background: rgba(255,255,255,0.8); }

/* Premium Gradient Border */
.cat-card-premium::after {
    content: ''; position: absolute; inset: 0; padding: 1.5px;
    background: linear-gradient(135deg, rgba(240,82,35,0.4), rgba(255,255,255,0.05), rgba(59,130,246,0.3));
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor; mask-composite: exclude;
    pointer-events: none; opacity: 0.5; transition: opacity 0.4s;
}
.cat-card-premium:hover::after { opacity: 1; }

.cat-card-premium:hover {
    transform: translateY(-12px) scale(1.01);
    box-shadow: 0 40px 100px rgba(0,0,0,0.5), 0 0 40px rgba(240,82,35,0.1);
    background: var(--navy-light);
}
body.light-mode .cat-card-premium:hover { background: #fff; box-shadow: 0 30px 60px rgba(0,0,0,0.08); }

/* Scanning Line Effect */
.scanner-line {
    position: absolute; top: -100%; left: 0; width: 100%; height: 2px;
    background: linear-gradient(90deg, transparent, rgba(240,82,35,0.2), transparent);
    z-index: 1; pointer-events: none;
}
.cat-card-premium:hover .scanner-line {
    animation: scan-loop 2s linear infinite;
}
@keyframes scan-loop {
    0% { top: -10%; }
    100% { top: 110%; }
}

.sector-tag {
    position: absolute; top: 25px; right: 30px;
    font-family: 'JetBrains Mono', 'Courier New', monospace;
    font-size: 0.65rem; color: var(--primary); opacity: 0.6;
    letter-spacing: 0.2em; font-weight: 800; border-bottom: 1px solid rgba(240,82,35,0.2);
}

.cat-icon-box {
    width: 68px; height: 68px; 
    background: rgba(240,82,35,0.04);
    border-radius: 20px; border: 1px solid rgba(240,82,35,0.1);
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; color: #f05223; margin-bottom: 32px;
    transition: all 0.5s; position: relative;
}
.cat-icon-box::before {
    content: ''; position: absolute; inset: -5px; background: var(--primary);
    border-radius: inherit; filter: blur(15px); opacity: 0; transition: 0.4s;
}
.cat-card-premium:hover .cat-icon-box {
    background: var(--primary); color: #fff; transform: translateY(-5px);
}
.cat-card-premium:hover .cat-icon-box::before { opacity: 0.2; }

.cat-title { font-family:'Outfit', sans-serif; font-weight: 700; font-size: 1.35rem; color: var(--white); margin-bottom: 12px; }
.cat-details { color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; flex-grow: 1; margin-bottom: 25px; }

/* ── Premium Protocol Buttons ── */
.btn-protocol {
    display: inline-flex; align-items: center; gap: 12px;
    padding: 18px 35px; border-radius: 100px;
    background: rgba(240,82,35,0.05); border: 1.5px solid rgba(240,82,35,0.25);
    color: #fff !important; font-weight: 800; font-size: 0.9rem;
    text-transform: uppercase; letter-spacing: 0.1em; transition: all 0.4s;
    text-decoration: none !important; position: relative; overflow: hidden;
    height: 60px; /* Matching height */
}
body.light-mode .btn-protocol {
    background: #f8fafc; border-color: #e2e8f0;
    color: #0f172a !important;
}
.btn-protocol i { transition: transform 0.4s; font-size: 1.2rem; }
.btn-protocol:hover {
    background: var(--primary); color: #fff !important;
    border-color: var(--primary);
    box-shadow: 0 15px 30px rgba(240,82,35,0.2); transform: translateY(-3px);
}
.btn-protocol:hover i { transform: translateX(3px); }

/* ── Cyber-Timeline ── */
.timeline-modern { position: relative; padding: 40px 0; }
.timeline-modern::before {
    content: ''; position: absolute; left: 50%; top: 0; bottom: 0;
    width: 1px; background: linear-gradient(to bottom, transparent, var(--border), var(--primary), var(--border), transparent);
    transform: translateX(-50%);
}

.timeline-step {
    display: flex; align-items: center; margin-bottom: 60px; position: relative;
    width: 100%;
}
.timeline-step:nth-child(even) { flex-direction: row-reverse; }

.step-content {
    width: calc(50% - 60px);
    background: var(--card-bg); border: 1px solid var(--border);
    padding: 35px; border-radius: 24px; backdrop-filter: blur(15px);
    transition: all 0.4s;
}
.timeline-step:hover .step-content { border-color: var(--primary); transform: scale(1.02); }

.step-point {
    width: 40px; height: 40px; background: var(--navy-dark);
    border: 2px solid var(--primary); border-radius: 50%;
    position: absolute; left: 50%; transform: translateX(-50%);
    z-index: 2; display: flex; align-items: center; justify-content: center;
    box-shadow: 0 0 20px rgba(240,82,35,0.4); 
}
.step-point span { font-weight: 900; color: var(--primary); font-size: 0.9rem; }

/* ── Buttons Upgrade ── */
.btn-premium-cta {
    background: linear-gradient(135deg, #f05223 0%, #ff7849 100%);
    color: #fff !important; padding: 18px 45px; border-radius: 100px;
    font-weight: 800; font-size: 1.1rem; border: none; text-transform: uppercase;
    letter-spacing: 0.1em; display: inline-flex; align-items: center; gap: 15px;
    box-shadow: 0 15px 45px rgba(240,82,35,0.35); transition: all 0.4s;
}
.btn-premium-cta:hover { transform: translateY(-5px); box-shadow: 0 25px 60px rgba(240,82,35,0.5); }

/* ── Orbit V2 ── */
.orbit-v2 { position: relative; width: 450px; height: 450px; margin: auto; }
.circle-blur {
    position: absolute; inset: 10%; background: var(--primary);
    filter: blur(120px); opacity: 0.15; border-radius: 50%;
}
.orbit-track {
    position: absolute; inset: 0; border: 1px solid rgba(255,255,255,0.05);
    border-radius: 50%; animation: spin-linear 20s linear infinite;
}
.orbit-track-inner {
    position: absolute; inset: 25%; border: 1px solid rgba(240,82,35,0.1);
    border-radius: 50%; animation: spin-linear 15s linear infinite reverse;
}
@keyframes spin-linear { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

.orbit-element {
    position: absolute; width: 54px; height: 54px; 
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: 12px; display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; backdrop-filter: blur(10px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}
.orbit-center-icon {
    position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);
    font-size: 4.5rem; color: var(--primary); filter: drop-shadow(0 0 30px rgba(240,82,35,0.4));
}

@media (max-width: 991px) {
    .timeline-modern::before { left: 40px; }
    .step-point { left: 40px; }
    .step-content { width: calc(100% - 100px); margin-left: 80px; }
    .timeline-step:nth-child(even) { flex-direction: row; }
}
</style>
@endpush

@section('content')

{{-- ── Hero Section ── --}}
<section class="int-hero">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="hero-badge">
                    <i class="bi bi-mortarboard-fill"></i>
                    Future-Ready Internship 2026
                </div>
                <h1 class="hero-title">Forge Your Future in <span class="text-v2-main">Tech Vanguard</span></h1>
                <p class="hero-sub">
                    Skip the coffee runs. Join a high-performance ecosystem where you contribute to live production systems and master advanced technical clinicals.
                </p>

                <div class="d-flex flex-wrap gap-4 align-items-center mb-5">
                    <div class="d-flex align-items-center gap-3">
                        <div class="num-stat text-v2-main fs-2 fw-bold font-monospace">{{ $stats['applications'] }}+</div>
                        <div class="small text-v2-muted text-uppercase fw-bold letter-spacing-1">Cadets<br>Enrolled</div>
                    </div>
                    <div class="vr opacity-10 d-none d-md-block"></div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="num-stat text-v2-main fs-2 fw-bold font-monospace">{{ $stats['categories'] }}</div>
                        <div class="small text-v2-muted text-uppercase fw-bold letter-spacing-1">Expert<br>Tracks</div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3 align-items-center mb-5">
                    <a href="{{ route('internship.apply') }}" class="btn-premium-cta">
                        Bridge the Gap <i class="bi bi-arrow-right-short"></i>
                    </a>
                    <a href="{{ route('internship.login') }}" class="btn-protocol">
                        <i class="bi bi-person-lock"></i> Intern Login
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="zoom-in">
                <div class="orbit-v2">
                    <div class="circle-blur"></div>
                    <div class="orbit-track">
                        <div class="orbit-element" style="top: 0; left: 50%; transform: translateX(-50%);"><i class="bi bi-code-slash text-primary"></i></div>
                        <div class="orbit-element" style="bottom: 0; left: 50%; transform: translateX(-50%);"><i class="bi bi-brush text-primary"></i></div>
                    </div>
                    <div class="orbit-track-inner">
                        <div class="orbit-element" style="top: 50%; left: 0; transform: translateY(-50%);"><i class="bi bi-phone text-primary"></i></div>
                        <div class="orbit-element" style="top: 50%; right: 0; transform: translateY(-50%);"><i class="bi bi-graph-up-arrow text-primary"></i></div>
                    </div>
                    <div class="orbit-center-icon">
                        <i class="bi bi-rocket-takeoff-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Critical Data Stream ── --}}
<section class="py-5" style="border-top: 1px solid var(--border);">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up">
                <div class="p-4 rounded-4" style="background: rgba(240,82,35,0.03); border: 1px solid rgba(240,82,35,0.1);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="bi bi-shield-lock-fill text-v2-main fs-3"></i>
                        <h6 class="m-0 text-white fw-bold">Security & Integrity</h6>
                    </div>
                    <p class="small text-v2-muted mb-0">Refundable security fee of ৳1,000 required post-exam. Refunded instantly upon project graduation.</p>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4 rounded-4" style="background: rgba(59,130,246,0.03); border: 1px solid rgba(59,130,246,0.1);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="bi bi-wallet2 text-info fs-3"></i>
                        <h6 class="m-0 text-white fw-bold">Yield Management</h6>
                    </div>
                    <p class="small text-v2-muted mb-0">Performance-based rewards and project commissions. This is a skill-for-work professional ecosystem.</p>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4 rounded-4" style="background: rgba(16,185,129,0.03); border: 1px solid rgba(16,185,129,0.1);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="bi bi-award-fill text-success fs-3"></i>
                        <h6 class="m-0 text-white fw-bold">Credentialing</h6>
                    </div>
                    <p class="small text-v2-muted mb-0">Earn ISO-certified completions and specialized tech badges recognized across the IT sector.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Specialist Tracks: Bento Grid ── --}}
<section class="py-section">
    <div class="container">
        <div class="section-tag text-center mb-5" data-aos="fade-up">
            <span class="tag">Active Vectors</span>
            <h2 class="text-white">Choose Your Combat specialization</h2>
            <p class="text-v2-muted mx-auto" style="max-width: 600px;">We currently have {{ $categories->count() }} specialized departments open for recruitment. Choose where you want to dominate.</p>
        </div>

        <div class="cat-grid">
            @foreach($categories as $category)
            <div class="cat-card-premium" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                <div class="scanner-line"></div>
                <div class="sector-tag">SECTOR-0{{ $loop->iteration }}</div>
                <div class="cat-icon-box">
                    <i class="bi {{ $category->icon ?: 'bi-cpu' }}"></i>
                </div>
                <h5 class="cat-title">{{ $category->name }}</h5>
                <p class="cat-details">{{ $category->description ?? 'Advanced professional track for industry excellence.' }}</p>
                <a href="{{ route('internship.apply') }}?category={{ $category->id }}" class="btn-protocol">
                    INITIATE PROTOCOL <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Protocol Steps ── --}}
<section class="py-section" style="background: rgba(255,255,255,0.01); border-top: 1px solid var(--border);">
    <div class="container">
        <div class="section-tag text-center mb-5" data-aos="fade-up">
            <span class="tag">Sequence</span>
            <h2 class="text-white">The Ascension Protocol</h2>
        </div>

        <div class="timeline-modern">
            @php
            $steps = [
                ['num'=>1,'bi'=>'bi-pencil-square', 'title'=>'Digital Application', 'desc'=>'Submit your professional dossier via our cryptographic application portal.'],
                ['num'=>2,'bi'=>'bi-journal-check', 'title'=>'Terms Decryption', 'desc'=>'Review and synchronize with our operational terms and conditions.'],
                ['num'=>3,'bi'=>'bi-cpu', 'title'=>'Neural Evaluation', 'desc'=>'Undergo a 20-phase MCQ assessment with real-time biometric integrity monitoring.'],
                ['num'=>4,'bi'=>'bi-check-all', 'title'=>'Validation', 'desc'=>'Secure your seat with the refundable activation fee via secure global gateways.'],
                ['num'=>5,'bi'=>'bi-person-badge', 'title'=>'Terminal Access', 'desc'=>'Receive your unique credentials and enter the centralized intern command center.'],
                ['num'=>6,'bi'=>'bi-trophy', 'title'=>'Mission Completion', 'desc'=>'Execute tasks, reach peak performance metrics, and receive global certification.'],
            ];
            @endphp

            @foreach($steps as $step)
            <div class="timeline-step" data-aos="{{ $loop->index % 2 == 0 ? 'fade-right' : 'fade-left' }}">
                <div class="step-point"><span>{{ $step['num'] }}</span></div>
                <div class="step-content">
                    <h5 class="text-white fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="bi {{ $step['bi'] }} text-v2-main"></i>
                        {{ $step['title'] }}
                    </h5>
                    <p class="text-v2-muted mb-0 small">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Final CTA ── --}}
<section class="py-section">
    <div class="container">
        <div class="int-cta text-center p-5 rounded-5 border border-primary border-opacity-10 position-relative overflow-hidden" data-aos="zoom-in" style="background: radial-gradient(circle at top right, rgba(240,82,35,0.1), transparent);">
            <div class="position-absolute top-0 start-0 w-100 h-100 opacity-5" style="background-image: var(--v2-mesh); pointer-events: none;"></div>
            <h2 class="text-white mb-4">Start Your Career Evolution</h2>
            <p class="text-v2-muted mx-auto mb-5" style="max-width: 500px;">The recruitment phase for 2026 is currently active. Do not miss your chance to join the vanguard.</p>
            <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
                <a href="{{ route('internship.apply') }}" class="btn-premium-cta">
                    Enter the Portal <i class="bi bi-door-open-fill"></i>
                </a>
                <a href="{{ route('internship.login') }}" class="btn-protocol">
                    <i class="bi bi-person-lock"></i> Existing Intern Login
                </a>
            </div>
            <div class="d-flex justify-content-center gap-4 text-v2-muted small fw-bold">
                <span><i class="bi bi-clock me-1 text-v2-main"></i> 8m to apply</span>
                <span><i class="bi bi-patch-check me-1 text-v2-main"></i> ISO Certified</span>
                <span><i class="bi bi-credit-card me-1 text-v2-main"></i> Instant Refund</span>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Category Hover Effect: X/Y Mouse Tracking
document.querySelectorAll('.cat-card-premium').forEach(card => {
    card.addEventListener('mousemove', e => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        card.style.setProperty('--x', `${x}px`);
        card.style.setProperty('--y', `${y}px`);
    });
});
</script>
@endpush
