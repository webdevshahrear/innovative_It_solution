@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="slide-mesh"></div>
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-3">Get in <span class="text-emerald">Touch</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="section-padding bg-light pb-0" style="margin-top: -80px; position: relative; z-index: 10;">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <!-- Phone -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="contact-card-premium text-center p-5 h-100 bg-white rounded-5 shadow-lg">
                        <div class="icon-box-lg bg-primary-light text-emerald rounded-circle mx-auto mb-4">
                            <i class="fas fa-phone-alt fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Call Us</h4>
                        <p class="text-muted mb-3">We are available Mon-Fri, 9am - 6pm.</p>
                        <a href="tel:{{ $contactPhone }}" class="h5 fw-bold text-dark text-decoration-none hover-emerald">{{ $contactPhone }}</a>
                    </div>
                </div>
                <!-- Email -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-card-premium text-center p-5 h-100 bg-emerald text-white rounded-5 shadow-lg">
                        <div class="icon-box-lg bg-white bg-opacity-25 text-white rounded-circle mx-auto mb-4">
                            <i class="fas fa-envelope fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Email Us</h4>
                        <p class="text-white-50 mb-3">Send us a message anytime.</p>
                        <a href="mailto:{{ $contactEmail }}" class="h5 fw-bold text-white text-decoration-none">{{ $contactEmail }}</a>
                    </div>
                </div>
                <!-- Location -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-card-premium text-center p-5 h-100 bg-white rounded-5 shadow-lg">
                        <div class="icon-box-lg bg-primary-light text-emerald rounded-circle mx-auto mb-4">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Visit Us</h4>
                        <p class="text-muted mb-3">Come say hello at our HQ.</p>
                        <p class="h5 fw-bold text-dark mb-0">{{ $contactAddress }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Map -->
    <section class="section-padding">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="ps-lg-4">
                        <span class="badge-modern mb-3">SEND A MESSAGE</span>
                        <h2 class="display-5 fw-bold mb-4">Let's Start a Conversation</h2>
                        <p class="text-muted mb-5">Whether you have a project in mind or just want to chat, we're here to help. Fill out the form, and we'll get back to you shortly.</p>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST" class="contact-form-modern">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" value="{{ request('subject') }}" required>
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="message" name="message" placeholder="Message" style="height: 150px" required></textarea>
                                        <label for="message">Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg w-100">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Map (Placeholder/Static Image or Embed) -->
                <div class="col-lg-6" data-aos="fade-left">
                     <div class="map-wrapper rounded-5 overflow-hidden shadow-lg h-100" style="min-height: 500px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d158858.182370726!2d-0.10159865000000001!3d51.52864165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8a00baf21de75%3A0x52963a5addd52a99!2sLondon%2C%20UK!5e0!3m2!1sen!2sbd!4v1683296232585!5m2!1sen!2sbd" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
