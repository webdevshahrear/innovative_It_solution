@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
    <!-- Page Header / Breadcrumb -->
    <section class="page-header">
        <div class="slide-mesh"></div>
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-3">About <span class="text-emerald">Us</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">About Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="section-padding bg-white overflow-hidden">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-image-wrapper position-relative">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=2070" alt="Our Team" class="img-fluid rounded-4 shadow-lg">
                        <div class="floating-exp-card" data-aos="zoom-in" data-aos-delay="200">
                            <h2 class="fw-bold mb-0 text-emerald">10+</h2>
                            <p class="small text-muted mb-0">Years of Excellence</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="ps-lg-4">
                        <span class="badge-modern mb-3">Our Story</span>
                        <h2 class="display-5 fw-bold mb-4">Crafting Digital Excellence for A Decade</h2>
                        <p class="lead text-muted mb-4 text-justify">At Webboomers, we believe that every brand has a story worth telling. Our journey began with a simple mission: to bridge the gap between complex technology and growth-driven business results.</p>
                        <p class="text-muted mb-5 text-justify">Today, we are a collective of designers, developers, and strategists dedicated to building high-performance digital solutions that empower businesses to scale. We don't just build websites; we create digital engines that drive success.</p>
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-box-sm bg-primary-light text-emerald rounded-circle">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold">Innovative Solutions</h6>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-box-sm bg-primary-light text-emerald rounded-circle">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold">Quality Guaranteed</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="badge-modern mb-3">Our Core Values</span>
                <h2 class="display-6 fw-bold">What Drives Us Forward</h2>
            </div>
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="modern-card p-5 h-100 border-0 shadow-sm text-center">
                        <div class="icon-box-lg bg-primary-light text-emerald rounded-4 mx-auto mb-4">
                            <i class="fas fa-lightbulb fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Innovation</h4>
                        <p class="text-muted mb-0">We stay ahead of the curve, utilizing the latest technologies to solve modern business challenges.</p>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="modern-card p-5 h-100 border-0 shadow-sm text-center">
                        <div class="icon-box-lg bg-emerald text-white rounded-4 mx-auto mb-4">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Passion</h4>
                        <p class="text-muted mb-0">Our love for digital craftsmanship is reflected in every line of code and every pixel we design.</p>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="modern-card p-5 h-100 border-0 shadow-sm text-center">
                        <div class="icon-box-lg bg-primary-light text-emerald rounded-4 mx-auto mb-4">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Integrity</h4>
                        <p class="text-muted mb-0">Transparency and honesty are at the heart of our client relationships. We build trust through results.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5">
        <div class="container py-lg-4">
            <div class="modern-card emerald-gradient p-5 text-center text-white border-0 shadow-lg" data-aos="zoom-in">
                <h2 class="display-5 fw-bold mb-3">Ready to Start Your Project?</h2>
                <p class="lead opacity-75 mb-5 mx-auto" style="max-width: 600px;">Join hundreds of businesses that have scaled with our custom digital solutions.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ url('contact') }}" class="btn btn-light btn-lg px-5 fw-bold text-emerald">Contact Us Now</a>
                </div>
            </div>
        </div>
    </section>
@endsection
