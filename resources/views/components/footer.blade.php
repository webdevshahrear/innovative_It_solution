<footer class="footer-premium">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-3">
                <a href="{{ url('/') }}" class="d-block mb-4">
                    @if($footerLogo || $siteLogo)
                        <div class="footer-logo mb-3">
                            <img src="{{ asset('uploads/settings/' . ($footerLogo ?: $siteLogo)) }}"
                                 alt="{{ $siteName }}"
                                 class="footer-img-logo"
                                 onerror="this.style.display='none'">
                        </div>
                    @endif
                    <h3 class="text-white fw-bold m-0">{{ $siteName }}</h3>
                </a>
                <p class="mb-4">Elevating brands through high-impact design and innovative technology. We create digital experiences that resonate.</p>
                <div class="d-flex gap-3">
                    <a href="{{ $facebookUrl }}" class="footer-social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ $twitterUrl }}" class="footer-social-link"><i class="fab fa-twitter"></i></a>
                    <a href="{{ $linkedinUrl }}" class="footer-social-link"><i class="fab fa-linkedin-in"></i></a>
                    <a href="{{ $instagramUrl }}" class="footer-social-link"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-3">
                <h5 class="footer-title">Agency</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ url('/#portfolio') }}">Projects</a></li>
                    <li><a href="{{ url('/#services') }}">Services</a></li>
                    <li><a href="{{ url('about') }}">About Us</a></li>
                    <li><a href="{{ url('team') }}">Team</a></li>
                    <li><a href="{{ url('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5 class="footer-title">Support</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ url('terms-of-use') }}">Terms of Use</a></li>
                    <li><a href="{{ url('help-center') }}">Help Center</a></li>
                    <li><a href="{{ url('sitemap') }}">Sitemap</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5 class="footer-title">Contact Us</h5>
                <div class="footer-contact-item mb-3">
                    <a href="mailto:{{ $contactEmail }}" class="text-white-50 small d-block mb-1">Email</a>
                    <a href="mailto:{{ $contactEmail }}" class="fw-bold">{{ $contactEmail }}</a>
                </div>
                <div class="footer-contact-item">
                    <a href="tel:{{ $contactPhone }}" class="text-white-50 small d-block mb-1">Phone</a>
                    <a href="tel:{{ $contactPhone }}" class="fw-bold">{{ $contactPhone }}</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    &copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <small>Made with <i class="fas fa-heart text-danger"></i> for excellence.</small>
                </div>
            </div>
        </div>
    </div>
</footer>