@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
<style>
    .sitemap-hero-v2 {
        position: relative;
        padding: 160px 0 100px;
        background: var(--navy-dark);
        overflow: hidden;
        text-align: center;
    }

    .sitemap-hero-v2::before {
        content: '';
        position: absolute;
        bottom: 0; left: 0; width: 100%; height: 200px;
        background: linear-gradient(to top, var(--primary-glow), transparent);
        opacity: 0.1;
        pointer-events: none;
    }

    .sitemap-section-v2 {
        background: var(--navy-dark);
        padding: 0 0 120px;
    }

    .sitemap-container-v2 {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 40px;
        padding: 60px;
    }

    .sitemap-group-v2 {
        margin-bottom: 50px;
    }

    .sitemap-group-v2 h3 {
        color: #fff;
        font-weight: 700;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 1.5rem;
    }

    .sitemap-group-v2 h3 i {
        color: var(--primary);
        font-size: 1.2rem;
    }

    .sitemap-links-v2 {
        list-style: none;
        padding: 0;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }

    .sitemap-links-v2 li a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        border: 1px solid transparent;
    }

    .sitemap-links-v2 li a:hover {
        color: #fff;
        background: rgba(240, 82, 35, 0.1);
        border-color: rgba(240, 82, 35, 0.2);
        transform: translateX(5px);
    }

    .sitemap-links-v2 li a i {
        color: var(--primary);
        font-size: 0.8rem;
    }

    @media (max-width: 767px) {
        .sitemap-container-v2 { padding: 40px 20px; border-radius: 24px; }
        .sitemap-links-v2 { grid-template-columns: 1fr; }
    }
</style>

<div class="sitemap-hero-v2">
    <div class="container position-relative z-1">
        <div class="hero-badge-v4 mb-3" data-aos="fade-down">
            NAVIGATION HUB
        </div>
        <h1 class="display-3 fw-bold text-white mb-4" data-aos="fade-up">Elite <span class="text-glow-primary">Sitemap</span></h1>
        <p class="text-white-50 lead" data-aos="fade-up" data-aos-delay="100">A comprehensive directory of our digital architecture.</p>
    </div>
</div>

<div class="sitemap-section-v2">
    <div class="container">
        <div class="sitemap-container-v2 shadow-lg" data-aos="fade-up" data-aos-delay="200">
            <div class="row">
                <div class="col-12">
                    <div class="sitemap-group-v2">
                        <h3><i class="fas fa-home"></i> Core Architecture</h3>
                        <ul class="sitemap-links-v2">
                            <li><a href="{{ url('/') }}"><i class="fas fa-chevron-right"></i> Home Page</a></li>
                            <li><a href="{{ url('about') }}"><i class="fas fa-chevron-right"></i> About Elite Team</a></li>
                            <li><a href="{{ url('services') }}"><i class="fas fa-chevron-right"></i> Our Capabilities</a></li>
                            <li><a href="{{ url('team') }}"><i class="fas fa-chevron-right"></i> Expert Collective</a></li>
                            <li><a href="{{ url('portfolio') }}"><i class="fas fa-chevron-right"></i> Projects Hub</a></li>
                            <li><a href="{{ url('blog') }}"><i class="fas fa-chevron-right"></i> Insights & Blog</a></li>
                            <li><a href="{{ url('contact') }}"><i class="fas fa-chevron-right"></i> Contact Support</a></li>
                        </ul>
                    </div>

                    <div class="sitemap-group-v2">
                        <h3><i class="fas fa-balance-scale"></i> Legal & Protocol</h3>
                        <ul class="sitemap-links-v2">
                            <li><a href="{{ url('privacy-policy') }}"><i class="fas fa-chevron-right"></i> Privacy Protocol</a></li>
                            <li><a href="{{ url('terms-of-use') }}"><i class="fas fa-chevron-right"></i> Terms of Engagement</a></li>
                            <li><a href="{{ url('help-center') }}"><i class="fas fa-chevron-right"></i> Knowledge Base</a></li>
                        </ul>
                    </div>

                    <div class="sitemap-group-v2">
                        <h3><i class="fas fa-user-lock"></i> Command Center</h3>
                        <ul class="sitemap-links-v2">
                            <li><a href="{{ url('login') }}"><i class="fas fa-chevron-right"></i> Admin Login</a></li>
                            <li><a href="{{ url('register') }}"><i class="fas fa-chevron-right"></i> Join Collective</a></li>
                            <li><a href="{{ url('dashboard') }}"><i class="fas fa-chevron-right"></i> Main Dashboard</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
