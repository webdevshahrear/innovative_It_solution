<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        use App\Models\SiteSetting;
        $page_title = $page_title ?? SiteSetting::getValue('site_title', 'Innovative It Solutions');
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    
    <!-- Local Assets -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v=1.5">
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
            /* Website V2: Modern Design System Tokens */
            --navy: #0d0b28;
            --navy-dark: #070719;
            --navy-light: #161642;
            --card-bg: rgba(20, 20, 58, 0.6);
            --border: rgba(255, 255, 255, 0.1);
            --border-glow: rgba(240, 82, 35, 0.2);

            --primary: #f05223; /* Logo Vibrant Orange */
            --primary-glow: rgba(240, 82, 35, 0.4);
            --primary-dark: #cc3f1a;
            --primary-light: rgba(240, 82, 35, 0.1);
            
            --secondary: #3b82f6; /* Logo Blue Accent */
            --accent: #ff8c42;
            
            --text-main: #f0eeff;
            --text-muted: #94a3b8;
            --white: #ffffff;

            /* Elevation & Blur */
            --glass-blur: 16px;
            --glass-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            --inner-glow: inset 0 0 20px rgba(255, 255, 255, 0.05);

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, var(--primary) 0%, #ff7b54 100%);
            --gradient-heading: linear-gradient(135deg, #ffffff 0%, #94a3b8 100%);
            --v2-mesh: radial-gradient(circle at 10% 10%, rgba(240, 82, 35, 0.1) 0%, transparent 40%),
                       radial-gradient(circle at 90% 90%, rgba(59, 130, 246, 0.08) 0%, transparent 40%);

            /* Spacing */
            --section-padding: 140px;
            --transition-theme: background 0.5s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* ── Premium Light Mode (Specific Fixes Only) ── */
        body.light-mode {
            --navy-dark: #f8fafc;
            --navy: #ffffff;
            --navy-light: #f1f5f9;
            --card-bg: rgba(255, 255, 255, 0.9);
            --border: rgba(0, 0, 0, 0.05);
            --text-main: #1e293b;
            --text-muted: #64748b;
            --white: #0f172a;
            --v2-mesh: radial-gradient(circle at 10% 10%, rgba(240, 82, 35, 0.05) 0%, transparent 40%),
                       radial-gradient(circle at 90% 90%, rgba(59, 130, 246, 0.05) 0%, transparent 40%);
        }

        /* ── Banner & Breadcrumb Light Mode Global ── */
        body.light-mode .about-hero-v2, 
        body.light-mode .team-hero-v2,
        body.light-mode .inner-banner,
        body.light-mode .page-header-premium { background-color: #f8fafc !important; border-bottom: 1px solid rgba(0,0,0,0.05) !important; }
        
        body.light-mode .hero-subtitle-cinematic, 
        body.light-mode .inner-banner p, 
        body.light-mode .page-header-premium p,
        body.light-mode .lead { color: #475569 !important; }
        
        body.light-mode .breadcrumb-item a { color: #64748b !important; }
        body.light-mode .breadcrumb-item a:hover { color: var(--primary) !important; }
        body.light-mode .breadcrumb-item.active { color: var(--primary) !important; }
        body.light-mode .text-white-50 { color: #64748b !important; }
        body.light-mode .text-white { color: #0f172a !important; }
        
        /* ── Cinematic & Glass Styles Global ── */
        body.light-mode .hero-badge-cinematic { background: rgba(240, 82, 35, 0.1) !important; border-color: rgba(240, 82, 35, 0.2) !important; color: var(--primary) !important; }
        body.light-mode .hero-title-cinematic { color: #0f172a !important; }
        body.light-mode .glass-effect { background: #ffffff !important; border-color: rgba(0,0,0,0.05) !important; box-shadow: 0 20px 40px rgba(0,0,0,0.03) !important; }
        body.light-mode .glass-effect p { color: #475569 !important; }
        body.light-mode .glass-effect h2 { color: #0f172a !important; }

        /* ── Global Utility Styles ── */
        .text-glow-primary { 
            background: linear-gradient(135deg, var(--primary), #ff8a65); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent; 
            text-shadow: 0 0 50px rgba(240, 82, 35, 0.35); 
        }
        body.light-mode .text-glow-primary {
            background: linear-gradient(135deg, var(--primary), #e11d48);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(240, 82, 35, 0.15);
        }

        body {
            font-family: 'Inter', sans-serif !important;
            background-color: var(--navy-dark) !important;
            color: var(--text-main) !important;
            background-image: var(--v2-mesh) !important;
            background-attachment: fixed;
            min-height: 100vh;
            overflow-x: hidden;
            transition: var(--transition-theme);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif !important;
            font-weight: 800 !important;
            color: var(--white) !important;
            transition: var(--transition-theme);
        }

        /* ── Light Mode Toggle Switch ── */
        .theme-switch-wrap {
            position: fixed; bottom: 30px; left: 30px; z-index: 9999;
            width: 50px; height: 50px; border-radius: 15px;
            background: var(--navy-light); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--primary); font-size: 1.2rem;
            box-shadow: var(--glass-shadow); transition: 0.3s;
        }
        .theme-switch-wrap:hover { transform: scale(1.1) rotate(15deg); background: var(--primary); color: #fff; }
        .theme-switch-wrap i { transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        body.light-mode .theme-switch-wrap .fa-moon { display: none; }
        body:not(.light-mode) .theme-switch-wrap .fa-sun { display: none; }



        {!! $custom_css !!}
        /* ── Global Mobile Safety Overrides ── */
        @media (max-width: 768px) {
            html, body { overflow-x: hidden !important; width: 100%; position: relative; }
            section { padding: 60px 0 !important; }
            .container { padding-left: 20px !important; padding-right: 20px !important; }
            .theme-switch-wrap { bottom: 20px; left: 20px; width: 45px; height: 45px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <x-header />

    <div class="theme-switch-wrap" id="themeToggle" title="Toggle Theme">
        <i class="fas fa-sun"></i>
        <i class="fas fa-moon"></i>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <x-footer />

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

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Theme Toggle Persistence
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;

        // Check for saved theme
        if (localStorage.getItem('theme') === 'light') {
            body.classList.add('light-mode');
        }

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('light-mode');
            const isLight = body.classList.contains('light-mode');
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            
            // Animation Feedback
            themeToggle.querySelector('i:visible')?.classList.add('fa-spin');
            setTimeout(() => {
                themeToggle.querySelector('i')?.classList.remove('fa-spin');
            }, 500);
        });
    </script>
    @stack('scripts')
</body>
</html>
