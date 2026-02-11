<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        use App\Models\SiteSetting;
        $page_title = $page_title ?? SiteSetting::getValue('site_title', 'Webboomers');
        $page_description = $page_description ?? SiteSetting::getValue('site_description', 'Professional Web Development Agency');
        $page_keywords = $page_keywords ?? SiteSetting::getValue('site_keywords', 'web design, web development');
        $favicon = SiteSetting::getValue('site_favicon');
    @endphp

    <title>{{ $page_title }}</title>
    <meta name="description" content="{{ $page_description }}">
    <meta name="keywords" content="{{ $page_keywords }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ !empty($favicon) ? asset('uploads/settings/' . $favicon) : asset('assets/images/logo/favicon.png') }}">

    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    @php
        $font_combo = SiteSetting::getValue('font_family_combo', 'Inter-Outfit');
        $body_font = "'Inter', sans-serif";
        $heading_font = "'Outfit', sans-serif";

        if ($font_combo === 'Poppins-Montserrat') {
            $body_font = "'Poppins', sans-serif";
            $heading_font = "'Montserrat', sans-serif";
        } elseif ($font_combo === 'Playfair-Lato') {
            $body_font = "'Lato', sans-serif";
            $heading_font = "'Playfair Display', serif";
        }
    @endphp

    @if ($font_combo === 'Poppins-Montserrat')
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    @elseif ($font_combo === 'Playfair-Lato')
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Playfair+Display:wght@400;600;700;800&display=swap" rel="stylesheet">
    @else
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    @endif

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    
    <!-- Local Assets -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v=1.5">
    <link rel="stylesheet" href="{{ asset('assets/css/clean-cards-fix.css') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}?v=2.0">

    @php
        // Colors from DB or Defaults
        $primary = SiteSetting::getValue('primary_color', '#4f46e5');
        $secondary = SiteSetting::getValue('secondary_color', '#ec4899');
        $accent = SiteSetting::getValue('accent_color', '#f59e0b');
        $text_main = SiteSetting::getValue('text_main_color', '#1e293b');
        $text_muted = SiteSetting::getValue('text_muted_color', '#64748b');
        $btn_bg = SiteSetting::getValue('button_color', $primary);
        $btn_text = SiteSetting::getValue('button_text_color', '#ffffff');

        // Logo dimensions
        $logo_width = SiteSetting::getValue('logo_width', '150');
        $logo_height = SiteSetting::getValue('logo_height', '50');

        // New Website Controls
        $btn_hover = SiteSetting::getValue('button_hover_color', '#4338ca');
        $banner_bg = SiteSetting::getValue('banner_bg_color', '#f8fafc');
        $team_bg = SiteSetting::getValue('team_section_color', '#ffffff');
        $grad_start = SiteSetting::getValue('heading_gradient_start', '#4f46e5');
        $grad_end = SiteSetting::getValue('heading_gradient_end', '#ec4899');

        $footer_bg = SiteSetting::getValue('footer_bg_color', '#0f172a');
        $service_bg = SiteSetting::getValue('service_bg_color', '#f8fafc');
        $team_style = SiteSetting::getValue('team_section_style', 'classic');
        $whatsapp_enabled = SiteSetting::getValue('whatsapp_float_enabled', '1');
        $whatsapp_number = SiteSetting::getValue('whatsapp_number', '+880 1736 111122');
        $custom_css = SiteSetting::getValue('custom_css', '');
    @endphp

    <style>
        :root {
            --primary: {{ $primary }};
            --primary-dark: {{ $primary }}cc;
            --primary-light: {{ $primary }}1a;
            --secondary: {{ $secondary }};
            --accent: {{ $accent }};
            --orange: {{ $accent }};
            --text-main: {{ $text_main }};
            --text-muted: {{ $text_muted }};

            /* Fonts */
            --body-font: {!! $body_font !!};
            --heading-font: {!! $heading_font !!};

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, {{ $primary }} 0%, {{ $secondary }} 100%);
            --gradient-hero: radial-gradient(circle at 0% 0%, {{ $primary }} 0%, {{ $secondary }} 100%);

            /* Button Overrides */
            --btn-bg: {{ $btn_bg }};
            --btn-text: {{ $btn_text }};
            --btn-hover: {{ $btn_hover }};

            /* Logo dimensions */
            --logo-width: {{ $logo_width }}px;
            --logo-height: {{ $logo_height }}px;

            /* Section Colors */
            --banner-bg: {{ $banner_bg }};
            --team-bg: {{ $team_bg }};
            --service-bg: {{ $service_bg }};
            --footer-bg: {{ $footer_bg }};
            --gradient-heading: linear-gradient(135deg, {{ $grad_start }} 0%, {{ $grad_end }} 100%);
        }

        body {
            font-family: var(--body-font) !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--heading-font) !important;
        }
        
        /* ... existing styles ... */
        .btn-purple-gradient, .btn-primary, .btn-pill-primary, .btn-quote {
            background: var(--btn-bg) !important;
            color: var(--btn-text) !important;
            border: none !important;
            transition: all 0.3s ease !important;
        }
        
        .btn-purple-gradient:hover, .btn-primary:hover, .btn-pill-primary:hover, .btn-quote:hover {
            background: var(--btn-hover) !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .text-gradient-purple, .text-gradient-primary, .text-gradient {
            background: var(--gradient-heading) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
        }

        .team-section-light {
            background-color: var(--team-bg) !important;
            @if ($team_style === 'glass')
                background: rgba(255, 255, 255, 0.05) !important;
                backdrop-filter: blur(10px);
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            @elseif ($team_style === 'modern')
                background-color: #10101f !important;
            @elseif ($team_style === 'gradient')
                background: linear-gradient(135deg, {{ $grad_start }}0a 0%, {{ $grad_end }}0a 100%) !important;
            @endif
        }

        .hero-section, .banner-section {
            background-color: var(--banner-bg) !important;
        }

        .navbar-brand img, .logo img, .footer-img-logo {
            max-width: var(--logo-width) !important;
            max-height: var(--logo-height) !important;
        }
        
        .footer-premium {
            background-color: var(--footer-bg) !important;
        }

        #services {
            background-color: var(--service-bg) !important;
        }

        {!! $custom_css !!}
    </style>
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="top-info">
                        @php
                            $email = SiteSetting::getValue('contact_email', 'hello@webboomers.tech');
                            $phone = SiteSetting::getValue('contact_phone', '+880 1736 111122');
                        @endphp
                        <a href="mailto:{{ $email }}"><i class="fas fa-envelope"></i> {{ $email }}</a>
                        <a href="tel:{{ $phone }}"><i class="fas fa-phone-alt"></i> {{ $phone }}</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="top-social-quote d-flex align-items-center justify-content-end">
                        <div class="top-social me-4">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <a href="{{ route('contact') }}" class="btn-quote">Get A Free Quote</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                @php
                    $logo = SiteSetting::getValue('site_logo');
                    $site_name = SiteSetting::getValue('site_name', 'Webboomers');
                @endphp

                @if (!empty($logo))
                    <div class="brand-logo me-2">
                        <img src="{{ asset('uploads/settings/' . $logo) }}"
                            alt="{{ $site_name }}"
                            class="img-fluid"
                            onerror="this.style.display='none'">
                    </div>
                @endif

                <div class="brand-text">
                    <span class="text-dark fw-bold fs-4 tracking-tight">{{ $site_name }}</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}" id="servicesDropdown" role="button" data-bs-toggle="dropdown">
                            Services +
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm">
                            <li><a class="dropdown-item" href="{{ route('services') }}">All Services</a></li>
                            @foreach(\App\Models\Service::where('status', 'active')->take(5)->get() as $navService)
                                <li><a class="dropdown-item" href="{{ route('services') }}#service-{{ $navService->id }}">{{ $navService->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('team') ? 'active' : '' }}" href="{{ route('team') }}">Our Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('portfolio.*') ? 'active' : '' }}" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                            Portfolio +
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm">
                            <li><a class="dropdown-item" href="{{ route('portfolio.index') }}">Elite Portfolio</a></li>
                            @auth
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a></li>
                            @endauth
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                    @auth
                        <li class="nav-item ms-lg-3">
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary rounded-pill px-3">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item ms-lg-3">
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer-premium">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-3">
                    <a href="{{ url('/') }}" class="d-block mb-4">
                        @php
                            $footer_logo = SiteSetting::getValue('footer_logo');
                            $display_logo = !empty($footer_logo) ? $footer_logo : $logo;
                        @endphp
                        @if (!empty($display_logo))
                            <div class="footer-logo mb-3">
                                <img src="{{ asset('uploads/settings/' . $display_logo) }}"
                                    alt="{{ $site_name }}"
                                    class="footer-img-logo"
                                    onerror="this.style.display='none'">
                            </div>
                        @endif
                        <h3 class="text-white fw-bold m-0">{{ $site_name }}</h3>
                    </a>
                    <p class="mb-4">Elevating brands through high-impact design and innovative technology.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ SiteSetting::getValue('facebook_url', '#') }}" class="footer-social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ SiteSetting::getValue('twitter_url', '#') }}" class="footer-social-link"><i class="fab fa-twitter"></i></a>
                        <a href="{{ SiteSetting::getValue('linkedin_url', '#') }}" class="footer-social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h5 class="footer-title">Agency</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ url('/#portfolio') }}">Projects</a></li>
                        <li><a href="{{ url('/#services') }}">Services</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="{{ route('team') }}">Team</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="footer-title">Support</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Help Center</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="footer-title">Contact Us</h5>
                    <div class="footer-contact-item mb-3">
                        <a href="mailto:{{ $email }}" class="text-white-50 small d-block mb-1">Email</a>
                        <a href="mailto:{{ $email }}" class="fw-bold">{{ $email }}</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        &copy; {{ date('Y') }} {{ $site_name }}. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
    @stack('scripts')
</body>
</html>
