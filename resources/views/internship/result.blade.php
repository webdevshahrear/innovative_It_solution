@extends('layouts.frontend')
@section('title', 'Exam Result — Internship Program')

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
body.light-mode {
    background: #f8fafc;
    background-image: 
        radial-gradient(ellipse at 80% 20%, rgba(240, 82, 35, 0.08) 0%, transparent 40%),
        radial-gradient(ellipse at 20% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 40%);
}

.res-hero { padding:140px 0 60px; text-align:center; position: relative; z-index: 1; }
.res-card {
    background: rgba(15, 23, 42, 0.5); border:1px solid rgba(255,255,255,0.08);
    border-radius: 24px; padding: 50px; max-width: 650px; margin: 0 auto;
    position: relative; overflow:hidden; backdrop-filter: blur(20px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.3); transition: all 0.3s;
}
body.light-mode .res-card {
    background: rgba(255,255,255,0.8); border: 1px solid rgba(0,0,0,0.06); box-shadow: 0 15px 35px rgba(0,0,0,0.04);
}
.res-card::before {
    content:''; position:absolute; inset:0;
    background: radial-gradient(circle at top, rgba(255,255,255,0.03), transparent 70%);
    pointer-events: none;
}
.res-status-badge {
    display:inline-flex; align-items:center; gap:10px; padding:10px 24px;
    border-radius:50px; font-weight:800; font-size:1rem; letter-spacing:.08em;
    margin-bottom:24px; position:relative; z-index:2; text-transform:uppercase;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}
.res-status-badge.passed { background:linear-gradient(135deg, rgba(16,185,129,.2), rgba(16,185,129,.1)); color:#10b981; border:1px solid rgba(16,185,129,.4); animation:glow-pass 2s infinite alternate; }
.res-status-badge.failed { background:linear-gradient(135deg, rgba(220,38,38,.2), rgba(220,38,38,.1)); color:#ef4444; border:1px solid rgba(220,38,38,.4); box-shadow: 0 0 20px rgba(220,38,38,0.2); }

@keyframes glow-pass { from{box-shadow:0 0 15px rgba(16,185,129,.2)} to{box-shadow:0 0 40px rgba(16,185,129,.6)} }

.score-circle {
    width: 160px; height: 160px; border-radius: 50%;
    border: 10px solid rgba(255,255,255,0.05); margin: 0 auto 30px;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Outfit', sans-serif; font-size: 3rem; font-weight: 800;
    position: relative; z-index: 2; box-shadow: inset 0 0 30px rgba(0,0,0,0.3);
}
body.light-mode .score-circle { border-color: rgba(0,0,0,0.05); box-shadow: inset 0 0 20px rgba(0,0,0,0.05); }
.score-circle.passed { border-color: #10b981; color: #10b981; text-shadow: 0 4px 15px rgba(16,185,129,0.4); box-shadow: inset 0 0 30px rgba(16,185,129,0.2), 0 15px 35px rgba(16,185,129,0.15); }
.score-circle.failed { border-color: #ef4444; color: #ef4444; text-shadow: 0 4px 15px rgba(239,68,68,0.4); box-shadow: inset 0 0 30px rgba(239,68,68,0.2), 0 15px 35px rgba(239,68,68,0.15); }

.res-stats { display:flex; justify-content:center; gap:40px; margin-bottom:40px; position:relative; z-index:2; background:rgba(255,255,255,0.03); padding:20px; border-radius:20px; border:1px solid rgba(255,255,255,0.05); }
body.light-mode .res-stats { background: #f8fafc; border-color: #e2e8f0; }
.r-stat { text-align:center; }
.r-stat .num { font-size:2rem; font-weight:800; color:var(--text-main); display:block; font-family:'Outfit',sans-serif; line-height:1; }
.r-stat.win .num { color:#10b981; }
.r-stat.loss .num { color:#ef4444; }
.r-stat .lbl { font-size:.8rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:.1em; font-weight:700; margin-top:8px; display:block; }

.btn-act {
    background: linear-gradient(135deg, #f05223, #e04010); color:#fff;
    padding:18px 48px; border-radius:16px; font-weight:800; font-size:1.1rem; text-decoration:none;
    display:inline-block; transition:all .4s cubic-bezier(0.165, 0.84, 0.44, 1); position:relative; z-index:2;
    box-shadow: 0 10px 30px rgba(240,82,35,.3); border:none;
}
.btn-act:hover { transform:translateY(-4px); box-shadow: 0 15px 40px rgba(240,82,35,.5); color:#fff; }
</style>
@endpush

@section('content')
<section class="res-hero">
    <div class="container">
        
        <div class="res-card" data-aos="zoom-in">
            @if($attempt->isPassed())
                <div class="res-status-badge passed"><i class="fas fa-trophy"></i> Exam Passed</div>
                <h2 style="font-family:'Outfit';font-weight:800">Congratulations, {{ explode(' ', $attempt->application->full_name)[0] }}!</h2>
                <p style="color:var(--text-muted)">You have successfully passed the internship qualification exam.</p>
            @else
                <div class="res-status-badge failed"><i class="fas fa-times-circle"></i> Exam Failed</div>
                <h2 style="font-family:'Outfit';font-weight:800">Better luck next time.</h2>
                <p style="color:var(--text-muted)">Unfortunately, you did not meet the required {{ $passMark }}% mark to pass the exam.</p>
            @endif

            <div class="score-circle {{ $attempt->isPassed() ? 'passed' : 'failed' }}">
                {{ round($attempt->score_percentage) }}%
            </div>

            <div class="res-stats">
                <div class="r-stat">
                    <span class="num">{{ $attempt->total_questions }}</span>
                    <span class="lbl">Questions</span>
                </div>
                <div class="r-stat win">
                    <span class="num">{{ $attempt->correct_answers }}</span>
                    <span class="lbl">Correct</span>
                </div>
                <div class="r-stat loss">
                    <span class="num">{{ $attempt->wrong_answers }}</span>
                    <span class="lbl">Wrong</span>
                </div>
            </div>

            @if($attempt->isPassed())
                <div class="alert alert-info rounded-3 text-start mb-4" style="background:rgba(59,130,246,.1);border-color:rgba(59,130,246,.3);color:#60a5fa">
                    <i class="fas fa-info-circle me-2"></i> Only one step left! Proceed to pay the refundable security deposit to create your intern account.
                </div>
                <a href="{{ route('internship.payment', $attempt) }}" class="btn-act">
                    Proceed to Payment <i class="fas fa-arrow-right ms-2"></i>
                </a>
            @else
                <p style="font-size:.85rem;color:var(--text-muted)">You may re-apply after 30 days. Keep learning and improving your skills!</p>
                <a href="{{ route('internship.landing') }}" class="btn btn-outline-secondary rounded-5">Return to Home</a>
            @endif
        </div>

    </div>
</section>
@endsection
