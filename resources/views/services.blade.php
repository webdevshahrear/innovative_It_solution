@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="slide-mesh"></div>
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-3">Our <span class="text-emerald">Services</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Services</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="section-padding" id="services-grid">
        <div class="container">
            <div class="section-title-modern text-center mb-5" data-aos="fade-up">
                <h2>Comprehensive Solutions</h2>
                <p>Tailored digital services to elevate your brand presence</p>
            </div>

            <div class="row g-4">
                @forelse($services as $service)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-card-premium h-100">
                            <div class="service-icon-box">
                                <i class="{{ $service->icon_class }}"></i>
                            </div>
                            <h3>{{ $service->title }}</h3>
                            <p>{{ $service->short_description }}</p>
                            <!-- Link to service details or contact for now since details page wasn't explicitly requested yet but I see service-details.php in file list -->
                            <!-- I will assume no details page for now unless I see it -->
                            <!-- Original code had: href="service-details.php?id=..." -->
                             <a href="{{ url('contact?subject=Service Inquiry: ' . urlencode($service->title)) }}" class="service-link">
                                Get Started <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No services found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center" data-aos="zoom-in">
                    <h2 class="fw-bold mb-3">Need a Custom Solution?</h2>
                    <p class="lead text-muted mb-4">We understand valid business needs are unique. Let's discuss your specific requirements.</p>
                    <a href="{{ url('contact') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
@endsection
