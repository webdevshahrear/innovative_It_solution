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

        /* ── Hero Slider V2 ── */
        .hero-slider-wrap { height: 100vh; background: var(--v2-bg); position: relative; }
        .hero-slide-item { height: 100vh; background-size: cover; background-position: center; position: relative; }
        .hero-overlay { position: absolute; inset: 0; background: linear-gradient(to right, rgba(6,6,30,0.95) 0%, rgba(6,6,30,0.4) 100%); display: flex; align-items: center; }
        .hero-content-wrapper { max-width: 850px; padding-left: 5%; }
        .hero-badge-v4 { display: inline-flex; align-items: center; gap: 10px; font-size: .8rem; font-weight: 800; letter-spacing: 2.5px; text-transform: uppercase; color: var(--v2-primary); background: rgba(240,82,35,0.12); border: 1px solid rgba(240,82,35,0.25); border-radius: 100px; padding: 10px 24px; margin-bottom: 35px; backdrop-filter: blur(15px); }
        .hero-title-v4 { font-size: clamp(3.5rem, 8vw, 6rem); font-weight: 900; line-height: 1; letter-spacing: -3px; color: #fff; margin-bottom: 30px; }
        .hero-subtitle-v4 { font-size: 1.25rem; color: var(--v2-text-muted); line-height: 1.7; margin-bottom: 45px; max-width: 650px; }

        /* ── Static Hero V2 ── */
        .hero-static-wrap-v2 { height: 100vh; background: var(--v2-bg); position: relative; overflow: hidden; display: flex; align-items: center; }
        .hero-v2-mesh { position: absolute; inset: 0; background: radial-gradient(circle at 15% 20%, rgba(240,82,35,0.1) 0%, transparent 40%), radial-gradient(circle at 85% 80%, rgba(59,130,246,0.08) 0%, transparent 40%); filter: blur(60px); animation: meshFloat 25s infinite alternate ease-in-out; }
        @keyframes meshFloat { 0% { transform: scale(1) translate(0,0); } 100% { transform: scale(1.15) translate(30px,-20px); } }
        .hero-title-elite { font-size: clamp(4rem, 10vw, 7.5rem); font-weight: 950; line-height: 0.95; letter-spacing: -5px; background: linear-gradient(180deg, #fff 40%, rgba(255,255,255,0.4)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .text-glow-primary { background: linear-gradient(135deg, var(--v2-primary), #ff8a65); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 0 50px var(--v2-primary-glow); }
        .hero-scroll-v4 { position: absolute; bottom: 50px; left: 50%; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center; gap: 20px; color: var(--v2-text-muted); font-size: 0.7rem; font-weight: 800; letter-spacing: 3px; }
        .mouse-v4 { width: 30px; height: 50px; border: 2.5px solid rgba(255,255,255,0.15); border-radius: 100px; position: relative; }
        .wheel-v4 { width: 4px; height: 10px; background: var(--v2-primary); border-radius: 100px; position: absolute; left: 50%; top: 10px; transform: translateX(-50%); animation: wheelDown 2s infinite; }
        @keyframes wheelDown { 0% { transform: translate(-50%, 0); opacity: 0; } 40% { opacity: 1; } 100% { transform: translate(-50%, 20px); opacity: 0; } }

        /* ── Buttons ── */
        .btn-elite-v4 { background: var(--v2-primary); color: #fff; border: none; border-radius: 20px; padding: 20px 45px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; transition: all 0.4s cubic-bezier(0.16,1,0.3,1); display: inline-flex; align-items: center; gap: 15px; box-shadow: 0 20px 40px var(--v2-primary-glow); }
        .btn-elite-v4:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 30px 60px var(--v2-primary-glow); color: #fff; }
        .btn-glass-v4 { background: rgba(255,255,255,0.03); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.12); color: #fff; border-radius: 20px; padding: 20px 45px; font-weight: 800; transition: all 0.4s; }
        .btn-glass-v4:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.25); transform: translateY(-8px); color: #fff; }

        /* ── Hero Nav ── */
        .hero-swiper-next, .hero-swiper-prev { width: 70px; height: 70px; background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; color: #fff; transition: all 0.4s cubic-bezier(0.16,1,0.3,1); z-index: 50; }
        .hero-swiper-next::after, .hero-swiper-prev::after { font-size: 1.5rem; font-weight: 900; }
        .hero-swiper-next:hover, .hero-swiper-prev:hover { background: var(--v2-primary); border-color: var(--v2-primary); box-shadow: 0 0 30px var(--v2-primary-glow); color: #fff; }
        .hero-swiper-next { right: 50px; }
        .hero-swiper-prev { left: 50px; }
        .swiper-pagination-bullet { background: rgba(255,255,255,0.3); width: 12px; height: 12px; opacity: 1; margin: 0 8px !important; transition: all 0.3s; }
        .swiper-pagination-bullet-active { background: var(--v2-primary); box-shadow: 0 0 15px var(--v2-primary-glow); transform: scale(1.3); }

        /* ── Common ── */
        .v2-badge-primary { display: inline-block; background: rgba(240,82,35,0.1); border: 1px solid rgba(240,82,35,0.2); color: var(--v2-primary); padding: 8px 18px; border-radius: 40px; font-size: 0.75rem; font-weight: 800; letter-spacing: 2px; }
        .v2-section-title { font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; color: #fff; line-height: 1.1; }
        .v2-mesh-glow { position: absolute; inset: 0; background: radial-gradient(circle at 10% 20%, rgba(240,82,35,0.05) 0%, transparent 40%); }
        .v2-mesh-glow-alt { position: absolute; inset: 0; background: radial-gradient(circle at 90% 80%, rgba(59,130,246,0.05) 0%, transparent 40%); }

        /* ── Services ── */
        .v2-services-wrap { background: #040415; padding: 150px 0; position: relative; overflow: hidden; }
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
        .v2-portfolio-wrap { background: #06061e; padding: 150px 0; position: relative; overflow: hidden; }
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

        /* ── Stats ── */
        .v2-stats-wrap { background: #040415; padding: 120px 0; border-top: 1px solid rgba(255,255,255,0.02); position: relative; overflow: hidden; }
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
        
        /* Pulse Animation */
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
        .v2-team-wrap { background: var(--v2-bg); padding: 150px 0; position: relative; overflow: hidden; }
        .team-card-v4 { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 35px; overflow: hidden; position: relative; transition: 0.5s; }
        .team-card-v4:hover { border-color: var(--v2-primary); transform: translateY(-15px); background: rgba(255,255,255,0.04); }
        .team-img-v4 { position: relative; aspect-ratio: 4/5; overflow: hidden; }
        .team-img-v4 img { width: 100%; height: 100%; object-fit: cover; transition: 0.8s; }
        .team-card-v4:hover .team-img-v4 img { transform: scale(1.1); filter: grayscale(1); }
        .team-social-v4 { position: absolute; bottom: 20px; left: 0; right: 0; justify-content: center; display: flex; gap: 10px; transform: translateY(100px); transition: 0.5s; }
        .team-card-v4:hover .team-social-v4 { transform: translateY(0); }
        .team-social-v4 a { width: 40px; height: 40px; background: var(--v2-primary); color: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.9rem; transition: 0.3s; }
        .team-social-v4 a:hover { background: #fff; color: var(--v2-primary); transform: translateY(-5px); }
        .team-info-v4 { padding: 30px; }
        .team-info-v4 h4 { color: #fff; font-weight: 800; margin-bottom: 5px; font-size: 1.4rem; }
        .team-info-v4 p { color: var(--v2-primary); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; margin: 0; }

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
        .t-card-v4 { background: rgba(255,255,255,0.02); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); border-radius: 40px; padding: 60px; text-align: center; position: relative; }
        .t-quote-v4 { font-size: 3rem; color: var(--v2-primary); opacity: 0.3; margin-bottom: 30px; }
        .t-text-v4 { font-size: 1.4rem; color: #fff; font-style: italic; line-height: 1.6; margin-bottom: 40px; }
        .t-author-v4 { display: flex; align-items: center; justify-content: center; gap: 20px; }
        .t-avatar-v4 { width: 70px; height: 70px; border-radius: 20px; overflow: hidden; border: 2px solid var(--v2-primary); }
        .t-avatar-v4 img { width: 100%; height: 100%; object-fit: cover; }
        .t-meta-v4 h5 { color: #fff; font-weight: 800; margin: 0; }
        .t-meta-v4 span { color: var(--v2-text-muted); font-size: 0.9rem; }
        .t-nav-v4 { position: absolute; top: 50%; width: 60px; height: 60px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; z-index: 10; }
        .t-nav-v4:hover { background: var(--v2-primary); border-color: transparent; transform: scale(1.1); }
        .t-prev-v4 { left: -30px; } .t-next-v4 { right: -30px; }

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
        .news-form-v4 button:hover { background: #fff; color: var(--v2-primary); transform: scale(1.05); }

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
        body.light-mode .v2-feature-abstract { background: #f8fafc !important; }

        body.light-mode .s-card-v4, 
        body.light-mode .p-card-v4, 
        body.light-mode .v2-stat-item, 
        body.light-mode .mv-card-v4, 
        body.light-mode .team-card-v4, 
        body.light-mode .blog-card-v4, 
        body.light-mode .pricing-card-v4, 
        body.light-mode .faq-item-v4, 
        body.light-mode .contact-glass-v4, 
        body.light-mode .newsletter-glass-v4 { 
            background: #ffffff !important; 
            border-color: rgba(0,0,0,0.05) !important; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important; 
        }

        body.light-mode h1, body.light-mode h2, body.light-mode h3, body.light-mode h4, body.light-mode h5, body.light-mode h6, 
        body.light-mode .v2-section-title, body.light-mode .s-title-v4, body.light-mode .p-title-v4, 
        body.light-mode .v2-stat-value, body.light-mode .blog-title-v4, body.light-mode .price-v4,
        body.light-mode .faq-question-v4 { color: #0f172a !important; }

        body.light-mode p, body.light-mode .s-desc-v4, body.light-mode .hero-subtitle-v4, 
        body.light-mode .v2-stat-label, body.light-mode .blog-excerpt-v4, body.light-mode .mv-card-v4 p,
        body.light-mode .faq-answer-v4, body.light-mode .t-text-v4 { color: #334155 !important; }

        body.light-mode .btn-glass-v4, body.light-mode .s-link-v4, body.light-mode .blog-link-v4, 
        body.light-mode .hero-swiper-next, body.light-mode .hero-swiper-prev, 
        body.light-mode .t-nav-v4 { 
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

        /* ── Cleanup ── */
        @media (max-width: 991px) {
            .desktop-only { display: none; }
            .p-title-v4 { font-size: 1.6rem; }
            .v2-stat-value { font-size: 2.5rem; }
            .contact-glass-v4 { padding: 40px; }
        }
    </style>

    {{-- ═══════════════════════════════════ HERO ═══════════════════════════════════ --}}
    @if($heroMode === 'slider' && $heroSlides->count() > 0)
        <section class="hero-slider-wrap">
            <div class="swiper hero-main-swiper">
                <div class="swiper-wrapper">
                    @foreach($heroSlides as $slide)
                        <div class="swiper-slide">
                            @php
                                $img_path = $slide->image_path;
                                if (!empty($img_path) && filter_var($img_path, FILTER_VALIDATE_URL)) {
                                    $bg_style = "url('$img_path')";
                                } else {
                                    $bg_style = "url('" . asset('uploads/slider/' . $img_path) . "')";
                                }
                            @endphp
                            <div class="hero-slide-item" style="background-image: {{ $bg_style }};">
                                <div class="hero-overlay">
                                    <div class="container-fluid px-lg-5">
                                        <div class="hero-content-wrapper" data-aos="fade-right">
                                            <div class="hero-badge-v4">ELITE ARCHITECTURE</div>
                                            <h1 class="hero-title-v4">{{ $slide->title ?: $heroTitle }}</h1>
                                            <p class="hero-subtitle-v4">{{ $slide->subtitle ?: $heroSubtitle }}</p>
                                            <div class="d-flex gap-4">
                                                <a href="{{ $slide->button_link }}" class="btn-elite-v4 z-3 position-relative">
                                                    {{ $slide->button_text ?: 'Launch Project' }}
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                                <a href="#services" class="btn-glass-v4 z-3 position-relative">Our Capabilities</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="hero-swiper-next swiper-button-next"></div>
                <div class="hero-swiper-prev swiper-button-prev"></div>
            </div>
            <div class="swiper hero-thumbs-swiper">
                <div class="swiper-wrapper">
                    @foreach($heroSlides as $index => $slide)
                        <div class="swiper-slide">
                            <div class="hero-thumb-item">
                                <div class="thumb-meta">STEP 0{{ $index + 1 }}</div>
                                <div class="thumb-title">{{ $slide->title ?: 'Elite Vertical' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
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
    <section id="process" class="v2-process-wrap">
        <div class="v2-mesh-glow-alt"></div>
        <div class="container position-relative z-1">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="v2-badge-primary mb-3">ELITE PROTOCOL</span>
                <h2 class="v2-section-title">The Blueprint of <br><span class="text-glow-primary">Digital Transformation</span></h2>
            </div>
            <div class="process-grid">
                <div class="process-card-v4" data-aos="fade-up" data-aos-delay="0">
                    <div class="process-icon-wrap">
                        <i class="fas fa-search"></i>
                        <span class="process-num">01</span>
                    </div>
                    <h4>Discovery</h4>
                    <p>In-depth analysis of your brand narrative and market positioning.</p>
                </div>
                <div class="process-card-v4" data-aos="fade-up" data-aos-delay="100">
                    <div class="process-icon-wrap">
                        <i class="fas fa-lightbulb"></i>
                        <span class="process-num">02</span>
                    </div>
                    <h4>Strategy</h4>
                    <p>Architecting the roadmap for geometric growth and domination.</p>
                </div>
                <div class="process-card-v4" data-aos="fade-up" data-aos-delay="200">
                    <div class="process-icon-wrap">
                        <i class="fas fa-code"></i>
                        <span class="process-num">03</span>
                    </div>
                    <h4>Execution</h4>
                    <p>Precision engineering and high-fidelity design implementation.</p>
                </div>
                <div class="process-card-v4" data-aos="fade-up" data-aos-delay="300">
                    <div class="process-icon-wrap">
                        <i class="fas fa-rocket"></i>
                        <span class="process-num">04</span>
                    </div>
                    <h4>Expansion</h4>
                    <p>Global deployment and continuous strategic scaling.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════ STATS ═══════════════════════════════════ --}}
    <section class="v2-stats-wrap">
        <div class="container">
            <div class="v2-stats-grid">
                @foreach($stats as $index => $stat)
                    <div class="v2-stat-item" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                        <div class="stat-status-dot"></div>
                        <div class="v2-stat-icon"><i class="{{ $stat->icon_class }}"></i></div>
                        
                        @php
                            // Separate numeric value from suffix (e.g., 99.9% -> 99.9 and %)
                            preg_match('/([0-9.]+)(.*)/', $stat->stat_value, $matches);
                            $val = $matches[1] ?? 0;
                            $suffix = $matches[2] ?? '';
                        @endphp
                        
                        <h3 class="v2-stat-value">
                            <span class="v2-counter" data-target="{{ $val }}">{{ $val }}</span>{{ $suffix }}
                        </h3>
                        <p class="v2-stat-label">{{ $stat->stat_label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════ ABSTRACT FEATURE ═══════════════════════════════════ --}}
    <section class="v2-feature-abstract">
        <div class="mesh-gradient-v4"></div>
        <div class="container">
            <div class="abstract-content-v4" data-aos="zoom-out">
                <h2 class="abstract-title">Scale Your Vision With <br><span class="text-glow-primary">Absolute Confidence</span></h2>
                <p class="text-muted fs-5 mb-5 mx-auto" style="max-width: 600px;">We don't just build websites; we architect digital empires designed for speed, security, and impact.</p>
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

    {{-- ═══════════════════════════════════ TEAM ═══════════════════════════════════ --}}
    @if($teamMembers->isNotEmpty())
        <section class="v2-team-wrap">
            <div class="v2-mesh-glow"></div>
            <div class="container position-relative z-1">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="v2-badge-primary mb-3">ELITE CORE</span>
                    <h2 class="v2-section-title">Architects of <br><span class="text-glow-primary">The Vision</span></h2>
                </div>
                <div class="row g-4 justify-content-center">
                    @foreach($teamMembers as $index => $member)
                        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
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
                                <div class="team-info-v4 text-center">
                                    <h4><a href="{{ route('team.show', $member->id) }}" class="text-decoration-none" style="color: var(--v2-text-h);">{{ $member->name }}</a></h4>
                                    <p class="mb-3">{{ $member->position }}</p>
                                    <a href="{{ route('team.show', $member->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-4" style="font-size: 0.8rem;">View Profile</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ route('team') }}" class="btn-glass-v4 px-5">Strategic Directory</a>
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
                                        <div class="t-avatar-v4">
                                            <img src="{{ asset('assets/images/testimonials/' . ($testimonial->image ?? 'user.png')) }}"
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
                    <div class="swiper-pagination mt-5"></div>
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
    if (document.querySelector('.hero-thumbs-swiper')) {
        var thumbsSwiper = new Swiper('.hero-thumbs-swiper', {
            loop: true, spaceBetween: 20, slidesPerView: 2,
            freeMode: true, watchSlidesProgress: true,
            breakpoints: { 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } }
        });
        var mainSwiper = new Swiper('.hero-main-swiper', {
            loop: true, effect: 'fade', speed: 1000,
            autoplay: { delay: 6000, disableOnInteraction: false },
            thumbs: { swiper: thumbsSwiper },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.hero-swiper-next', prevEl: '.hero-swiper-prev' },
        });
    }

    if (document.querySelector('.testimonial-main-swiper')) {
        new Swiper('.testimonial-main-swiper', {
            loop: true, autoplay: { delay: 5000, disableOnInteraction: false },
            slidesPerView: 1, spaceBetween: 30,
            pagination: { el: '.testimonial-main-swiper .swiper-pagination', clickable: true },
            navigation: { nextEl: '.t-next-v4', prevEl: '.t-prev-v4' },
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
</script>
@endpush
