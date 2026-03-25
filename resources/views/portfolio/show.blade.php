@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
@push('styles')
<style>
    .page-header-premium {
        background: var(--navy-dark);
        background-image: radial-gradient(circle at 100% 0%, var(--primary-light) 0%, transparent 50%);
        position: relative;
        overflow: hidden;
    }
    .page-header-premium::before {
        content: ''; position: absolute; top: -100px; right: -100px;
        width: 400px; height: 400px;
        background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%);
        opacity: 0.5;
    }
    .glass-card {
        background: var(--card-bg);
        backdrop-filter: blur(16px);
        border: 1px solid var(--border);
        border-radius: 24px;
        box-shadow: var(--glass-shadow);
    }
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .btn-premium {
        background: var(--gradient-primary);
        color: white; font-weight: 700; border-radius: 12px;
        padding: 12px 24px; transition: all 0.3s ease;
        border: none; box-shadow: 0 4px 15px var(--primary-glow);
    }
    .btn-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--primary-glow);
        color: white;
    }
    .tag {
        font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em;
        text-transform: uppercase; border-radius: 6px; padding: 6px 14px;
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid var(--border) !important;
        color: #fff !important;
    }
    .mockups img {
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .mockups:hover img {
        transform: scale(1.02);
    }
</style>
@endpush
    <section class="page-header-premium" style="min-height: 60vh; padding-top: 150px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('portfolio.index') }}" class="text-white-50">Portfolio</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{ $project->title }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-3 fw-bold mb-4">{{ $project->title }}</h1>
                    <div class="tags">
                        @if($project->categories)
                            @foreach($project->categories as $cat)
                                <span class="tag bg-white text-dark border-0 px-4 py-2">{{ $cat->name }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" style="margin-top: -100px; position: relative; z-index: 10;">
        <div class="container">
            <div class="glass-card p-5 mb-5" data-aos="fade-up">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <div class="mockups mb-5" style="height: auto; padding: 0; background: transparent;">
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
                                class="img-fluid rounded-4 shadow-2xl"
                                alt="{{ $project->title }}"
                                onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=1200'">
                        </div>
                        <div class="project-content text-white">
                            <h2 class="mb-4">Project Overview</h2>
                            <div class="opacity-75 lead">
                                {!! nl2br(e($project->description)) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="sticky-top" style="top: 100px;">
                            <div class="glass-card p-4 border-primary">
                                <h4 class="text-white mb-4">Project Info</h4>
                                <div class="info-item mb-4">
                                    <label class="text-white-50 small d-block">Client</label>
                                    <span class="text-white fw-bold">{{ $project->client ?? 'Global Partner' }}</span>
                                </div>
                                <div class="info-item mb-4">
                                    <label class="text-white-50 small d-block">Completion Date</label>
                                    <span class="text-white fw-bold">{{ $project->created_at->format('M Y') }}</span>
                                </div>
                                <div class="info-item mb-4">
                                    <label class="text-white-50 small d-block">Live Preview</label>
                                    <a href="{{ $project->project_url ?? '#' }}" target="_blank" class="btn btn-premium w-100">Visit Website <i class="fas fa-external-link-alt ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Projects -->
            @if($relatedProjects->isNotEmpty())
                <div class="mt-5 pt-5">
                    <h2 class="text-white mb-5">Related <span class="text-gradient">Projects</span></h2>
                    <div class="row g-4">
                        @foreach($relatedProjects as $rel)
                            <div class="col-md-4 d-flex">
                                <div class="project-card w-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; overflow: hidden; transition: all 0.3s ease; display: flex; flex-direction: column;">
                                    <div class="mockups position-relative" style="height: 240px; overflow: hidden;">
                                        @php
                                            $rel_img = $rel->desktop_image;
                                            $placeholders = [
                                                'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80',
                                                'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=800&q=80',
                                                'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=800&q=80',
                                            ];
                                            $relIdx = ($rel->id ?? 0) % count($placeholders);

                                            if (!empty($rel_img) && !filter_var($rel_img, FILTER_VALIDATE_URL)) {
                                                 $top_img_path = public_path('assets/images/projects/' . $rel_img);
                                                 if(file_exists($top_img_path)) {
                                                     $rel_img = asset('assets/images/projects/' . $rel_img);
                                                 } else {
                                                      $rel_img = asset('uploads/projects/' . $rel_img);
                                                 }
                                            } elseif (empty($rel_img)) {
                                                 $rel_img = $placeholders[$relIdx];
                                            }
                                        @endphp
                                        <img src="{{ $rel_img }}"
                                            class="w-100 h-100"
                                            style="object-fit: cover; transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);"
                                            alt="{{ $rel->title }}"
                                            onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=600'"
                                            onmouseover="this.style.transform='scale(1.05)'"
                                            onmouseout="this.style.transform='scale(1)'">
                                    </div>
                                    <div class="p-4 d-flex flex-column flex-grow-1">
                                        <h4 class="text-white mb-4" style="font-weight: 700; font-size: 1.25rem;">{{ $rel->title }}</h4>
                                        <a href="{{ route('portfolio.show', $rel->slug) }}" class="mt-auto d-inline-flex align-items-center text-decoration-none" style="color: var(--v2-primary); font-weight: 600; font-size: 0.9rem; transition: 0.3s; letter-spacing: 0.5px; text-transform: uppercase;">
                                            <span onmouseover="this.nextElementSibling.style.transform='translateX(5px)'" onmouseout="this.nextElementSibling.style.transform='translateX(0)'">View Case Study</span> 
                                            <i class="fas fa-arrow-right ms-2" style="transition: transform 0.3s;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
