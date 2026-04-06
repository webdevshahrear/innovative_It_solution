@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
<style>
    .help-hero-v2 {
        position: relative;
        padding: 160px 0 100px;
        background: var(--navy-dark);
        overflow: hidden;
        text-align: center;
    }

    .help-hero-v2::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 50% 50%, rgba(240, 82, 35, 0.1) 0%, transparent 60%);
        pointer-events: none;
    }

    .search-box-v2 {
        max-width: 600px;
        margin: 40px auto 0;
        position: relative;
    }

    .search-box-v2 input {
        width: 100%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 20px 30px;
        color: #fff;
        backdrop-filter: blur(10px);
        transition: all 0.3s;
    }

    .search-box-v2 input:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--primary);
        box-shadow: 0 0 30px var(--primary-glow);
        outline: none;
    }

    .help-section-v2 {
        background: var(--navy-dark);
        padding: 0 0 120px;
    }

    .help-category-card {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 30px;
        padding: 40px;
        height: 100%;
        transition: all 0.4s ease;
    }

    .help-category-card:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 0.04);
        border-color: var(--primary);
    }

    .category-icon-v2 {
        width: 70px;
        height: 70px;
        background: rgba(240, 82, 35, 0.1);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: var(--primary);
        margin-bottom: 25px;
    }

    .help-category-card h3 {
        color: #fff;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .faq-list-v2 {
        list-style: none;
        padding: 0;
    }

    .faq-list-v2 li {
        margin-bottom: 15px;
    }

    .faq-list-v2 a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .faq-list-v2 a:hover {
        color: var(--primary);
        padding-left: 5px;
    }

    .support-cta-v2 {
        background: linear-gradient(135deg, rgba(240, 82, 35, 0.1), rgba(59, 130, 246, 0.1));
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 40px;
        padding: 60px;
        text-align: center;
        margin-top: 80px;
    }

    .btn-support-v2 {
        background: var(--primary);
        color: #fff;
        padding: 15px 40px;
        border-radius: 15px;
        font-weight: 700;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
        box-shadow: 0 10px 30px var(--primary-glow);
    }

    .btn-support-v2:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px var(--primary-glow);
        color: #fff;
    }

    /* ── Light Mode Overrides for Help Center ── */
    body.light-mode .help-hero-v2 { background: #f8fafc !important; }
    body.light-mode .help-section-v2 { background: #f8fafc !important; }
    body.light-mode .display-3 { color: #0f172a !important; }
    body.light-mode .text-white-50 { color: #64748b !important; }
    body.light-mode .search-box-v2 input { 
        background: #ffffff !important; 
        border-color: #e2e8f0 !important; 
        color: #1e293b !important; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important;
    }
    body.light-mode .help-category-card { 
        background: #ffffff !important; 
        border-color: rgba(0, 0, 0, 0.06) !important;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.03) !important;
    }
    body.light-mode .help-category-card h3 { color: #0f172a !important; }
    body.light-mode .faq-list-v2 a { color: #64748b !important; }
    body.light-mode .support-cta-v2 { 
        background: #ffffff !important; 
        border-color: rgba(0, 0, 0, 0.06) !important;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.05) !important;
    }
    body.light-mode .support-cta-v2 h2 { color: #0f172a !important; }
</style>

<div class="help-hero-v2">
    <div class="container position-relative z-1">
        <div class="hero-badge-v4 mb-3" data-aos="fade-down">
            SUPPORT CENTER
        </div>
        <h1 class="display-3 fw-bold text-white mb-2" data-aos="fade-up">How can we <span class="text-glow-primary">help?</span></h1>
        <p class="text-white-50 lead mb-5" data-aos="fade-up" data-aos-delay="100">Find answers to frequently asked questions or contact our support team.</p>
        
        <div class="search-box-v2" data-aos="zoom-in" data-aos-delay="200">
            <input type="text" placeholder="Search for help topics, features, or keywords...">
        </div>
    </div>
</div>

<div class="help-section-v2">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up">
                <div class="help-category-card">
                    <div class="category-icon-v2"><i class="fas fa-rocket"></i></div>
                    <h3>Getting Started</h3>
                    <ul class="faq-list-v2">
                        <li><a href="#"><i class="fas fa-chevron-right small"></i> How to initiate a project?</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right small"></i> Setting up your dashboard</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right small"></i> Collaboration workflow</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="help-category-card">
                    <div class="category-icon-v2"><i class="fas fa-cogs"></i></div>
                    <h3>Services & Solutions</h3>
                    <ul class="faq-list-v2">
                        <li><a href="#"><i class="fas fa-chevron-right small"></i> Custom software development</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right small"></i> UI/UX design process</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right small"></i> Maintenance & Support</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="help-category-card">
                    <div class="category-icon-v2"><i class="fas fa-user-shield"></i></div>
                    <h3>Account & Billing</h3>
                    <ul class="faq-list-v2">
                        <li><a href="#"><i class="fas fa-chevron-right small"></i> Managing your subscription</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right small"></i> Payment methods supported</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right small"></i> Invoice & Receipt access</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="support-cta-v2" data-aos="zoom-in">
            <h2 class="text-white mb-4">Still need assistance?</h2>
            <p class="text-white-50 mb-5">Our elite architecture support team is ready to help you coordinate your next digital legacy.</p>
            <a href="{{ url('contact') }}" class="btn-support-v2">Contact Support Team</a>
        </div>
    </div>
</div>
@endsection
