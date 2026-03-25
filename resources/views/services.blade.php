@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
<style>
    /* Services Page Premium Styles */
    .services-hero-v2 {
        position: relative;
        padding: 160px 0 100px;
        background: var(--navy-dark);
        overflow: hidden;
    }

    .services-hero-v2::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.08) 0%, transparent 40%),
                    radial-gradient(circle at 20% 80%, rgba(240, 82, 35, 0.08) 0%, transparent 40%);
        pointer-events: none;
    }

    .service-grid-v2 {
        background: var(--navy-dark);
        padding: 120px 0;
        position: relative;
    }

    .glass-service-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 32px;
        padding: 50px 40px;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .glass-service-card:hover {
        transform: translateY(-15px);
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.05);
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5), 0 0 30px rgba(240, 82, 35, 0.1);
    }

    .service-icon-v3 {
        width: 80px;
        height: 80px;
        background: rgba(240, 82, 35, 0.05);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: var(--primary);
        margin-bottom: 35px;
        transition: 0.5s;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .glass-service-card:hover .service-icon-v3 {
        background: var(--primary);
        color: #fff;
        transform: scale(1.1) rotate(10deg);
        box-shadow: 0 0 30px var(--primary-glow);
    }

    .service-link-v2 {
        margin-top: auto;
        padding-top: 30px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--primary);
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: 0.85rem;
        transition: 0.3s;
    }

    .service-link-v2:hover {
        gap: 15px;
        color: #fff;
    }

    .service-link-v2 i {
        font-size: 0.8rem;
    }
</style>

<div class="services-hero-v2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <span class="hero-badge-cinematic">SOLUTIONS ARCHIVE</span>
                <h1 class="hero-title-cinematic mb-4">High-Performance <br><span class="text-primary">Digital Engineering</span></h1>
                <p class="hero-subtitle-cinematic mb-5">We don't just provide services; we engineer strategic advantages. Explore our comprehensive suite of digital solutions.</p>
                
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Our Services</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="service-grid-v2">
    <div class="container">
        <div class="text-center mb-100" data-aos="fade-up">
            <span class="badge-modern mb-3" style="background: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.2); color: #3b82f6;">FULL SPECTRUM</span>
            <h2 class="display-4 fw-bold">Comprehensive <span class="text-primary">Tech Stack</span></h2>
        </div>

        <div class="row g-4">
            @if($services->count() > 0)
                @foreach($services as $index => $service)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                        <div class="glass-service-card">
                            <div class="service-icon-v3">
                                <i class="{{ $service->icon_class }}"></i>
                            </div>
                            <h3 class="fw-bold mb-3">{{ $service->title }}</h3>
                            <p class="text-v2-muted mb-0 leading-relaxed">{{ $service->short_description }}</p>
                            
                            <a href="{{ url('contact?subject=Service Inquiry: ' . urlencode($service->title)) }}" class="service-link-v2">
                                GET STARTED <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-120">
                    <div class="glass-effect p-5 rounded-4 d-inline-block">
                        <i class="fas fa-layer-group fa-3x text-primary mb-3"></i>
                        <p class="text-v2-muted mb-0">Our service catalog is currently being updated by our engineers.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Premium CTA -->
<section class="section-padding overflow-hidden">
    <div class="container">
        <div class="glass-effect p-120 rounded-5 text-center position-relative overflow-hidden" data-aos="zoom-in">
            <div class="position-absolute top-0 end-0 w-100 h-100" 
                 style="background: radial-gradient(circle at 70% 30%, rgba(59, 130, 246, 0.1) 0%, transparent 60%); pointer-events: none;"></div>
            
            <h2 class="display-3 fw-bold mb-4">Need a Bespoke <br><span class="text-primary">Enterprise Solution?</span></h2>
            <p class="lead text-v2-muted mb-5 mx-auto" style="max-width: 700px;">
                Our architect team specializes in solving complex business logic with elegant technology. Let's discuss your unique requirements.
            </p>
            <div class="d-flex justify-content-center gap-4">
                <a href="{{ url('contact') }}" class="btn-btn-elite-v2">
                    Consult Our Architects <i class="fas fa-comment-dots ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
