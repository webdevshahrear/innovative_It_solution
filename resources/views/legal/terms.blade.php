@extends('layouts.frontend')

@section('title', $pageTitle)

@section('content')
<style>
    /* Reuse Privacy Styles or extend them */
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
        <h1 class="display-3 fw-bold text-white mb-4" data-aos="fade-up">Terms of <span class="text-glow-primary">Use</span></h1>
        
        <div class="legal-meta-v2" data-aos="fade-up" data-aos-delay="200">
            <span><i class="fas fa-file-contract"></i> Version 1.0</span>
            <span><i class="fas fa-globe"></i> Active Jurisdiction: GLOBAL</span>
        </div>
    </div>
</div>

<div class="legal-content-section">
    <div class="container">
        <div class="legal-card-v2" data-aos="fade-up" data-aos-delay="300">
            <p>Welcome to <span class="highlight-primary">Innovative IT Solutions</span>. These terms and conditions outline the rules and regulations for the use of Innovative IT Solutions' Website, located at <span class="highlight-primary">innovativeitsolutions.com</span>.</p>

            <p>By accessing this website we assume you accept these terms and conditions. Do not continue to use Innovative IT Solutions if you do not agree to take all of the terms and conditions stated on this page.</p>

            <h2>1. Intellectual Property Rights</h2>
            <p>Other than the content you own, under these Terms, Innovative IT Solutions and/or its licensors own all the intellectual property rights and materials contained in this Website. You are granted a limited license only for purposes of viewing the material contained on this Website.</p>

            <h2>2. Restrictions</h2>
            <p>You are specifically restricted from all of the following:</p>
            <ul>
                <li>Publishing any Website material in any other media.</li>
                <li>Selling, sublicensing and/or otherwise commercializing any Website material.</li>
                <li>Publicly performing and/or showing any Website material.</li>
                <li>Using this Website in any way that is or may be damaging to this Website.</li>
                <li>Using this Website in any way that impacts user access to this Website.</li>
            </ul>

            <h2>3. No Warranties</h2>
            <p>This Website is provided "as is," with all faults, and Innovative IT Solutions express no representations or warranties, of any kind related to this Website or the materials contained on this Website. Also, nothing contained on this Website shall be interpreted as advising you.</p>

            <h2>4. Limitation of Liability</h2>
            <p>In no event shall Innovative IT Solutions, nor any of its officers, directors and employees, be held liable for anything arising out of or in any way connected with your use of this Website whether such liability is under contract. Innovative IT Solutions, including its officers, directors and employees shall not be held liable for any indirect, consequential or special liability arising out of or in any way related to your use of this Website.</p>

            <h2>5. Governing Law & Jurisdiction</h2>
            <p>These Terms will be governed by and interpreted in accordance with the laws of the State of Global, and you submit to the non-exclusive jurisdiction of the state and federal courts located in Global for the resolution of any disputes.</p>
        </div>
    </div>
</div>
@endsection
