<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WebBoost Lab') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            /* Design V3 - Modern Tech Aesthetic */
            --v3-bg: #0b0e14;
            --v3-sidebar: #131720;
            --v3-accent: #6366f1;
            --v3-accent-glow: rgba(99, 102, 241, 0.5);
            --v3-text-main: #f8fafc;
            --v3-text-muted: #94a3b8;
            --v3-border: rgba(255, 255, 255, 0.05);
            --v3-glass: rgba(30, 41, 59, 0.7);
            --v3-card: #1e293b;
            --v3-success: #10b981;
            --v3-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--v3-bg);
            color: var(--v3-text-main);
            overflow-x: hidden;
            letter-spacing: -0.01em;
        }

        /* Sleek Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--v3-bg); }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--v3-accent); }

        .admin-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Modern Sidebar V3 */
        .admin-sidebar {
            width: 280px;
            background: var(--v3-sidebar);
            border-right: 1px solid var(--v3-border);
            position: fixed;
            height: 100vh;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .brand-logo {
            padding: 2.5rem 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-dot {
            width: 8px;
            height: 8px;
            background: var(--v3-gradient);
            border-radius: 50%;
            box-shadow: 0 0 15px var(--v3-accent-glow);
        }

        .brand-text {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: 0.1rem;
            background: var(--v3-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-menu {
            padding: 0 1.25rem;
            flex: 1;
            overflow-y: auto;
        }

        .nav-section-title {
            font-size: 0.65rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            margin: 2rem 0 1rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.25rem;
            color: var(--v3-text-muted);
            text-decoration: none !important;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
        }

        .nav-link:hover {
            color: var(--v3-text-main);
            background: rgba(255,255,255,0.03);
            transform: translateX(4px);
        }

        .nav-link.active {
            background: rgba(99, 102, 241, 0.1);
            color: var(--v3-accent);
            font-weight: 600;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 25%;
            height: 50%;
            width: 3px;
            background: var(--v3-gradient);
            border-radius: 0 4px 4px 0;
            box-shadow: 4px 0 10px var(--v3-accent-glow);
        }

        .nav-icon {
            width: 20px;
            margin-right: 1rem;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .nav-link:hover .nav-icon {
            transform: scale(1.1);
            color: var(--v3-accent);
        }

        .admin-content {
            flex: 1;
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.4s ease;
        }

        /* Minimal Header V3 */
        .admin-header {
            height: 80px;
            background: rgba(11, 14, 20, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--v3-border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 3rem;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .header-search {
            flex: 1;
            max-width: 400px;
            margin-right: auto;
            position: relative;
        }

        .header-search input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--v3-border);
            border-radius: 10px;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            color: white;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.3s;
        }

        .header-search i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--v3-text-muted);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--v3-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-avatar:hover {
            transform: rotate(5deg) scale(1.05);
        }

        .admin-main {
            padding: 3rem;
            flex: 1;
        }

        /* Tech Glass Cards */
        .tech-card {
            background: var(--v3-card);
            border: 1px solid var(--v3-border);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tech-card:hover {
            border-color: rgba(99, 102, 241, 0.3);
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);
            transform: translateY(-2px);
        }

        @media (max-width: 1024px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.show { transform: translateX(0); }
            .admin-content { margin-left: 0; width: 100%; }
        }
    </style>

    </style>
</head>
<body class="antialiased">
    <div class="admin-wrapper" id="app">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="brand-logo">
                <div class="logo-dot"></div>
                <span class="brand-text">WEBOOMERS</span>
            </div>
            <nav class="nav-menu">
                <div class="nav-section-title">MAIN</div>
                <div class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <div class="nav-icon"><i class="fas fa-rocket"></i></div>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="nav-section-title">CONTENT</div>
                <div class="nav-item">
                    <a href="{{ route('admin.hero-slides.index') }}" class="nav-link {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                        <div class="nav-icon"><i class="fas fa-images"></i></div>
                        <span>Hero Slider</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <div class="nav-icon"><i class="fas fa-server"></i></div>
                        <span>Services</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.projects.index') }}" class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                        <div class="nav-icon"><i class="fas fa-layer-group"></i></div>
                        <span>Portfolio Hub</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.team.index') }}" class="nav-link {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                        <div class="nav-icon"><i class="fas fa-user-shield"></i></div>
                        <span>Team</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.blog.index') }}" class="nav-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                        <div class="nav-icon"><i class="fas fa-terminal"></i></div>
                        <span>Blog</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                        <div class="nav-icon"><i class="fas fa-comment-dots"></i></div>
                        <span>Testimonials</span>
                    </a>
                </div>

                <div class="nav-section-title">AUDIENCE</div>
                <div class="nav-item">
                    <a href="{{ route('admin.inquiries.index') }}" class="nav-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                        <div class="nav-icon"><i class="fas fa-satellite-dish"></i></div>
                        <span>Inquiries</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.subscribers.index') }}" class="nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
                        <div class="nav-icon"><i class="fas fa-envelope-open-text"></i></div>
                        <span>Subscribers</span>
                    </a>
                </div>

                <div class="nav-section-title">CONFIGURATION</div>
                <div class="nav-item">
                    <a href="{{ route('admin.statistics.index') }}" class="nav-link {{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">
                        <div class="nav-icon"><i class="fas fa-chart-line"></i></div>
                        <span>Statistics</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <div class="nav-icon"><i class="fas fa-atom"></i></div>
                        <span>Settings</span>
                    </a>
                </div>

                <div class="nav-item mt-auto mb-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link text-danger">
                            <div class="nav-icon"><i class="fas fa-power-off"></i></div>
                            <span>Logout</span>
                        </a>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="admin-content">
            <!-- Header -->
            <header class="admin-header">
                <button class="btn p-0 border-0 fs-4 text-white d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars-staggered"></i>
                </button>
                <div class="header-search d-none d-md-block">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search resources...">
                </div>
                <div class="user-menu dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3 p-2 bg-dark" aria-labelledby="dropdownUser1" style="border-radius: 12px; min-width: 200px; border: 1px solid var(--v3-border) !important;">
                        <li><a class="dropdown-item rounded-3 py-2 text-white" href="{{ route('profile.edit') }}"><i class="fas fa-user-circle me-2 opacity-50"></i> Profile</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 text-white" href="{{ route('admin.settings.index') }}"><i class="fas fa-cog me-2 opacity-50"></i> Settings</a></li>
                        <li><hr class="dropdown-divider opacity-10"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item rounded-3 py-2 text-danger"><i class="fas fa-sign-out-alt me-2 opacity-50"></i> Sign out</button>
                            </form>
                        </li>
                    </ul>
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
        });
    </script>
</body>
</html>
