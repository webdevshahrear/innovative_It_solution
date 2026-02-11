<header>
    <!-- Top Bar -->
    <div class="top-bar d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="top-info">
                        <a href="mailto:{{ $contactEmail }}"><i class="fas fa-envelope"></i> {{ $contactEmail }}</a>
                        <a href="tel:{{ $contactPhone }}"><i class="fas fa-phone-alt"></i> {{ $contactPhone }}</a>
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
                        <a href="{{ url('contact') }}" class="btn-quote">Get A Free Quote</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                @if($logo)
                    <div class="brand-logo me-2">
                        <img src="{{ asset('uploads/settings/' . $logo) }}"
                             alt="{{ $siteName }}"
                             class="img-fluid"
                             style="max-width: {{ $logoWidth }}px; max-height: {{ $logoHeight }}px;"
                             onerror="this.style.display='none'">
                    </div>
                @endif

                @if($siteName)
                    <div class="brand-text">
                        <span class="text-dark fw-bold fs-4 tracking-tight">{{ $siteName }}</span>
                    </div>
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('about') }}">About Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('services*') ? 'active' : '' }}" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Services +
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item" href="{{ url('services?cat=design') }}">Web Design</a></li>
                            <li><a class="dropdown-item" href="{{ url('services?cat=development') }}">Web Development</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('team') ? 'active' : '' }}" href="{{ url('team') }}">Our Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('blog*') ? 'active' : '' }}" href="{{ url('blog') }}">Blog</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('portfolio*') ? 'active' : '' }}" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Profile +
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="{{ url('portfolio') }}">Portfolio</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('help-center') || request()->is('faq') ? 'active' : '' }}" href="{{ url('help-center') }}">FAQ's</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('contact') }}">Contact Us</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="#" class="search-icon"><i class="fas fa-search"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
