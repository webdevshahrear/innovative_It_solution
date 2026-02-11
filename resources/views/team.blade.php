@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="slide-mesh"></div>
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-3">Our <span class="text-emerald">Team</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Our Team</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="section-padding bg-white">
        <div class="container">
            <div class="section-title-modern text-center mb-5" data-aos="fade-up">
                <h2>Meet The Experts</h2>
                <p>The talented people behind our success</p>
            </div>

            <div class="row g-4 justify-content-center">
                @forelse($teamMembers as $member)
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="team-member-card-premium">
                            <div class="team-member-img">
                                <img src="{{ asset('assets/images/team/' . ($member->image ?? 'placeholder-team.jpg')) }}"
                                    alt="{{ $member->name }}"
                                    onerror="this.src='https://via.placeholder.com/400x500/10101f/ffffff?text={{ urlencode($member->name) }}'">
                            </div>
                            <div class="team-info-premium">
                                <h4>{{ $member->name }}</h4>
                                <p>{{ $member->position }}</p>
                                <div class="team-social-premium">
                                    @if($member->facebook_url)
                                        <a href="{{ $member->facebook_url }}"><i class="fab fa-facebook-f"></i></a>
                                    @endif
                                    @if($member->twitter_url)
                                        <a href="{{ $member->twitter_url }}"><i class="fab fa-twitter"></i></a>
                                    @endif
                                    @if($member->linkedin_url)
                                        <a href="{{ $member->linkedin_url }}"><i class="fab fa-linkedin-in"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No team members found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
