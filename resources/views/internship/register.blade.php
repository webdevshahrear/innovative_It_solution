@extends('layouts.frontend')
@section('title', 'Create Intern Account — Innovative IT Solutions')

@push('styles')
<style>
/* Premium Dynamic Background */
body {
    background: #020617;
    background-image: 
        radial-gradient(ellipse at 80% 20%, rgba(240, 82, 35, 0.15) 0%, transparent 40%),
        radial-gradient(ellipse at 20% 80%, rgba(59, 130, 246, 0.15) 0%, transparent 40%);
    background-attachment: fixed;
}
[data-theme="light"] body {
    background: #f8fafc;
    background-image: 
        radial-gradient(ellipse at 80% 20%, rgba(240, 82, 35, 0.08) 0%, transparent 40%),
        radial-gradient(ellipse at 20% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 40%);
}

.reg-hero { padding: 140px 0 50px; text-align:center; position: relative; z-index: 1; }
.reg-hero h1 { font-family:'Outfit',sans-serif;font-weight:800;font-size:clamp(2.2rem,4vw,3rem);color:var(--text-primary); margin-bottom:15px; letter-spacing:-0.02em; }

.hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(240,82,35,0.1); border: 1px solid rgba(240,82,35,0.2);
    color: #f05223; border-radius: 50px; padding: 8px 24px; font-size: 0.9rem;
    font-weight: 700; letter-spacing: 0.05em; margin-bottom: 24px;
    box-shadow: 0 0 20px rgba(240,82,35,0.15);
}

.reg-card { 
    background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255,255,255,0.08); 
    border-radius: 24px; padding: 50px; max-width: 550px; margin: 0 auto; 
    box-shadow: 0 25px 50px rgba(0,0,0,0.2); backdrop-filter: blur(20px);
    transition: all 0.3s;
}
[data-theme="light"] .reg-card {
    background: rgba(255,255,255,0.8); border: 1px solid rgba(0,0,0,0.06); box-shadow: 0 15px 35px rgba(0,0,0,0.04);
}
.reg-card:hover { border-color: rgba(240, 82, 35, 0.3); box-shadow: 0 30px 60px rgba(0,0,0,0.3); transform: translateY(-3px); }

.form-label { font-size:0.9rem;color:var(--text-secondary);font-weight:600;margin-bottom:8px; }
.form-control-int {
    background: rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1);
    border-radius:14px; color:var(--text-primary); padding:14px 18px; width:100%;
    transition: all 0.3s; font-size: 1rem;
}
[data-theme="light"] .form-control-int { background: #fff; border-color: #cbd5e1; }
.form-control-int:focus { outline:none; border-color:#f05223; box-shadow:0 0 0 4px rgba(240,82,35,.15); background: rgba(255,255,255,0.05); }

.btn-reg { 
    background:linear-gradient(135deg,#f05223,#e04010); color:#fff; border:none; 
    padding:16px; width:100%; border-radius:16px; font-weight:800; font-size:1.1rem;
    cursor:pointer; transition:all 0.4s; box-shadow:0 10px 30px rgba(240,82,35,.3); 
}
.btn-reg:hover { transform:translateY(-3px); box-shadow:0 15px 40px rgba(240,82,35,.5); }

.avatar-wrapper { position: relative; display: inline-block; }
.avatar-wrapper::after { content:''; position:absolute; bottom:5px; right:5px; width:15px; height:15px; background:#10b981; border-radius:50%; border:3px solid var(--v2-card); }
</style>
@endpush

@section('content')
<section class="reg-hero">
    <div class="container">
        <div class="hero-badge mx-auto mb-3"><i class="fas fa-user-plus"></i> Final Step 5 of 5</div>
        <h1>Create Your Intern Account</h1>
        <p style="color:var(--text-secondary)">Your payment is verified. Set a password to access your dashboard.</p>
    </div>
</section>

<section class="py-4 pb-section">
    <div class="container">
        <div class="reg-card" data-aos="zoom-in">
            @if(session('error')) <div class="alert alert-danger rounded-3">{{ session('error') }}</div> @endif

            <form action="{{ route('internship.register.store', $token) }}" method="POST">
                @csrf
                <div class="mb-4 text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($account->application->full_name) }}&background=f05223&color=fff&size=80&rounded=true" alt="Avatar" class="mb-3">
                    <h5 style="font-weight:700;color:var(--text-primary);margin:0">{{ $account->application->full_name }}</h5>
                    <div style="color:var(--text-secondary);font-size:.85rem">{{ $account->application->email }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control-int" placeholder="Min 8 characters" required>
                    @error('password')<small style="color:#f05223">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control-int" required>
                </div>

                <button type="submit" class="btn-reg">Complete Setup & Go to Dashboard <i class="fas fa-arrow-right ms-2"></i></button>
            </form>
        </div>
    </div>
</section>
@endsection
