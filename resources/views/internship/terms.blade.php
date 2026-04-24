@extends('layouts.frontend')
@section('title', 'Terms & Conditions — Internship Program')

@push('styles')
<style>
/* Premium Dynamic Background */
body {
    background: var(--navy-dark);
    background-image: var(--v2-mesh);
    background-attachment: fixed;
    transition: var(--transition-theme);
}

.terms-hero { padding:140px 0 50px; position:relative; z-index:1; }
.terms-hero h1 { font-family:'Outfit',sans-serif;font-weight:800;font-size:clamp(2rem,4vw,3.2rem);color:var(--white); letter-spacing:-0.02em; }

.hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(240,82,35,0.1); border: 1px solid rgba(240,82,35,0.2);
    color: #f05223; border-radius: 50px; padding: 8px 24px; font-size: 0.9rem;
    font-weight: 700; letter-spacing: 0.05em; margin-bottom: 24px;
    box-shadow: 0 0 20px rgba(240,82,35,0.15);
}

.terms-body { 
    background: var(--card-bg); border:1px solid var(--border); 
    border-radius:24px; padding:40px 50px; backdrop-filter: blur(20px); 
    box-shadow: var(--glass-shadow); transition: all 0.3s; 
}
body.light-mode .terms-body {
    background: #ffffff;
    box-shadow: 0 15px 35px rgba(0,0,0,0.04);
}
.terms-body:hover { border-color: rgba(240, 82, 35, 0.2); box-shadow: 0 30px 60px rgba(0,0,0,0.3); }

.term-item { border-bottom: 1px solid var(--border); padding:24px 0; }
.term-item:last-child { border-bottom:none; }
.term-num {
    width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg, rgba(240,82,35,0.2), rgba(240,82,35,0.05));
    color:#f05223; display:inline-flex; align-items:center; justify-content:center;
    font-weight:800; font-size:1rem; flex-shrink:0; margin-right:16px; border:1px solid rgba(240,82,35,0.3);
    font-family:'Outfit',sans-serif;
}
.term-title { font-family:'Outfit',sans-serif; font-weight:700; font-size:1.2rem; color:var(--white); margin-bottom:12px; display:flex; align-items:center; }
.term-content { color:var(--text-muted); font-size:1rem; line-height:1.7; padding-left:56px; }
.term-content ul { padding-left:24px; margin:10px 0 0; }
.term-content li { margin-bottom:8px; position:relative; }

/* Sticky accept box */
.accept-box {
    position:sticky; top:120px; background: var(--card-bg);
    border:1px solid var(--border); border-radius:24px; padding:32px;
    backdrop-filter: blur(20px); box-shadow: var(--glass-shadow);
}
body.light-mode .accept-box {
    background: #ffffff;
    box-shadow: 0 15px 35px rgba(0,0,0,0.04);
}
.accept-box h5 { font-family:'Outfit',sans-serif; font-weight:700; font-size:1.3rem; color:var(--white); margin-bottom:20px; }
.accept-check-wrap {
    background:rgba(255,255,255,0.03); border:1px solid var(--border);
    border-radius:16px; padding:20px; margin-bottom:24px;
    display:flex; align-items:flex-start; gap:16px; cursor:pointer; transition:all 0.3s;
}
body.light-mode .accept-check-wrap { background: #f8fafc; border-color: #cbd5e1; }
.accept-check-wrap:hover { border-color:rgba(240,82,35,0.4); background:rgba(240,82,35,0.05); }
.accept-check-wrap input[type=checkbox] { width:24px; height:24px; cursor:pointer; accent-color:#f05223; flex-shrink:0; margin-top:2px; }
.accept-check-label { font-size:0.95rem; color:var(--text-muted); cursor:pointer; line-height:1.5; }

.btn-proceed {
    width:100%; background:linear-gradient(135deg,#f05223,#e04010); color:#fff;
    border:none; border-radius:16px; padding:18px; font-weight:800; font-size:1.1rem;
    cursor:pointer; transition:all .4s; box-shadow: 0 10px 30px rgba(240,82,35,.3);
    opacity:.5; pointer-events:none; position:relative; overflow: hidden;
}
.btn-proceed.enabled { opacity:1; pointer-events:auto; }
.btn-proceed.enabled:hover { transform:translateY(-3px); box-shadow: 0 15px 40px rgba(240,82,35,.5); }

.app-summary-item { display:flex; justify-content:space-between; font-size:0.95rem; padding:10px 0; border-bottom:1px dashed var(--border); }
.app-summary-item:last-child { border-bottom:none; }
.app-summary-item .lbl { color:var(--text-muted); font-weight:500; }
.app-summary-item .val { color:var(--white); font-weight:700; text-align:right;}
</style>
@endpush

@section('content')
<section class="terms-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="hero-badge mb-3"><i class="fas fa-file-contract"></i> Step 2 of 5 — Terms & Conditions</div>
                <h1>Please Read Before Proceeding</h1>
                <p style="color:var(--text-secondary)">Read all terms carefully. You must accept before taking the exam.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-4 pb-section">
    <div class="container">
        @if (session('success'))
        <div class="alert alert-success rounded-4 mb-4"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            {{-- Terms Content --}}
            <div class="col-lg-8" data-aos="fade-right">
                <div class="terms-body">
                    @if (session('error'))
                    <div class="alert alert-danger rounded-4 mb-4"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</div>
                    @endif
                    
                    @php
                    $terms = [
                        ['title'=>'Program Duration', 'icon'=>'fas fa-calendar', 'content'=>'The internship program lasts <strong>3 calendar months</strong> from the date of your account activation. Extensions may be granted at admin discretion based on performance.'],
                        ['title'=>'Security Deposit', 'icon'=>'fas fa-lock', 'content'=>'A refundable security fee of <strong>৳1,000 BDT</strong> is required after passing the exam. This deposit is fully refunded upon successful completion of the program. The deposit is <strong>non-refundable</strong> if you leave before completion without valid reason.'],
                        ['title'=>'No Fixed Salary', 'icon'=>'fas fa-money-bill', 'content'=>'This is a skill-development internship. There is <strong>no fixed monthly salary</strong>. Compensation is commission-based on projects delivered or client work completed under supervision. Income is not guaranteed.'],
                        ['title'=>'Commitment & Availability', 'icon'=>'fas fa-clock', 'content'=>'You must be available for a minimum of <strong>4 hours per day, 5 days per week</strong>. Consistent absence without notification may result in account suspension without refund.'],
                        ['title'=>'Exam Rules', 'icon'=>'fas fa-brain', 'content'=>'<ul><li>The MCQ exam has <strong>20 questions</strong> with a <strong>30-minute time limit</strong>.</li><li>Passing score: <strong>60%</strong> (12 correct answers).</li><li>Switching browser tabs, minimizing the window, or any focus loss will <strong>immediately terminate</strong> the exam.</li><li>You must re-apply after <strong>30 days</strong> if you fail or cheat.</li></ul>'],
                        ['title'=>'Task Completion', 'icon'=>'fas fa-tasks', 'content'=>'Tasks assigned by your mentor must be submitted before the deadline. Late submissions may receive reduced scores. Repeated missed deadlines may result in account suspension.'],
                        ['title'=>'Professional Conduct', 'icon'=>'fas fa-user-tie', 'content'=>'All interns must maintain professional behavior in all communications. Harassment, plagiarism, or submitting AI-generated work as your own is grounds for immediate termination without refund.'],
                        ['title'=>'Certificate Eligibility', 'icon'=>'fas fa-certificate', 'content'=>'Certificates are issued upon completing the program with a <strong>minimum performance score of 60%</strong> and at least <strong>5 approved tasks</strong>. Certificates are digitally signed and verifiable.'],
                        ['title'=>'Data & Privacy', 'icon'=>'fas fa-shield-alt', 'content'=>'Your application data (name, email, phone, CV) is stored securely and used only for internship management purposes. We do not sell or share your data with third parties.'],
                        ['title'=>'Agreement', 'icon'=>'fas fa-handshake', 'content'=>'By accepting these terms, you confirm that all information provided in your application is truthful. Providing false information will result in immediate disqualification.'],
                    ];
                    @endphp

                    @foreach($terms as $i => $term)
                    <div class="term-item">
                        <div class="term-title">
                            <span class="term-num">{{ $i+1 }}</span>
                            <i class="{{ $term['icon'] }} me-2" style="color:#f05223"></i>
                            {{ $term['title'] }}
                        </div>
                        <div class="term-content">{!! $term['content'] !!}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Sticky Accept Box --}}
            <div class="col-lg-4" data-aos="fade-left">
                <div class="accept-box">
                    <h5><i class="fas fa-user-check me-2" style="color:#f05223"></i>Your Application</h5>

                    <div class="mb-3">
                        <div class="app-summary-item">
                            <span class="lbl">Name</span>
                            <span class="val">{{ $application->full_name }}</span>
                        </div>
                        <div class="app-summary-item">
                            <span class="lbl">Email</span>
                            <span class="val" style="word-break:break-all">{{ $application->email }}</span>
                        </div>
                        <div class="app-summary-item">
                            <span class="lbl">Category</span>
                            <span class="val">{{ $application->preferredCategory->name }}</span>
                        </div>
                        <div class="app-summary-item">
                            <span class="lbl">Exam Duration</span>
                            <span class="val" style="color:#f05223">30 Minutes</span>
                        </div>
                        <div class="app-summary-item">
                            <span class="lbl">Pass Mark</span>
                            <span class="val" style="color:#f05223">60% (12/20)</span>
                        </div>
                    </div>

                    {{-- Timer Alert --}}
                    <div id="countdownAlert" class="alert alert-info rounded-4 border-0 mb-3 d-flex align-items-center gap-3" style="background:rgba(59,130,246,0.1); color:#60a5fa; font-size:0.9rem">
                        <div id="timerSpinner" class="spinner-border spinner-border-sm" role="status"></div>
                        <span>Please read the terms carefully. You can proceed in <strong id="timerCounter">60</strong>s.</span>
                    </div>

                    <form action="{{ route('internship.terms.accept', $application) }}" method="POST">
                    @csrf

                    <div class="accept-check-wrap" onclick="toggleAccept(event)">
                        <input type="checkbox" name="terms_accepted" id="termsCheck" value="1">
                        <label class="accept-check-label" for="termsCheck">
                            I have read, understood, and agree to all the terms & conditions of the Innovative IT Solutions Internship Program.
                        </label>
                    </div>

                    <button type="submit" class="btn-proceed" id="proceedBtn">
                        <i class="fas fa-arrow-right me-2"></i> Accept & Start Exam
                    </button>

                    </form>

                    <div class="mt-3 text-center" style="font-size:.75rem;color:var(--text-muted)">
                        <i class="fas fa-shield-alt me-1"></i> Accepted at {{ now()->format('d M Y, h:i A') }}
                    </div>

                    @error('terms_accepted')
                    <div class="alert alert-danger mt-3 rounded-3" style="font-size:.82rem">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
let timeLeft = 60;
let timerComplete = false;
const timerBtn = document.getElementById('proceedBtn');
const timerCounter = document.getElementById('timerCounter');
const countdownAlert = document.getElementById('countdownAlert');
const timerSpinner = document.getElementById('timerSpinner');
const termsCheck = document.getElementById('termsCheck');

const countdown = setInterval(() => {
    timeLeft--;
    if (timerCounter) timerCounter.innerText = timeLeft;
    
    if (timeLeft <= 0) {
        clearInterval(countdown);
        timerComplete = true;
        if (countdownAlert) {
            countdownAlert.style.background = 'rgba(16,185,129,0.1)';
            countdownAlert.style.color = '#34d399';
            countdownAlert.innerHTML = '<i class="fas fa-check-circle"></i> <span>Reading time complete. You may now proceed.</span>';
        }
        updateProceedButton();
    }
}, 1000);

function updateProceedButton() {
    const isChecked = termsCheck.checked;
    if (timerComplete && isChecked) {
        timerBtn.classList.add('enabled');
    } else {
        timerBtn.classList.remove('enabled');
    }
}

function toggleAccept(event) {
    const cb = document.getElementById('termsCheck');
    // If the target is NOT the checkbox and NOT the label, we toggle it manually.
    // Labels with 'for' attribute and checkboxes handle their own toggles in the browser.
    if (event.target !== cb && event.target.tagName !== 'LABEL') {
        cb.checked = !cb.checked;
        updateProceedButton();
    }
}

termsCheck.addEventListener('change', updateProceedButton);
</script>
@endpush
