@extends('layouts.frontend')
@section('title', 'Security Deposit Payment — Internship Program')

@push('styles')
<style>
/* Premium Dynamic Background */
body {
    background: var(--navy-dark);
    background-image: var(--v2-mesh);
    background-attachment: fixed;
    transition: var(--transition-theme);
}

.pay-hero { padding: 140px 0 50px; position: relative; z-index: 1; }
.pay-hero h1 { font-family:'Outfit',sans-serif;font-weight:800;font-size:clamp(2.2rem,4vw,3rem);color:var(--white); letter-spacing:-0.02em; }

.hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(240,82,35,0.1); border: 1px solid rgba(240,82,35,0.2);
    color: #f05223; border-radius: 50px; padding: 8px 24px; font-size: 0.9rem;
    font-weight: 700; letter-spacing: 0.05em; margin-bottom: 24px;
    box-shadow: 0 0 20px rgba(240,82,35,0.15);
}

.pay-card { 
    background: var(--card-bg); border: 1px solid var(--border); 
    border-radius: 24px; padding: 40px; box-shadow: var(--glass-shadow);
    backdrop-filter: blur(20px); transition: all 0.3s;
}
body.light-mode .pay-card {
    background: #ffffff;
    box-shadow: 0 15px 35px rgba(0,0,0,0.04);
}
.pay-card:hover { border-color: rgba(240, 82, 35, 0.2); box-shadow: 0 25px 50px rgba(0,0,0,0.3); }

.pay-card-title { font-family:'Outfit',sans-serif;font-weight:700;font-size:1.4rem;margin-bottom:24px;display:flex;align-items:center;gap:12px; color:var(--white); }
.pay-card-title i { background: rgba(240,82,35,0.15); color: #f05223; padding: 10px; border-radius: 12px; font-size: 1.2rem; }

.amt-box {
    background: linear-gradient(135deg, rgba(240,82,35,0.1), rgba(240,82,35,0.02)); border:1px solid rgba(240,82,35,.3);
    border-radius:20px; padding:32px; text-align:center; margin-bottom:30px; position:relative; overflow:hidden;
}
.amt-box::before { content:''; position:absolute; top:0; left:0; width:100%; height:4px; background:linear-gradient(90deg, #f05223, #ff7849); }
.amt-lbl { font-size:.9rem;color:#f05223;font-weight:800;text-transform:uppercase;letter-spacing:.1em;margin-bottom:12px; }
.amt-val { font-family:'Outfit',sans-serif;font-weight:800;font-size:3.5rem;color:var(--white); line-height:1; }

.gateway-btn {
    width:100%; display:flex; align-items:center; justify-content:center; gap:12px;
    padding:18px; border-radius:16px; font-weight:800; font-size:1.1rem; cursor:pointer;
    transition:all .4s cubic-bezier(0.165, 0.84, 0.44, 1); border:none;
}
.btn-ssl { background:#fff; color:#1a1a1a; box-shadow:0 10px 25px rgba(255,255,255,.15); }
body.light-mode .btn-ssl { background: #f8fafc; border: 1px solid #cbd5e1; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
.btn-ssl:hover { transform:translateY(-4px); box-shadow:0 15px 35px rgba(255,255,255,.25); }
.btn-ssl img { height:28px; }

/* tabs */
.pay-tabs { display:flex; gap:8px; margin-bottom:24px; background:rgba(255,255,255,0.03); padding:8px; border-radius:16px; border:1px solid var(--border); }
body.light-mode .pay-tabs { background: #f1f5f9; border-color: #e2e8f0; }
.pay-tab { flex:1; text-align:center; padding:12px; border-radius:12px; font-weight:700; font-size:1rem; color:var(--text-muted); cursor:pointer; transition:.3s; }
.pay-tab.active { background:var(--navy-light); color:var(--white); box-shadow:0 8px 20px rgba(0,0,0,.2); border:1px solid var(--border); }
body.light-mode .pay-tab.active { background: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-color: #cbd5e1; color: var(--navy-dark); }

.tab-pane { display:none; }
.tab-pane.active { display:block; animation:fade-slide-up .4s cubic-bezier(0.165, 0.84, 0.44, 1); }
@keyframes fade-slide-up{from{opacity:0;transform:translateY(15px)}to{opacity:1;transform:translateY(0)}}

/* bkash */
.bkash-box { background:linear-gradient(135deg, #e2136e, #c00e5a); border-radius:20px; padding:32px; color:#fff; box-shadow:0 15px 35px rgba(226,19,110,0.3); border:1px solid rgba(255,255,255,0.2); }
.bkash-step { display:flex; gap:16px; margin-bottom:16px; font-size:.95rem; align-items:center; }
.bkash-step .n { width:30px;height:30px;background:rgba(255,255,255,0.2);backdrop-filter:blur(5px);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.85rem;flex-shrink:0; border:1px solid rgba(255,255,255,0.3); }
.bkash-input { background:rgba(0,0,0,.2); border:1px solid rgba(255,255,255,.2); color:#fff; border-radius:12px; padding:16px; width:100%; transition:.3s; font-size:1rem; }
.bkash-input:focus { outline:none; border-color:#fff; background:rgba(0,0,0,.3); box-shadow:0 0 0 4px rgba(255,255,255,0.1); }
.bkash-input::placeholder { color:rgba(255,255,255,.5); }
.btn-bkash-submit { background:#fff; color:#e2136e; border:none; padding:16px; border-radius:12px; width:100%; font-weight:800; font-size:1.1rem; margin-top:20px; cursor:pointer; transition:.3s; box-shadow:0 8px 20px rgba(0,0,0,0.15); }
.btn-bkash-submit:hover { transform:translateY(-2px); box-shadow:0 12px 25px rgba(0,0,0,0.2); }

.inc-list { list-style:none; padding:0; margin:0; }
.inc-list li { display:flex; align-items:flex-start; gap:16px; margin-bottom:24px; color:var(--text-muted); font-size:.95rem; line-height:1.5; }
.inc-list li i { color:#10b981; margin-top:4px; font-size:1.1rem; background:rgba(16,185,129,0.1); padding:6px; border-radius:8px; }
.inc-list li strong { color:var(--white); font-size:1.05rem; display:block; margin-bottom:4px; font-weight:700; }
</style>
@endpush

@section('content')
<section class="pay-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="hero-badge mb-3"><i class="fas fa-lock"></i> Step 4 of 5 — Security Deposit</div>
                <h1>Secure Your Internship Spot</h1>
            </div>
        </div>
    </div>
</section>

<section class="py-4 pb-section">
    <div class="container">
        <div class="row g-4">
            {{-- Left: Payment Box --}}
            <div class="col-lg-7" data-aos="fade-right">
                <div class="pay-card">
                    <div class="amt-box">
                        <div class="amt-lbl">Refundable Security Fee</div>
                        <div class="amt-val">৳{{ number_format($amount) }}</div>
                        <div class="mt-2" style="font-size:.8rem;color:var(--text-secondary)">Refunded upon successful completion of the 3-month program.</div>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger rounded-3">{{ session('error') }}</div>
                    @endif

                    <div class="pay-tabs">
                        @if($sslConfigured)<div class="pay-tab active" onclick="switchTab('ssl')"><i class="fas fa-credit-card me-2"></i> Card / Net Banking</div>@endif
                        @if($bkashConfigured)<div class="pay-tab {{ !$sslConfigured ? 'active' : '' }}" onclick="switchTab('bkash')"><i class="fas fa-mobile-alt me-2"></i> bKash</div>@endif
                    </div>

                    {{-- SSLCommerz --}}
                    @if($sslConfigured)
                    <div class="tab-pane active" id="tab-ssl">
                        <p style="color:var(--text-secondary);font-size:.9rem;text-align:center;margin-bottom:24px;">Pay securely via SSLCommerz using any Debit/Credit card, MFS (bKash, Nagad), or Net Banking.</p>
                        
                        <form action="{{ route('internship.payment.ssl', $attempt) }}" method="POST">
                            @csrf
                            <button type="submit" class="gateway-btn btn-ssl">
                                Pay via <img src="https://securepay.sslcommerz.com/public/image/SSLCommerz-Pay-With-logo-All-Size-03.png" alt="SSLCommerz" style="height:25px">
                            </button>
                        </form>
                    </div>
                    @endif

                    {{-- bKash Manual --}}
                    @if($bkashConfigured)
                    <div class="tab-pane {{ !$sslConfigured ? 'active' : '' }}" id="tab-bkash">
                        <div class="bkash-box">
                            <div class="text-center mb-4"><img src="https://scripts.sandbox.bka.sh/resources/img/bkash_logo.png" alt="bKash" height="35"></div>
                            
                            @foreach($bkashInfo['steps'] as $i => $step)
                            <div class="bkash-step"><div class="n">{{ $i+1 }}</div><div>{!! $step !!}</div></div>
                            @endforeach

                            <hr style="border-color:rgba(255,255,255,.2);margin:24px 0">

                            <form action="{{ route('internship.payment.bkash', $attempt) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" style="font-size:.85rem">Your bKash Account Number</label>
                                    <input type="text" name="bkash_number" class="bkash-input" placeholder="e.g. 017XXXXXXXX" value="{{ old('bkash_number') }}" required>
                                    @error('bkash_number')<small class="text-white mt-1 d-block">{{ $message }}</small>@enderror
                                </div>
                                <div>
                                    <label class="form-label" style="font-size:.85rem">bKash Transaction ID (TrxID)</label>
                                    <input type="text" name="bkash_transaction_id" class="bkash-input" placeholder="e.g. 9J5A9Z8B" value="{{ old('bkash_transaction_id') }}" required>
                                    @error('bkash_transaction_id')<small class="text-white mt-1 d-block">{{ $message }}</small>@enderror
                                </div>
                                <button type="submit" class="btn-bkash-submit">Submit Payment for Verification</button>
                            </form>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Right: What's included --}}
            <div class="col-lg-5" data-aos="fade-left">
                <div class="pay-card h-100" style="background:var(--bg-secondary)">
                    <div class="pay-card-title"><i class="fas fa-box-open" style="color:#f05223"></i> What's Included?</div>
                    <ul class="inc-list">
                        <li><i class="fas fa-check"></i> <div><strong>Instant Account Activation</strong><br>Access to your personal intern dashboard immediately.</div></li>
                        <li><i class="fas fa-check"></i> <div><strong>Dedicated Mentor</strong><br>An experienced senior dev/designer assigned to guide you.</div></li>
                        <li><i class="fas fa-check"></i> <div><strong>Live Client Projects</strong><br>Gain real-world experience, not just theoretical tasks.</div></li>
                        <li><i class="fas fa-check"></i> <div><strong>Commission Earnings</strong><br>Earn money for successfully completing client deliverables.</div></li>
                        <li><i class="fas fa-check"></i> <div><strong>Verifiable Certificate</strong><br>Digital certificate upon completion featuring your performance grade.</div></li>
                    </ul>
                    
                    <div class="mt-4 p-3 rounded-3" style="background:rgba(240,82,35,.1);border:1px solid rgba(240,82,35,.2)">
                        <h6 style="color:#f05223;font-size:.9rem;font-weight:700;margin-bottom:8px"><i class="fas fa-shield-alt me-2"></i>Refund Policy</h6>
                        <p style="font-size:.8rem;color:var(--text-secondary);margin:0">The deposit is refunded via bank transfer or MFS within 7 days after the 3-month program concludes successfully.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function switchTab(tabId) {
    document.querySelectorAll('.pay-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    
    event.currentTarget.classList.add('active');
    document.getElementById('tab-' + tabId).classList.add('active');
}
</script>
@endpush
