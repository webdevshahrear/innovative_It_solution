@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="slide-mesh"></div>
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-3">Our <span class="text-emerald">Blog</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Blog</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row g-5">
                <!-- Main Content -->
                <div class="col-lg-8">
                    @forelse($posts as $post)
                        <article class="blog-card-modern mb-5" data-aos="fade-up">
                            <div class="blog-card-img-wrapper">
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
                                    class="blog-card-img"
                                    onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800'">
                                <div class="blog-date-float">
                                    <span class="day">{{ $post->created_at->format('d') }}</span>
                                    <span class="month">{{ $post->created_at->format('M') }}</span>
                                </div>
                            </div>
                            <div class="blog-card-body p-4 bg-white">
                                <div class="blog-meta mb-3">
                                    <span class="meta-item"><i class="fas fa-user-circle me-2"></i>{{ $post->author ?? 'Admin' }}</span>
                                     @if($post->category)
                                        <span class="meta-item ms-3"><i class="fas fa-folder me-2"></i>{{ $post->category }}</span>
                                    @endif
                                </div>
                                <h2 class="blog-title h3 fw-bold mb-3">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none hover-primary">{{ $post->title }}</a>
                                </h2>
                                <p class="text-muted mb-4">
                                    {{ Str::limit(strip_tags($post->excerpt ?: $post->content), 150) }}
                                </p>
                                <a href="{{ route('blog.show', $post->slug) }}" class="btn-link-custom fw-bold text-primary">
                                    Read Article <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="alert alert-info">No blog posts found.</div>
                    @endforelse

                    <!-- Pagination -->
                    <div class="mt-5">
                        {{ $posts->links() }}
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sidebar-wrapper ps-lg-4">
                        <!-- Search Widget -->
                        <div class="sidebar-widget bg-white p-4 rounded-4 shadow-sm mb-4" data-aos="fade-left">
                            <h4 class="widget-title fw-bold mb-4">Search</h4>
                            <form action="{{ route('blog.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control border-end-0" placeholder="Search articles..." value="{{ request('search') }}">
                                    <button class="btn btn-primary border-start-0" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <!-- Categories Widget -->
                         <div class="sidebar-widget bg-white p-4 rounded-4 shadow-sm mb-4" data-aos="fade-left" data-aos-delay="100">
                            <h4 class="widget-title fw-bold mb-4">Categories</h4>
                            <ul class="list-unstyled category-list-modern">
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('blog.index', ['category' => $category]) }}" class="d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-chevron-right me-2 small text-primary"></i> {{ $category }}</span>
                                            <!-- <span class="badge bg-light text-dark rounded-pill">3</span> -->
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
