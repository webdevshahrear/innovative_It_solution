@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
<style>
    /* About Page Premium Styles */
    .about-hero-v2 {
        position: relative;
        padding: 160px 0 100px;
        background: var(--navy-dark);
        overflow: hidden;
    }

    .about-hero-v2::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 10% 20%, rgba(240, 82, 35, 0.08) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 40%);
        pointer-events: none;
    }

    .story-section-v2 {
        background: var(--navy-dark);
        padding: 120px 0;
        position: relative;
    }

    .about-image-premium {
        position: relative;
        border-radius: 40px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5);
    }

    .about-image-premium img {
        transition: transform 1.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .about-image-premium:hover img {
        transform: scale(1.1);
    }

    .experience-floating-v2 {
        position: absolute;
        bottom: 30px;
        right: 30px;
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 25px;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        border-right: 4px solid var(--primary);
    }

    .value-card-v2 {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 32px;
        padding: 50px 40px;
        transition: all 0.5s ease;
        text-align: center;
        height: 100%;
    }

    .value-card-v2:hover {
        transform: translateY(-10px);
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.05);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
    }

    .value-icon-v2 {
        width: 80px;
        height: 80px;
        background: rgba(240, 82, 35, 0.1);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: var(--primary);
        margin: 0 auto 30px;
        transition: 0.5s;
    }

    .value-card-v2:hover .value-icon-v2 {
        transform: rotateY(180deg);
        background: var(--primary);
        color: #fff;
        box-shadow: 0 0 30px var(--primary-glow);
    }

    .check-item-v2 {
        display: flex;
        align-items: center;
        gap: 15px;
        background: rgba(255, 255, 255, 0.03);
        padding: 15px 25px;
        border-radius: 100px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: 0.3s;
    }

    .check-item-v2:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--primary);
    }

    .check-icon-v2 {
        color: var(--primary);
        font-size: 1.1rem;
    }

    /* Modern Text Justification */
    .text-justify-v2 {
        text-align: justify;
        text-justify: inter-word;
    }
</style>

<div class="about-hero-v2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <span class="hero-badge-cinematic">BEYOND PIXELS</span>
                <h1 class="hero-title-cinematic mb-4">Architecting the <br><span class="text-primary">Next Digital Generation</span></h1>
                <p class="hero-subtitle-cinematic mb-5">Since 2014, we've been pushing the boundaries of what's possible in the digital realm. Meet the visionaries behind Innovative IT Solutions.</p>
                
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">About Journey</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="story-section-v2">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-image-premium">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=2070" alt="Team Session" class="w-100">
                    <div class="experience-floating-v2" data-aos="zoom-in" data-aos-delay="300">
                        <h2 class="fw-bold mb-0 text-white">10+</h2>
                        <p class="small text-white-50 mb-0 font-body">Years of Digital Mastery</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="ps-lg-5">
                    <span class="badge-modern mb-3" style="background: rgba(240, 82, 35, 0.1); border-color: rgba(240, 82, 35, 0.2); color: var(--primary);">EST 2014</span>
                    <h2 class="display-5 fw-bold mb-4">Crafting Digital Excellence for A Decade</h2>
                    <p class="text-v2-muted lead mb-4 text-justify-v2">At {{ $siteName ?? 'Innovative IT Solutions' }}, we believe that every brand has a story worth telling. Our journey began with a simple mission: to bridge the gap between complex technology and growth-driven business results.</p>
                    <p class="text-v2-muted mb-5 text-justify-v2">Today, we are a collective of designers, developers, and strategists dedicated to building high-performance digital solutions that empower businesses to scale. We don't just build websites; we create digital engines that drive success.</p>
                    
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="check-item-v2">
                                <i class="fas fa-microchip check-icon-v2"></i>
                                <span class="fw-bold small">Pioneering Tech</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="check-item-v2">
                                <i class="fas fa-award check-icon-v2"></i>
                                <span class="fw-bold small">Certified Quality</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-navy-dark">
    <div class="container">
        <div class="text-center mb-100" data-aos="fade-up">
            <span class="hero-badge-cinematic mb-3">OUR CORE VALUES</span>
            <h2 class="display-4 fw-bold">Built on Trust, Driven by <span class="text-primary">Passion</span></h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card-v2">
                    <div class="value-icon-v2">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h4 class="mb-3">Constant Innovation</h4>
                    <p class="text-v2-muted">We don't settle for "good enough". We explore the frontiers of tech to give our clients an unfair competitive advantage.</p>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card-v2">
                    <div class="value-icon-v2">
                        <i class="fas fa-fingerprint"></i>
                    </div>
                    <h4 class="mb-3">Extreme Passion</h4>
                    <p class="text-v2-muted">Digital craftsmanship is in our DNA. Every project is handled with the precision of an artisan and the logic of an engineer.</p>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="value-card-v2">
                    <div class="value-icon-v2">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <h4 class="mb-3">Absolute Integrity</h4>
                    <p class="text-v2-muted">Radical transparency is our standard. We believe true success is built on the pillar of unshakeable client trust.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Elite CTA -->
<section class="section-padding overflow-hidden">
    <div class="container">
        <div class="glass-effect p-120 rounded-5 text-center position-relative overflow-hidden" data-aos="zoom-in">
            <div class="position-absolute top-0 start-0 w-100 h-100" 
                 style="background: radial-gradient(circle at 50% 50%, rgba(240, 82, 35, 0.1) 0%, transparent 60%); pointer-events: none;"></div>
            
            <h2 class="display-3 fw-bold mb-4">Ready to Write Your <br><span class="text-primary">Success Story?</span></h2>
            <p class="lead text-v2-muted mb-5 mx-auto" style="max-width: 700px;">
                Join 500+ global brands that leveraged our strategic technology to dominate their markets.
            </p>
            <div class="d-flex justify-content-center gap-4">
                <a href="{{ url('contact') }}" class="btn-btn-elite-v2">
                    Launch Your Project <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
