@extends('layouts.frontend')

@section('title', $post->title . ' - Innovative IT Solutions')

@section('content')
@push('styles')
<style>
    /* Premium Modern Blog Styles */
    .blog-hero-v4 {
        position: relative;
        padding: 180px 0 100px;
        background: #040415;
        overflow: hidden;
    }
    .blog-hero-v4::before {
        content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle at center, rgba(240, 82, 35, 0.05) 0%, transparent 50%);
        pointer-events: none;
    }
    .blog-badge-v4 {
        display: inline-block;
        padding: 6px 16px;
        background: rgba(240, 82, 35, 0.15);
        border: 1px solid rgba(240, 82, 35, 0.3);
        color: var(--v2-primary);
        border-radius: 100px;
        font-size: 0.8rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 25px;
    }
    .blog-title-v4 {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 900;
        color: #ffffff;
        line-height: 1.2;
        letter-spacing: -1px;
        margin-bottom: 40px;
    }
    .blog-meta-v4 {
        display: flex; align-items: center; justify-content: center; gap: 30px;
        color: rgba(255,255,255,0.6); font-size: 0.95rem; font-weight: 500;
        flex-wrap: wrap;
    }
    .blog-meta-author {
        display: flex; align-items: center; gap: 12px; color: #fff; font-weight: 600;
    }
    .author-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: linear-gradient(135deg, var(--v2-primary), #ff7b00); 
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-weight: 800; font-size: 1.2rem;
    }
    
    .blog-cover-wrapper {
        margin-top: -60px;
        position: relative;
        z-index: 10;
        max-width: 1000px;
        margin-left: auto; margin-right: auto;
    }
    .blog-cover-v4 {
        width: 100%;
        height: 550px;
        object-fit: cover;
        border-radius: 30px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.6);
        border: 1px solid rgba(255,255,255,0.05);
    }
    @media (max-width: 768px) {
        .blog-cover-v4 { height: 350px; border-radius: 20px; }
    }

    .blog-content-container {
        max-width: 800px;
        margin: 80px auto 100px;
    }
    .blog-content-v4 {
        color: rgba(255,255,255,0.85);
        font-size: 1.2rem;
        line-height: 1.9;
        font-family: 'Inter', system-ui, sans-serif;
    }
    .blog-content-v4 p { margin-bottom: 25px; }
    .blog-content-v4 h1, .blog-content-v4 h2, .blog-content-v4 h3, .blog-content-v4 h4 {
        color: #fff; font-weight: 800; margin: 50px 0 25px; line-height: 1.3;
    }
    .blog-content-v4 img {
        max-width: 100%; height: auto; border-radius: 20px; margin: 40px 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .blog-content-v4 blockquote {
        border-left: 4px solid var(--v2-primary);
        padding: 30px 40px;
        margin: 50px 0;
        background: rgba(255,255,255,0.02);
        border-radius: 0 20px 20px 0;
        font-style: italic;
        color: #fff;
        font-size: 1.4rem;
        line-height: 1.7;
    }
    .blog-content-v4 ul, .blog-content-v4 ol { margin-bottom: 30px; padding-left: 20px; }
    .blog-content-v4 li { margin-bottom: 12px; }
    .blog-content-v4 a { color: var(--v2-primary); text-decoration: none; border-bottom: 1px solid transparent; transition: 0.3s; }
    .blog-content-v4 a:hover { border-color: var(--v2-primary); }
    
    .blog-share-v4 {
        display: flex; align-items: center; gap: 20px;
        padding: 40px 0; border-top: 1px solid rgba(255,255,255,0.1); border-bottom: 1px solid rgba(255,255,255,0.1);
        margin: 60px 0 0;
    }
    .share-label { color: #fff; font-weight: 700; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px; }
    .share-btn { width: 50px; height: 50px; border-radius: 50%; background: rgba(255,255,255,0.05); color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.3s; font-size: 1.1rem; }
    .share-btn:hover { background: var(--v2-primary); transform: translateY(-5px); box-shadow: 0 10px 20px rgba(240, 82, 35, 0.2); }

    /* Related Posts */
    .related-posts-section { background: #06061e; padding: 100px 0; border-top: 1px solid rgba(255,255,255,0.03); }
    .rel-card-v4 { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 24px; overflow: hidden; transition: 0.4s; height: 100%; display: flex; flex-direction: column; }
    .rel-card-v4:hover { border-color: rgba(240, 82, 35, 0.3); transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
    .rel-img-v4 { height: 220px; overflow: hidden; position: relative; }
    .rel-img-v4 img { width: 100%; height: 100%; object-fit: cover; transition: 0.8s ease; }
    .rel-card-v4:hover .rel-img-v4 img { transform: scale(1.1); filter: grayscale(0.2); }
    .rel-body-v4 { padding: 30px; display: flex; flex-direction: column; flex-grow: 1; }
    .rel-title-v4 { font-size: 1.4rem; font-weight: 800; color: #fff; margin-bottom: 20px; line-height: 1.4; text-decoration: none; transition: 0.3s; }
    .rel-card-v4:hover .rel-title-v4 { color: var(--v2-primary); }
    .rel-link-v4 { margin-top: auto; color: rgba(255,255,255,0.5); font-weight: 700; text-decoration: none; font-size: 0.85rem; transition: 0.3s; display: flex; align-items: center; gap: 8px; text-transform: uppercase; letter-spacing: 1.5px; }
    .rel-card-v4:hover .rel-link-v4 { color: #fff; gap: 12px; }
</style>
@endpush

    <article class="single-post">
        <!-- Hero Section -->
        <section class="blog-hero-v4 text-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10" data-aos="fade-up">
                        <span class="blog-badge-v4">Insights & Intelligence</span>
                        <h1 class="blog-title-v4">{{ $post->title }}</h1>
                        <div class="blog-meta-v4">
                            <div class="blog-meta-author">
                                <div class="author-avatar">{{ substr($post->author ?? 'A', 0, 1) }}</div>
                                {{ $post->author ?? 'Admin' }}
                            </div>
                            <span><i class="far fa-calendar-alt me-2" style="color:var(--v2-primary)"></i>{{ $post->created_at->format('F d, Y') }}</span>
                            <span><i class="far fa-clock me-2" style="color:var(--v2-primary)"></i>{{ max(1, ceil(str_word_count(strip_tags($post->content)) / 200)) }} min read</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cover Image -->
        <div class="container">
            <div class="blog-cover-wrapper" data-aos="fade-up" data-aos-delay="100">
                @php
                    $img_src = $post->featured_image;
                    if (!empty($img_src) && !filter_var($img_src, FILTER_VALIDATE_URL)) {
                        $img_src = asset('uploads/blog/' . $img_src);
                    } elseif (empty($img_src)) {
                         $img_src = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=1200';
                    }
                @endphp
                <img src="{{ $img_src }}" class="blog-cover-v4" alt="{{ $post->title }}" onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=1200'">
            </div>
        </div>

        <!-- Article Content -->
        <div class="container">
            <div class="blog-content-container">
                <div class="blog-content-v4" data-aos="fade-up" data-aos-delay="200">
                    {!! $post->content !!}
                </div>

                <!-- Share -->
                <div class="blog-share-v4" data-aos="fade-up">
                    <span class="share-label">Share Article:</span>
                    <a href="#" class="share-btn"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="share-btn"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="share-btn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="share-btn"><i class="fas fa-link"></i></a>
                </div>
            </div>
        </div>

        <!-- Recent Posts -->
        @if($recentPosts->isNotEmpty())
            <section class="related-posts-section">
                <div class="container">
                    <div class="text-center mb-5" data-aos="fade-up">
                        <h2 class="blog-title-v4" style="font-size: 3rem;">More <span class="text-glow-primary" style="color:var(--v2-primary);">Insights</span></h2>
                    </div>
                    <div class="row g-4 justify-content-center">
                        @foreach($recentPosts as $rel)
                            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <a href="{{ route('blog.show', $rel->slug) }}" class="text-decoration-none h-100">
                                    <div class="rel-card-v4">
                                        <div class="rel-img-v4">
                                            @php
                                                $rel_img = $rel->featured_image;
                                                if (!empty($rel_img) && !filter_var($rel_img, FILTER_VALIDATE_URL)) {
                                                    $rel_img = asset('uploads/blog/' . $rel_img);
                                                } elseif (empty($rel_img)) {
                                                     $rel_img = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=600';
                                                }
                                            @endphp
                                            <img src="{{ $rel_img }}" alt="{{ $rel->title }}" onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=600'">
                                        </div>
                                        <div class="rel-body-v4">
                                            <h3 class="rel-title-v4">{{ $rel->title }}</h3>
                                            <span class="rel-link-v4">Keep Reading <i class="fas fa-arrow-right"></i></span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </article>
@endsection
