@extends('layouts.frontend')

@use('Illuminate\Support\Str')

@section('title', $pageTitle)

@section('content')
<style>
    /* Blog Page Premium Styles */
    .blog-hero-v2 {
        position: relative;
        padding: 160px 0 100px;
        background: var(--navy-dark);
        overflow: hidden;
    }

    .blog-hero-v2::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 30% 20%, rgba(236, 72, 153, 0.05) 0%, transparent 40%),
                    radial-gradient(circle at 70% 80%, rgba(59, 130, 246, 0.05) 0%, transparent 40%);
        pointer-events: none;
    }

    .blog-section-v2 {
        background: var(--navy-dark);
        padding: 100px 0;
    }

    .article-card-elite {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 32px;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .article-card-elite:hover {
        transform: translateY(-12px);
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.05);
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5);
    }

    .article-img-box {
        position: relative;
        height: 260px;
        overflow: hidden;
    }

    .article-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .article-card-elite:hover .article-img-box img {
        transform: scale(1.1);
    }

    .article-date-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(13, 11, 40, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 8px 15px;
        border-radius: 12px;
        color: #fff;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .article-content {
        padding: 35px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .article-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .article-title-v2 {
        font-size: 1.5rem;
        font-weight: 800;
        line-height: 1.3;
        margin-bottom: 20px;
    }

    .article-title-v2 a {
        color: #fff;
        text-decoration: none;
        transition: 0.3s;
    }

    .article-card-elite:hover .article-title-v2 a {
        color: var(--primary);
    }

    .article-read-more {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: 0.3s;
    }

    .article-card-elite:hover .article-read-more {
        color: var(--primary);
        gap: 15px;
    }

    /* Sidebar Premium */
    .sidebar-widget-v2 {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 35px;
        margin-bottom: 30px;
    }

    .widget-title-v2 {
        font-size: 1.2rem;
        font-weight: 800;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 15px;
    }

    .widget-title-v2::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; width: 40px; height: 3px;
        background: var(--primary);
    }

    .category-link-v2 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 15px;
        color: #fff;
        text-decoration: none;
        transition: 0.3s;
        border: 1px solid rgba(255, 255, 255, 0.05);
        margin-bottom: 10px;
    }

    .category-link-v2:hover {
        background: var(--primary);
        border-color: transparent;
        transform: translateX(5px);
        color: #fff !important;
    }

    .search-input-v2 {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        padding: 15px 20px 15px 50px !important;
        border-radius: 15px !important;
    }

    .search-icon-v2 {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
    }
</style>

<div class="blog-hero-v2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <span class="hero-badge-cinematic">INSIGHTS & TRENDS</span>
                <h1 class="hero-title-cinematic mb-4">Navigating the <br><span class="text-primary">Digital Frontier</span></h1>
                <p class="hero-subtitle-cinematic mb-5">Deep dives into technology, strategy, and the future of digital business from our expert architects.</p>
                
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Insights</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="blog-section-v2">
    <div class="container">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8">
                @if($posts->count() > 0)
                    <div class="row g-4">
                        @foreach($posts as $index => $post)
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index % 2) * 100 }}">
                                <article class="article-card-elite">
                                    <div class="article-img-box">
                                        @php
                                            $img_src = $post->featured_image;
                                            if (!empty($img_src) && !filter_var($img_src, FILTER_VALIDATE_URL)) {
                                                $img_src = asset('uploads/blog/' . $img_src);
                                            } elseif (empty($img_src)) {
                                                 $img_src = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800';
                                            }
                                        @endphp
                                        <img src="{{ $img_src }}" alt="{{ $post->title }}">
                                        <div class="article-date-badge">
                                            {{ $post->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                    <div class="article-content">
                                        <div class="article-meta">
                                            <span><i class="far fa-user me-2"></i> {{ $post->author ?? 'Admin' }}</span>
                                            @if($post->category)
                                                <span><i class="far fa-folder me-2"></i> {{ $post->category }}</span>
                                            @endif
                                        </div>
                                        <h3 class="article-title-v2">
                                            <a href="{{ route('blog.show', $post->slug) }}">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <p class="text-v2-muted mb-4 small">
                                            {{ Str::limit(strip_tags($post->excerpt ?: $post->content), 120) }}
                                        </p>
                                        <a href="{{ route('blog.show', $post->slug) }}" class="article-read-more">
                                            Read Article <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-80 d-flex justify-content-center">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="text-center py-120 glass-effect rounded-4">
                        <i class="fas fa-newspaper fa-4x text-primary mb-4"></i>
                        <h3 class="fw-bold">No Insights Found</h3>
                        <p class="text-v2-muted">Our authors are currently drafting new pioneering content.</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar-wrapper ps-lg-4 position-sticky" style="top: 120px;">
                    <!-- Search Widget -->
                    <div class="sidebar-widget-v2" data-aos="fade-left">
                        <h4 class="widget-title-v2">Search</h4>
                        <form action="{{ route('blog.index') }}" method="GET">
                            <div class="position-relative">
                                <input type="text" name="search" class="form-control search-input-v2" placeholder="Search insights..." value="{{ request('search') }}">
                                <i class="fas fa-search search-icon-v2"></i>
                            </div>
                        </form>
                    </div>

                    <!-- Categories Widget -->
                     <div class="sidebar-widget-v2" data-aos="fade-left" data-aos-delay="100">
                        <h4 class="widget-title-v2">Categories</h4>
                        @if(count($categories) > 0)
                            <div class="d-flex flex-column gap-2">
                                @foreach($categories as $category)
                                    <a href="{{ route('blog.index', ['category' => $category]) }}" class="category-link-v2">
                                        <span>{{ $category }}</span>
                                        <i class="fas fa-chevron-right small opacity-50"></i>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-v2-muted small mb-0">No categories found.</p>
                        @endif
                    </div>
                    
                    <!-- Newsletter Widget -->
                    <div class="sidebar-widget-v2" style="background: linear-gradient(135deg, var(--primary) 0%, #e64a19 100%);" data-aos="fade-left" data-aos-delay="200">
                        <div class="text-center text-white">
                            <i class="far fa-paper-plane fa-3x mb-4"></i>
                            <h4 class="fw-bold mb-3">Elite Newsletter</h4>
                            <p class="small text-white-50 mb-4">Exclusive digital strategy delivered bi-weekly to your inbox.</p>
                            <form action="#" class="d-flex flex-column gap-3">
                                <input type="email" class="form-control border-0 bg-white bg-opacity-20 text-white placeholder-white-50" placeholder="Architect email..." style="border-radius:12px;">
                                <button class="btn btn-white fw-bold w-100 py-3" style="border-radius:12px;">SUBSCRIBE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
