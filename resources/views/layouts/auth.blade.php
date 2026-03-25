<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Authentication</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <style>
        :root {
            --v3-bg: #030712;
            --v3-accent: #6366f1;
            --v3-accent-glow: rgba(99, 102, 241, 0.4);
            --v3-card: rgba(17, 24, 39, 0.7);
            --v3-border: rgba(255, 255, 255, 0.1);
            --v3-text-muted: #9ca3af;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--v3-bg);
            color: white;
            overflow: hidden;
        }

        .auth-grid {
            position: absolute;
            inset: 0;
            background-image: 
                radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0);
            background-size: 40px 40px;
            z-index: 1;
        }

        .auth-glow-1 {
            position: absolute;
            top: -10%;
            right: -10%;
            width: 50%;
            height: 50%;
            background: radial-gradient(circle, var(--v3-accent-glow) 0%, transparent 70%);
            z-index: 2;
        }

        .auth-glow-2 {
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.2) 0%, transparent 70%);
            z-index: 2;
        }

        .auth-container {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background: var(--v3-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--v3-border);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .auth-logo img {
            height: 48px;
            margin-bottom: 1rem;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .auth-header h1 {
            font-size: 1.875rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, #fff, #9ca3af);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-header p {
            color: var(--v3-text-muted);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--v3-text-muted);
            margin-bottom: 0.75rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--v3-text-muted);
            font-size: 1rem;
            transition: color 0.3s;
        }

        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--v3-border);
            border-radius: 14px;
            padding: 0.875rem 1.25rem 0.875rem 3.25rem;
            color: white;
            font-size: 0.95rem;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--v3-accent);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .form-control:focus + i {
            color: var(--v3-accent);
        }

        .auth-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            font-size: 0.875rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            color: var(--v3-text-muted);
        }

        .remember-me input {
            accent-color: var(--v3-accent);
        }

        .forgot-password {
            color: var(--v3-accent);
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.3s;
        }

        .forgot-password:hover {
            opacity: 0.8;
        }

        .btn-auth {
            width: 100%;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            border: none;
            border-radius: 14px;
            padding: 1rem;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.4);
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #f87171;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="auth-grid"></div>
    <div class="auth-glow-1"></div>
    <div class="auth-glow-2"></div>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <a href="/">
                    @php
                        $siteLogo = \App\Models\SiteSetting::getValue('site_logo', 'logo.png');
                    @endphp
                    @if(file_exists(public_path('uploads/settings/'.$siteLogo)))
                        <img src="{{ asset('uploads/settings/'.$siteLogo) }}" alt="Logo">
                    @else
                        <div style="font-size: 2rem; font-weight: 800; color: var(--v3-accent);">WBL</div>
                    @endif
                </a>
            </div>

            <div class="auth-header">
                <h1>Welcome Back</h1>
                <p>Uplink to your control terminal</p>
            </div>

            @yield('content')
        </div>
    </div>
</body>
</html>
