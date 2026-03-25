@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
<style>
    /* Team Page Premium Styles */
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
        background: var(--navy-dark);
        padding: 120px 0;
        position: relative;
    }

    .cyber-team-card {
        position: relative;
        border-radius: 40px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        height: 100%;
    }

    .cyber-team-img {
        position: relative;
        height: 420px;
        overflow: hidden;
    }

    .cyber-team-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        filter: grayscale(0.2);
    }

    .cyber-team-card:hover .cyber-team-img img {
        transform: scale(1.1);
        filter: grayscale(0);
    }

    .cyber-team-info {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
        background: rgba(13, 11, 40, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 30px;
        border-radius: 30px;
        text-align: center;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        transform: translateY(10px);
    }

    .cyber-team-card:hover .cyber-team-info {
        transform: translateY(0);
        border-color: var(--primary);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    .cyber-team-name {
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 5px;
        color: #fff;
    }

    .cyber-team-pos {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 20px;
        display: block;
    }

    .cyber-social {
        display: flex;
        justify-content: center;
        gap: 15px;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.4s ease 0.1s;
    }

    .cyber-team-card:hover .cyber-social {
        opacity: 1;
        transform: translateY(0);
    }

    .cyber-social-link {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        transition: all 0.3s;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cyber-social-link:hover {
        background: var(--primary);
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px var(--primary-glow);
    }
</style>

<div class="team-hero-v2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <span class="hero-badge-cinematic">THE ARCHITECTS</span>
                <h1 class="hero-title-cinematic mb-4">The Minds Behind the <br><span class="text-primary">Innovation</span></h1>
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
    <div class="container">
        <div class="text-center mb-100" data-aos="fade-up">
            <span class="badge-modern mb-3" style="background: rgba(240, 82, 35, 0.1); border-color: rgba(240, 82, 35, 0.2); color: var(--primary);">LEADERSHIP</span>
            <h2 class="display-4 fw-bold">Human-Centric <span class="text-primary">Engineering</span></h2>
        </div>

        <div class="row g-4 justify-content-center">
            @if($teamMembers->count() > 0)
                @foreach($teamMembers as $index => $member)
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}">
                        <div class="cyber-team-card">
                            <div class="cyber-team-img">
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
                                    onerror="this.src='https://via.placeholder.com/400x600/10101f/ffffff?text={{ urlencode($member->name) }}'">
                            </div>
                            <div class="cyber-team-info text-center">
                                <h4 class="cyber-team-name"><a href="{{ route('team.show', $member->id) }}" class="text-white text-decoration-none">{{ $member->name }}</a></h4>
                                <span class="cyber-team-pos mb-3 d-block">{{ $member->position }}</span>
                                <a href="{{ route('team.show', $member->id) }}" class="btn btn-sm d-inline-block mb-3" style="background: rgba(240, 82, 35, 0.1); color: var(--v2-primary); border: 1px solid rgba(240, 82, 35, 0.2); border-radius: 20px; font-size: 0.8rem; font-weight: 700; padding: 5px 20px; transition: 0.3s;" onmouseover="this.style.background='var(--v2-primary)'; this.style.color='#fff';" onmouseout="this.style.background='rgba(240, 82, 35, 0.1)'; this.style.color='var(--v2-primary)';">View Profile</a>
                               
                                <div class="cyber-social">
                                    @if($member->facebook_url)
                                        <a href="{{ $member->facebook_url }}" class="cyber-social-link"><i class="fab fa-facebook-f"></i></a>
                                    @endif
                                    @if($member->twitter_url)
                                        <a href="{{ $member->twitter_url }}" class="cyber-social-link"><i class="fab fa-twitter"></i></a>
                                    @endif
                                    @if($member->instagram_url)
                                        <a href="{{ $member->instagram_url }}" class="cyber-social-link"><i class="fab fa-instagram"></i></a>
                                    @endif
                                    @if($member->linkedin_url)
                                        <a href="{{ $member->linkedin_url }}" class="cyber-social-link"><i class="fab fa-linkedin-in"></i></a>
                                    @endif
                                </div>
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
