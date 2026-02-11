@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
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
                                    <a href="{{ $project->project_url ?? '#' }}" target="_blank" class="btn btn-premium w-100 magnetic">Visit Website <i class="fas fa-external-link-alt ms-2"></i></a>
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
                            <div class="col-md-4">
                                <div class="project-card">
                                    <div class="mockups" style="height: 250px;">
                                        @php
                                            $rel_img = $rel->desktop_image;
                                            if (!empty($rel_img) && !filter_var($rel_img, FILTER_VALIDATE_URL)) {
                                                 $top_img_path = public_path('assets/images/projects/' . $rel_img);
                                                 if(file_exists($top_img_path)) {
                                                     $rel_img = asset('assets/images/projects/' . $rel_img);
                                                 } else {
                                                      $rel_img = asset('uploads/projects/' . $rel_img);
                                                 }
                                            } elseif (empty($rel_img)) {
                                                 $rel_img = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=600';
                                            }
                                        @endphp
                                        <img src="{{ $rel_img }}"
                                            class="desktop-mockup"
                                            alt="{{ $rel->title }}"
                                            onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=600'">
                                    </div>
                                    <div class="card-footer">
                                        <h4 class="text-white">{{ $rel->title }}</h4>
                                        <a href="{{ route('portfolio.show', $rel->slug) }}" class="btn btn-link text-white-50 px-0 magnetic">View Case Study <i class="fas fa-arrow-right ms-2"></i></a>
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
