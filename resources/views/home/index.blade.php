@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')

    @if($heroMode === 'slider' && $heroSlides->count() > 0)
        <!-- Hero Slider Section -->
        <section class="hero-slider-wrap">
            <div class="swiper hero-main-swiper">
                <div class="swiper-wrapper">
                    @foreach($heroSlides as $slide)
                        <div class="swiper-slide">
                            @php
                                $img_path = $slide->image_path;
                                if (!empty($img_path) && filter_var($img_path, FILTER_VALIDATE_URL)) {
                                    $bg_style = "url('$img_path')";
                                } else {
                                     $bg_style = "url('" . asset('uploads/slider/' . $img_path) . "')";
                                }
                            @endphp
                            <div class="hero-slide-item" style="background-image: {{ $bg_style }};">
                                <div class="hero-overlay">
                                    <div class="container-fluid">
                                        <div class="hero-content-wrapper">
                                            <div class="hero-badge-cinematic">FEATURED PROJECT</div>
                                            <h1 class="hero-title-cinematic">{{ $slide->title ?: $heroTitle }}</h1>
                                            <p class="hero-subtitle-cinematic">{{ $slide->subtitle ?: $heroSubtitle }}</p>

                                            <div class="btn-pill-group">
                                                <a href="{{ $slide->button_link }}" class="btn btn-pill btn-pill-primary">
                                                    {{ $slide->button_text ?: 'Explore Now' }}
                                                </a>
                                                <a href="#services" class="btn btn-pill btn-pill-glass">
                                                    Our Services
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
            
             <!-- Thumbnail Navigation Slider -->
            <div class="swiper hero-thumbs-swiper">
                <div class="swiper-wrapper">
                    @foreach($heroSlides as $index => $slide)
                        <div class="swiper-slide">
                            <div class="hero-thumb-item">
                                <div class="thumb-meta">0{{ $index + 1 }} — Next Slide</div>
                                <div class="thumb-title ">{{ $slide->title ?: 'Untitled Project' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <!-- Fallback Static Hero -->
        <section class="hero-static-wrap">
            <div class="hero-mesh"></div>
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center">
                    <div class="col-lg-10 text-center">
                        <div class="hero-content" data-aos="zoom-out" data-aos-duration="1500">
                            <div class="hero-badge-modern mb-4">WELCOME TO WEBBOOMERS</div>
                            <h1 class="hero-title-modern mb-4">{!! $heroTitle ?: 'Leading You to Modern <br><span class="text-gradient-purple">Web Mastery</span>' !!}</h1>
                            <p class="hero-subtitle-modern mb-5 mx-auto">{!! $heroSubtitle ?: 'At Webboomers, we transform digital concepts into engaging websites.' !!}</p>
                            <div class="d-flex justify-content-center gap-4">
                                <a href="{{ route('contact') }}" class="btn btn-purple-gradient btn-lg px-5 py-4">GET STARTED</a>
                                <a href="{{ route('portfolio.index') }}" class="btn btn-outline-white-modern btn-lg px-5 py-4">LEARN MORE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Services Section -->
    <section id="services" style="padding: 120px 0;">
        <div class="container">
            <div class="section-title-modern" data-aos="fade-up">
                <h2>Our Services</h2>
                <p>We provide comprehensive web solutions to help your business succeed online</p>
            </div>
            <div class="row g-4">
                @foreach($services as $service)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-card-premium">
                            <div class="service-icon-box">
                                <i class="{{ $service->icon_class }}"></i>
                            </div>
                            <h3>{{ $service->title }}</h3>
                            <p>{{ $service->short_description }}</p>
                            <a href="{{ route('services') }}" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Projects -->
    <section id="portfolio" class="portfolio-section-elite" style="padding: 120px 0; overflow: hidden;">
        <div class="container">
            <div class="portfolio-header-elite mb-5" data-aos="fade-right">
                <div class="portfolio-header-box">
                    <div class="accent-bar"></div>
                    <div class="title-bg">
                        <h2 data-text="PROJECTS">OUR PROJECTS</h2>
                    </div>
                </div>
                <p class="portfolio-subtitle">Explore our amazing recent works</p>
            </div>
            
            @if($projects->isEmpty())
                 <div class="col-12 text-center">
                    <p>No projects found.</p>
                </div>
            @else
                 <div class="row g-4">
                    @foreach($projects as $index => $project)
                        @php
                             $cat_first = $project->categories->first()->name ?? 'Web Development';
                             $img_src = $project->desktop_image;
                                if (!empty($img_src) && !filter_var($img_src, FILTER_VALIDATE_URL)) {
                                     $top_img_path = public_path('assets/images/projects/' . $img_src);
                                     if(file_exists($top_img_path)) {
                                         $img_src = asset('assets/images/projects/' . $img_src);
                                     } else {
                                          $img_src = asset('uploads/projects/' . $img_src);
                                     }
                                } elseif (empty($img_src)) {
                                     $img_src = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800';
                                }
                        @endphp
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div class="project-card-modern-v2">
                                <div class="p-card-inner">
                                    <div class="p-card-img">
                                        <img src="{{ $img_src }}" alt="{{ $project->title }}" onerror="this.src='https://placehold.co/800x600/1e293b/ffffff?text=Project'">
                                        <div class="p-card-overlay">
                                            <div class="p-card-meta">
                                                <span class="p-category">{{ $cat_first }}</span>
                                                <h3 class="p-title">{{ $project->title }}</h3>
                                            </div>
                                            <div class="p-card-action">
                                                <a href="{{ route('portfolio.show', $project->slug) }}" class="btn-project-link">
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                 </div>
                 <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ route('portfolio.index') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg">View All Projects</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Statistics -->
    <section id="statistics" class="stats-section-premium position-relative overflow-hidden py-5">
         <div class="position-absolute top-0 start-0 w-100 h-100" style="background: var(--gradient-primary); opacity: 0.05;"></div>
         <div class="container position-relative">
            <div class="row g-4">
                @foreach($stats as $stat)
                     <div class="col-md-3 col-6" data-aos="fade-up">
                        <div class="p-4 rounded-4 bg-white shadow-sm text-center card-hover-lift border-0 h-100 d-flex flex-column justify-content-center align-items-center">
                            <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary" style="width: 60px; height: 60px;">
                                <i class="{{ $stat->icon_class }} fa-2x"></i>
                            </div>
                            <h3 class="display-6 fw-bold mb-1 text-dark">{{ $stat->stat_value }}</h3>
                            <p class="text-uppercase small fw-bold text-muted letter-spacing-1 mb-0">{{ $stat->stat_label }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
         </div>
    </section>

    <!-- Mission & Vision -->
    <section class="mv-section">
        <div class="mv-bg-shape mv-shape-1"></div>
        <div class="mv-bg-shape mv-shape-2"></div>
         <div class="container position-relative">
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="mv-card">
                        <div class="mv-icon-box bg-mission">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3>Our Mission</h3>
                        <p>{{ $mission }}</p>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="mv-card">
                        <div class="mv-icon-box bg-vision">
                             <i class="fas fa-eye"></i>
                        </div>
                         <h3>Our Vision</h3>
                        <p>{{ $vision }}</p>
                    </div>
                </div>
            </div>
         </div>
    </section>

    <!-- Featured Team -->
    @if($teamMembers->isNotEmpty())
        <section class="team-section-light">
             <div class="container">
                <div class="team-header-elite" data-aos="fade-right">
                    <div class="team-header-box">
                        <div class="yellow-bar"></div>
                        <div class="title-bg">
                            <h2>OUR TEAM</h2>
                        </div>
                    </div>
                    <p class="team-subtitle">Meet our team members</p>
                </div>
                 <div class="row g-4">
                    @foreach($teamMembers as $member)
                         <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up">
                             <div class="team-member-card-premium">
                                <div class="team-member-img">
                                    <img src="{{ asset('assets/images/team/' . ($member->image ?? 'placeholder-team.jpg')) }}"
                                        alt="{{ $member->name }}"
                                        onerror="this.src='https://via.placeholder.com/400x500/10101f/ffffff?text={{ urlencode($member->name) }}'">
                                </div>
                                <div class="team-info-premium">
                                    <h4>{{ $member->name }}</h4>
                                    <p>{{ $member->position }}</p>
                                    <!-- Social icons could be added here similar to team page -->
                                </div>
                            </div>
                         </div>
                    @endforeach
                 </div>
                 <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ route('team') }}" class="btn-elite px-5 magnetic">View Full Team</a>
                </div>
             </div>
        </section>
    @endif

    <!-- Testimonials -->
     @if($testimonials->isNotEmpty())
        <section class="testimonials-section-premium">
             <div class="container">
                <div class="section-title-modern" data-aos="fade-up">
                    <h2>What Our <span class="text-gradient">Clients</span> Say</h2>
                    <p>We pride ourselves on delivering exceptional results for our clients</p>
                </div>
                 <div class="row g-4 justify-content-center">
                    @foreach($testimonials as $testimonial)
                         <div class="col-lg-4 col-md-6" data-aos="fade-up">
                            <div class="testimonial-card-modern">
                                 <img src="{{ asset('assets/images/clients/' . ($testimonial->client_image ?? 'default-avatar.png')) }}"
                                    class="testimonial-avatar"
                                    alt="{{ $testimonial->client_name }}"
                                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($testimonial->client_name) }}&background=10b981&color=fff'">
                                <div class="testimonial-text">
                                    "{{ $testimonial->testimonial_text }}"
                                </div>
                                <div class="testimonial-name">{{ $testimonial->client_name }}</div>
                                <div class="testimonial-role">{{ $testimonial->client_position }}</div>
                            </div>
                        </div>
                    @endforeach
                 </div>
             </div>
        </section>
     @endif

     <!-- Blog -->
     @if($posts->isNotEmpty())
        <section id="blog" class="section-padding position-relative overflow-hidden">
             <div class="container">
                 <div class="section-title-modern mb-5" data-aos="fade-up">
                    <span class="badge bg-orange-soft text-orange px-4 py-2 rounded-pill fw-bold mb-3">LATEST NEWS</span>
                    <h2 class="display-5 fw-bold">Recent <span class="text-gradient-primary">Insights</span></h2>
                    <p class="lead">Explore our latest thoughts, digital trends, and expert transformations.</p>
                </div>
                <div class="row g-4">
                    @foreach($posts as $post)
                         <div class="col-lg-4 col-md-6" data-aos="fade-up">
                             <article class="blog-card-elite">
                                 <div class="blog-img-box">
                                     @php
                                        $img_src = $post->featured_image;
                                        if (!empty($img_src) && !filter_var($img_src, FILTER_VALIDATE_URL)) {
                                            $img_src = asset('uploads/blog/' . $img_src);
                                        } elseif (empty($img_src)) {
                                             $img_src = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800';
                                        }
                                    @endphp
                                    <img src="{{ $img_src }}"
                                        alt="{{ $post->title }}"
                                        class="blog-img"
                                        onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800'">
                                    <div class="blog-date-badge">
                                        <span class="day">{{ $post->created_at->format('d') }}</span>
                                        <span class="month">{{ $post->created_at->format('M') }}</span>
                                    </div>
                                 </div>
                                  <div class="blog-content-box">
                                     <h3 class="blog-title-elite" style="font-size: 1.3rem;">
                                        <a href="{{ route('blog.show', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                      <p class="blog-excerpt-elite">
                                        {{ Str::limit(strip_tags($post->excerpt ?: $post->content), 100) }}...
                                    </p>
                                     <a href="{{ route('blog.show', $post->slug) }}" class="blog-link-elite">
                                        READ ARTICLE <i class="fas fa-arrow-right"></i>
                                    </a>
                                 </div>
                             </article>
                         </div>
                    @endforeach
                </div>
             </div>
        </section>
     @endif
     
     <!-- Contact Section -->
     <section id="contact" class="position-relative overflow-hidden section-padding bg-light">
          <div class="container position-relative z-1">
               <div class="row align-items-center g-5">
                    <div class="col-lg-5" data-aos="fade-right">
                         <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3 fw-bold">CONTACT US</span>
                        <h2 class="display-5 fw-bold mb-4">Let's Build Your <br><span class="text-gradient-primary">Digital Future</span></h2>
                        <p class="lead text-muted mb-5">Have a project in mind? We are ready to help you grow your business online.</p>
                         <div class="d-flex flex-column gap-4">
                            <div class="d-flex align-items-center gap-3">
                                 <div class="d-flex align-items-center justify-content-center bg-white shadow-sm rounded-circle text-primary" style="width: 50px; height: 50px;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Email Us</h6>
                                    <!-- Use proper configured email or fallback -->
                                    <p class="text-muted mb-0">info@webboomers.com</p>
                                </div>
                            </div>
                         </div>
                    </div>
                     <div class="col-lg-7" data-aos="fade-left">
                         <div class="bg-white p-5 rounded-5 shadow-lg position-relative border border-light">
                            <h3 class="fw-bold mb-4">Send us a message</h3>
                             <form action="{{ route('contact.submit') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                     <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control bg-light border-0" id="name" name="name" placeholder="Name" required>
                                            <label for="name">Your Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control bg-light border-0" id="email" name="email" placeholder="Email" required>
                                            <label for="email">Your Email</label>
                                        </div>
                                    </div>
                                     <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control bg-light border-0" id="subject" name="subject" placeholder="Subject" required>
                                            <label for="subject">Subject</label>
                                        </div>
                                    </div>
                                     <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control bg-light border-0" placeholder="Message" id="message" name="message" style="height: 150px" required></textarea>
                                            <label for="message">Your Message</label>
                                        </div>
                                    </div>
                                     <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill py-3 shadow-sm">Send Message</button>
                                    </div>
                                </div>
                             </form>
                         </div>
                     </div>
               </div>
          </div>
     </section>

@endsection

@push('scripts')
<script>
    // Initialize Swiper Scripts if needed (assuming app.js or layout includes them)
    // If not, we might need to push a script block here or ensure layout loads swiper.
    // Logic from index.php script block should be adapted here if it's not in a main js file.
    
    if (document.querySelector('.hero-thumbs-swiper')) {
        var thumbsSwiper = new Swiper('.hero-thumbs-swiper', {
            loop: true,
            spaceBetween: 20,
            slidesPerView: 2,
            freeMode: true,
            watchSlidesProgress: true,
            breakpoints: {
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 }
            }
        });

        var mainSwiper = new Swiper('.hero-main-swiper', {
            loop: true,
            effect: 'fade',
            speed: 1000,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            thumbs: {
                swiper: thumbsSwiper,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
</script>
@endpush
