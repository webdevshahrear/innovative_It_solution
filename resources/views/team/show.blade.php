@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
@push('styles')
<style>
    .instructor-profile-wrap {
        padding: 180px 0 100px;
        background: #040415;
        min-height: 100vh;
        color: #fff;
    }
    
    .instructor-sidebar {
        text-align: center;
        position: sticky;
        top: 120px;
        padding-bottom: 40px;
    }
    .inst-avatar {
        width: 200px; height: 200px; border-radius: 50%; object-fit: cover;
        margin-bottom: 25px; border: 4px solid rgba(255,255,255,0.03);
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    .inst-socials {
        display: flex; gap: 10px; justify-content: center; margin-top: 30px; flex-wrap: wrap;
    }
    .inst-social-btn {
        width: 45px; height: 45px; border-radius: 50%;
        background: rgba(255,255,255,0.03); color: #fff;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid rgba(255,255,255,0.05); transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none; font-size: 1.1rem;
    }
    .inst-social-btn:hover {
        background: var(--v2-primary); border-color: transparent; transform: translateY(-5px) scale(1.1); color: #fff;
        box-shadow: 0 10px 20px rgba(240, 82, 35, 0.25);
    }
    .inst-action-btn {
        display: block; width: 100%; padding: 16px;
        background: var(--v2-primary); color: #fff; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;
        border-radius: 12px; text-decoration: none; margin-top: 35px; transition: 0.3s; font-size: 0.95rem;
    }
    .inst-action-btn:hover { background: #fff; color: var(--v2-primary); transform: translateY(-3px); box-shadow: 0 15px 30px rgba(255,255,255,0.1); }

    .inst-main {
        padding-left: 0;
    }
    @media (min-width: 992px) {
        .inst-main { padding-left: 80px; }
    }
    .inst-badge {
        font-size: 0.85rem; font-weight: 800; color: var(--v2-primary); letter-spacing: 2.5px; text-transform: uppercase; margin-bottom: 20px; display: inline-block;
        background: rgba(240, 82, 35, 0.1); padding: 5px 15px; border-radius: 50px; border: 1px solid rgba(240, 82, 35, 0.2);
    }
    .inst-name { font-size: clamp(3rem, 5vw, 4.5rem); font-weight: 900; margin-bottom: 15px; line-height: 1.1; letter-spacing: -1.5px; }
    .inst-role { font-size: 1.4rem; color: rgba(255,255,255,0.7); font-weight: 500; margin-bottom: 50px; }

    .inst-stats-row {
        display: flex; gap: 50px; margin-bottom: 60px; flex-wrap: wrap;
        border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); padding: 30px 0;
    }
    .inst-stat { display: flex; flex-direction: column; gap: 8px; }
    .inst-stat-val { font-size: 2.2rem; font-weight: 900; color: #fff; line-height: 1; }
    .inst-stat-label { font-size: 0.85rem; color: rgba(255,255,255,0.5); font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; }

    .inst-section-title { font-size: 1.8rem; font-weight: 800; margin-bottom: 30px; color: #fff; display: flex; align-items: center; gap: 15px; }
    .inst-section-title i { color: var(--v2-primary); font-size: 1.4rem; }
    
    .inst-bio {
        font-size: 1.2rem; line-height: 1.9; color: rgba(255,255,255,0.85); margin-bottom: 60px; font-family: 'Inter', sans-serif; text-align: justify;
    }

    .inst-skills-wrap { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 60px; }
    .inst-skill-tag {
        padding: 12px 25px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.08);
        border-radius: 50px; font-size: 0.95rem; font-weight: 700; color: rgba(255,255,255,0.9); letter-spacing: 0.5px;
        transition: 0.3s; cursor: default;
    }
    .inst-skill-tag:hover { border-color: var(--v2-primary); color: #fff; background: rgba(240, 82, 35, 0.1); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(240, 82, 35, 0.15); }

    .inst-timeline { margin-bottom: 50px; border-left: 2px solid rgba(255,255,255,0.05); padding-left: 40px; position: relative; }
    .inst-timeline-item { position: relative; margin-bottom: 40px; }
    .inst-timeline-item:last-child { margin-bottom: 0; }
    .inst-timeline-item::before {
        content: ''; position: absolute; left: -49px; top: 0; width: 16px; height: 16px;
        background: #040415; border: 3px solid var(--v2-primary); border-radius: 50%;
        box-shadow: 0 0 10px rgba(240, 82, 35, 0.5);
    }
    .inst-timeline-date { font-size: 0.9rem; color: var(--v2-primary); font-weight: 800; letter-spacing: 1.5px; margin-bottom: 10px; display: inline-block; padding: 4px 12px; background: rgba(240, 82, 35, 0.1); border-radius: 6px; }
    .inst-timeline-title { font-size: 1.3rem; font-weight: 800; color: #fff; margin-bottom: 8px; }
    .inst-timeline-desc { font-size: 1.1rem; color: rgba(255,255,255,0.6); line-height: 1.7; }

</style>
@endpush

<section class="instructor-profile-wrap">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4 mb-5 mb-md-0" data-aos="fade-right">
                <div class="instructor-sidebar">
                    @php
                        $memberImg = $member->image ?? null;
                        if (!empty($memberImg) && !filter_var($memberImg, FILTER_VALIDATE_URL)) {
                             $top_img_path = public_path('assets/images/team/' . $memberImg);
                             if(file_exists($top_img_path)) {
                                 $memberImg = asset('assets/images/team/' . $memberImg);
                             } else {
                                  $memberImg = asset('uploads/team/' . $memberImg);
                             }
                        } elseif (empty($memberImg)) {
                             $memberImg = 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=10101f&color=fff&size=400';
                        }
                    @endphp
                    <img src="{{ $memberImg }}" alt="{{ $member->name }}" class="inst-avatar" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=10101f&color=fff&size=400'">
                    
                    <a href="{{ route('contact') }}" class="inst-action-btn"><i class="fas fa-envelope me-2"></i> Request Consultation</a>

                    <div class="inst-socials">
                        @if($member->linkedin_url)
                            <a href="{{ $member->linkedin_url }}" target="_blank" class="inst-social-btn"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                        @if($member->twitter_url)
                            <a href="{{ $member->twitter_url }}" target="_blank" class="inst-social-btn"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if($member->facebook_url)
                            <a href="{{ $member->facebook_url }}" target="_blank" class="inst-social-btn"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if($member->instagram_url)
                            <a href="{{ $member->instagram_url }}" target="_blank" class="inst-social-btn"><i class="fab fa-instagram"></i></a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-md-8" data-aos="fade-up" data-aos-delay="100">
                <div class="inst-main">
                    <span class="inst-badge">CORE TEAM EXPERT</span>
                    <h1 class="inst-name">{{ $member->name }}</h1>
                    <div class="inst-role">{{ $member->position }}</div>

                    <div class="inst-stats-row">
                        <div class="inst-stat">
                            <span class="inst-stat-val">50+</span>
                            <span class="inst-stat-label">Projects Deployed</span>
                        </div>
                        <div class="inst-stat">
                            <span class="inst-stat-val">5+ Years</span>
                            <span class="inst-stat-label">Industry Experience</span>
                        </div>
                        <div class="inst-stat">
                            <span class="inst-stat-val">4.9/5.0</span>
                            <span class="inst-stat-label">Client Rating</span>
                        </div>
                    </div>

                    <h2 class="inst-section-title"><i class="fas fa-user-astronaut"></i> About Me</h2>
                    <div class="inst-bio">
                        @if($member->bio)
                            {!! nl2br(e($member->bio)) !!}
                        @else
                            I'm a passionate and highly focused professional who loves crafting precise, elite-tier digital solutions. Currently operating out of Innovative IT Solutions, where I strive to redefine industry standards through robust architecture and forward-thinking engineering. During my career, I've consistently prioritized security, clean design, and rapid deployment. 
                            <br><br>
                            I believe in the power of code and structural integrity to transform organizations. When I'm not engaged in deep work, I immerse myself in the latest cyber security trends, cloud computing architectures, and the limitless possibilities of AI integration.
                        @endif
                    </div>

                    <h2 class="inst-section-title"><i class="fas fa-code-branch"></i> Core Mastery</h2>
                    <div class="inst-skills-wrap">
                        <span class="inst-skill-tag">Cyber Security</span>
                        <span class="inst-skill-tag">System Architecture</span>
                        <span class="inst-skill-tag">Cloud Infrastructure</span>
                        <span class="inst-skill-tag">Agile Leadership</span>
                        <span class="inst-skill-tag">Full-Stack Development</span>
                        <span class="inst-skill-tag">Ethical Hacking</span>
                        <span class="inst-skill-tag">Penetration Testing</span>
                        <span class="inst-skill-tag">DevOps</span>
                    </div>

                    <h2 class="inst-section-title"><i class="fas fa-route"></i> Career Trajectory</h2>
                    <div class="inst-timeline">
                        <div class="inst-timeline-item">
                            <div class="inst-timeline-date">2023 - Present</div>
                            <h4 class="inst-timeline-title">{{ $member->position }} @ Innovative IT Solutions</h4>
                            <p class="inst-timeline-desc">Leading digital transformation protocols and ensuring elite-level service delivery for global clients. Spearheaded major security overhauls and infrastructure scaling.</p>
                        </div>
                        <div class="inst-timeline-item">
                            <div class="inst-timeline-date">2020 - 2023</div>
                            <h4 class="inst-timeline-title">Senior Consultant @ TechNova Global</h4>
                            <p class="inst-timeline-desc">Managed high-tier enterprise systems, optimized cloud infrastructures, and led agile development teams across international high-stakes web projects.</p>
                        </div>
                        <div class="inst-timeline-item">
                            <div class="inst-timeline-date">2018 - 2020</div>
                            <h4 class="inst-timeline-title">M.Sc. in Advanced Computing</h4>
                            <p class="inst-timeline-desc">Graduated with top honors. Thesis focused explicitly on deep learning implementations within cyber-physical security matrices.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
