<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Login | Innovative IT Solutions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #0f172a; }
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .gradient-orb {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.15;
        }
        .orb-1 { top: -200px; right: -200px; background: #f05223; }
        .orb-2 { bottom: -200px; left: -200px; background: #1e293b; }
        
        .input-group input:focus {
            border-color: #f05223;
            box-shadow: 0 0 0 2px rgba(240, 82, 35, 0.2);
        }
        .btn-premium {
            background: linear-gradient(135deg, #f05223 0%, #7c2206 100%);
            transition: all 0.3s ease;
        }
        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(240, 82, 35, 0.3);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 overflow-hidden relative">
    
    <!-- Decorative Orbs -->
    <div class="gradient-orb orb-1"></div>
    <div class="gradient-orb orb-2"></div>

    <div class="max-w-md w-full relative z-10">
        <!-- Logo -->
        <div class="text-center mb-10">
            <img src="{{ asset('uploads/settings/'.\App\Models\SiteSetting::getValue('site_logo_light', 'logo.png')) }}" alt="Logo" class="h-16 mx-auto mb-4">
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Intern Portal</h1>
            <p class="text-slate-400 mt-2">Welcome back! Please login to your dashboard.</p>
        </div>

        <!-- Login Card -->
        <div class="glass-card rounded-3xl p-8 md:p-10">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('internship.login.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="input-group">
                    <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3.5 text-white placeholder-slate-500 transition-all focus:outline-none"
                        placeholder="intern@iits.com">
                </div>

                <div class="input-group">
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="text-sm font-semibold text-slate-300">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs font-medium text-slate-500 hover:text-[#f05223] transition-colors">Forgot password?</a>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3.5 text-white placeholder-slate-500 transition-all focus:outline-none"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-slate-700 bg-slate-800 text-[#f05223] focus:ring-[#f05223] transition-all">
                    <label for="remember" class="ml-2 text-sm text-slate-400">Remember me for 30 days</label>
                </div>

                <button type="submit" class="w-full btn-premium text-white font-bold py-4 rounded-xl shadow-lg shadow-red-900/20">
                    Sign In to Dashboard
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-slate-700/50 text-center">
                <p class="text-slate-400 text-sm">
                    Not an intern yet? 
                    <a href="{{ route('internship.landing') }}" class="text-[#f05223] font-bold hover:underline">Apply Now</a>
                </p>
            </div>
        </div>

        <!-- Footer Info -->
        <p class="text-center text-slate-500 text-xs mt-10">
            &copy; {{ date('Y') }} Innovative IT Solutions. All rights reserved.
        </p>
    </div>

</body>
</html>
