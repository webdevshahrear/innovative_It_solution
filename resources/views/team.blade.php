@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
@push('styles')
<style>
    :root {
        --v2-bg: #06061e;
        --v2-card: rgba(255, 255, 255, 0.02);
        --v2-glass: rgba(13, 11, 40, 0.7);
        --v2-border: rgba(255, 255, 255, 0.08);
        --v2-primary: #f05223;
        --v2-primary-glow: rgba(240, 82, 35, 0.35);
        --v2-secondary: #3b82f6;
        --v2-text-main: #f0eeff;
        --v2-text-muted: #94a3b8;
    }

    /* ── Team Page Specific ── */
    .team-hero-v2 {
        position: relative;
        padding: 160px 0 100px;
        background: var(--navy-dark);
        overflow: hidden;
    }

    .team-hero-v2::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 50% 10%, rgba(240, 82, 35, 0.08) 0%, transparent 40%),
                    radial-gradient(circle at 50% 90%, rgba(59, 130, 246, 0.08) 0%, transparent 40%);
        pointer-events: none;
    }

    .team-grid-v2 {
        background: #040415;
        padding: 120px 0;
        position: relative;
        overflow: hidden;
    }

    /* ── Team Card V4 (Home Page Match) ── */
    .team-card-v4 { background: var(--v2-card); border: 1px solid var(--v2-border); border-radius: 30px; overflow: visible; position: relative; transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1); height: 100%; }
    .team-card-v4:hover { transform: translateY(-10px); border-color: rgba(240,82,35,0.35); box-shadow: 0 25px 50px rgba(0,0,0,0.3); }
    .team-img-v4 { 
        position: relative; 
        aspect-ratio: 1/1.1; 
        background: #ffffff; 
        border-radius: 26px 26px 0 0; 
        overflow: hidden;
    }
    .team-img-v4 img { width: 100%; height: 100%; object-fit: cover; object-position: top center; transition: 0.6s ease; display: block; }
    .team-card-v4:hover .team-img-v4 img { transform: scale(1.06); }

    .team-img-v4::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(240, 82, 35, 0.25) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.4s ease;
        pointer-events: none;
    }
    .team-card-v4:hover .team-img-v4::after { opacity: 1; }

    .team-social-v4 { position: absolute; bottom: 22px; left: 0; right: 0; justify-content: center; display: flex; gap: 10px; z-index: 10; }
    .team-social-v4 a {
        width: 42px; height: 42px;
        background: #fff;
        color: var(--v2-primary);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        text-decoration: none; font-size: 1rem;
        transition: all 0.45s ease;
        transform: translateY(30px);
        opacity: 0;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .team-card-v4:hover .team-social-v4 a { transform: translateY(0); opacity: 1; }
    .team-card-v4:hover .team-social-v4 a:nth-child(1) { transition-delay: 0s; }
    .team-card-v4:hover .team-social-v4 a:nth-child(2) { transition-delay: 0.06s; }
    .team-card-v4:hover .team-social-v4 a:nth-child(3) { transition-delay: 0.12s; }
    .team-card-v4:hover .team-social-v4 a:nth-child(4) { transition-delay: 0.18s; }
    .team-social-v4 a:hover { background: var(--v2-primary); color: #fff; transform: translateY(-4px) !important; box-shadow: 0 12px 25px rgba(240, 82, 35, 0.4); }

    .team-info-v4 { padding: 28px 22px 32px; background: var(--v2-card); border-radius: 0 0 26px 26px; text-align: center; }
    .team-info-v4 h4 { color: #fff; font-weight: 800; margin-bottom: 6px; font-size: 1.35rem; letter-spacing: -0.3px; }
    .team-info-v4 .team-position { color: var(--v2-primary); font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 22px; display: block; }
    
    .btn-pill-dark { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); color: #fff; border-radius: 100px; padding: 10px 30px; font-size: 0.82rem; font-weight: 700; transition: all 0.3s; text-decoration: none; display: inline-block; }
    .btn-pill-dark:hover { background: var(--v2-primary); border-color: var(--v2-primary); color: #fff; transform: translateY(-2px); }

    /* Light Mode Adjustments */
    body.light-mode .team-hero-v2,
    body.light-mode .team-grid-v2 { background: #f8fafc !important; }
    body.light-mode .hero-title-cinematic,
    body.light-mode .v2-section-title { color: #0f172a !important; }
    body.light-mode .hero-subtitle-cinematic { color: #475569 !important; }

    body.light-mode .team-card-v4 { background: #ffffff; border-color: #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    body.light-mode .team-img-v4 { background: #f8fafc; border-bottom: 1px solid #edf2f7; }
    body.light-mode .team-info-v4 { background: #ffffff; }
    body.light-mode .team-info-v4 h4 { color: #0f172a !important; }
    body.light-mode .btn-pill-dark { background: transparent; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; }
    body.light-mode .btn-pill-dark:hover { background: var(--v2-primary); border-color: var(--v2-primary); color: #fff; }
</style>
@endpush

<div class="team-hero-v2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <span class="hero-badge-cinematic">THE ARCHITECTS</span>
                <h1 class="hero-title-cinematic mb-4">The Minds Behind the <br><span class="text-glow-primary">Innovation</span></h1>
                <p class="hero-subtitle-cinematic mb-5">Meet our collective of elite engineers, visionary designers, and strategic thinkers dedicated to your success.</p>
                
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Our Experts</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="team-grid-v2">
    <div class="v2-mesh-glow"></div>
    <div class="container position-relative z-1">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="v2-badge-primary mb-3">LEADERSHIP</span>
            <h2 class="v2-section-title">Human-Centric <br><span class="text-glow-primary">Engineering</span></h2>
        </div>

        <div class="row g-5 justify-content-center">
            @if($teamMembers->count() > 0)
                @foreach($teamMembers as $index => $member)
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}">
                        <div class="team-card-v4">
                            <div class="team-img-v4">
                                @php
                                    $memberImg = $member->image ?? null;
                                    if (!empty($memberImg) && !filter_var($memberImg, FILTER_VALIDATE_URL)) {
                                        $memberImg = asset('uploads/team/' . $memberImg);
                                    } elseif (empty($memberImg)) {
                                        $memberImg = 'https://via.placeholder.com/400x500/10101f/ffffff?text=' . urlencode($member->name);
                                    }
                                @endphp
                                <img src="{{ $memberImg }}"
                                    alt="{{ $member->name }}"
                                    onerror="this.src='https://via.placeholder.com/400x500/10101f/ffffff?text={{ urlencode($member->name) }}'">
                                
                                <div class="team-social-v4">
                                    @if($member->facebook_url)
                                        <a href="{{ $member->facebook_url }}"><i class="fab fa-facebook-f"></i></a>
                                    @endif
                                    @if($member->twitter_url)
                                        <a href="{{ $member->twitter_url }}"><i class="fab fa-twitter"></i></a>
                                    @endif
                                    @if($member->instagram_url)
                                        <a href="{{ $member->instagram_url }}"><i class="fab fa-instagram"></i></a>
                                    @endif
                                    @if($member->linkedin_url)
                                        <a href="{{ $member->linkedin_url }}"><i class="fab fa-linkedin-in"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="team-info-v4">
                                <h4>{{ $member->name }}</h4>
                                <span class="team-position">{{ $member->position }}</span>
                                <a href="{{ route('team.show', $member->id) }}" class="btn-pill-dark">View Profile</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-120">
                    <div class="glass-effect p-5 rounded-4 d-inline-block">
                        <i class="fas fa-users-slash fa-3x text-primary mb-3"></i>
                        <p class="text-v2-muted mb-0">Our team catalog is currently being updated for the next generation.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Elite CTA -->
<section class="section-padding overflow-hidden">
    <div class="container">
        <div class="glass-effect p-120 rounded-5 text-center position-relative overflow-hidden" data-aos="zoom-in">
            <div class="position-absolute top-0 start-0 w-100 h-100" 
                 style="background: radial-gradient(circle at 50% 50%, rgba(240, 82, 35, 0.1) 0%, transparent 60%); pointer-events: none;"></div>
            
            <h2 class="display-3 fw-bold mb-4">Want to Join Our <br><span class="text-primary">Elite Force?</span></h2>
            <p class="lead text-v2-muted mb-5 mx-auto" style="max-width: 700px;">
                We are always looking for visionary talent to help us solve the digital challenges of tomorrow. 
            </p>
            <div class="d-flex justify-content-center gap-4">
                <a href="{{ url('contact') }}" class="btn-btn-elite-v2">
                    Become an Architect <i class="fas fa-rocket ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
