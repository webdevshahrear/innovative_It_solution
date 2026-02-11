@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
    <!-- Page Header -->
    <section class="page-header-premium">
        <div class="floating-particle" style="top: 10%; right: -5%;"></div>
        <div class="floating-particle" style="bottom: -10%; left: -5%; background: radial-gradient(circle, var(--accent) 0%, transparent 70%);"></div>
        <div class="container text-center">
            <h1 data-aos="fade-up">Explore Our <span class="text-gradient">Portfolio</span></h1>
            <p class="lead text-white-50" data-aos="fade-up" data-aos-delay="200">Witness the digital transformations we've crafted for world-class brands.</p>
        </div>
    </section>

    <!-- Filter Navigation -->
    <div class="container d-flex justify-content-center mt-n5 position-relative" style="z-index: 10;">
        <div class="filter-nav-glass" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('portfolio.index', ['category' => 'all']) }}"
                class="filter-btn-premium {{ $categoryFilter === 'all' ? 'active' : '' }}">
                <i class="fas fa-th-large me-2"></i> All Projects
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('portfolio.index', ['category' => $cat->slug]) }}"
                    class="filter-btn-premium {{ $categoryFilter === $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="container py-5">
        <!-- Portfolio Grid -->
        <div class="row g-4">
            @forelse($projects as $project)
                <div class="col-lg-6 col-md-12 mb-4 portfolio-item" data-aos="fade-up">
                    <div class="project-card">
                        <div class="mockups">
                            @php
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
                            <img src="{{ $img_src }}"
                                class="desktop-mockup"
                                alt="{{ $project->title }}"
                                onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800'">
                        </div>
                        <div class="card-footer p-4">
                            <h3 class="h5 mb-2">{{ $project->title }}</h3>
                            <div class="tags mb-3">
                                @if($project->categories)
                                    @foreach($project->categories as $cat)
                                        <span class="tag bg-white text-dark border-0 shadow-sm">{{ $cat->name }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <a href="{{ route('portfolio.show', $project->slug) }}" class="btn btn-premium btn-sm px-4">
                                Case Study <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div style="font-size: 4rem; margin-bottom: 20px;">📁</div>
                    <h3>No projects found.</h3>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $projects->appends(['category' => $categoryFilter])->links() }}
        </div>
    </div>
@endsection
