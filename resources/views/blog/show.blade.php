@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
    <article class="single-post pb-5">
        <section class="page-header-premium" style="min-height: 50vh; padding-top: 150px; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 text-center" data-aos="fade-up">
                        <span class="badge bg-primary px-3 py-2 mb-4">Latest Insights</span>
                        <h1 class="display-4 fw-bold text-white mb-4">{{ $post->title }}</h1>
                        <div class="post-meta text-white-50">
                            <span class="me-3"><i class="far fa-calendar-alt me-2"></i>{{ $post->created_at->format('F d, Y') }}</span>
                            <span><i class="far fa-user me-2"></i>By {{ $post->author ?? 'Admin' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container" style="margin-top: -60px; position: relative; z-index: 10;">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="glass-card p-4 p-md-5 bg-white rounded-4 shadow-lg" data-aos="fade-up">
                        @php
                            $img_src = $post->featured_image;
                            if (!empty($img_src) && !filter_var($img_src, FILTER_VALIDATE_URL)) {
                                $img_src = asset('uploads/blog/' . $img_src);
                            } elseif (empty($img_src)) {
                                 $img_src = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=1200';
                            }
                        @endphp
                        <img src="{{ $img_src }}"
                            class="img-fluid rounded-4 mb-5 shadow-lg w-100"
                            alt="{{ $post->title }}"
                            onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=1200'">

                        <div class="post-content text-dark lead" style="line-height: 1.8;">
                            {!! $post->content !!}
                        </div>

                        <hr class="my-5 opacity-25">

                        <div class="post-footer d-flex justify-content-between align-items-center">
                            <div class="share-box">
                                <span class="text-muted small d-block mb-3">Share this article</span>
                                <div class="d-flex gap-3">
                                    <a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="btn btn-outline-info btn-sm rounded-circle"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    @if($recentPosts->isNotEmpty())
                        <div class="mt-5 pt-5">
                            <h2 class="mb-5">More <span class="text-primary">Insights</span></h2>
                            <div class="row g-4">
                                @foreach($recentPosts as $rel)
                                    <div class="col-md-4">
                                        <div class="card h-100 border-0 shadow-sm overflow-hidden">
                                            @php
                                                $rel_img = $rel->featured_image;
                                                if (!empty($rel_img) && !filter_var($rel_img, FILTER_VALIDATE_URL)) {
                                                    $rel_img = asset('uploads/blog/' . $rel_img);
                                                } elseif (empty($rel_img)) {
                                                     $rel_img = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=600';
                                                }
                                            @endphp
                                            <img src="{{ $rel_img }}"
                                                class="card-img-top"
                                                alt="{{ $rel->title }}"
                                                style="height: 200px; object-fit: cover;"
                                                onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=600'">
                                            <div class="card-body p-4">
                                                <h5 class="card-title mb-3">{{ $rel->title }}</h5>
                                                <a href="{{ route('blog.show', $rel->slug) }}" class="btn btn-link text-primary p-0">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </article>
@endsection
