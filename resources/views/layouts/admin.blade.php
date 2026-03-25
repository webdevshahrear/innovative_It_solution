@use('Illuminate\Support\Facades\Auth')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Innovative It Solutions') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            /* Website V2: Admin Unified Design System */
            --v2-bg: #020617;
            --v2-sidebar: rgba(13, 11, 40, 0.95);
            --v2-card: rgba(255, 255, 255, 0.02);
            --v2-glass: rgba(13, 11, 40, 0.8);
            --v2-border: rgba(255, 255, 255, 0.08);
            
            --v2-primary: #f05223; /* Logo Orange */
            --v2-primary-glow: rgba(240, 82, 35, 0.4);
            --v2-secondary: #3b82f6; /* Logo Blue */
            --v2-secondary-glow: rgba(59, 130, 246, 0.3);
            
            --v2-text-main: #f0eeff;
            --v2-text-muted: #94a3b8;
            --v2-success: #10b981;
            --v2-warning: #f59e0b;
            --v2-danger: #ef4444;
            
            --v2-gradient: linear-gradient(135deg, var(--v2-primary) 0%, #ff7b54 100%);
            --v2-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            --v2-blur: 20px;
        }

        [data-theme="light"] {
            /* V2 Light Mesh Mode */
            --v2-bg: #f8fafc;
            --v2-sidebar: #ffffff;
            --v2-card: #ffffff;
            --v2-glass: rgba(255, 255, 255, 0.95);
            --v2-border: #e2e8f0;
            --v2-text-main: #0f172a;
            --v2-text-muted: #64748b;
            --v2-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Inter', 'Outfit', sans-serif;
            background: var(--v2-bg);
            color: var(--v2-text-main);
            overflow-x: hidden;
            transition: all 0.3s ease;
        }
        
        /* Modern Sidebar V2 */
        .admin-sidebar {
            width: 280px;
            background: var(--v2-sidebar);
            backdrop-filter: blur(var(--v2-blur));
            border-right: 1px solid var(--v2-border);
            position: fixed;
            height: 100vh;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            box-shadow: 10px 0 30px rgba(0,0,0,0.2);
        }

        .brand-logo {
            padding: 2.5rem 2rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-dot-v2 {
            width: 12px;
            height: 12px;
            background: var(--v2-gradient);
            border-radius: 50%;
            box-shadow: 0 0 15px var(--v2-primary-glow);
            animation: pulse-v2 2s infinite;
        }

        @keyframes pulse-v2 {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
        }

        .brand-text-v2 {
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: #fff;
            text-transform: uppercase;
        }

        .nav-menu {
            padding: 0 15px;
            flex: 1;
            overflow-y: auto;
        }

        .nav-section-title-v2 {
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--v2-text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 25px 0 10px 15px;
            opacity: 0.6;
        }

        .nav-link-v2-admin {
            display: flex;
            align-items: center;
            padding: 12px 18px;
            color: var(--v2-text-muted);
            text-decoration: none !important;
            border-radius: 12px;
            margin-bottom: 5px;
            transition: all 0.3s;
            font-weight: 600;
            font-size: 0.9rem;
            gap: 15px;
        }

        .nav-link-v2-admin:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(5px);
        }

        .nav-link-v2-admin.active {
            background: var(--v2-gradient);
            color: #fff;
            box-shadow: 0 10px 20px var(--v2-primary-glow);
        }

        .nav-icon-v2 {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* Admin Content Area */
        .admin-content {
            margin-left: 280px;
            padding: 40px;
            min-height: 100vh;
            background: radial-gradient(circle at 0% 0%, rgba(240, 82, 35, 0.03) 0%, transparent 50%),
                        radial-gradient(circle at 100% 100%, rgba(59, 130, 246, 0.03) 0%, transparent 50%);
        }

        /* Admin Header V2 */
        .admin-header-v2 {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 40px;
            background: var(--v2-glass);
            backdrop-filter: blur(15px);
            padding: 15px 30px;
            border-radius: 20px;
            border: 1px solid var(--v2-border);
            box-shadow: var(--v2-shadow);
            gap: 20px;
        }

        .user-avatar-v2 {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: var(--v2-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            box-shadow: 0 5px 15px var(--v2-primary-glow);
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-avatar-v2:hover {
            transform: scale(1.05) rotate(5deg);
        }

        /* Tech Glass Cards V2 */
        .tech-card-v2 {
            background: var(--v2-card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--v2-border);
            border-radius: 24px;
            padding: 30px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .tech-card-v2:hover {
            border-color: var(--v2-primary);
            transform: translateY(-8px);
            box-shadow: 0 20px 50px -10px var(--v2-primary-glow);
        }

        .btn-v2-primary {
            background: var(--v2-gradient);
            color: #fff !important;
            border: none;
            padding: 12px 25px;
            border-radius: 15px;
            font-weight: 700;
            transition: all 0.3s;
            box-shadow: 0 5px 15px var(--v2-primary-glow);
        }

        .btn-v2-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--v2-primary-glow);
            filter: brightness(1.1);
        }

        /* Form Controls V2 */
        .v2-admin-input {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid var(--v2-border) !important;
            border-radius: 12px !important;
            color: #fff !important;
            padding: 12px 18px !important;
            transition: all 0.3s !important;
        }

        .v2-admin-input:focus {
            background: rgba(255, 255, 255, 0.06) !important;
            border-color: var(--v2-primary) !important;
            box-shadow: 0 0 15px var(--v2-primary-glow) !important;
        }

        @media (max-width: 1024px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.show { transform: translateX(0); }
            .admin-content { margin-left: 0; padding: 20px; }
        }
        
        /* ========================================
           LIGHT MODE ULTRA-PREMIUM STYLING 2.0
        ======================================== */
        
        [data-theme="light"] {
            /* Lighter Gradients and Tech Variables */
            --v2-primary: #f05223;
            --v2-primary-glow: rgba(240, 82, 35, 0.15);
            --v2-secondary: #3b82f6; 
            --v2-secondary-glow: rgba(59, 130, 246, 0.15);
            --v2-gradient: linear-gradient(135deg, #f05223 0%, #ff7b54 100%);
            --v2-sidebar: rgba(255, 255, 255, 0.75);
            --v2-glass: rgba(255, 255, 255, 0.85);
            --v2-border: rgba(255, 255, 255, 0.6);
            --v2-shadow: 0 20px 40px rgba(100, 116, 139, 0.1);
        }

        /* Ambient Mesh Light Background */
        [data-theme="light"] .admin-content {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(240, 82, 35, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(59, 130, 246, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wMikiLz48L3N2Zz4=');
        }

        /* Sidebar - Frosted Glass */
        [data-theme="light"] .admin-sidebar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            box-shadow: 4px 0 30px rgba(0,0,0,0.03);
            border-right: 1px solid rgba(255, 255, 255, 0.6);
        }
        
        [data-theme="light"] .brand-text-v2 {
            color: #0f172a;
            background: var(--v2-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        [data-theme="light"] .nav-link-v2-admin {
            color: #64748b;
        }
        
        [data-theme="light"] .nav-link-v2-admin:hover {
            background: rgba(240, 82, 35, 0.08);
            color: #f05223;
            box-shadow: inset 2px 0 0 #f05223;
        }
        
        [data-theme="light"] .nav-link-v2-admin.active {
            background: var(--v2-gradient);
            color: white;
            box-shadow: 0 10px 20px rgba(240, 82, 35, 0.25);
        }
        
        /* Header - Frosted Premium Glass */
        [data-theme="light"] .admin-header-v2 {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            box-shadow: 0 10px 40px rgba(100, 116, 139, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
        
        [data-theme="light"] .user-name-v2 {
            color: #0f172a !important;
        }

        [data-theme="light"] .dropdown-menu-v2-glass {
            background: rgba(255, 255, 255, 0.98) !important;
            border: 1px solid rgba(0,0,0,0.05) !important;
            box-shadow: 0 15px 50px rgba(0,0,0,0.08) !important;
        }
        
        /* Cards - Beautiful Frosted Glass */
        [data-theme="light"] .tech-card-v2, 
        [data-theme="light"] .glass-panel,
        [data-theme="light"] .tech-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 1) !important;
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.05), inset 0 2px 0 rgba(255, 255, 255, 1);
        }
        
        [data-theme="light"] .tech-card-v2:hover,
        [data-theme="light"] .tech-card:hover {
            border-color: rgba(240, 82, 35, 0.3) !important;
            box-shadow: 0 25px 60px rgba(240, 82, 35, 0.1), inset 0 2px 0 rgba(255, 255, 255, 1);
            transform: translateY(-5px);
        }
        
        /* Typography */
        [data-theme="light"] .text-white,
        [data-theme="light"] .page-title,
        [data-theme="light"] .v2-page-title { color: #0f172a !important; }
        
        [data-theme="light"] .text-v2-muted,
        [data-theme="light"] .page-subtitle,
        [data-theme="light"] .v2-page-subtitle { color: #64748b !important; }
        
        /* Tables - Premium Frosted Rows */
        [data-theme="light"] .table-v2 th,
        [data-theme="light"] .v2-table thead th {
            background: rgba(248, 250, 252, 0.8) !important;
            color: #64748b !important;
            border-bottom: 2px solid rgba(226, 232, 240, 0.6) !important;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        
        [data-theme="light"] .table-v2 td,
        [data-theme="light"] .v2-table tbody tr {
            border-bottom: 1px solid rgba(226, 232, 240, 0.5) !important;
        }
        
        [data-theme="light"] .table-v2 tr:hover td,
        [data-theme="light"] .v2-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.6) !important;
            box-shadow: inset 4px 0 0 #f05223;
        }

        /* Forms - Glass Inputs */
        [data-theme="light"] .v2-admin-input,
        [data-theme="light"] .v2-form-control {
            background: rgba(255, 255, 255, 0.6) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(203, 213, 225, 0.6) !important;
            color: #0f172a !important;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        
        [data-theme="light"] .v2-admin-input:focus,
        [data-theme="light"] .v2-form-control:focus {
            background: #ffffff !important;
            border-color: #f05223 !important;
            box-shadow: 0 0 0 4px rgba(240, 82, 35, 0.1), 0 10px 20px rgba(0,0,0,0.05) !important;
            transform: translateY(-1px);
        }
        
        [data-theme="light"] .v2-admin-input::placeholder,
        [data-theme="light"] .v2-form-control::placeholder {
            color: #94a3b8 !important;
        }
        
        [data-theme="light"] .v2-form-label {
            color: #475569 !important;
        }

        [data-theme="light"] .action-btn-v2,
        [data-theme="light"] .btn-icon-glow {
            background: rgba(255, 255, 255, 0.8) !important;
            border: 1px solid rgba(203, 213, 225, 0.5) !important;
            color: #64748b !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02) !important;
        }
        
        [data-theme="light"] .action-btn-v2:hover,
        [data-theme="light"] .btn-icon-glow:hover {
            background: #ffffff !important;
            border-color: #f05223 !important;
            color: #f05223 !important;
            box-shadow: 0 8px 20px rgba(240, 82, 35, 0.15) !important;
            transform: translateY(-2px);
        }
        
        [data-theme="light"] .action-btn-v2.delete:hover,
        [data-theme="light"] .btn-icon-glow.text-v2-danger:hover {
            border-color: #ef4444 !important;
            color: #ef4444 !important;
            background: rgba(239, 68, 68, 0.05) !important;
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.1) !important;
        }

        [data-theme="light"] .theme-toggle {
            background: rgba(255, 255, 255, 0.8) !important;
            color: #f59e0b !important; /* Sun icon color */
            border: 1px solid rgba(245, 158, 11, 0.3) !important;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.1) !important;
        }

        [data-theme="light"] .theme-toggle:hover {
            background: #ffffff !important;
            border-color: #f59e0b !important;
            transform: rotate(15deg) scale(1.05);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.2) !important;
        }
        
        /* Dashboard Metric Cards Light Mode Override */
        [data-theme="light"] .stat-card-v2 {
            border-color: rgba(255, 255, 255, 1) !important;
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(20px);
        }
        
        [data-theme="light"] .stat-card-v2 .stat-value {
            color: #0f172a !important;
            text-shadow: none !important;
        }
        
        /* Specific CRUD Components */
        [data-theme="light"] .v2-checkbox-group {
            background: rgba(255, 255, 255, 0.4) !important;
            border: 1px solid rgba(203, 213, 225, 0.5) !important;
        }
        [data-theme="light"] .v2-checkbox-label {
            color: #334155 !important;
        }
        
        [data-theme="light"] .v2-file-upload {
            background: rgba(255, 255, 255, 0.6) !important;
            border: 2px dashed rgba(203, 213, 225, 0.8) !important;
        }
        [data-theme="light"] .v2-file-upload:hover {
            border-color: #f05223 !important;
            background: #ffffff !important;
            box-shadow: 0 8px 25px rgba(240, 82, 35, 0.1) !important;
        }
        
        [data-theme="light"] .v2-switch-item {
            background: rgba(255, 255, 255, 0.7) !important;
            border: 1px solid rgba(203, 213, 225, 0.5) !important;
            box-shadow: 0 5px 15px rgba(0,0,0,0.02) !important;
        }
        [data-theme="light"] .v2-switch label {
            background-color: #cbd5e1 !important;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1) !important;
        }
        [data-theme="light"] .v2-switch input:checked + label {
            background: var(--v2-gradient) !important;
            box-shadow: 0 4px 10px rgba(240, 82, 35, 0.3) !important;
        }
        
        [data-theme="light"] .btn-tech-outline {
            background: rgba(255, 255, 255, 0.8) !important;
            border-color: rgba(203, 213, 225, 0.8) !important;
            color: #475569 !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02) !important;
        }
        [data-theme="light"] .btn-tech-outline:hover {
            border-color: #f05223 !important;
            color: #f05223 !important;
            background: #ffffff !important;
            box-shadow: 0 8px 20px rgba(240, 82, 35, 0.1) !important;
        }
        
        [data-theme="light"] .project-preview-v2 {
            border-color: #ffffff !important;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
        }
        
        [data-theme="light"] .badge-v2.turquoise { 
            background: linear-gradient(135deg, #ecfeff, #cffafe) !important; 
            color: #0891b2 !important; 
            border: 1px solid #67e8f9 !important; 
            box-shadow: 0 4px 10px rgba(6, 182, 212, 0.1) !important;
        }
    </style>

    </style>
</head>
<body class="antialiased">
    <div class="admin-wrapper" id="app">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="brand-logo">
                <div class="logo-dot-v2"></div>
                <span class="brand-text-v2">Innovative IT</span>
            </div>
            <nav class="nav-menu">
                <div class="nav-section-title-v2">MAIN</div>
                <div class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link-v2-admin {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <div class="nav-icon-v2"><i class="fas fa-rocket"></i></div>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="nav-section-title-v2">CONTENT</div>
                <div class="nav-item">
                    <a href="{{ route('admin.hero-slides.index') }}" class="nav-link-v2-admin {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                        <div class="nav-icon-v2"><i class="fas fa-images"></i></div>
                        <span>Hero Slider</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.services.index') }}" class="nav-link-v2-admin {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <div class="nav-icon-v2"><i class="fas fa-server"></i></div>
                        <span>Services</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.projects.index') }}" class="nav-link-v2-admin {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                        <div class="nav-icon-v2"><i class="fas fa-layer-group"></i></div>
                        <span>Portfolio Hub</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.project-categories.index') }}" class="nav-link-v2-admin {{ request()->routeIs('admin.project-categories.*') ? 'active' : '' }}">
                        <div class="nav-icon-v2"><i class="fas fa-tags"></i></div>
                        <span>Portfolio Categories</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.team.index') }}" class="nav-link-v2-admin {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                        <div class="nav-icon-v2"><i class="fas fa-user-shield"></i></div>
                        <span>Team</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.blog.index') }}" class="nav-link-v2-admin {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                        <div class="nav-icon-v2"><i class="fas fa-terminal"></i></div>
                        <span>Blog</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.testimonials.index') }}" class="nav-link-v2-admin {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                        <div class="nav-icon-v2"><i class="fas fa-comment-dots"></i></div>
                        <span>Testimonials</span>
                    </a>
                </div>

                <div class="nav-section-title-v2">AUDIENCE</div>
                <div class="nav-item">
                    <a href="{{ route('admin.inquiries.index') }}" class="nav-link-v2-admin {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                        <div class="nav-icon-v2"><i class="fas fa-satellite-dish"></i></div>
                        <span>Inquiries</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.subscribers.index') }}" class="nav-link-v2-admin {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
                        <div class="nav-icon-v2"><i class="fas fa-envelope-open-text"></i></div>
                        <span>Subscribers</span>
                    </a>
                </div>

                <div class="nav-section-title-v2">CONFIGURATION</div>
                <div class="nav-item">
                    <a href="{{ route('admin.statistics.index') }}" class="nav-link-v2-admin {{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">
                        <div class="nav-icon-v2"><i class="fas fa-chart-line"></i></div>
                        <span>Statistics</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link-v2-admin {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <div class="nav-icon-v2"><i class="fas fa-atom"></i></div>
                        <span>Settings</span>
                    </a>
                </div>

                <div class="nav-item mt-auto mb-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link-v2-admin text-danger">
                            <div class="nav-icon-v2"><i class="fas fa-power-off"></i></div>
                            <span>Logout</span>
                        </a>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="admin-content">
            <!-- Header -->
            <header class="admin-header-v2">
                <button class="btn p-0 border-0 fs-4 text-white d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars-staggered"></i>
                </button>
                <div class="header-search d-none d-md-block" style="flex: 1; max-width: 400px; margin-right: auto; position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--v2-text-muted);"></i>
                    <input type="text" placeholder="Search resources..." class="v2-admin-input w-100" style="padding-left: 2.5rem !important;">
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button id="themeToggle" class="theme-toggle border-0" title="Toggle Theme" style="background: var(--v2-card); color: var(--v2-text-muted); width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">
                        <i class="fas fa-moon"></i>
                    </button>
                    
                    <div x-data="{ open: false }" class="user-menu" style="position: relative;">
                        <div @click="open = !open" @click.away="open = false" class="user-avatar-v2" id="userMenuBtn">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                             class="dropdown-menu-v2-glass" 
                             style="position: absolute; top: 100%; right: 0; background: var(--v2-glass); backdrop-filter: blur(20px); border: 1px solid var(--v2-border); border-radius: 12px; padding: 10px; width: 220px; z-index: 1000; box-shadow: var(--v2-shadow); display: none;">
                            
                            <div class="dropdown-header-v2" style="padding: 10px; border-bottom: 1px solid var(--v2-border); margin-bottom: 10px;">
                                <div class="user-name-v2" style="font-weight: 700; color: #fff;">{{ Auth::user()->name ?? 'Admin' }}</div>
                                <div class="user-role-v2" style="font-size: 0.75rem; color: var(--v2-primary);">Administrator</div>
                            </div>
                            
                            <a class="nav-link-v2-admin" href="{{ route('profile.edit') }}" style="padding: 8px 12px;">
                                <i class="fas fa-user-circle opacity-50"></i> Profile
                            </a>
                            <a class="nav-link-v2-admin" href="{{ route('admin.settings.index') }}" style="padding: 8px 12px;">
                                <i class="fas fa-cog opacity-50"></i> Settings
                            </a>
                            
                            <div style="height: 1px; background: var(--v2-border); margin: 0.5rem 0;"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link-v2-admin text-danger w-100 border-0 bg-transparent text-start" style="padding: 8px 12px;">
                                    <i class="fas fa-sign-out-alt opacity-50"></i> Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="admin-main">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                         <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        // Mobile Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.admin-sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Theme Toggle Logic
            const themeToggle = document.getElementById('themeToggle');
            const icon = themeToggle.querySelector('i');
            const html = document.documentElement;
            
            // Check saved theme
            const savedTheme = localStorage.getItem('theme') || 'dark';
            html.setAttribute('data-theme', savedTheme);
            updateIcon(savedTheme);

            themeToggle.addEventListener('click', () => {
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateIcon(newTheme);
            });

            function updateIcon(theme) {
                if (theme === 'dark') {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                } else {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                }
            }
        });
    </script>
</body>
</html>
