<footer class="footer-v2">
    <div class="footer-glow-top"></div>
    <div class="footer-mesh-bg"></div>
    
    <div class="container position-relative z-1">
        <div class="row g-5">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ url('/') }}" class="d-block mb-4">
                    @if($footerLogo || $siteLogo)
                        <div class="footer-logo-box">
                            <img src="{{ asset('uploads/settings/' . ($footerLogo ?: $siteLogo)) }}"
                                 alt="{{ $siteName }}"
                                 class="footer-img-logo-v2"
                                 style="width: {{ $footerLogoWidth }}px; height: {{ $footerLogoHeight }}px; object-fit: contain; object-position: left center;"
                                 onerror="this.style.display='none'">
                        </div>
                    @else
                        <span class="brand-text-v2">{{ $siteName }}</span>
                    @endif
                </a>
                <p class="footer-desc-v2 mb-4">{{ $footerDescription }}</p>
                <div class="footer-social-group-v2">
                    <a href="{{ $facebookUrl }}" class="social-link-v2"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ $twitterUrl }}" class="social-link-v2"><i class="fab fa-twitter"></i></a>
                    <a href="{{ $linkedinUrl }}" class="social-link-v2"><i class="fab fa-linkedin-in"></i></a>
                    <a href="{{ $instagramUrl }}" class="social-link-v2"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4" data-aos="fade-up" data-aos-delay="200">
                <h5 class="footer-title-v2">{{ $footerCol1Title }}</h5>
                <ul class="list-unstyled footer-links-v2">
                    <li><a href="{{ url('/#portfolio') }}">Projects Hub</a></li>
                    <li><a href="{{ url('/#services') }}">Elite Services</a></li>
                    <li><a href="{{ url('about') }}">Our Story</a></li>
                    <li><a href="{{ url('team') }}">Expert Team</a></li>
                    <li><a href="{{ url('contact') }}">Contact Us</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-4" data-aos="fade-up" data-aos-delay="300">
                <h5 class="footer-title-v2">{{ $footerCol2Title }}</h5>
                <ul class="list-unstyled footer-links-v2">
                    <li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ url('terms-of-use') }}">Terms of Use</a></li>
                    <li><a href="{{ url('help-center') }}">Help Center</a></li>
                    <li><a href="{{ url('sitemap') }}">Sitemap</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-4" data-aos="fade-up" data-aos-delay="400">
                <h5 class="footer-title-v2">{{ $footerCol3Title }}</h5>
                <div class="footer-contact-card-v2">
                    <div class="contact-item-v2 mb-4">
                        <div class="icon-v2"><i class="fas fa-envelope-open"></i></div>
                        <div class="info">
                            <span class="label">{{ $footerEmailLabel }}</span>
                            <a href="mailto:{{ $contactEmail }}" class="link">{{ $contactEmail }}</a>
                        </div>
                    </div>
                    <div class="contact-item-v2">
                        <div class="icon-v2"><i class="fas fa-phone-volume"></i></div>
                        <div class="info">
                            <span class="label">{{ $footerPhoneLabel }}</span>
                            <a href="tel:{{ $contactPhone }}" class="link">{{ $contactPhone }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-divider-v2"></div>

        <div class="footer-bottom-v2">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="copyright-v2">&copy; {{ date('Y') }} <span class="highlight-v2">{{ $siteName }}</span>. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <p class="crafted-v2">{!! $footerCopyright !!}</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
/* Footer V2 - Ultra Premium Styling */
.footer-v2 {
    background: #070719;
    padding: 120px 0 40px;
    position: relative;
    overflow: hidden;
    transition: var(--transition-theme);
}

.footer-glow-top {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--primary), transparent);
    box-shadow: 0 0 20px var(--primary-glow);
}

.footer-mesh-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at 10% 20%, rgba(240, 82, 35, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(59, 130, 246, 0.05) 0%, transparent 40%);
    pointer-events: none;
}

.footer-logo-box {
    filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.2));
    transition: all 0.3s ease;
}

.footer-img-logo-v2 {
    transition: all 0.3s;
}

.footer-desc-v2 {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.95rem;
    line-height: 1.8;
    max-width: 350px;
}

.footer-social-group-v2 {
    display: flex;
    gap: 15px;
}

.social-link-v2 {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    color: #fff;
    font-size: 1rem;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.social-link-v2:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 10px 20px var(--primary-glow);
}

.footer-title-v2 {
    color: #fff;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 30px;
    position: relative;
    display: inline-block;
}

.footer-title-v2::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 30px;
    height: 2px;
    background: var(--primary);
}

.footer-links-v2 li {
    margin-bottom: 15px;
}

.footer-links-v2 a {
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    transition: all 0.3s;
    font-weight: 500;
}

.footer-links-v2 a:hover {
    color: var(--primary);
    padding-left: 8px;
}

.footer-contact-card-v2 {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 30px;
    border-radius: 24px;
    backdrop-filter: blur(10px);
}

.contact-item-v2 {
    display: flex;
    gap: 20px;
    align-items: center;
}

.contact-item-v2 .icon-v2 {
    width: 50px;
    height: 50px;
    background: rgba(240, 82, 35, 0.1);
    border: 1px solid rgba(240, 82, 35, 0.2);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.2rem;
}

.contact-item-v2 .label {
    display: block;
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 4px;
}

.contact-item-v2 .link {
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s;
}

.contact-item-v2 .link:hover {
    color: var(--primary);
}

.footer-divider-v2 {
    height: 1px;
    background: linear-gradient(90deg, rgba(255,255,255,0), rgba(255,255,255,0.05), rgba(255,255,255,0));
    margin: 60px 0 30px;
}

.copyright-v2 {
    color: rgba(255, 255, 255, 0.4);
    font-size: 0.9rem;
    margin: 0;
}

.highlight-v2 {
    color: #fff;
    font-weight: 700;
}

.crafted-v2 {
    color: rgba(255, 255, 255, 0.4);
    font-size: 0.9rem;
    margin: 0;
}

.crafted-v2 i {
    color: var(--primary);
    margin: 0 4px;
    animation: heartBeat 2s infinite;
}

}

/* Light Mode Overrides */
body.light-mode .footer-v2 { background: #f8fafc !important; }
body.light-mode .footer-glow-top { background: linear-gradient(90deg, transparent, rgba(0,0,0,0.1), transparent) !important; box-shadow: none !important; }
body.light-mode .footer-desc-v2 { color: #475569 !important; }
body.light-mode .footer-title-v2 { color: #0f172a !important; }
body.light-mode .footer-links-v2 a { color: #475569 !important; }
body.light-mode .footer-links-v2 a:hover { color: var(--primary) !important; }
body.light-mode .footer-contact-card-v2 { background: #ffffff !important; border-color: rgba(0,0,0,0.05) !important; box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important; }
body.light-mode .contact-item-v2 .label { color: #64748b !important; }
body.light-mode .contact-item-v2 .link { color: #0f172a !important; }
body.light-mode .social-link-v2 { background: rgba(0,0,0,0.03) !important; border-color: rgba(0,0,0,0.1) !important; color: #0f172a !important; }
body.light-mode .social-link-v2:hover { color: #fff !important; background: var(--primary) !important; }
body.light-mode .copyright-v2, body.light-mode .crafted-v2 { color: #64748b !important; }
body.light-mode .highlight-v2 { color: #0f172a !important; }

@keyframes heartBeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

@media (max-width: 767px) {
    .footer-v2 { padding: 80px 0 40px; }
    .footer-title-v2 { margin-bottom: 20px; }
}
</style>