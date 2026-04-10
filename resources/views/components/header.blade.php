<header id="main-header" class="header-v2">
    <!-- Top Bar V2 -->
    <div class="top-bar-v2 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="top-info-v2">
                        <a href="mailto:{{ $contactEmail }}" class="info-item">
                            <i class="fas fa-envelope-open-text"></i>
                            <span>{{ $contactEmail }}</span>
                        </a>
                        <a href="tel:{{ $contactPhone }}" class="info-item">
                            <i class="fas fa-headset"></i>
                            <span>{{ $contactPhone }}</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-5 text-end">
                    <div class="top-social-v2 d-inline-flex gap-3 align-items-center">
                        <span class="social-label text-white-50 small fw-bold me-2">FOLLOW US</span>
                        <a href="{{ $facebookUrl }}" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ $instagramUrl }}" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="{{ $twitterUrl }}" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="{{ $linkedinUrl }}" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation V2 -->
    <nav class="navbar navbar-expand-lg navbar-v2-main">
        <div class="container">
            <a class="navbar-brand-v2" href="{{ url('/') }}">
                <div class="brand-logo-glow">
                    @if($logo)
                        <img src="{{ asset('uploads/settings/' . $logo) }}"
                             alt="{{ $siteName }}"
                             class="logo-dark"
                             style="width: {{ $logoWidth }}px; height: {{ $logoHeight }}px; object-fit: contain; object-position: left center;">
                    @endif
                    
                    @if($logoLight)
                        <img src="{{ asset('uploads/settings/' . $logoLight) }}"
                             alt="{{ $siteName }}"
                             class="logo-light"
                             style="width: {{ $logoWidth }}px; height: {{ $logoHeight }}px; object-fit: contain; object-position: left center; display: none;">
                    @elseif(!$logo)
                        <span class="brand-text-v2">{{ $siteName }}</span>
                    @endif
                </div>
            </a>
            
            <button class="navbar-toggler-v2 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <div class="nav-toggle-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link-v2 {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <span class="nav-dot"></span>
                            <span class="nav-label">Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-v2 {{ request()->is('about') ? 'active' : '' }}" href="{{ url('about') }}">
                            <span class="nav-dot"></span>
                            <span class="nav-label">About</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link-v2 dropdown-toggle {{ request()->is('services*') ? 'active' : '' }}" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="nav-dot"></span>
                            <span class="nav-label">Services</span>
                        </a>
                        <ul class="dropdown-menu-v2-glass dropdown-menu border-0 shadow-lg" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item-v2" href="{{ url('services') }}"><i class="fas fa-th-large"></i> All Solutions</a></li>
                            <div class="dropdown-divider-v2"></div>
                            <li><a class="dropdown-item-v2" href="{{ url('services?cat=design') }}"><i class="fas fa-paint-brush"></i> UI/UX Design</a></li>
                            <li><a class="dropdown-item-v2" href="{{ url('services?cat=development') }}"><i class="fas fa-code"></i> Web Development</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-v2 {{ request()->is('team') ? 'active' : '' }}" href="{{ url('team') }}">
                            <span class="nav-dot"></span>
                            <span class="nav-label">Team</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-v2 {{ request()->is('portfolio*') ? 'active' : '' }}" href="{{ url('portfolio') }}">
                            <span class="nav-dot"></span>
                            <span class="nav-label">Portfolio</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-v2 {{ request()->is('blog*') ? 'active' : '' }}" href="{{ url('blog') }}">
                            <span class="nav-dot"></span>
                            <span class="nav-label">Insights</span>
                        </a>
                    </li>
                    <li class="nav-item ms-lg-4 mt-3 mt-lg-0">
                        <a href="{{ url('contact') }}" class="btn-btn-elite-v2">
                            <span>Get Started</span>
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<style>
/* Header V2 - Ultra Premium Styling */
.header-v2 {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    transition: var(--transition-theme);
}

.top-bar-v2 {
    background: #070719;
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    padding: 10px 0;
    font-size: 0.85rem;
    transition: all 0.4s ease;
}

.header-v2.scrolled .top-bar-v2 {
    transform: translateY(-100%);
    opacity: 0;
    visibility: hidden;
    height: 0;
    padding: 0;
}

.top-info-v2 {
    display: flex;
    gap: 25px;
}

.top-info-v2 .info-item {
    color: var(--v2-text-p);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
}

.top-info-v2 .info-item i {
    color: var(--primary);
    font-size: 1rem;
}

.top-info-v2 .info-item:hover {
    color: #fff;
}

.social-icon {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    color: #fff;
    font-size: 0.8rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.social-icon:hover {
    background: var(--primary);
    border-color: var(--primary);
    transform: translateY(-3px) rotate(8deg);
    box-shadow: 0 5px 15px var(--primary-glow);
}

/* Navbar Main */
.navbar-v2-main {
    padding: 20px 0;
    background: rgba(4, 4, 18, 0.5); /* Subtle glass by default for dark theme */
    backdrop-filter: blur(15px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
}

.header-v2.scrolled .navbar-v2-main {
    background: rgba(7, 7, 25, 0.9);
    backdrop-filter: blur(25px);
    padding: 12px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}


/* Light Mode Overrides */
body.light-mode .top-bar-v2 { background: #ffffff !important; border-bottom-color: rgba(0,0,0,0.06) !important; }
body.light-mode .top-info-v2 .info-item { color: #475569 !important; font-weight: 500; }
body.light-mode .top-info-v2 .info-item:hover { color: var(--primary) !important; }
body.light-mode .social-label { color: #64748b !important; }
body.light-mode .social-icon { background: rgba(0,0,0,0.02) !important; border-color: rgba(0,0,0,0.08) !important; color: #475569 !important; }
body.light-mode .social-icon:hover { color: #fff !important; background: var(--primary) !important; box-shadow: 0 5px 15px var(--primary-glow); }
body.light-mode .navbar-v2-main { background: rgba(255, 255, 255, 0.7) !important; backdrop-filter: blur(20px) !important; border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important; }
body.light-mode .header-v2.scrolled .navbar-v2-main { background: rgba(255, 255, 255, 0.95) !important; border-bottom-color: rgba(0,0,0,0.05) !important; box-shadow: 0 10px 40px rgba(0,0,0,0.04) !important; }

body.light-mode .nav-link-v2 { color: #1e293b !important; }
body.light-mode .nav-link-v2:hover, body.light-mode .nav-link-v2.active { color: var(--primary) !important; }
body.light-mode .dropdown-menu-v2-glass { background: #ffffff !important; border-color: rgba(0,0,0,0.05) !important; }
body.light-mode .dropdown-item-v2 { color: #475569 !important; }
body.light-mode .dropdown-item-v2:hover { color: var(--primary) !important; background: rgba(240,82,35,0.05) !important; }
body.light-mode .nav-toggle-icon span { background: #0f172a !important; }
body.light-mode .navbar-collapse { border-color: rgba(0,0,0,0.05) !important; }

/* Logo Theme Toggling */
.logo-dark { display: block; }
.logo-light { display: none; }
body.light-mode .logo-dark { display: none !important; }
body.light-mode .logo-light { display: block !important; }
body:not(.light-mode) .logo-light { display: none !important; }

.navbar-brand-v2 {
    display: flex;
    align-items: center;
    padding: 0;
    margin: 0;
    transition: all 0.3s ease;
}

.header-v2.scrolled .navbar-brand-v2 {
    transform: scale(0.9);
}

.brand-logo-glow {
    position: relative;
    display: inline-block;
}

.brand-logo-glow::after {
    content: '';
    position: absolute;
    inset: -10px;
    background: var(--primary-glow);
    filter: blur(20px);
    opacity: 0;
    transition: all 0.4s ease;
    z-index: -1;
}

.navbar-brand-v2:hover .brand-logo-glow::after {
    opacity: 0.3;
}

/* Nav Links */
.nav-link-v2 {
    position: relative;
    padding: 8px 18px !important;
    color: rgba(255, 255, 255, 0.75) !important;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-link-v2 .nav-dot {
    width: 6px;
    height: 6px;
    background: var(--primary);
    border-radius: 50%;
    opacity: 0;
    transform: scale(0);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.nav-link-v2:hover, .nav-link-v2.active {
    color: #fff !important;
}

.nav-link-v2:hover .nav-dot, .nav-link-v2.active .nav-dot {
    opacity: 1;
    transform: scale(1);
    box-shadow: 0 0 10px var(--primary-glow);
}

/* Dropdown */
.dropdown-menu-v2-glass {
    background: rgba(13, 11, 40, 0.9);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    border-radius: 18px;
    padding: 12px;
    margin-top: 15px !important;
    animation: dropdownSlide 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

@keyframes dropdownSlide {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.dropdown-item-v2 {
    color: rgba(255, 255, 255, 0.8) !important;
    padding: 10px 18px !important;
    border-radius: 12px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
}

.dropdown-item-v2 i {
    font-size: 0.9rem;
    color: var(--primary);
    opacity: 0.7;
}

.dropdown-item-v2:hover {
    background: rgba(240, 82, 35, 0.1) !important;
    color: #fff !important;
    transform: translateX(5px);
}

.dropdown-divider-v2 {
    height: 1px;
    background: rgba(255, 255, 255, 0.05);
    margin: 8px 0;
}

/* Elite Button V2 */
.btn-btn-elite-v2 {
    background: var(--gradient-primary);
    color: #fff;
    padding: 12px 28px;
    border-radius: 30px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 5px 20px var(--primary-glow);
}

.btn-btn-elite-v2::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
    opacity: 0;
    transition: all 0.6s ease;
    transform: scale(0.5);
}

.btn-btn-elite-v2:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px var(--primary-glow);
    color: #fff;
}

.btn-btn-elite-v2:hover::before {
    opacity: 0.5;
    transform: scale(1);
}

body.light-mode .btn-btn-elite-v2 {
    border-color: rgba(240, 82, 35, 0.2);
    box-shadow: 0 5px 20px rgba(240, 82, 35, 0.15);
}
body.light-mode .btn-btn-elite-v2:hover {
    box-shadow: 0 10px 30px rgba(240, 82, 35, 0.25);
}

/* Mobile Toggler */
.navbar-toggler-v2 {
    padding: 8px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    transition: all 0.3s;
}

.nav-toggle-icon span {
    display: block;
    width: 22px;
    height: 2px;
    background: #fff;
    margin: 5px 0;
    transition: all 0.3s;
    border-radius: 2px;
}

.navbar-toggler-v2:focus {
    box-shadow: none;
}

.navbar-toggler-v2[aria-expanded="true"] span:nth-child(1) { transform: rotate(45deg) translateY(10px); }
.navbar-toggler-v2[aria-expanded="true"] span:nth-child(2) { opacity: 0; }
.navbar-toggler-v2[aria-expanded="true"] span:nth-child(3) { transform: rotate(-45deg) translateY(-10px); }

@media (max-width: 991px) {
    .navbar-v2-main { padding: 15px 0; }
    .header-v2.scrolled .navbar-v2-main { padding: 10px 0; }
    
    .navbar-collapse {
        background: rgba(7, 7, 25, 0.98);
        backdrop-filter: blur(25px);
        margin-top: 15px;
        padding: 25px;
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        max-height: 80vh;
        overflow-y: auto;
    }
    
    body.light-mode .navbar-collapse {
        background: rgba(255, 255, 255, 0.98) !important;
        border-color: rgba(0,0,0,0.05) !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1) !important;
    }
    
    .nav-link-v2 {
        padding: 12px 0 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        justify-content: space-between;
    }
    
    body.light-mode .nav-link-v2 {
        border-bottom-color: rgba(0,0,0,0.05) !important;
    }
    
    .nav-link-v2 .nav-dot { display: none; }
    
    .dropdown-menu-v2-glass {
        background: rgba(255, 255, 255, 0.03);
        border: none !important;
        padding: 0 0 0 15px;
        margin-top: 5px !important;
        box-shadow: none !important;
    }
    
    body.light-mode .dropdown-menu-v2-glass {
        background: rgba(0, 0, 0, 0.02) !important;
    }
    
    .dropdown-item-v2 {
        padding: 10px 0 !important;
        font-size: 0.9rem;
    }
    
    .btn-btn-elite-v2 {
        width: 100%;
        justify-content: center;
        margin-top: 10px;
    }
}

@media (max-width: 480px) {
    .navbar-brand-v2 img {
        height: 35px !important;
        width: auto !important;
    }
}
</style>
