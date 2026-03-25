@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
<style>
    /* Premium Contact Page Custom Styles */
    .contact-hero-v2 {
        position: relative;
        padding: 160px 0 100px;
        background: var(--navy-dark);
        overflow: hidden;
    }

    .contact-hero-v2::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 20% 30%, rgba(240, 82, 35, 0.08) 0%, transparent 40%),
                    radial-gradient(circle at 80% 70%, rgba(59, 130, 246, 0.08) 0%, transparent 40%);
        pointer-events: none;
    }

    .glass-contact-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 32px;
        padding: 45px 35px;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .glass-contact-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, transparent 100%);
        opacity: 0;
        transition: 0.5s;
    }

    .glass-contact-card:hover {
        transform: translateY(-12px);
        border-color: var(--primary);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4), 0 0 20px rgba(240, 82, 35, 0.1);
    }

    .glass-contact-card:hover::before {
        opacity: 1;
    }

    .contact-icon-v2 {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: var(--primary);
        margin-bottom: 30px;
        transition: 0.5s;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .glass-contact-card:hover .contact-icon-v2 {
        background: var(--primary);
        color: #fff;
        transform: scale(1.1) rotate(10deg);
        box-shadow: 0 0 20px var(--primary-glow);
    }

    /* Premium Form Styling */
    .premium-form-box {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 40px;
        padding: 50px;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5);
    }

    .v2-input-group {
        position: relative;
        margin-bottom: 30px;
    }

    .v2-input-field {
        width: 100%;
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 16px !important;
        padding: 18px 25px !important;
        color: #fff !important;
        font-weight: 500;
        transition: all 0.3s;
    }

    .v2-input-field:focus {
        background: rgba(255, 255, 255, 0.05) !important;
        border-color: var(--primary) !important;
        box-shadow: 0 0 20px rgba(240, 82, 35, 0.1) !important;
        outline: none;
    }

    .v2-label {
        position: absolute;
        left: 25px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.4);
        pointer-events: none;
        transition: all 0.3s;
        font-weight: 500;
    }

    .v2-input-field:focus ~ .v2-label,
    .v2-input-field:not(:placeholder-shown) ~ .v2-label {
        top: -12px;
        left: 15px;
        font-size: 0.8rem;
        background: var(--navy-dark);
        padding: 2px 10px;
        color: var(--primary);
        border-radius: 4px;
    }

    .textarea-v2 {
        height: 160px !important;
        resize: none;
    }

    .btn-submit-premium {
        background: var(--gradient-primary);
        color: #fff;
        border: none;
        padding: 20px 40px;
        border-radius: 100px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: all 0.4s;
        width: 100%;
        box-shadow: 0 15px 30px var(--primary-glow);
    }

    .btn-submit-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px var(--primary-glow);
        filter: brightness(1.1);
    }

    .map-premium {
        border-radius: 40px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        filter: grayscale(1) invert(0.9) contrast(1.2);
        opacity: 0.7;
        transition: 0.5s;
    }

    .map-premium:hover {
        filter: grayscale(0) invert(0);
        opacity: 1;
    }
</style>

<div class="contact-hero-v2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <span class="hero-badge-cinematic">GET IN TOUCH</span>
                <h1 class="hero-title-cinematic mb-4">Let's Ignite Your <br><span class="text-primary">Digital Future</span></h1>
                <p class="hero-subtitle-cinematic mb-5">Have a visionary project? We're ready to engineer it into reality. Reach out via the channel that suits you best.</p>
                
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Get Started</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="pb-120 pt-0" style="margin-top: -60px;">
    <div class="container">
        <div class="row g-4">
            <!-- Email -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-contact-card">
                    <div class="contact-icon-v2">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h4 class="mb-3">Email Inquiry</h4>
                    <p class="text-v2-muted mb-4">Drop us a line for detailed proposals and project queries.</p>
                    <a href="mailto:{{ $contactEmail }}" class="h5 fw-bold text-white text-decoration-none d-flex align-items-center gap-2">
                        {{ $contactEmail }} <i class="fas fa-external-link-alt small opacity-50"></i>
                    </a>
                </div>
            </div>
            
            <!-- Phone -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-contact-card">
                    <div class="contact-icon-v2">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4 class="mb-3">Voice Support</h4>
                    <p class="text-v2-muted mb-4">Call us directly to discuss immediate corporate solutions.</p>
                    <a href="tel:{{ $contactPhone }}" class="h5 fw-bold text-white text-decoration-none d-flex align-items-center gap-2">
                        {{ $contactPhone }} <i class="fas fa-external-link-alt small opacity-50"></i>
                    </a>
                </div>
            </div>

            <!-- Location -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="glass-contact-card">
                    <div class="contact-icon-v2">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h4 class="mb-3">Studio Base</h4>
                    <p class="text-v2-muted mb-4">Visit our creative hub to meet the engineers behind the tech.</p>
                    <p class="h5 fw-bold text-white mb-0">{{ $contactAddress }}</p>
                </div>
            </div>
        </div>

        <div class="row mt-120 align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="premium-form-box">
                    <div class="mb-5">
                        <h2 class="h1 fw-bold mb-2">Send a Message</h2>
                        <p class="text-v2-muted">Our strategic team will respond within 12 standard Earth hours.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success bg-primary bg-opacity-10 border-primary border-opacity-20 text-white rounded-4 mb-4">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="v2-input-group">
                            <input type="text" class="v2-input-field" name="name" placeholder=" " required>
                            <label class="v2-label">Full Name</label>
                        </div>

                        <div class="v2-input-group">
                            <input type="email" class="v2-input-field" name="email" placeholder=" " required>
                            <label class="v2-label">Email Address</label>
                        </div>

                        <div class="v2-input-group">
                            <input type="text" class="v2-input-field" name="subject" value="{{ request('subject') }}" placeholder=" " required>
                            <label class="v2-label">Subject</label>
                        </div>

                        <div class="v2-input-group">
                            <textarea class="v2-input-field textarea-v2" name="message" placeholder=" " required></textarea>
                            <label class="v2-label">Tell us about your project</label>
                        </div>

                        <button type="submit" class="btn-submit-premium">
                            Dispatch Message <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="map-premium h-100" style="min-height: 600px;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d158858.182370726!2d-0.10159865000000001!3d51.52864165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8a00baf21de75%3A0x52963a5addd52a99!2sLondon%2C%20UK!5e0!3m2!1sen!2sbd!4v1683296232585!5m2!1sen!2sbd" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
