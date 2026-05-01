<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Innovative IT Solutions</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-primary: #020617;
            --bg-secondary: #0f172a;
            --v2-card: rgba(15, 23, 42, 0.5);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --primary: #f05223;
            --sidebar-w: 280px;
        }
        
        body { 
            background: var(--bg-primary); color: var(--text-primary); font-family: 'Inter', sans-serif; display: flex; min-height: 100vh;
            background-image: 
                radial-gradient(ellipse at 80% 20%, rgba(240, 82, 35, 0.08) 0%, transparent 40%),
                radial-gradient(ellipse at 20% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 40%);
            background-attachment: fixed;
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-w); background: rgba(15,23,42,0.7); backdrop-filter: blur(20px); border-right: 1px solid var(--border-color);
            position: fixed; inset: 0; bottom: 0; z-index: 100; display: flex; flex-direction: column;
            box-shadow: 10px 0 30px rgba(0,0,0,0.2);
        }
        .sb-brand { padding: 30px 24px; border-bottom: 1px solid var(--border-color); background: rgba(255,255,255,0.01); }
        .sb-nav { padding: 24px 16px; flex-grow: 1; overflow-y: auto; }
        .nav-item { margin-bottom: 8px; }
        .nav-link {
            display: flex; align-items: center; gap: 14px; padding: 14px 18px; border-radius: 14px;
            color: var(--text-secondary); text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .nav-link:hover { background: rgba(255,255,255,0.05); color: var(--text-primary); transform: translateX(4px); }
        .nav-link.active { background: linear-gradient(135deg, rgba(240,82,35,0.15), rgba(240,82,35,0.05)); color: #f05223; border: 1px solid rgba(240,82,35,0.3); box-shadow: 0 5px 15px rgba(240,82,35,0.1); }
        .nav-link i { width: 24px; text-align: center; font-size: 1.1rem; }
        
        .sb-footer { padding: 24px; border-top: 1px solid var(--border-color); background: rgba(255,255,255,0.01); }
        .user-chip { display: flex; align-items: center; gap: 14px; }
        .user-chip img { width: 44px; height: 44px; border-radius: 12px; border:2px solid rgba(255,255,255,0.1); }
        
        /* Main Layout */
        .main-wrapper { margin-left: var(--sidebar-w); flex-grow: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .top-navbar {
            height: 76px; background: rgba(2,6,23,0.7); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: flex-end;
            padding: 0 40px; position: sticky; top: 0; z-index: 90; box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .main-content { padding: 40px; flex-grow: 1; }
        
        /* Common Utils */
        .stat-card { 
            background: var(--v2-card); border: 1px solid var(--border-color); border-radius: 20px; padding: 28px; 
            backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s;
        }
        .stat-card:hover { border-color: rgba(255,255,255,0.15); box-shadow: 0 15px 40px rgba(0,0,0,0.2); transform: translateY(-2px); }
        .table-dark { background: transparent; }
        .table-dark th { border-bottom: 1px solid var(--border-color); color: var(--text-secondary); font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.1em; padding: 20px; background: transparent; }
        .table-dark td { border-bottom: 1px solid rgba(255,255,255,0.04); padding: 20px; vertical-align: middle; color: var(--text-primary); background: transparent; transition: all 0.2s; }
        .table-dark tbody tr:hover td { background: rgba(255,255,255,0.02); }
        
        /* Premium Buttons */
        .btn-premium { 
            background: linear-gradient(135deg, #f05223, #e04010); color: #fff; border: none;
            padding: 10px 24px; border-radius: 12px; font-weight: 700; transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 6px 20px rgba(240,82,35,0.2); text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-premium:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(240,82,35,0.4); color: #fff; }
        
        .btn-premium-outline {
            background: rgba(255,255,255,0.03); color: var(--text-primary); border: 1px solid rgba(255,255,255,0.1);
            padding: 10px 24px; border-radius: 12px; font-weight: 600; transition: all 0.3s; text-decoration: none;
        }
        .btn-premium-outline:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: #fff; transform: translateY(-2px); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }

        .logo-light { display: none !important; }
        .logo-dark { display: inline-block !important; }

        [data-bs-theme="light"] .logo-dark { display: none !important; }
        [data-bs-theme="light"] .logo-light { display: inline-block !important; }

        [data-bs-theme="light"] .logo-single { filter: invert(1) hue-rotate(180deg) brightness(0.6) !important; }
    </style>
    @stack('styles')
</head>
<body>

    <aside class="sidebar">
        <div class="sb-brand" style="display:flex; align-items:center; justify-content:center; padding: 28px 22px; border-bottom: 1px solid var(--border-color);">
            <a href="/" style="text-decoration: none;">
                @php
                    $siteLogo = \App\Models\SiteSetting::getValue('site_logo', 'logo.png');
                    $siteLogoLight = \App\Models\SiteSetting::getValue('site_logo_light');
                @endphp
                @if($siteLogoLight && file_exists(public_path('uploads/settings/'.$siteLogoLight)))
                    <img src="{{ asset('uploads/settings/'.$siteLogoLight) }}" alt="Logo" class="logo-light" style="max-height: 55px; width: auto;">
                    <img src="{{ asset('uploads/settings/'.$siteLogo) }}" alt="Logo" class="logo-dark" style="max-height: 55px; width: auto;">
                @elseif(file_exists(public_path('uploads/settings/'.$siteLogo)))
                    <img src="{{ asset('uploads/settings/'.$siteLogo) }}" alt="Logo" class="logo-single" style="max-height: 55px; width: auto;">
                @else
                    <span style="font-family:'Outfit';font-weight:800;color:#fff;font-size:1.4rem;">Innovate<span style="color:#f05223">IT</span></span>
                @endif
            </a>
        </div>
        <nav class="sb-nav">
            @yield('sidebar')
        </nav>
        <div class="sb-footer border-top border-secondary">
            <div class="user-chip">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=f05223&color=fff" alt="">
                <div>
                    <div style="font-weight:600;font-size:0.9rem;color:#fff">{{ auth()->user()->name }}</div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" style="background:none;border:none;color:var(--text-secondary);font-size:0.75rem;padding:0;cursor:pointer">Log out</button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="top-navbar" style="justify-content: space-between;">
            <h2 style="font-family:'Outfit'; font-weight:800; color:#f05223; margin:0; font-size:1.6rem; letter-spacing:-0.5px;">@yield('panel_type', 'Intern Panel')</h2>
            <div class="d-flex align-items-center gap-3">
                @yield('topbar')
            </div>
        </header>

        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success rounded-3 border-0 bg-success bg-opacity-10 text-success mb-4"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger rounded-3 border-0 bg-danger bg-opacity-10 text-danger mb-4"><i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
