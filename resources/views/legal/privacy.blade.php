@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
<style>
    /* Legal Pages Premium Styles */
    .legal-hero-v2 {
        position: relative;
        padding: 160px 0 100px;
        background: var(--navy-dark);
        overflow: hidden;
        text-align: center;
    }

    .legal-hero-v2::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 10% 20%, rgba(240, 82, 35, 0.08) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 40%);
        pointer-events: none;
    }

    .legal-content-section {
        background: var(--navy-dark);
        padding: 0 0 120px;
        position: relative;
    }

    .legal-card-v2 {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 40px;
        padding: 80px;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.8;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.3);
    }

    .legal-card-v2 h2, .legal-card-v2 h3 {
        color: #fff;
        margin-top: 40px;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .legal-card-v2 h2 {
        font-size: 2rem;
        border-left: 4px solid var(--primary);
        padding-left: 20px;
    }

    .legal-card-v2 p {
        margin-bottom: 20px;
    }

    .legal-card-v2 ul {
        margin-bottom: 20px;
        padding-left: 20px;
    }

    .legal-card-v2 li {
        margin-bottom: 10px;
    }

    .highlight-primary {
        color: var(--primary);
        font-weight: 600;
    }

    .legal-meta-v2 {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 30px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .legal-meta-v2 span i {
        color: var(--primary);
        margin-right: 8px;
    }

    @media (max-width: 767px) {
        .legal-card-v2 { padding: 40px 20px; border-radius: 24px; }
        .legal-hero-v2 { padding: 120px 0 60px; }
    }
</style>

<div class="legal-hero-v2">
    <div class="container position-relative z-1">
        <div class="hero-badge-v4 mb-3" data-aos="fade-down">
            LEGAL DOCUMENTATION
        </div>
        <h1 class="display-3 fw-bold text-white mb-4" data-aos="fade-up">Privacy <span class="text-glow-primary">Policy</span></h1>
        
        <div class="legal-meta-v2" data-aos="fade-up" data-aos-delay="200">
            <span><i class="fas fa-calendar-alt"></i> Last Updated: {{ date('F d, Y') }}</span>
            <span><i class="fas fa-shield-alt"></i> Protected Status: GLOBAL</span>
        </div>
    </div>
</div>

<div class="legal-content-section">
    <div class="container">
        <div class="legal-card-v2" data-aos="fade-up" data-aos-delay="300">
            <p>At <span class="highlight-primary">Innovative IT Solutions</span>, accessible from our website, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by Innovative IT Solutions and how we use it.</p>

            <h2>1. Information We Collect</h2>
            <p>The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p>
            <ul>
                <li><strong>Log Files:</strong> We follow a standard procedure of using log files. These files log visitors when they visit websites.</li>
                <li><strong>Cookies and Web Beacons:</strong> Like any other website, Innovative IT Solutions uses 'cookies'.</li>
                <li><strong>Direct Contacts:</strong> If you contact us directly, we may receive additional information about you such as your name, email address, phone number, and the message contents.</li>
            </ul>

            <h2>2. How We Use Your Information</h2>
            <p>We use the information we collect in various ways, including to:</p>
            <ul>
                <li>Provide, operate, and maintain our website.</li>
                <li>Improve, personalize, and expand our website.</li>
                <li>Understand and analyze how you use our website.</li>
                <li>Develop new products, services, features, and functionality.</li>
                <li>Communicate with you, either directly or through one of our partners.</li>
            </ul>

            <h2>3. GDPR Data Protection Rights</h2>
            <p>We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:</p>
            <ul>
                <li><strong>The right to access:</strong> You have the right to request copies of your personal data.</li>
                <li><strong>The right to rectification:</strong> You have the right to request that we correct any information you believe is inaccurate.</li>
                <li><strong>The right to erasure:</strong> You have the right to request that we erase your personal data.</li>
            </ul>

            <h2>4. Contact Us</h2>
            <p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us through email at <span class="highlight-primary">hello@innovativeitsolutions.com</span>.</p>
        </div>
    </div>
</div>
@endsection
