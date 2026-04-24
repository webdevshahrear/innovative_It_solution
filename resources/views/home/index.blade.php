@extends('layouts.frontend')

@use('Illuminate\Support\Str')

@section('title', $pageTitle)

@section('content')

    <style>
        :root {
            --v2-bg: #06061e;
            --v2-card: rgba(255, 255, 255, 0.02);
            --v2-glass: rgba(13, 11, 40, 0.7);
            --v2-border: rgba(255, 255, 255, 0.08);
            --v2-primary: #f05223;
            --v2-primary-glow: rgba(240, 82, 35, 0.35);
            --v2-secondary: #3b82f6;
            --v2-text-main: #f0eeff;
            --v2-text-muted: #94a3b8;
        }

        /* ── Ultra-Premium Hero Slider Redesign ── */
        .hero-slider-wrap { 
            height: 100vh; 
            background: #020212; 
            position: relative; 
            overflow: hidden; 
        }
        .hero-slide-item { 
            height: 100vh; 
            position: relative; 
            display: flex; 
            align-items: center;
            overflow: hidden;
            padding-top: 100px;
        }

        /* Bottom Visual Layer: Mesh & Image */
        .hero-bg-visual {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            filter: brightness(0.7) contrast(1.1);
        }
        .swiper-slide-active .hero-bg-visual { transform: scale(1.05); }

        .hero-mesh-overlay {
            position: absolute; inset: 0;
            background: 
                radial-gradient(circle at 10% 20%, rgba(240, 82, 35, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 40%);
            mix-blend-mode: plus-lighter;
            animation: meshPulse 10s infinite alternate linear;
        }

        /* Middle Layer: Floating Tech Shapes */
        .hero-tech-layer {
            position: absolute; inset: 0;
            pointer-events: none; z-index: 2;
        }
        .tech-shape {
            position: absolute;
            width: 300px; height: 300px;
            background: linear-gradient(135deg, rgba(240, 82, 35, 0.05), transparent);
            border: 1px solid rgba(255,255,255,0.03);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: floatShape 20s infinite linear;
        }
        .tech-shape-1 { top: 15%; left: 10%; animation-duration: 25s; }
        .tech-shape-2 { bottom: 10%; right: 15%; animation-duration: 30s; border-radius: 50% 50% 20% 80% / 25% 80% 20% 75%; }

        /* Top Layer: Content Hub */
        .hero-content-anchor {
            position: relative; z-index: 10;
            width: 100%;
        }
        .hero-glass-panel {
            background: rgba(255, 255, 255, 0.015);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 35px;
            padding: 40px 60px;
            max-width: 750px;
            position: relative;
            margin: 0 auto;
            text-align: center;
            transform: translateY(40px);
            opacity: 0;
            transition: all 1s cubic-bezier(0.16, 1, 0.3, 1) 0.3s;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5);
        }
        .swiper-slide-active .hero-glass-panel { transform: translateY(0); opacity: 1; }


        .hero-badge-v4 { 
            display: inline-flex; align-items: center; gap: 12px; 
            font-size: 0.75rem; font-weight: 900; letter-spacing: 4px; 
            text-transform: uppercase; color: var(--v2-primary); 
            background: rgba(240,82,35,0.1); 
            border: 1px solid rgba(240,82,35,0.2); 
            border-radius: 100px; padding: 10px 25px; margin-bottom: 30px; 
        }


        /* ── Noise Overlay ── */
        .hero-noise-overlay {
            position: absolute; inset: 0; z-index: 15; pointer-events: none;
            background: url('https://grainy-gradients.vercel.app/noise.svg');
            opacity: 0.08; mix-blend-mode: overlay;
        }

        /* ── Ghost Typography ── */
        .hero-ghost-text {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-size: 25vw; font-weight: 1000;
            color: rgba(255,255,255,0.03);
            -webkit-text-stroke: 1px rgba(255,255,255,0.05);
            line-height: 1; pointer-events: none; z-index: 1;
            text-transform: uppercase; white-space: nowrap;
            letter-spacing: -10px;
            transition: transform 1.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* ── Cursor Glow ── */
        .hero-cursor-glow {
            position: absolute; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(240, 82, 35, 0.1) 0%, transparent 70%);
            pointer-events: none; z-index: 5;
            transform: translate(-50%, -50%);
            mix-blend-mode: screen;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.23, 1);
        }

        /* ── Glass Sheen ── */
        .hero-glass-panel::before {
            content: ''; position: absolute; inset: -100px;
            background: linear-gradient(135deg, transparent 40%, rgba(255,255,255,0.1) 45%, rgba(255,255,255,0.1) 50%, transparent 55%);
            transform: translateX(-100%) rotate(25deg);
            transition: transform 1.5s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
        }
        .swiper-slide-active .hero-glass-panel::before { transform: translateX(100%) rotate(25deg); }

        /* ── Beautiful Nav Arrows (Orbitals) ── */
        .hero-swiper-next, .hero-swiper-prev { 
            width: 60px; height: 60px; 
            background: rgba(255,255,255,0.03); 
            backdrop-filter: blur(20px); 
            border: 1px solid rgba(255,255,255,0.08); 
            border-radius: 50%; color: #fff; 
            display: flex; align-items: center; justify-content: center;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 150 !important;
        }
        .hero-swiper-next::before, .hero-swiper-prev::before {
            content: ''; position: absolute; inset: -4px;
            border: 1px solid var(--v2-primary);
            border-radius: 50%; border-top-color: transparent;
            opacity: 0; transition: 0.5s;
            animation: orbitalRotate 3s infinite linear;
        }
        .hero-swiper-next:hover::before, .hero-swiper-prev:hover::before { opacity: 1; }
        .hero-swiper-next:hover, .hero-swiper-prev:hover { 
            background: var(--v2-primary); 
            border-color: var(--v2-primary);
            color: #fff; box-shadow: 0 0 30px var(--v2-primary-glow);
        }
        .hero-swiper-next { right: 50px; }
        .hero-swiper-prev { left: 50px; }
        .hero-swiper-next::after, .hero-swiper-prev::after { font-size: 1.1rem; font-weight: 900; }

        
        @keyframes orbitalRotate { 0% { transform: rotate(0); } 100% { transform: rotate(360deg); } }

        /* ── Premium Liquid Dot Timeline (Unified) ── */
        .hero-timeline-container {
            position: absolute; bottom: 60px; left: 50%;
            transform: translateX(-50%);
            display: flex; gap: 15px; z-index: 100;
            width: auto; height: auto;
        }
        .timeline-item {
            position: relative; cursor: pointer;
            padding: 10px 0; display: flex; align-items: center;
        }
        .timeline-number { display: none !important; }
        
        .timeline-bar {
            width: 10px; height: 10px; background: rgba(255,255,255,0.2);
            border-radius: 50%; overflow: hidden; position: relative;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            border: none;
        }
        .timeline-fill { display: none !important; } /* Simplify for dots */

        .timeline-item.active .timeline-bar { 
            width: 40px; height: 10px; 
            background: var(--v2-primary); 
            border-radius: 20px;
            box-shadow: 0 0 20px var(--v2-primary-glow);
        }
        
        @keyframes timelineLiquid { 0% { width: 0; } 100% { width: 100%; } }


        .hero-title-v4 { 
            font-size: clamp(2.5rem, 6vw, 4.2rem); 
            font-weight: 1000; line-height: 1; 
            letter-spacing: -2px; color: #fff; 
            margin-bottom: 25px;
            transform: translateY(40px);
            opacity: 0;
            transition: all 1s cubic-bezier(0.16, 1, 0.3, 1) var(--d, 0.5s);
        }
        .swiper-slide-active .hero-title-v4 { transform: translateY(0); opacity: 1; }

        .hero-subtitle-v4 { 
            font-size: 1.1rem; color: rgba(255,255,255,0.7); 
            line-height: 1.7; margin: 0 auto 40px; 
            max-width: 580px; 
            transform: translateY(30px);
            opacity: 0;
            transition: all 1s cubic-bezier(0.16, 1, 0.3, 1) var(--d, 0.7s);
        }
        .swiper-slide-active .hero-subtitle-v4 { transform: translateY(0); opacity: 1; }

        .btn-reveal {
            display: flex; gap: 20px; justify-content: center;
            transform: translateY(20px); opacity: 0;
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1) var(--d, 0.9s);
        }

        .swiper-slide-active .btn-reveal { transform: translateY(0); opacity: 1; }

        /* ── Hero Buttons ── */
        .btn-elite-v4 { 
            background: var(--v2-primary); color: #fff; border: none; 
            border-radius: 20px; padding: 22px 50px; font-weight: 800; 
            text-transform: uppercase; letter-spacing: 1px; 
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1); 
            display: inline-flex; align-items: center; gap: 15px; 
            box-shadow: 0 20px 40px var(--v2-primary-glow); 
            text-decoration: none;
        }
        .btn-elite-v4:hover { 
            transform: translateY(-8px) scale(1.02); 
            box-shadow: 0 30px 60px var(--v2-primary-glow); color: #fff; 
        }
        .btn-glass-v4 { 
            background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); 
            border: 1px solid rgba(255,255,255,0.12); color: #fff; 
            border-radius: 20px; padding: 22px 50px; font-weight: 800; 
            transition: all 0.5s; text-decoration: none;
        }
        .btn-glass-v4:hover { 
            background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.25); 
            transform: translateY(-8px); color: #fff; 
        }

        /* ── Common ── */
        .v2-badge-primary { display: inline-block; background: rgba(240,82,35,0.1); border: 1px solid rgba(240,82,35,0.2); color: var(--v2-primary); padding: 8px 18px; border-radius: 40px; font-size: 0.75rem; font-weight: 800; letter-spacing: 2px; }
        .v2-section-title { font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; color: #fff; line-height: 1.1; }
        .v2-mesh-glow { position: absolute; inset: 0; background: radial-gradient(circle at 10% 20%, rgba(240,82,35,0.05) 0%, transparent 40%); }
        .v2-mesh-glow-alt { position: absolute; inset: 0; background: radial-gradient(circle at 90% 80%, rgba(59,130,246,0.05) 0%, transparent 40%); }

        /* ── Services ── */
        .v2-services-wrap { background: #040415; padding: 80px 0; position: relative; overflow: hidden; }
        .s-card-v4 { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 35px; padding: 50px; height: 100%; transition: 0.5s; position: relative; }
        .s-card-v4:hover { border-color: var(--v2-primary); background: rgba(255,255,255,0.04); transform: translateY(-15px); }
        .s-step-v4 { position: absolute; top: 40px; right: 40px; font-size: 0.9rem; font-weight: 900; color: var(--v2-primary); opacity: 0.4; }
        .s-icon-v4 { width: 70px; height: 70px; background: rgba(240,82,35,0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: var(--v2-primary); font-size: 1.8rem; margin-bottom: 30px; transition: 0.5s; }
        .s-card-v4:hover .s-icon-v4 { background: var(--v2-primary); color: #fff; transform: rotate(10deg); }
        .s-title-v4 { font-size: 1.6rem; font-weight: 800; color: #fff; margin-bottom: 20px; }
        .s-desc-v4 { color: var(--v2-text-muted); line-height: 1.7; margin-bottom: 30px; }
        .s-link-v4 { color: #fff; text-decoration: none; font-weight: 700; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 10px; transition: 0.3s; }
        .s-card-v4:hover .s-link-v4 { color: var(--v2-primary); gap: 15px; }

        /* ── Portfolio ── */
        .v2-portfolio-wrap { background: #06061e; padding: 80px 0; position: relative; overflow: hidden; }
        .p-card-v4 { border-radius: 40px; overflow: hidden; position: relative; background: #000; }
        .p-img-v4 { position: relative; aspect-ratio: 16/10; }
        .p-img-v4 img { width: 100%; height: 100%; object-fit: cover; transition: 1s ease; }
        .p-card-v4:hover img { transform: scale(1.1) rotate(2deg); opacity: 0.5; }
        .p-overlay-v4 { position: absolute; inset: 0; padding: 50px; display: flex; flex-direction: column; justify-content: flex-end; opacity: 0; transform: translateY(30px); transition: 0.5s cubic-bezier(0.16,1,0.3,1); }
        .p-card-v4:hover .p-overlay-v4 { opacity: 1; transform: translateY(0); }
        .p-cat-v4 { font-size: 0.8rem; font-weight: 800; color: var(--v2-primary); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 15px; display: block; }
        .p-title-v4 { font-size: 2.2rem; font-weight: 900; color: #fff; margin: 0; } /* Keep white on image overlay */
        .p-btn-v4 { position: absolute; top: 50px; right: 50px; width: 60px; height: 60px; background: var(--v2-primary); border-radius: 20px; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; text-decoration: none; transition: 0.3s; }
        .p-btn-v4:hover { background: #fff; color: var(--v2-primary); transform: rotate(15deg) scale(1.1); }

        /* ── Abstract Feature Section ── */
        .v2-feature-abstract { position: relative; padding: 80px 0; background: #020212; overflow: hidden; text-align: center; border-top: 1px solid rgba(255,255,255,0.03); }
        .abstract-content-v4 { position: relative; z-index: 10; }
        .abstract-title { font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 1000; color: #fff; line-height: 1.1; margin-bottom: 35px; letter-spacing: -3px; }
        .abstract-desc { color: rgba(255,255,255,0.6); line-height: 1.8; max-width: 700px; margin: 0 auto 50px; }
        
        body.light-mode .v2-feature-abstract { background: #ffffff; border-color: rgba(0,0,0,0.05); }
        body.light-mode .abstract-title { color: #0f172a; }
        body.light-mode .abstract-desc { color: #475569; }

        /* Light Mode Buttons Overrides */
        body.light-mode .btn-elite-v4 { box-shadow: 0 15px 35px rgba(240, 82, 35, 0.25); }
        body.light-mode .btn-glass-v4 { background: rgba(0, 0, 0, 0.04); border-color: rgba(0, 0, 0, 0.1); color: #0f172a; }
        body.light-mode .btn-glass-v4:hover { background: rgba(0, 0, 0, 0.08); border-color: rgba(0, 0, 0, 0.15); color: #000; }
        
        .mesh-gradient-v4 { position: absolute; inset: 0; background: radial-gradient(circle at 50% 50%, rgba(240, 82, 35, 0.05) 0%, transparent 70%); pointer-events: none; }



        /* ── Hero Mobile Responsiveness ── */
        @media (max-width: 767px) {
            .hero-slider-wrap { padding: 60px 0 100px; min-height: 100vh; display: flex; align-items: center; }
            .hero-slide-item { padding: 0; min-height: auto; width: 100%; }
            .hero-ghost-text { display: none !important; }
            .hero-swiper-next, .hero-swiper-prev { display: none !important; }

            .hero-glass-panel { 
                padding: 40px 24px !important; 
                border-radius: 24px !important; 
                text-align: center; 
                transform: none !important; 
                opacity: 1 !important;
                width: calc(100% - 30px) !important;
                margin: 0 auto !important;
                backdrop-filter: blur(20px) !important;
                background: rgba(255, 255, 255, 0.03) !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
            }

            body.light-mode .hero-glass-panel {
                background: rgba(255, 255, 255, 0.7) !important;
                border: 1px solid rgba(0, 0, 0, 0.05) !important;
                box-shadow: 0 20px 50px rgba(0,0,0,0.1) !important;
            }

            .hero-badge-v4 { 
                justify-content: center;
                margin: 0 auto 25px !important; 
                padding: 10px 20px !important;
                font-size: 0.65rem !important;
            }

            .hero-title-v4 { 
                font-size: 2.3rem !important; 
                letter-spacing: -1px !important; 
                line-height: 1.1 !important; 
                margin-bottom: 20px !important; 
            }
            .hero-subtitle-v4 { 
                font-size: 0.9rem !important; 
                line-height: 1.6 !important; 
                margin: 0 auto 35px !important; 
                opacity: 0.8;
                max-width: 100%;
            }
            
            .hero-btns-wrap { display: flex !important; flex-direction: column; gap: 12px; align-items: center; }
            .btn-elite-v4, .btn-glass-v4 { 
                width: 100%; 
                padding: 16px 25px !important; 
                justify-content: center; 
                font-size: 0.8rem !important; 
                border-radius: 15px !important;
            }

            .hero-timeline-container { 
                bottom: 80px !important; 
                left: 50% !important; 
                transform: translateX(-50%) !important; 
                gap: 10px !important; 
                width: auto !important;
                right: auto !important;
            }
            .timeline-bar { 
                width: 7px !important; 
                height: 7px !important; 
            }
            .timeline-item.active .timeline-bar { 
                width: 28px !important; 
                height: 8px !important;
            }
        }




        /* ── Stats ── */
        .v2-stats-wrap { background: #040415; padding: 80px 0; border-top: 1px solid rgba(255,255,255,0.02); position: relative; overflow: hidden; }
        .v2-stats-wrap::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle at center, rgba(240, 82, 35, 0.03) 0%, transparent 60%); pointer-events: none; }
        
        /* Stats Grid Background Dots */
        .v2-stats-wrap {
            background-image: radial-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .v2-stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; position: relative; z-index: 10; }
        @media (max-width: 991px) { .v2-stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 575px) { .v2-stats-grid { grid-template-columns: 1fr; } }
        .v2-stat-item { 
            background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%); 
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.05); 
            border-top: 1px solid rgba(240, 82, 35, 0.2);
            border-radius: 30px; padding: 60px 30px 50px; text-align: center; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            position: relative; overflow: hidden;
        }
        
        /* Live Status Indicator */
        .stat-status-dot {
            position: absolute; top: 25px; right: 25px; width: 10px; height: 10px;
            background: #00ff88; border-radius: 50%;
            box-shadow: 0 0 10px #00ff88;
            animation: stat-blink 2s infinite;
        }
        @keyframes stat-blink {
            0% { opacity: 0.3; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); box-shadow: 0 0 15px #00ff88; }
            100% { opacity: 0.3; transform: scale(0.8); }
        }

        .v2-stat-item::after {
            content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 4px; background: var(--v2-primary); transform: scaleX(0); transition: 0.4s; transform-origin: left;
        }
        .v2-stat-item:hover { 
            transform: translateY(-15px); 
            border-color: rgba(240, 82, 35, 0.4); 
            box-shadow: 0 20px 40px rgba(240, 82, 35, 0.15);
        }
        .v2-stat-item:hover::after { transform: scaleX(1); }
        
        .v2-stat-icon { 
            font-size: 2.2rem; color: var(--v2-primary); margin-bottom: 25px; 
            text-shadow: 0 0 20px rgba(240, 82, 35, 0.5); 
            display: inline-flex; align-items: center; justify-content: center;
            width: 70px; height: 70px;
            background: rgba(240, 82, 35, 0.1); border-radius: 50%; border: 1px solid rgba(240, 82, 35, 0.2);
            transition: 0.4s;
            position: relative;
        }
        .text-glow-primary { color: var(--v2-primary); text-shadow: 0 0 30px rgba(240, 82, 35, 0.6), 0 0 60px rgba(240, 82, 35, 0.4); }
        .v2-section-title { font-size: 4.5rem; font-weight: 900; color: #fff; line-height: 1.1; letter-spacing: -2px; }

        .v2-stat-icon::before {
            content: ''; position: absolute; inset: -5px; border: 1px solid var(--v2-primary); 
            border-radius: 50%; opacity: 0; animation: icon-pulse 3s infinite;
        }
        @keyframes icon-pulse {
            0% { transform: scale(1); opacity: 0.5; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        .v2-stat-item:hover .v2-stat-icon { transform: scale(1.1) rotate(10deg); background: var(--v2-primary); color: #fff; }
        .v2-stat-value { font-size: 3.8rem; font-weight: 900; color: #fff; margin-bottom: 5px; letter-spacing: -2px; text-shadow: 0 5px 15px rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: baseline; }
        .v2-stat-value span { font-size: 2rem; color: var(--v2-primary); margin-left: 2px; }
        .v2-stat-label { font-size: 0.95rem; font-weight: 800; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 2px; transition: 0.3s; }
        .v2-stat-item:hover .v2-stat-label { color: var(--v2-primary); }

        /* ── Mission & Vision ── */
        .v2-mv-wrap { background: var(--v2-bg); padding: 150px 0; position: relative; overflow: hidden; border-top: 1px solid var(--v2-border); }
        .mv-card-v4 { 
            background: linear-gradient(135deg, rgba(255,255,255,0.04) 0%, rgba(255,255,255,0.01) 100%); 
            backdrop-filter: blur(20px); 
            border: 1px solid rgba(255,255,255,0.08); 
            border-radius: 40px; padding: 70px 60px; position: relative; height: 100%; transition: all 0.5s ease;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
        .mv-card-v4::before {
            content: ''; position: absolute; inset: 0; border-radius: 40px; padding: 2px;
            background: linear-gradient(135deg, rgba(240, 82, 35, 0.5), transparent, transparent);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0; transition: 0.5s;
        }
        .mv-card-v4:hover { transform: translateY(-10px); box-shadow: 0 30px 60px rgba(240, 82, 35, 0.15); }
        .mv-card-v4:hover::before { opacity: 1; }
        .mv-icon-v4 { 
            width: 90px; height: 90px; 
            background: linear-gradient(135deg, var(--v2-primary), #ff7b00);
            border-radius: 25px; display: flex; align-items: center; justify-content: center; 
            color: #fff; font-size: 2.5rem; margin-bottom: 40px;
            box-shadow: 0 15px 30px rgba(240, 82, 35, 0.4);
            transform: rotate(-10deg); transition: 0.4s;
        }
        .mv-card-v4:hover .mv-icon-v4 { transform: rotate(0deg) scale(1.1); }
        .mv-card-v4 h3 { font-size: 2.5rem; font-weight: 900; color: #fff; margin-bottom: 25px; letter-spacing: -1px; }
        .mv-card-v4 p { font-size: 1.25rem; color: rgba(255,255,255,0.7); line-height: 1.8; margin: 0; font-family: 'Inter', sans-serif; }

        /* ── Team ── */
        .v2-team-wrap { background: var(--v2-bg); padding: 120px 0; position: relative; overflow: hidden; }
        .team-card-v4 { background: var(--v2-card); border: 1px solid var(--v2-border); border-radius: 30px; overflow: visible; position: relative; transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1); height: 100%; }
        .team-card-v4:hover { transform: translateY(-10px); border-color: rgba(240,82,35,0.35); box-shadow: 0 25px 50px rgba(0,0,0,0.3); }
        .team-img-v4 { 
            position: relative; 
            aspect-ratio: 1/1.1; 
            background: #ffffff; 
            border-radius: 26px 26px 0 0; 
            overflow: hidden;
        }
        .team-img-v4 img { width: 100%; height: 100%; object-fit: cover; object-position: top center; transition: 0.6s ease; display: block; }
        .team-card-v4:hover .team-img-v4 img { transform: scale(1.06); }

        /* Image overlay on hover */
        .team-img-v4::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(240, 82, 35, 0.25) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }
        .team-card-v4:hover .team-img-v4::after { opacity: 1; }

        /* Social icons - staggered bounce in */
        .team-social-v4 { position: absolute; bottom: 22px; left: 0; right: 0; justify-content: center; display: flex; gap: 10px; z-index: 10; }
        .team-social-v4 a {
            width: 42px; height: 42px;
            background: #fff;
            color: var(--v2-primary);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; font-size: 1rem;
            transition: all 0.45s ease;
            transform: translateY(30px);
            opacity: 0;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .team-card-v4:hover .team-social-v4 a { transform: translateY(0); opacity: 1; }
        .team-card-v4:hover .team-social-v4 a:nth-child(1) { transition-delay: 0s; }
        .team-card-v4:hover .team-social-v4 a:nth-child(2) { transition-delay: 0.06s; }
        .team-card-v4:hover .team-social-v4 a:nth-child(3) { transition-delay: 0.12s; }
        .team-card-v4:hover .team-social-v4 a:nth-child(4) { transition-delay: 0.18s; }
        .team-social-v4 a:hover { background: var(--v2-primary); color: #fff; transform: translateY(-4px) !important; box-shadow: 0 12px 25px rgba(240, 82, 35, 0.4); }
        .team-info-v4 { padding: 28px 22px 32px; background: var(--v2-card); border-radius: 0 0 26px 26px; text-align: center; }
        .team-info-v4 h4 { color: #fff; font-weight: 800; margin-bottom: 6px; font-size: 1.35rem; letter-spacing: -0.3px; }
        .team-info-v4 .team-position { color: var(--v2-primary); font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 22px; display: block; }
        .btn-pill-dark { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); color: #fff; border-radius: 100px; padding: 10px 30px; font-size: 0.82rem; font-weight: 700; transition: all 0.3s; text-decoration: none; display: inline-block; }
        .btn-pill-dark:hover { background: var(--v2-primary); border-color: var(--v2-primary); color: #fff; transform: translateY(-2px); }
        .btn-pill-lg { padding: 16px 50px; font-size: 0.95rem; }
        /* Light Mode – Team */
        body.light-mode .v2-team-wrap { background: #f0f4f8; }
        body.light-mode .team-card-v4 { background: #ffffff; border-color: #e8edf2; box-shadow: 0 8px 30px rgba(0,0,0,0.07); }
        body.light-mode .team-img-v4 { background: #f8fafc; border-bottom: 1px solid #edf0f3; }
        body.light-mode .team-info-v4 { background: #ffffff; }
        body.light-mode .team-info-v4 h4 { color: #0f172a !important; }
        body.light-mode .team-info-v4 .team-position { color: var(--v2-primary) !important; }
        body.light-mode .btn-pill-dark { background: transparent; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; }
        body.light-mode .btn-pill-dark:hover { background: var(--v2-primary); border-color: var(--v2-primary); color: #fff; }
        body.light-mode .v2-section-title { color: #0f172a; }
        body.light-mode .t-nav-v4, body.light-mode .team-nav-v4 { background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; }
        body.light-mode .t-nav-v4:hover, body.light-mode .team-nav-v4:hover { background: var(--v2-primary); border-color: transparent; color: #fff; }

        /* ── Blog ── */
        .v2-blog-wrap { background: var(--v2-bg); padding: 150px 0; position: relative; overflow: hidden; }
        .blog-card-v4 { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 35px; overflow: hidden; height: 100%; transition: 0.5s; }
        .blog-card-v4:hover { border-color: var(--v2-primary); transform: translateY(-15px); }
        .blog-img-v4 { position: relative; aspect-ratio: 16/9; overflow: hidden; }
        .blog-img-v4 img { width: 100%; height: 100%; object-fit: cover; transition: 0.8s; }
        .blog-card-v4:hover .blog-img-v4 img { transform: scale(1.1); }
        .blog-date-v4 { position: absolute; top: 20px; right: 20px; background: var(--v2-primary); color: #fff; padding: 10px 15px; border-radius: 15px; text-align: center; }
        .blog-date-v4 span { display: block; line-height: 1; }
        .blog-date-v4 .day { font-size: 1.2rem; font-weight: 900; }
        .blog-date-v4 .month { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .blog-info-v4 { padding: 35px; }
        .blog-cat-v4 { font-size: 0.7rem; font-weight: 800; color: var(--v2-primary); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 15px; display: block; }
        .blog-title-v4 { font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 15px; line-height: 1.4; }
        .blog-excerpt-v4 { color: var(--v2-text-muted); font-size: 0.95rem; margin-bottom: 25px; line-height: 1.6; }
        .blog-link-v4 { color: #fff; font-weight: 800; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; border-bottom: 2px solid var(--v2-primary); padding-bottom: 5px; transition: 0.3s; }
        .blog-link-v4:hover { color: var(--v2-primary); letter-spacing: 2px; }

        /* ── Testimonials ── */
        .testimonials-v2-wrap { background: var(--v2-bg); padding: 150px 0; position: relative; overflow: hidden; }
        .testimonial-main-swiper .swiper-slide, .team-main-swiper .swiper-slide { height: auto; }
        .t-card-v4 { background: rgba(255,255,255,0.02); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); border-radius: 30px; padding: 40px; text-align: center; position: relative; height: 100%; display: flex; flex-direction: column; justify-content: space-between; }
        .t-quote-v4 { font-size: 2.2rem; color: var(--v2-primary); opacity: 0.3; margin-bottom: 20px; }
        .t-text-v4 { font-size: 1.1rem; color: #fff; font-style: italic; line-height: 1.6; margin-bottom: 30px; flex-grow: 1; display: flex; align-items: center; justify-content: center; }
        .t-author-v4 { display: flex; align-items: center; justify-content: center; gap: 15px; text-align: left; }
        .t-avatar-v4 { width: 55px; height: 55px; border-radius: 15px; overflow: hidden; border: 2px solid var(--v2-primary); flex-shrink: 0; }
        .t-avatar-v4 img { width: 100%; height: 100%; object-fit: cover; }
        .t-meta-v4 h5 { color: #fff; font-weight: 800; margin: 0; font-size: 1rem; }
        .t-meta-v4 span { color: var(--v2-text-muted); font-size: 0.8rem; }
        .t-nav-v4, .team-nav-v4 { position: absolute; top: 50%; transform: translateY(-50%); width: 50px; height: 50px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; z-index: 10; }
        .t-nav-v4:hover, .team-nav-v4:hover { background: var(--v2-primary); border-color: transparent; transform: translateY(-50%) scale(1.1); }
        .t-prev-v4, .team-prev-v4 { left: -20px; } .t-next-v4, .team-next-v4 { right: -20px; }

        /* ── Contact ── */
        .v2-contact-wrap { background: var(--v2-bg); padding: 150px 0; position: relative; overflow: hidden; }
        .contact-glass-v4 { background: rgba(255,255,255,0.01); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.05); border-radius: 50px; padding: 80px; }
        .contact-reach-v4 { display: flex; flex-direction: column; gap: 30px; }
        .reach-item-v4 { display: flex; align-items: center; gap: 20px; }
        .reach-icon-v4 { width: 50px; height: 50px; background: rgba(240,82,35,0.1); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: var(--v2-primary); font-size: 1.2rem; }
        .reach-item-v4 p { font-size: 0.7rem; font-weight: 800; color: var(--v2-text-muted); margin: 0; }
        .reach-item-v4 h5 { color: #fff; margin: 0; font-size: 1.2rem; font-weight: 700; }
        .contact-form-v4 input, .contact-form-v4 textarea { width: 100%; background: rgba(255,255,255,0.03) !important; border: 1px solid rgba(255,255,255,0.08); border-radius: 15px; padding: 15px 25px; color: #fff; outline: none; transition: 0.3s; margin-bottom: 20px; }
        .contact-form-v4 input:focus, .contact-form-v4 textarea:focus { border-color: var(--v2-primary); background: rgba(255,255,255,0.05) !important; }

        /* ── Tech-Stack Marquee ── */
        .v2-marquee-wrap { background: #040415; padding: 60px 0; border-top: 1px solid rgba(255,255,255,0.02); overflow: hidden; white-space: nowrap; position: relative; }
        .v2-marquee-wrap::before, .v2-marquee-wrap::after { content: ''; position: absolute; top: 0; bottom: 0; width: 150px; z-index: 2; pointer-events: none; }
        .v2-marquee-wrap::before { left: 0; background: linear-gradient(to right, var(--v2-bg), transparent); }
        .v2-marquee-wrap::after { right: 0; background: linear-gradient(to left, var(--v2-bg), transparent); }
        .marquee-content { display: inline-flex; animation: marquee-scroll 30s linear infinite; }
        .marquee-item { display: flex; align-items: center; gap: 15px; margin: 0 40px; font-size: 1.2rem; font-weight: 800; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 2px; }
        .marquee-item i { color: var(--v2-primary); font-size: 1.5rem; opacity: 0.8; }
        @keyframes marquee-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }

        /* ── Working Process ── */
        .process-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 40px; position: relative; z-index: 10; }
        @media (max-width: 991px) { .process-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 575px) { .process-grid { grid-template-columns: 1fr; } }
        .process-card-v4 { text-align: center; position: relative; }
        .process-icon-wrap { width: 100px; height: 100px; background: rgba(240,82,35,0.05); border: 1px solid rgba(240,82,35,0.15); border-radius: 30px; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; font-size: 2rem; color: var(--v2-primary); transition: 0.5s; position: relative; }
        .process-card-v4:hover .process-icon-wrap { background: var(--v2-primary); color: #fff; transform: translateY(-10px) rotate(10deg); box-shadow: 0 20px 40px var(--v2-primary-glow); }
        .process-num { position: absolute; -top: 15px; -right: -15px; width: 35px; height: 35px; background: #fff; color: #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.8rem; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .process-card-v4 h4 { font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 15px; }
        .process-card-v4 p { color: var(--v2-text-muted); line-height: 1.7; font-size: 0.95rem; }

        /* ── Abstract Feature ── */
        .v2-feature-abstract { background: var(--v2-bg); padding: 200px 0; position: relative; overflow: hidden; }
        .mesh-gradient-v4 { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; height: 80%; background: radial-gradient(circle at center, rgba(240,82,35,0.15) 0%, transparent 60%); filter: blur(100px); animation: abstract-glow 10s infinite alternate; }
        @keyframes abstract-glow { 0% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; } 100% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.8; } }
        .abstract-content-v4 { position: relative; z-index: 10; text-align: center; max-width: 900px; margin: 0 auto; }
        .abstract-title { font-size: clamp(3rem, 6vw, 5rem); font-weight: 950; color: #fff; margin-bottom: 30px; line-height: 1; letter-spacing: -2px; }

        /* ── Pricing ── */
        .v2-pricing-wrap { background: var(--v2-bg); padding: 150px 0; position: relative; overflow: hidden; }
        .pricing-card-v4 { background: rgba(255,255,255,0.02); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.05); border-radius: 40px; padding: 60px 45px; height: 100%; transition: 0.5s; position: relative; overflow: hidden; }
        .pricing-card-v4.featured { border-color: var(--v2-primary); background: rgba(240,82,35,0.03); }
        .pricing-card-v4:hover { transform: translateY(-15px); border-color: var(--v2-primary); box-shadow: 0 30px 60px rgba(0,0,0,0.5); }
        .price-v4 { font-size: 3.5rem; font-weight: 900; color: #fff; margin-bottom: 10px; }
        .price-v4 span { font-size: 1rem; color: var(--v2-text-muted); font-weight: 600; letter-spacing: 1px; }
        .pricing-card-v4 h4 { font-size: 1.8rem; font-weight: 800; color: #fff; margin-bottom: 25px; }
        .pricing-list-v4 { list-style: none; padding: 0; margin: 0 0 40px; }
        .pricing-list-v4 li { color: var(--v2-text-muted); margin-bottom: 15px; display: flex; align-items: center; gap: 12px; font-weight: 600; }
        .pricing-list-v4 li i { color: var(--v2-primary); font-size: 0.9rem; }

        /* ── FAQ ── */
        .v2-faq-wrap { background: var(--v2-bg); padding: 150px 0; position: relative; }
        .faq-accordion-v4 { max-width: 800px; margin: 0 auto; }
        .faq-item-v4 { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; margin-bottom: 20px; overflow: hidden; transition: 0.3s; }
        .faq-question-v4 { padding: 30px 40px; color: #fff; font-size: 1.2rem; font-weight: 700; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
        .faq-question-v4 i { transition: 0.3s; color: var(--v2-primary); }
        .faq-item-v4.active { border-color: var(--v2-primary); background: rgba(255,255,255,0.04); }
        .faq-item-v4.active .faq-question-v4 i { transform: rotate(180deg); }
        .faq-answer-v4 { padding: 0 40px; max-height: 0; overflow: hidden; transition: 0.5s cubic-bezier(0,1,0,1); color: var(--v2-text-muted); line-height: 1.7; font-size: 1.1rem; }
        .faq-item-v4.active .faq-answer-v4 { max-height: 500px; padding: 0 40px 30px; transition: 0.5s cubic-bezier(1,0,1,0); }

        /* ── Newsletter ── */
        .v2-newsletter-wrap { background: #06061e; padding: 120px 0; position: relative; overflow: hidden; }
        .newsletter-glass-v4 { background: linear-gradient(135deg, rgba(255,255,255,0.02) 0%, rgba(255,255,255,0.01) 100%); backdrop-filter: blur(30px); border: 1px solid rgba(255,255,255,0.05); border-radius: 50px; padding: 80px; position: relative; overflow: hidden; text-align: center; }
        .neon-glimmer-v4 { position: absolute; inset: 0; border: 2px solid transparent; border-radius: 50px; background: linear-gradient(90deg, transparent, var(--v2-primary), transparent) border-box; -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0); -webkit-mask-composite: destination-out; mask-composite: exclude; opacity: 0.3; animation: neon-slide 4s linear infinite; }
        @keyframes neon-slide { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        .news-form-v4 { max-width: 600px; margin: 40px auto 0; position: relative; }
        .news-form-v4 input { width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 100px; padding: 25px 230px 25px 40px; color: #fff; font-weight: 600; outline: none; transition: 0.3s; }
        .news-form-v4 button { position: absolute; right: 10px; top: 10px; bottom: 10px; background: var(--v2-primary); color: #fff; border: none; border-radius: 100px; padding: 0 40px; font-weight: 800; letter-spacing: 2px; transition: 0.3s; box-shadow: 0 10px 20px var(--v2-primary-glow); }
        .news-form-v4 button:hover { background: #fff; color: var(--v2-primary); transform: scale(1.02); }

        /* ── Internship Section ── */
        .v2-internship-cta-wrap { background: var(--v2-bg); padding: 150px 0; position: relative; overflow: hidden; border-top: 1px solid var(--v2-border); }
        .internship-floating-card { position: absolute; bottom: 30px; left: -30px; background: rgba(13, 11, 40, 0.8); backdrop-filter: blur(20px); border: 1px solid rgba(240, 82, 35, 0.3); border-radius: 20px; padding: 20px; z-index: 3; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .internship-icon-box { width: 50px; height: 50px; background: rgba(240,82,35,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--v2-primary); font-size: 1.5rem; }
        .internship-floating-title { color: #fff; margin: 0; font-size: 1.25rem; font-weight: 800; }
        @media (max-width: 991px) { .internship-floating-card { left: 20px; bottom: 20px; right: 20px; text-align: left; } }

        /* ── Light Mode PERFECT Overrides ── */
        body.light-mode { background: #f8fafc !important; }
        body.light-mode .v2-services-wrap, 
        body.light-mode .v2-portfolio-wrap, 
        body.light-mode .v2-stats-wrap, 
        body.light-mode .v2-mv-wrap, 
        body.light-mode .v2-team-wrap, 
        body.light-mode .v2-blog-wrap, 
        body.light-mode .v2-pricing-wrap, 
        body.light-mode .v2-faq-wrap, 
        body.light-mode .v2-contact-wrap, 
        body.light-mode .v2-newsletter-wrap, 
        body.light-mode .wf-section-wrapper,
        body.light-mode .v2-marquee-wrap,
        body.light-mode .testimonials-v2-wrap,
        body.light-mode .v2-internship-cta-wrap,
        body.light-mode .v2-feature-abstract { background: #f8fafc !important; }

        body.light-mode .v2-mesh-glow,
        body.light-mode .v2-mesh-glow-alt,
        body.light-mode .mesh-gradient-v4 { opacity: 0.15 !important; }

        body.light-mode .s-card-v4, 
        body.light-mode .p-card-v4, 
        body.light-mode .v2-stat-item, 
        body.light-mode .mv-card-v4, 
        body.light-mode .team-card-v4, 
        body.light-mode .blog-card-v4, 
        body.light-mode .pricing-card-v4, 
        body.light-mode .faq-item-v4, 
        body.light-mode .contact-glass-v4, 
        body.light-mode .t-card-v4,
        body.light-mode .newsletter-glass-v4,
        body.light-mode .internship-floating-card { 
            background: #ffffff !important; 
            border-color: rgba(0,0,0,0.06) !important; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.04) !important; 
        }

        body.light-mode h1, body.light-mode h2, body.light-mode h3, body.light-mode h4, body.light-mode h5, body.light-mode h6, 
        body.light-mode .display-3, body.light-mode .display-4, body.light-mode .display-5,
        body.light-mode .v2-section-title, body.light-mode .s-title-v4, body.light-mode .p-title-v4, 
        body.light-mode .v2-stat-value, body.light-mode .blog-title-v4, body.light-mode .price-v4,
        body.light-mode .faq-question-v4, body.light-mode .abstract-title,
        body.light-mode .t-meta-v4 h5, body.light-mode .internship-floating-title { color: #0f172a !important; }

        body.light-mode p, body.light-mode .lead, body.light-mode .s-desc-v4, body.light-mode .hero-subtitle-v4, 
        body.light-mode .v2-stat-label, body.light-mode .blog-excerpt-v4, body.light-mode .mv-card-v4 p,
        body.light-mode .faq-answer-v4, body.light-mode .t-text-v4, body.light-mode .t-meta-v4 span,
        body.light-mode .marquee-item { color: #334155 !important; }

        body.light-mode .s-link-v4, body.light-mode .blog-link-v4, 
        body.light-mode .t-nav-v4, body.light-mode .hero-static-wrap-v2 .hero-scroll-v4 .mouse-v4 { 
            background: #f1f5f9 !important; 
            color: #0f172a !important; 
            border-color: rgba(0,0,0,0.1) !important; 
        }

        body.light-mode .contact-form-v4 input, 
        body.light-mode .contact-form-v4 textarea,
        body.light-mode .news-form-v4 input { 
            background: #f1f5f9 !important; 
            border-color: rgba(0,0,0,0.1) !important; 
            color: #0f172a !important; 
        }

        body.light-mode .v2-marquee-wrap { background: #ffffff !important; border-top-color: rgba(0,0,0,0.05) !important; }
        body.light-mode .v2-marquee-wrap::before { background: linear-gradient(to right, #fff, transparent) !important; }
        body.light-mode .v2-marquee-wrap::after { background: linear-gradient(to left, #fff, transparent) !important; }

        /* ── Testimonials Light Mode ── */
        body.light-mode .t-card-v4 { border-color: rgba(0,0,0,0.08) !important; }
        body.light-mode .t-quote-v4 { opacity: 0.2 !important; }

        /* ── Portfolio Light Mode Refinement ── */
        body.light-mode .p-card-v4 { background: #fff !important; }
        body.light-mode .p-img-v4::after { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.02); pointer-events: none; }

        /* ── Workflow Light Mode Fixes ── */
        body.light-mode .wf-section-wrapper::before,
        body.light-mode .wf-section-wrapper::after { opacity: 0.15; }
        body.light-mode .wf-node { 
            background: rgba(255,255,255,0.8) !important; 
            border-color: rgba(240, 82, 35, 0.3) !important;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05) !important;
        }
        body.light-mode .wf-node i { color: #0f172a !important; background: none !important; -webkit-text-fill-color: initial !important; }
        body.light-mode .wf-node.active { background: linear-gradient(135deg, var(--wf-orange), var(--wf-red-orange)) !important; }
        body.light-mode .wf-node.active i { color: #fff !important; -webkit-text-fill-color: #fff !important; }

        body.light-mode .big-ring { border-color: rgba(0, 0, 0, 0.08) !important; }
        body.light-mode .big-ring-outer { border-color: rgba(0, 0, 0, 0.05) !important; }
        body.light-mode .wf-stat-item { border-left-color: rgba(240, 82, 35, 0.1) !important; }
        body.light-mode .wf-stat-number { color: #0f172a !important; }
        body.light-mode .wf-stat-label { color: #64748b !important; }
        body.light-mode .center-text p { color: #475569 !important; }
        body.light-mode .wf-section-wrapper { background-image: radial-gradient(rgba(0, 0, 0, 0.03) 1px, transparent 1px) !important; }

        /* ── Ultra-Premium Hero Slider Light Mode ── */
        body.light-mode .hero-slider-wrap,
        body.light-mode .hero-static-wrap-v2 { background: #f8fafc !important; }
        
        body.light-mode .hero-noise-overlay { opacity: 0.04 !important; }
        body.light-mode .hero-bg-visual { filter: brightness(1.05) contrast(1.05) saturate(1.1); }
        
        body.light-mode .hero-mesh-overlay {
            background: 
                radial-gradient(circle at 10% 20%, rgba(240, 82, 35, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(59, 130, 246, 0.05) 0%, transparent 40%) !important;
        }

        body.light-mode .hero-ghost-text { 
            color: rgba(15, 23, 42, 0.02) !important; 
            -webkit-text-stroke: 1px rgba(15, 23, 42, 0.03) !important; 
        }

        body.light-mode .hero-cursor-glow { background: radial-gradient(circle, rgba(240, 82, 35, 0.05) 0%, transparent 70%) !important; }

        body.light-mode .hero-glass-panel {
            background: rgba(255, 255, 255, 0.55) !important;
            backdrop-filter: blur(40px) !important;
            border-color: rgba(0, 0, 0, 0.05) !important;
            box-shadow: 0 40px 100px rgba(0,0,0,0.06) !important;
        }

        body.light-mode .hero-title-v4, 
        body.light-mode .hero-title-elite { 
            background: none !important;
            -webkit-text-fill-color: #0f172a !important;
            color: #0f172a !important; 
            text-shadow: none !important; 
        }

        body.light-mode .hero-subtitle-v4 { color: #475569 !important; }
        body.light-mode .hero-badge-v4 { 
            background: rgba(240, 82, 35, 0.05) !important; 
            border-color: rgba(240, 82, 35, 0.1) !important; 
            color: var(--v2-primary) !important; 
        }

        body.light-mode .tech-shape { background: linear-gradient(135deg, rgba(240, 82, 35, 0.03), transparent) !important; border-color: rgba(0,0,0,0.02) !important; }

        body.light-mode .timeline-item { background: rgba(0,0,0,0.05) !important; }
        body.light-mode .timeline-progress { background: var(--v2-primary) !important; }

        body.light-mode .hero-swiper-next, 
        body.light-mode .hero-swiper-prev { 
            background: #ffffff !important; 
            color: #0f172a !important; 
            border-color: rgba(0,0,0,0.05) !important; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important; 
        }
        body.light-mode .hero-scroll-v4 span { color: #0f172a !important; }
        body.light-mode .mouse-v4 { border-color: #0f172a !important; }
        body.light-mode .wheel-v4 { background: #0f172a !important; }



        /* ── Cleanup ── */
        @media (max-width: 991px) {
            .desktop-only { display: none; }
            .p-title-v4 { font-size: 1.6rem; }
            .v2-stat-value { font-size: 2.5rem; }
            .contact-glass-v4 { padding: 40px; }
        }

        /* ── NEW WORK FLOWS SECTION ── */
        :root {
            --wf-navy: #040415;
            --wf-blue: #3b82f6;
            --wf-blue-light: #60a5fa;
            --wf-orange: #f05223;
            --wf-red-orange: #d14118;
            --wf-white: #ffffff;
            --wf-text-gray: #94a3b8;
            --wf-ring-color: rgba(59, 130, 246, 0.25);
        }

        .wf-section-wrapper {
            padding: 120px 0;
            position: relative;
            overflow: hidden;
            background: var(--v2-bg);
            background-image: radial-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
        }


        .wf-section-wrapper::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(240, 82, 35, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .wf-section-wrapper::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .wf-content-row {
            display: flex;
            align-items: center;
            gap: 60px;
            flex-wrap: wrap;
        }

        .workflow-left {
            flex: 0 0 520px;
            position: relative;
        }

        .circle-wrapper {
            position: relative;
            width: 500px;
            height: 500px;
            margin: 0 auto;
        }

        .big-ring-outer {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 390px; height: 390px;
            border-radius: 50%;
            border: 1px dashed rgba(59, 130, 246, 0.18);
        }

        .big-ring {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 340px; height: 340px;
            border-radius: 50%;
            border: 1.5px solid var(--wf-ring-color);
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.1);
        }

        .center-text {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: 195px;
            z-index: 5;
        }
        .center-text h3 {
            font-size: 24px;
            font-weight: 900;
            background: linear-gradient(135deg, var(--wf-orange), var(--wf-red-orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }
        .center-text p {
            font-size: 14px;
            color: var(--wf-text-gray);
            line-height: 1.7;
        }

        @keyframes wfFadeSwap {
            0%   { opacity: 0; transform: translate(-50%, -44%); }
            100% { opacity: 1; transform: translate(-50%, -50%); }
        }
        .center-text.animate { animation: wfFadeSwap 0.4s ease forwards; }

        .wf-node {
            position: absolute;
            width: 85px; height: 85px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            border: 1.5px solid rgba(240, 82, 35, 0.25);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transform: translate(-50%, -50%);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 10;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        }
        .wf-node i {
            font-size: 28px;
            background: linear-gradient(135deg, #fff, #aaa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: 0.3s;
        }
        .wf-node:hover {
            border-color: var(--wf-orange);
            box-shadow: 0 12px 40px rgba(240, 82, 35, 0.3);
            transform: translate(-50%, -50%) scale(1.1) rotate(5deg);
        }
        .wf-node.active {
            background: linear-gradient(135deg, var(--wf-orange), var(--wf-red-orange));
            border-color: var(--wf-orange);
            box-shadow: 0 15px 45px rgba(240, 82, 35, 0.5);
            transform: translate(-50%, -50%) scale(1.15);
        }
        .wf-node.active i {
            background: none;
            -webkit-text-fill-color: #fff;
            color: #fff;
        }

        .wf-node-1 { left: 148px; top:  72px; }
        .wf-node-2 { left: 352px; top:  72px; }
        .wf-node-3 { left: 460px; top: 250px; }
        .wf-node-4 { left: 352px; top: 428px; }
        .wf-node-5 { left: 148px; top: 428px; }
        .wf-node-6 { left:  40px; top: 250px; }

        .stats-right {
            flex: 1;
            min-width: 280px;
        }
        .wf-stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px 30px;
        }
        .wf-stat-item { text-align: left; position: relative; padding-left: 20px; border-left: 2px solid rgba(240, 82, 35, 0.1); transition: 0.3s; }
        .wf-stat-item:hover { border-left-color: var(--wf-orange); transform: translateX(10px); }

        .wf-stat-number {
            font-size: 60px;
            font-weight: 950;
            color: #fff;
            line-height: 1;
            display: flex;
            align-items: flex-start;
            letter-spacing: -2px;
        }
        .wf-stat-number .plus {
            font-size: 28px;
            color: var(--wf-orange);
            margin-top: 8px;
            font-weight: 900;
        }
        .wf-stat-label {
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 2px;
            color: var(--wf-text-gray);
            text-transform: uppercase;
            margin-top: 10px;
        }

        @media (max-width: 900px) {
            .wf-content-row { flex-direction: column; align-items: center; gap: 40px; }
            .workflow-left { flex: none; width: 100%; max-width: 520px; margin: 0 auto; overflow: visible; }
            .stats-right { text-align: center; width: 100%; margin-top: 20px; }
            .wf-stat-item { text-align: center; border-left: none; padding-left: 0; }
            .wf-stat-number { justify-content: center; }
        }
        @media (max-width: 560px) {
            .workflow-left { flex: none; width: 100%; display: flex; justify-content: center; overflow: visible; padding: 20px 0; }
            .circle-wrapper { width: 500px; height: 500px; transform: scale(0.6); transform-origin: center center; margin: 0 auto !important; position: relative; display: block; flex: none; }
            .center-text { width: 200px; position: absolute; left: 50% !important; top: 50% !important; transform: translate(-50%, -50%) !important; }
            .wf-section-wrapper { padding: 40px 15px; }
            .center-text h3 { font-size: 22px; }
            .center-text p { font-size: 13px; line-height: 1.4; }
            .wf-node { width: 85px; height: 85px; }
        }
        @media (max-width: 400px) {
            .circle-wrapper { transform: scale(0.5); }
            .center-text { width: 180px; }
            .center-text h3 { font-size: 18px; }
            .center-text p { font-size: 11px; }
        }




        /* ── GLOBAL MOBILE RESPONSIVENESS OVERRIDES ── */
        @media (max-width: 768px) {
            /* Hero Slider */
            .hero-slider-wrap, .hero-slide-item, .hero-static-wrap-v2 { height: auto; min-height: 85vh; padding: 180px 0 80px; }
            .hero-overlay { background: linear-gradient(to bottom, rgba(6,6,30,0.98) 0%, rgba(6,6,30,0.85) 100%); align-items: center; text-align: center; }
            body.light-mode .hero-overlay { background: linear-gradient(to bottom, rgba(255,255,255,0.98) 0%, rgba(255,255,255,0.9) 100%) !important; }
            .hero-content-wrapper { padding-left: 0; max-width: 100%; margin: 0 auto; padding-top: 20px !important; }

            .hero-badge-v4 { padding: 8px 18px; margin-bottom: 25px; font-size: 0.7rem; }
            .hero-title-v4 { font-size: 2.8rem; margin-bottom: 20px; letter-spacing: -1.5px; }
            .hero-subtitle-v4 { font-size: 0.95rem; margin-bottom: 35px; margin-left: auto; margin-right: auto; line-height: 1.6; }
            .hero-main-swiper { height: auto; }
            .btn-elite-v4, .btn-glass-v4 { padding: 15px 30px; font-size: 0.85rem; width: 100%; justify-content: center; border-radius: 15px; }
            .hero-glass-panel .btn-reveal { flex-direction: column; gap: 12px !important; width: 100%; margin: 0 auto; display: flex !important; }
            .hero-swiper-next, .hero-swiper-prev { display: none !important; }

            .hero-thumbs-swiper { display: none !important; }
            .hero-scroll-v4 { display: none !important; }
            .hero-title-elite { font-size: 3.5rem; letter-spacing: -2px; }

            /* Common Section Sizing */
            .v2-services-wrap, .v2-portfolio-wrap, .v2-stats-wrap, .v2-mv-wrap, .v2-team-wrap, .v2-blog-wrap, .v2-pricing-wrap, .v2-faq-wrap, .v2-contact-wrap, .v2-newsletter-wrap, .testimonials-v2-wrap, .v2-feature-abstract, .v2-internship-cta-wrap { padding: 80px 0; }
            .v2-section-title { font-size: 2.5rem; }

            /* Services */
            .s-card-v4 { padding: 40px 30px; border-radius: 25px; }
            .s-title-v4 { font-size: 1.4rem; }

            /* Stats */
            .v2-stat-item { padding: 40px 20px; border-radius: 25px; }
            .v2-stat-value { font-size: 3rem; }
            .v2-stat-icon { width: 60px; height: 60px; font-size: 1.8rem; }

            /* Mission & Vision */
            .mv-card-v4 { padding: 40px 30px; border-radius: 25px; text-align: center; }
            .mv-icon-v4 { margin: 0 auto 30px; width: 80px; height: 80px; font-size: 2.2rem; }
            .mv-card-v4 h3 { font-size: 2rem; }
            .mv-card-v4 p { font-size: 1.1rem; }

            /* Team */
            .team-info-v4 { padding: 25px 15px; }
            .team-info-v4 h4 { font-size: 1.2rem; }
            .team-social-v4 { position: relative; bottom: 0; transform: none; opacity: 1; margin-top: 15px; padding-bottom: 5px; }
            .team-social-v4 a { transform: none; opacity: 1; position: static; }

            /* Portfolio */
            .p-overlay-v4 { opacity: 1; transform: none; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%); padding: 30px 20px; }
            .p-title-v4 { font-size: 1.5rem; }
            .p-btn-v4 { width: 45px; height: 45px; top: 20px; right: 20px; font-size: 1rem; border-radius: 12px; }

            /* Blog */
            .blog-info-v4 { padding: 25px; }
            .blog-title-v4 { font-size: 1.3rem; }

            /* Testimonials */
            .t-card-v4 { padding: 40px 20px; border-radius: 30px; }
            .t-text-v4 { font-size: 1.1rem; }
            .t-nav-v4 { display: none !important; }
            .t-author-v4 { flex-direction: column; gap: 15px; }

            /* Contact & Newsletter */
            .contact-glass-v4, .newsletter-glass-v4 { padding: 40px 20px; border-radius: 30px; }
            .contact-reach-v4 { margin-bottom: 40px; }
            .news-form-v4 input { padding: 20px 30px; border-radius: 15px; text-align: center; margin-bottom: 15px; }
            .news-form-v4 button { position: static; width: 100%; padding: 20px; border-radius: 15px; }
            
            /* Section Title */
            .v2-section-title { font-size: 2.2rem; }
        }

        @media (max-width: 480px) {
            .hero-title-v4 { font-size: 2.5rem; }
            .hero-title-elite { font-size: 2.8rem; }
            .v2-section-title { font-size: 1.8rem; }
            .v2-stat-value { font-size: 2.5rem; }
        }
    </style>


    {{-- ═══════════════════════════════════ HERO ═══════════════════════════════════ --}}
    @if($heroMode === 'slider' && $heroSlides->count() > 0)
        <section class="hero-slider-wrap">
            {{-- Global Premium Layers --}}
            <div class="hero-noise-overlay"></div>
            <div class="hero-cursor-glow" id="heroCursorGlow"></div>

            <div class="swiper hero-main-swiper">
                <div class="swiper-wrapper">
                    @foreach($heroSlides as $slide)
                        <div class="swiper-slide">
                            @php
                                $img_path = $slide->image_path;
                                if (!empty($img_path) && filter_var($img_path, FILTER_VALIDATE_URL)) {
                                    $bg_image = $img_path;
                                } else {
                                    $bg_image = asset('uploads/slider/' . $img_path);
                                }
                            @endphp
                            
                            {{-- Base Visual Layer --}}
                            <div class="hero-bg-visual" style="background-image: url('{{ $bg_image }}');"></div>
                            <div class="hero-mesh-overlay"></div>
                            
                            {{-- Ghost Typography Background --}}
                            <div class="hero-ghost-text">DIGITAL</div>

                            {{-- Middle Tech Layer --}}
                            <div class="hero-tech-layer">
                                <div class="tech-shape tech-shape-1"></div>
                                <div class="tech-shape tech-shape-2"></div>
                            </div>

                            {{-- Content Layer --}}
                            <div class="hero-slide-item">
                                <div class="container-fluid px-lg-5">
                                    <div class="hero-content-anchor">
                                        <div class="hero-glass-panel">
                                            <div class="hero-badge-v4" style="--d: 0.4s">
                                                <i class="fas fa-microchip"></i>
                                                NEXT-GEN SOLUTIONS
                                            </div>
                                            <h1 class="hero-title-v4" style="--d: 0.6s">
                                                {!! $slide->title ?: $heroTitle !!}
                                            </h1>
                                            <p class="hero-subtitle-v4" style="--d: 0.8s">
                                                {{ $slide->subtitle ?: $heroSubtitle }}
                                            </p>
                                            <div class="d-flex gap-4 btn-reveal" style="--d: 1s">
                                                <a href="{{ $slide->button_link }}" class="btn-elite-v4 z-3 position-relative btn-magnetic">
                                                    {{ $slide->button_text ?: 'Launch Project' }}
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                                <a href="#services" class="btn-glass-v4 z-3 position-relative btn-magnetic">Our Capabilities</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Numbered Liquid Timeline --}}
                <div class="hero-timeline-container">
                    @foreach($heroSlides as $index => $slide)
                        <div class="timeline-item" onclick="mainSwiper.slideToLoop({{ $index }})">
                            <span class="timeline-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="timeline-bar">
                                <div class="timeline-fill"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Beautiful Navigation with Magnetic support --}}
                <div class="hero-swiper-next swiper-button-next btn-magnetic"></div>
                <div class="hero-swiper-prev swiper-button-prev btn-magnetic"></div>
            </div>
        </section>
    @else
        <section class="hero-static-wrap-v2">
            <div class="hero-v2-mesh"></div>
            <div class="container position-relative z-1">
                <div class="text-center">
                    <div class="hero-badge-v4 mb-4" data-aos="fade-down"><span>EST. 2020 — DIGITAL ARCHITECTS</span></div>
                    <h1 class="hero-title-elite mb-4" data-aos="fade-up" data-aos-delay="200">
                        {!! $heroTitle ?: 'Crafting The Next <br><span class="text-glow-primary">Digital Legacy</span>' !!}
                    </h1>
                    <p class="hero-subtitle-v4 mx-auto mb-5" data-aos="fade-up" data-aos-delay="400">
                        {!! $heroSubtitle ?: 'We pioneer high-impact digital solutions that bridge the gap between visionary concepts and explosive brand growth.' !!}
                    </p>
                    <div class="d-flex justify-content-center gap-4" data-aos="fade-up" data-aos-delay="600">
                        <a href="{{ route('contact') }}" class="btn-elite-v4 z-3 position-relative">Start Collaboration <i class="fas fa-arrow-right"></i></a>
                        <a href="{{ route('portfolio.index') }}" class="btn-glass-v4 z-3 position-relative">Review Portfolio</a>
                    </div>
                </div>
            </div>
            <div class="hero-scroll-v4">
                <div class="mouse-v4"><div class="wheel-v4"></div></div>
                <span>DISCOVER SUCCESS</span>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════ SERVICES ═══════════════════════════════════ --}}
    <section id="services" class="v2-services-wrap">
        <div class="v2-mesh-glow-alt"></div>
        <div class="container position-relative z-1">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="v2-badge-primary mb-3">ELITE CAPACITIES</span>
                <h2 class="v2-section-title">Architecting The <br><span class="text-glow-primary">Digital Future</span></h2>
            </div>
            <div class="row g-4">
                @foreach($services as $index => $service)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="s-card-v4 h-100 position-relative">
                            <div class="s-step-v4">0{{ $index + 1 }}</div>
                            <div class="s-icon-v4"><i class="{{ $service->icon_class }}"></i></div>
                            <h3 class="s-title-v4">{{ $service->title }}</h3>
                            <p class="s-desc-v4">{{ $service->short_description }}</p>
                            <a href="{{ route('services') }}" class="s-link-v4 stretched-link">Explore Methodology <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════ TECH MARQUEE ═══════════════════════════════════ --}}
    <section class="v2-marquee-wrap">
        <div class="marquee-content">
            <div class="marquee-item"><i class="fab fa-laravel"></i> LARAVEL ECOLOGY</div>
            <div class="marquee-item"><i class="fab fa-react"></i> REACT ARCHITECTURE</div>
            <div class="marquee-item"><i class="fab fa-node-js"></i> NODE.js BACKEND</div>
            <div class="marquee-item"><i class="fab fa-php"></i> PHP PERFORMANCE</div>
            <div class="marquee-item"><i class="fab fa-js"></i> MODERN JAVASCRIPT</div>
            <div class="marquee-item"><i class="fab fa-python"></i> PYTHON INTELLIGENCE</div>
            <div class="marquee-item"><i class="fab fa-aws"></i> AWS INFRASTRUCTURE</div>
            <div class="marquee-item"><i class="fab fa-docker"></i> DOCKER VIRTUALIZATION</div>
            <div class="marquee-item"><i class="fab fa-git-alt"></i> GIT VERSIONING</div>
            <!-- Duplicate for seamless scroll -->
            <div class="marquee-item"><i class="fab fa-laravel"></i> LARAVEL ECOLOGY</div>
            <div class="marquee-item"><i class="fab fa-react"></i> REACT ARCHITECTURE</div>
            <div class="marquee-item"><i class="fab fa-node-js"></i> NODE.js BACKEND</div>
            <div class="marquee-item"><i class="fab fa-php"></i> PHP PERFORMANCE</div>
            <div class="marquee-item"><i class="fab fa-js"></i> MODERN JAVASCRIPT</div>
            <div class="marquee-item"><i class="fab fa-python"></i> PYTHON INTELLIGENCE</div>
            <div class="marquee-item"><i class="fab fa-aws"></i> AWS INFRASTRUCTURE</div>
            <div class="marquee-item"><i class="fab fa-docker"></i> DOCKER VIRTUALIZATION</div>
            <div class="marquee-item"><i class="fab fa-git-alt"></i> GIT VERSIONING</div>
        </div>
    </section>

    {{-- ═══════════════════════════════════ PORTFOLIO ═══════════════════════════════════ --}}
    <section id="portfolio" class="v2-portfolio-wrap">
        <div class="v2-mesh-glow"></div>
        <div class="container position-relative z-1">
            <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
                <div>
                    <span class="v2-badge-primary mb-3">FEATURED WORK</span>
                    <h2 class="v2-section-title">Case Studies of <br><span class="text-glow-primary">Digital Domination</span></h2>
                </div>
                <a href="{{ route('portfolio.index') }}" class="btn-glass-v4 desktop-only">Explore Archives</a>
            </div>
            @if($projects->isEmpty())
                <div class="col-12 text-center py-5"><p class="text-muted">Archives currently being indexed...</p></div>
            @else
                <div class="row g-5">
                    @foreach($projects as $index => $project)
                        @php
                            $cat_first = $project->categories->first()->name ?? 'Advanced Vertical';
                            $img_src = $project->desktop_image;
                            if (!empty($img_src) && !filter_var($img_src, FILTER_VALIDATE_URL)) {
                                $top_img_path = public_path('assets/images/projects/' . $img_src);
                                $img_src = file_exists($top_img_path) ? asset('assets/images/projects/' . $img_src) : asset('uploads/projects/' . $img_src);
                            } elseif (empty($img_src)) {
                                $img_src = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800';
                            }
                        @endphp
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                            <div class="p-card-v4">
                                <div class="p-img-v4">
                                    <img src="{{ $img_src }}" alt="{{ $project->title }}" onerror="this.src='https://placehold.co/800x600/1e293b/ffffff?text=Project'">
                                    <div class="p-overlay-v4">
                                        <div class="p-meta-v4">
                                            <span class="p-cat-v4">{{ $cat_first }}</span>
                                            <h3 class="p-title-v4">{{ $project->title }}</h3>
                                        </div>
                                        <a href="{{ route('portfolio.show', $project->slug) }}" class="p-btn-v4 stretched-link"><i class="fas fa-external-link-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5 mobile-only" data-aos="fade-up">
                    <a href="{{ route('portfolio.index') }}" class="btn-glass-v4">Explore Archives</a>
                </div>
            @endif
        </div>
    </section>

    {{-- ═══════════════════════════════════ WORKING PROCESS ═══════════════════════════════════ --}}
    {{-- ═══════════════════════════════════ OUR WORK FLOWS & STATS ═══════════════════════════════════ --}}
    <section id="process" class="wf-section-wrapper">
        <div class="container overflow-hidden">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="v2-badge-primary mb-3">ELITE PROTOCOL</span>
                <h2 class="v2-section-title">Our Strategic <br><span class="text-glow-primary">Work Flows</span></h2>

            </div>

            <div class="wf-content-row">
                <!-- LEFT: Circular Workflow -->
                <div class="workflow-left" data-aos="fade-right">
                    <div class="circle-wrapper">
                        <div class="big-ring-outer"></div>
                        <div class="big-ring"></div>

                        <div class="center-text" id="centerText">
                            @if($workFlows->count() > 0)
                                @php $activeItem = $workFlows->where('display_order', 3)->first() ?: $workFlows->first(); @endphp
                                <h3 id="centerTitle">{{ $activeItem->title }}</h3>
                                <p id="centerDesc">{{ $activeItem->description }}</p>
                            @else
                                <h3 id="centerTitle">Design</h3>
                                <p id="centerDesc">We develop a user friendly responsive layout with the content generally provided by the client and convert your vision into design and development.</p>
                            @endif
                        </div>

                        @forelse($workFlows as $index => $step)
                            <div class="wf-node wf-node-{{ $index + 1 }} {{ $index === 2 ? 'active' : '' }}"
                                 data-title="{{ $step->title }}"
                                 data-desc="{{ $step->description }}"
                                 onclick="setWFActive(this)">
                                <i class="{{ $step->icon_class }}"></i>
                            </div>
                        @empty
                            <!-- Fallback Nodes -->
                            <div class="wf-node wf-node-1" data-title="Discovery" data-desc="We consult with clients to understand their goals, audience and project requirements thoroughly." onclick="setWFActive(this)"><i class="fa-solid fa-handshake"></i></div>
                            <div class="wf-node wf-node-2" data-title="Idea & Concept" data-desc="We brainstorm creative concepts and innovative ideas that best align with your business vision." onclick="setWFActive(this)"><i class="fa-solid fa-lightbulb"></i></div>
                            <div class="wf-node wf-node-3 active" data-title="Design" data-desc="We develop a user friendly responsive layout with the content generally provided by the client and convert your vision into design and development." onclick="setWFActive(this)"><i class="fa-solid fa-desktop"></i></div>
                            <div class="wf-node wf-node-4" data-title="Support & Maintenance" data-desc="We provide ongoing support, updates and maintenance to keep your product running flawlessly." onclick="setWFActive(this)"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                            <div class="wf-node wf-node-5" data-title="Testing & QA" data-desc="We rigorously test every feature for performance, compatibility and quality before going live." onclick="setWFActive(this)"><i class="fa-solid fa-magnifying-glass"></i></div>
                            <div class="wf-node wf-node-6" data-title="Development" data-desc="We build scalable, clean-coded solutions bringing your approved designs to life with precision." onclick="setWFActive(this)"><i class="fa-solid fa-rocket"></i></div>
                        @endforelse

                    </div>
                </div>

                <!-- RIGHT: Stats -->
                <div class="stats-right" data-aos="fade-left">
                    <div class="wf-stats-grid">
                        @foreach($stats as $index => $stat)
                            @php
                                preg_match('/([0-9.]+)(.*)/', $stat->stat_value, $matches);
                                $val = $matches[1] ?? 0;
                                $suffix = $matches[2] ?? '';
                            @endphp
                            <div class="wf-stat-item">
                                <div class="wf-stat-number">
                                    <span class="wf-count" data-target="{{ $val }}">0</span>
                                    <span class="plus">{{ $suffix ?: '+' }}</span>
                                </div>
                                <div class="wf-stat-label">{{ $stat->stat_label }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════ ABSTRACT FEATURE ═══════════════════════════════════ --}}
    <section class="v2-feature-abstract">
        <div class="mesh-gradient-v4"></div>
        <div class="container">
            <div class="abstract-content-v4" data-aos="zoom-out">
                <h2 class="abstract-title">Scale Your Vision With <br><span class="text-glow-primary">Absolute Confidence</span></h2>
                <p class="abstract-desc fs-5 mb-5 mx-auto" style="max-width: 600px;">We don't just build websites; we architect digital empires designed for speed, security, and impact.</p>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('contact') }}" class="btn-elite-v4">Start Exploration</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════ MISSION & VISION ═══════════════════════════════════ --}}
    <section class="v2-mv-wrap">
        <div class="v2-mesh-glow-alt"></div>
        <div class="container position-relative z-1">
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="mv-card-v4 mission">
                        <div class="mv-icon-v4"><i class="fas fa-bullseye"></i></div>
                        <h3>Our Core Mission</h3>
                        <p>{{ $mission }}</p>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="mv-card-v4 vision">
                        <div class="mv-icon-v4"><i class="fas fa-eye"></i></div>
                        <h3>Our Strategic Vision</h3>
                        <p>{{ $vision }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════ INTERNSHIP CTA ═══════════════════════════════════ --}}
    <section class="v2-internship-cta-wrap">
        <div class="v2-mesh-glow"></div>
        <div class="container position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <span class="v2-badge-primary mb-3">CAREER JUMPSTART</span>
                    <h2 class="v2-section-title mb-4">Elite <br><span class="text-glow-primary">Internship Program</span></h2>
                    <p class="fs-5 mb-5" style="color: var(--v2-text-muted); max-width: 500px;">Are you ready to accelerate your career? Join our exclusive internship program and work on cutting-edge technologies with industry experts. Gain real-world experience, build a stellar portfolio, and step into your digital future with absolute confidence.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('internship.landing') }}" class="btn-elite-v4">Explore Program <i class="fas fa-arrow-right"></i></a>
                        <a href="{{ route('internship.apply') }}" class="btn-glass-v4">Apply Now</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <div class="position-relative mx-auto" style="max-width: 500px;">
                        <div class="mesh-gradient-v4" style="filter: blur(60px); opacity: 0.6; transform: scale(1.2);"></div>
                        <img src="{{ asset('assets/images/internship-banner.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=800'" class="img-fluid position-relative z-2" style="border-radius: 40px; border: 1px solid rgba(255,255,255,0.05);" alt="Internship Program">
                        
                        <!-- Floating element -->
                        <div class="internship-floating-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="internship-icon-box">
                                    <i class="fas fa-laptop-code"></i>
                                </div>
                                <div class="text-start">
                                    <h4 class="internship-floating-title">Real Projects</h4>
                                    <span style="color: var(--v2-text-muted); font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase; font-weight: 700;">100% Practical</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════ TEAM ═══════════════════════════════════ --}}
    @if($teamMembers->isNotEmpty())
        <section class="v2-team-wrap">
            <div class="v2-mesh-glow"></div>
            <div class="container position-relative z-1">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="v2-badge-primary mb-3">ELITE CORE</span>
                    <h2 class="v2-section-title">Architects of <br><span class="text-glow-primary">The Vision</span></h2>
                </div>
                <div class="position-relative px-lg-4">
                    <div class="swiper team-main-swiper" data-aos="fade-up">
                        <div class="swiper-wrapper">
                            @foreach($teamMembers as $index => $member)
                                <div class="swiper-slide py-3">
                                    <div class="team-card-v4">
                                        <div class="team-img-v4">
                                            @php
                                                $memberImg = $member->image ?? null;
                                                if (!empty($memberImg) && !filter_var($memberImg, FILTER_VALIDATE_URL)) {
                                                    $memberImg = asset('uploads/team/' . $memberImg);
                                                } elseif (empty($memberImg)) {
                                                    $memberImg = 'https://via.placeholder.com/400x500/10101f/ffffff?text=' . urlencode($member->name);
                                                }
                                            @endphp
                                            <img src="{{ $memberImg }}" alt="{{ $member->name }}" onerror="this.src='https://via.placeholder.com/400x500/10101f/ffffff?text={{ urlencode($member->name) }}'">
                                            <div class="team-social-v4">
                                                @if($member->facebook_url)
                                                    <a href="{{ $member->facebook_url }}"><i class="fab fa-facebook-f"></i></a>
                                                @endif
                                                @if($member->twitter_url)
                                                    <a href="{{ $member->twitter_url }}"><i class="fab fa-twitter"></i></a>
                                                @endif
                                                @if($member->instagram_url)
                                                    <a href="{{ $member->instagram_url }}"><i class="fab fa-instagram"></i></a>
                                                @endif
                                                @if($member->linkedin_url)
                                                    <a href="{{ $member->linkedin_url }}"><i class="fab fa-linkedin-in"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="team-info-v4">
                                            <h4>{{ $member->name }}</h4>
                                            <span class="team-position">{{ $member->position }}</span>
                                            <a href="{{ route('team.show', $member->id) }}" class="btn-pill-dark">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="team-nav-v4 team-prev-v4"><i class="fas fa-chevron-left"></i></div>
                    <div class="team-nav-v4 team-next-v4"><i class="fas fa-chevron-right"></i></div>
                </div>
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ route('team') }}" class="btn-pill-dark px-5">Strategic Directory</a>
                </div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════ PRICING / SOLUTIONS ═══════════════════════════════════ --}}
    <section id="pricing" class="v2-pricing-wrap">
        <div class="v2-mesh-glow-alt"></div>
        <div class="container position-relative z-1">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="v2-badge-primary mb-3">SCALABLE SOLUTIONS</span>
                <h2 class="v2-section-title">Strategic Investment <br><span class="text-glow-primary">For Exponential Growth</span></h2>
            </div>
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="pricing-card-v4">
                        <h4>Starter Suite</h4>
                        <div class="price-v4">$1.2K<span>/mo</span></div>
                        <ul class="pricing-list-v4">
                            <li><i class="fas fa-check-circle"></i> Custom UI/UX Design</li>
                            <li><i class="fas fa-check-circle"></i> Responsive Development</li>
                            <li><i class="fas fa-check-circle"></i> Basic SEO Optimization</li>
                            <li><i class="fas fa-check-circle"></i> 3 Months Support</li>
                        </ul>
                        <a href="{{ route('contact') }}" class="btn-glass-v4 w-100 text-center">Get Started</a>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="pricing-card-v4 featured">
                        <h4>Elite Enterprise</h4>
                        <div class="price-v4">$3.5K<span>/mo</span></div>
                        <ul class="pricing-list-v4">
                            <li><i class="fas fa-check-circle"></i> Full-Stack Architecture</li>
                            <li><i class="fas fa-check-circle"></i> Advanced AI Integration</li>
                            <li><i class="fas fa-check-circle"></i> Premium Cloud Hosting</li>
                            <li><i class="fas fa-check-circle"></i> 1 Year Priority Support</li>
                        </ul>
                        <a href="{{ route('contact') }}" class="btn-elite-v4 w-100 justify-content-center">Go Premium</a>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="pricing-card-v4">
                        <h4>Global Custom</h4>
                        <div class="price-v4">Custom<span>/po</span></div>
                        <ul class="pricing-list-v4">
                            <li><i class="fas fa-check-circle"></i> Strategic Consulting</li>
                            <li><i class="fas fa-check-circle"></i> Infinite Scalability</li>
                            <li><i class="fas fa-check-circle"></i> Dedicated DevOps Team</li>
                            <li><i class="fas fa-check-circle"></i> 24/7 Global Access</li>
                        </ul>
                        <a href="{{ route('contact') }}" class="btn-glass-v4 w-100 text-center">Consult Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════ BLOG ═══════════════════════════════════ --}}
    @if($posts->isNotEmpty())
        <section id="blog" class="v2-blog-wrap">
            <div class="v2-mesh-glow-alt"></div>
            <div class="container position-relative z-1">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="v2-badge-primary mb-3">STRATEGIC INSIGHTS</span>
                    <h2 class="v2-section-title">Latest From Our <br><span class="text-glow-primary">Intelligence Feed</span></h2>
                </div>
                <div class="row g-4">
                    @foreach($posts as $index => $post)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                            <article class="blog-card-v4">
                                <div class="blog-img-v4">
                                    @php
                                        $img_src = $post->featured_image;
                                        if (!empty($img_src) && !filter_var($img_src, FILTER_VALIDATE_URL)) {
                                            $img_src = asset('uploads/blog/' . $img_src);
                                        } elseif (empty($img_src)) {
                                            $img_src = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800';
                                        }
                                    @endphp
                                    <img src="{{ $img_src }}" alt="{{ $post->title }}" onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800'">
                                    <div class="blog-date-v4">
                                        <span class="day">{{ $post->created_at->format('d') }}</span>
                                        <span class="month">{{ $post->created_at->format('M') }}</span>
                                    </div>
                                </div>
                                <div class="blog-info-v4">
                                    <span class="blog-cat-v4">STRATEGY</span>
                                    <h3 class="blog-title-v4">{{ $post->title }}</h3>
                                    <p class="blog-excerpt-v4">{{ Str::limit(strip_tags($post->excerpt ?: $post->content), 100) }}</p>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="blog-link-v4">Read Insight</a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════ NEWSLETTER ═══════════════════════════════════ --}}
    <section class="v2-newsletter-wrap">
        <div class="container">
            <div class="newsletter-glass-v4" data-aos="zoom-in">
                <div class="neon-glimmer-v4"></div>
                <span class="v2-badge-primary mb-4">INNER CIRCLE</span>
                <h2 class="v2-section-title mb-4">Stay Ahead of The <br><span class="text-glow-primary">Innovation Curve</span></h2>
                <p class="text-muted">Join 5,000+ industry leaders receiving our weekly strategic blueprints.</p>
                <div class="news-form-v4">
                    <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Subscribed to Intelligence Feed!');">
                        <input type="email" placeholder="Enter Your Executive Email" required>
                        <button type="submit">SUBSCRIBE</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════ CLIENT VOICES (Testimonials) ═══════════════════════════════════ --}}
    <section class="testimonials-v2-wrap">
        <div class="v2-mesh-glow"></div>
        <div class="container position-relative z-1">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="v2-badge-primary mb-3">CLIENT VOICES</span>
                <h2 class="v2-section-title">Validation of <br><span class="text-glow-primary">Strategic Success</span></h2>
            </div>
            <div class="position-relative px-lg-5">
                <div class="swiper testimonial-main-swiper" data-aos="fade-up">
                    <div class="swiper-wrapper">
                        @foreach($testimonials as $testimonial)
                            <div class="swiper-slide py-4">
                                <div class="t-card-v4">
                                    <div class="t-quote-v4"><i class="fas fa-quote-left"></i></div>
                                    <p class="t-text-v4">"{{ $testimonial->comment }}"</p>
                                    <div class="t-author-v4">
                                        @php
                                            $t_img = $testimonial->image;
                                            if (!empty($t_img) && !filter_var($t_img, FILTER_VALIDATE_URL)) {
                                                $t_img = asset('uploads/testimonials/' . $t_img);
                                            } elseif (empty($t_img)) {
                                                $t_img = 'https://via.placeholder.com/100/1e293b/ffffff?text=' . urlencode(mb_substr($testimonial->name ?? 'U', 0, 1));
                                            }
                                        @endphp
                                        <div class="t-avatar-v4">
                                            <img src="{{ $t_img }}"
                                                 alt="{{ $testimonial->name }}"
                                                 onerror="this.src='https://via.placeholder.com/100/1e293b/ffffff?text={{ urlencode(mb_substr($testimonial->name ?? 'U', 0, 1)) }}'">
                                        </div>
                                        <div class="t-meta-v4">
                                            <h5>{{ $testimonial->name }}</h5>
                                            <span>{{ $testimonial->position }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="t-nav-v4 t-prev-v4"><i class="fas fa-chevron-left"></i></div>
                <div class="t-nav-v4 t-next-v4"><i class="fas fa-chevron-right"></i></div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════ ELITE FAQ ═══════════════════════════════════ --}}
    <section id="faq" class="v2-faq-wrap">
        <div class="v2-mesh-glow-alt"></div>
        <div class="container position-relative z-1">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="v2-badge-primary mb-3">KNOWLEDGE BASE</span>
                <h2 class="v2-section-title">Common <br><span class="text-glow-primary">Inquiries</span></h2>
            </div>
            <div class="faq-accordion-v4">
                <div class="faq-item-v4 active" data-aos="fade-up">
                    <div class="faq-question-v4">How long does a typical digital transformation take? <i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer-v4">Usually, a comprehensive phase takes 4-12 weeks depending on the complexity and depth of the integration required for your brand.</div>
                </div>
                <div class="faq-item-v4" data-aos="fade-up" data-aos-delay="100">
                    <div class="faq-question-v4">Do you provide post-launch strategic support? <i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer-v4">Yes, we offer elite support tiers ranging from standard maintenance to 24/7 dedicated DevOps and strategic scaling assistance.</div>
                </div>
                <div class="faq-item-v4" data-aos="fade-up" data-aos-delay="200">
                    <div class="faq-question-v4">Can you integrate AI into existing infrastructures? <i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer-v4">Abolsutely. We specialize in architecting AI layers that sit on top of legacy systems to enhance automation and intelligence without full rewrites.</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════ CONTACT ═══════════════════════════════════ --}}
    <section id="contact" class="v2-contact-wrap">
        <div class="v2-mesh-glow"></div>
        <div class="container position-relative z-1">
            <div class="contact-glass-v4" data-aos="fade-up">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-5">
                        <span class="v2-badge-primary mb-4">CONTACT ARCHITECTURE</span>
                        <h2 class="v2-section-title mb-4">Initiate Your <br><span class="text-glow-primary">Next Project</span></h2>
                        <p class="text-muted mb-5">Ready to scale? Connect with our strategic consultants to start your transformation.</p>
                        <div class="contact-reach-v4">
                            <div class="reach-item-v4">
                                <div class="reach-icon-v4"><i class="fas fa-envelope"></i></div>
                                <div><p>EMAIL</p><h5>{{ $contactEmail }}</h5></div>
                            </div>
                            <div class="reach-item-v4">
                                <div class="reach-icon-v4"><i class="fas fa-phone"></i></div>
                                <div><p>PHONE</p><h5>{{ $contactPhone }}</h5></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="contact-form-v4">
                            <form action="{{ route('contact.submit') }}" method="POST">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6"><input type="text" name="name" placeholder="FULL NAME" required></div>
                                    <div class="col-md-6"><input type="email" name="email" placeholder="EMAIL ADDRESS" required></div>
                                    <div class="col-12"><input type="text" name="subject" placeholder="SUBJECT" required></div>
                                    <div class="col-12"><textarea name="message" rows="4" placeholder="HOW CAN WE HELP?" required></textarea></div>
                                    <div class="col-12">
                                        <button type="submit" class="btn-elite-v4 w-100 py-3">SEND MESSAGE</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    if (document.querySelector('.hero-main-swiper')) {
        const timelineItems = document.querySelectorAll('.timeline-item');
        const glowSphere = document.getElementById('heroCursorGlow');
        
        var mainSwiper = new Swiper('.hero-main-swiper', {
            loop: true,
            speed: 1600,
            autoplay: { delay: 6000, disableOnInteraction: false },
            effect: 'creative',
            creativeEffect: {
                prev: { shadow: true, translate: ['-25%', 0, -1] },
                next: { translate: ['100%', 0, 0] },
            },
            navigation: { nextEl: '.hero-swiper-next', prevEl: '.hero-swiper-prev' },
            on: {
                init: function() { updateTimeline(0); },
                slideChange: function() { updateTimeline(this.realIndex); }
            }
        });

        function updateTimeline(index) {
            timelineItems.forEach((item, i) => {
                const isActive = (i === index);
                item.classList.toggle('active', isActive);
                
                // Reset animation if needed
                const fill = item.querySelector('.timeline-fill');
                if (fill) {
                    fill.style.animation = 'none';
                    fill.offsetHeight; // trigger reflow
                    if (isActive) fill.style.animation = 'timelineLiquid 6s linear forwards';
                }
            });
        }

        // Mouse Interactivity Hub (Glow, Parallax, Magnetic)
        const heroWrap = document.querySelector('.hero-slider-wrap');
        
        heroWrap.addEventListener('mousemove', (e) => {
            const { clientX, clientY } = e;
            const rect = heroWrap.getBoundingClientRect();
            const relX = clientX - rect.left;
            const relY = clientY - rect.top;

            // 1. Glow Sphere Tracking
            if (glowSphere) {
                glowSphere.style.left = `${relX}px`;
                glowSphere.style.top = `${relY}px`;
            }

            // 2. Multi-Layer Parallax
            const xPos = (clientX / window.innerWidth - 0.5);
            const yPos = (clientY / window.innerHeight - 0.5);

            // Ghost Text (Strongest)
            document.querySelectorAll('.hero-ghost-text').forEach(ghost => {
                ghost.style.transform = `translate(calc(-50% + ${xPos * 120}px), calc(-50% + ${yPos * 120}px))`;
            });

            // Tech Shapes
            document.querySelectorAll('.tech-shape').forEach((shape, i) => {
                const factor = (i + 1) * 30;
                shape.style.transform = `translate(${xPos * factor}px, ${yPos * factor}px) rotate(${xPos * 20}deg)`;
            });

            // Content Panel (Subtle)
            const activePanel = document.querySelector('.swiper-slide-active .hero-glass-panel');
            if (activePanel) {
                activePanel.style.transform = `translate(${xPos * 20}px, ${yPos * 20}px)`;
            }

            // 3. Magnetic Buttons
            document.querySelectorAll('.btn-magnetic').forEach(btn => {
                const btnRect = btn.getBoundingClientRect();
                const btnX = btnRect.left + btnRect.width / 2;
                const btnY = btnRect.top + btnRect.height / 2;
                
                const dist = Math.hypot(clientX - btnX, clientY - btnY);
                if (dist < 100) {
                    const x = (clientX - btnX) * 0.3;
                    const y = (clientY - btnY) * 0.3;
                    btn.style.transform = `translate(${x}px, ${y}px)`;
                } else {
                    btn.style.transform = `translate(0, 0)`;
                }
            });
        });

        heroWrap.addEventListener('mouseleave', () => {
            document.querySelectorAll('.btn-magnetic').forEach(btn => {
                btn.style.transform = `translate(0, 0)`;
            });
        });
    }

    if (document.querySelector('.testimonial-main-swiper')) {
        new Swiper('.testimonial-main-swiper', {
            loop: true, autoplay: { delay: 5000, disableOnInteraction: false },
            slidesPerView: 3, spaceBetween: 30,
            breakpoints: {
                0: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                992: { slidesPerView: 3 }
            },
            navigation: { nextEl: '.t-next-v4', prevEl: '.t-prev-v4' },
        });
    }

    if (document.querySelector('.team-main-swiper')) {
        new Swiper('.team-main-swiper', {
            loop: true, autoplay: { delay: 4000, disableOnInteraction: false },
            slidesPerView: 4, spaceBetween: 30,
            breakpoints: {
                0: { slidesPerView: 1 },
                576: { slidesPerView: 2 },
                992: { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
            },
            navigation: { nextEl: '.team-next-v4', prevEl: '.team-prev-v4' },
        });
    }

    document.querySelectorAll('.team-card-v4, .blog-card-v4, .s-card-v4').forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            card.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
            card.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
        });
    });

    // Stats Counter Animation
    const observerOptions = { threshold: 0.5 };
    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseFloat(counter.getAttribute('data-target'));
                const duration = 2000; // 2 seconds
                let startTime = null;

                const animate = (timestamp) => {
                    if (!startTime) startTime = timestamp;
                    const progress = Math.min((timestamp - startTime) / duration, 1);
                    const currentVal = (progress * target).toFixed(target % 1 === 0 ? 0 : 1);
                    counter.innerText = currentVal;
                    if (progress < 1) requestAnimationFrame(animate);
                };
                requestAnimationFrame(animate);
                observer.unobserve(counter);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.v2-counter').forEach(el => counterObserver.observe(el));

    // FAQ Accordion
    document.querySelectorAll('.faq-question-v4').forEach(q => {
        q.addEventListener('click', () => {
            const item = q.parentElement;
            const wasActive = item.classList.contains('active');
            
            document.querySelectorAll('.faq-item-v4').forEach(i => i.classList.remove('active'));
            if (!wasActive) item.classList.add('active');
        });
    });

    // Workflow Section Logic
    window.setWFActive = function(el) {
        document.querySelectorAll('.wf-node').forEach(n => n.classList.remove('active'));
        el.classList.add('active');
        const ct = document.getElementById('centerText');
        ct.classList.remove('animate');
        void ct.offsetWidth; 
        ct.classList.add('animate');
        document.getElementById('centerTitle').textContent = el.getAttribute('data-title');
        document.getElementById('centerDesc').textContent  = el.getAttribute('data-desc');
    };

    function animateWFCounter(el) {
        const target = parseFloat(el.getAttribute('data-target'));
        const duration = 2000;
        let startTime = null;
        
        const animate = (timestamp) => {
            if (!startTime) startTime = timestamp;
            const progress = Math.min((timestamp - startTime) / duration, 1);
            const currentVal = (progress * target).toFixed(target % 1 === 0 ? 0 : 1);
            el.textContent = parseFloat(currentVal).toLocaleString();
            if (progress < 1) requestAnimationFrame(animate);
        };
        requestAnimationFrame(animate);
    }

    const wfObserver = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                document.querySelectorAll('.wf-count').forEach(c => animateWFCounter(c));
                wfObserver.unobserve(e.target);
            }
        });
    }, { threshold: 0.3 });

    const statsRight = document.querySelector('.stats-right');
    if(statsRight) wfObserver.observe(statsRight);

</script>
@endpush
