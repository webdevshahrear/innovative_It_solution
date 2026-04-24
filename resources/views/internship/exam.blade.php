<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Exam — Innovative IT Solutions</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-primary: #020617;
            --bg-secondary: rgba(15, 23, 42, 0.6);
            --v2-card: rgba(15, 23, 42, 0.5);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --primary: #f05223;
        }
        
        body {
            background-color: var(--bg-primary);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(240, 82, 35, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(59, 130, 246, 0.15) 0%, transparent 40%);
            background-size: 200% 200%;
            animation: mesh-move 15s ease infinite alternate;
            background-attachment: fixed;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            user-select: none; /* Prevent text selection */
        }
        
        @keyframes mesh-move {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }
        
        /* ── Anti Tab Switch Banner ── */
        .anti-cheat-banner {
            background: linear-gradient(90deg, #dc2626, #ef4444); color: #fff; text-align: center; font-weight: 800;
            padding: 10px; font-size: 0.9rem; letter-spacing: 0.08em; text-transform: uppercase;
            position: sticky; top: 0; z-index: 1000;
            box-shadow: 0 5px 20px rgba(220,38,38,0.4);
        }
        
        /* ── Header ── */
        .exam-header {
            background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid var(--border-color);
            padding: 16px 0; backdrop-filter: blur(20px);
            position: sticky; top: 38px; z-index: 999;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .timer-box {
            background: rgba(240,82,35,0.08); border: 1px solid rgba(240,82,35,0.3);
            color: #f05223; border-radius: 12px; padding: 10px 20px;
            font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.3rem;
            display: inline-flex; align-items: center; gap: 10px;
            box-shadow: 0 5px 15px rgba(240,82,35,0.15);
            transition: all 0.3s;
        }
        .timer-box.danger {
            background: rgba(220,38,38,0.1); border-color: rgba(220,38,38,0.4); color: #ef4444;
            animation: pulse-danger 1s infinite alternate;
        }
        @keyframes pulse-danger { from { box-shadow:0 0 0 rgba(220,38,38,0); transform:scale(1); } to { box-shadow:0 0 20px rgba(220,38,38,0.6); transform:scale(1.05); } }
        
        /* ── Sidebar ── */
        .q-nav-box {
            background: var(--v2-card); border: 1px solid var(--border-color);
            border-radius: 20px; padding: 28px; position: sticky; top: 120px;
            backdrop-filter: blur(20px); box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .q-pills { display: flex; flex-wrap: wrap; gap: 12px; }
        .q-pill {
            width: 42px; height: 42px; border-radius: 12px;
            background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-secondary); display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 700; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Outfit', sans-serif;
        }
        .q-pill:hover { border-color: rgba(255,255,255,0.3); color: var(--text-primary); transform:translateY(-2px); }
        .q-pill.answered { background: rgba(59,130,246,0.15); border-color: #3b82f6; color: #60a5fa; }
        .q-pill.active { background: linear-gradient(135deg, #f05223, #e04010); border-color: transparent; color: #fff; box-shadow: 0 8px 20px rgba(240,82,35,0.4); transform:scale(1.1); }
        
        /* ── Question Card ── */
        .q-card {
            background: var(--v2-card); border: 1px solid var(--border-color);
            border-radius: 24px; padding: 48px; display: none;
            backdrop-filter: blur(20px); box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            transition: all 0.3s;
        }
        .q-card.active { 
            display: block; 
            animation: fade-slide-in 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
            box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 30px rgba(240,82,35,0.08);
            border-color: rgba(255,255,255,0.12);
        }
        @keyframes fade-slide-in { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
        
        .q-text { font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; margin-bottom: 30px; line-height: 1.5; text-shadow: 0 2px 10px rgba(0,0,0,0.5); }
        
        .option-label {
            display: flex; align-items: center; gap: 20px; width: 100%;
            background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px; padding: 20px 24px; margin-bottom: 16px;
            cursor: pointer; transition: all 0.3s; font-size: 1.1rem; color: var(--text-primary);
        }
        .option-label:hover { border-color: rgba(255,255,255,0.2); background: rgba(255,255,255,0.05); transform:translateX(5px); }
        .option-input:checked + .option-label {
            background: rgba(59,130,246,0.1); border-color: #3b82f6;
            box-shadow: 0 10px 25px rgba(59,130,246,0.2); transform:translateX(10px);
        }
        .option-input:checked + .option-label .opt-char {
            background: linear-gradient(135deg, #3b82f6, #60a5fa); color: #fff; box-shadow: 0 4px 10px rgba(59,130,246,0.4); border-color:transparent;
        }
        .opt-char {
            width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center; font-weight: 800;
            color: var(--text-secondary); transition: all 0.3s; flex-shrink: 0; font-family:'Outfit',sans-serif;
        }
        
        /* ── Terminated Overlay ── */
        .terminated-overlay {
            position: fixed; inset: 0; background: rgba(2,6,23,0.95); z-index: 9999;
            display: none; align-items: center; justify-content: center; backdrop-filter: blur(20px);
        }
        .term-box {
            background: rgba(15,23,42,0.8); border: 1px solid rgba(220,38,38,0.5); border-radius: 24px;
            padding: 60px; text-align: center; max-width: 560px;
            box-shadow: 0 30px 80px rgba(220,38,38,0.3); position:relative; overflow:hidden;
        }
        .term-box::before { content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:linear-gradient(90deg,transparent,#dc2626,transparent); }
        .term-icon { font-size: 5rem; color: #ef4444; margin-bottom: 24px; animation: shake-icon 0.5s; text-shadow:0 10px 30px rgba(220,38,38,0.5); }
        @keyframes shake-icon { 0%,100%{transform:rotate(0)} 25%{transform:rotate(-15deg) scale(1.1)} 75%{transform:rotate(15deg) scale(1.1)} }

        /* Buttons Enhancement */
        .btn-exam {
            padding: 14px 28px; border-radius: 14px; font-weight: 700; font-size: 1rem;
            transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-exam.primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb); border: none; color: #fff;
            box-shadow: 0 8px 20px rgba(59,130,246,0.3);
        }
        .btn-exam.primary:hover { box-shadow: 0 12px 25px rgba(59,130,246,0.5); transform:translateY(-2px); }
        
        .btn-exam.success {
            background: linear-gradient(135deg, #10b981, #059669); border: none; color: #fff;
            box-shadow: 0 8px 20px rgba(16,185,129,0.3);
        }
        .btn-exam.success:hover { box-shadow: 0 12px 25px rgba(16,185,129,0.5); transform:translateY(-2px); }
        
        .btn-exam.outline {
            background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); color: var(--text-primary);
        }
        .btn-exam.outline:hover:not(:disabled) { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2); }
        .btn-exam.outline:disabled { opacity: 0.5; cursor: not-allowed; }
    </style>
</head>
<body>

<div class="anti-cheat-banner" id="cheatBanner">
    <i class="fas fa-exclamation-triangle me-2"></i> WARNING: Do not switch tabs, minimize window, or click outside. Your exam will be immediately terminated.
</div>

<header class="exam-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#f05223,#ff7849);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#fff;box-shadow:0 4px 15px rgba(240,82,35,0.3)"><i class="fas fa-laptop-code"></i></div>
                <div>
                    <strong style="font-family:'Outfit';font-size:1.1rem;letter-spacing:1px">Innovative IT Solutions</strong>
                    <div style="font-size:0.85rem; color:var(--text-secondary)">Internship Exam - {{ $attempt->category->name }}</div>
                </div>
            </div>
            <div class="timer-box" id="timerBox">
                <i class="fas fa-stopwatch"></i> <span id="timeDisplay">--:--</span>
            </div>
        </div>
    </div>
</header>

<main class="flex-grow-1 py-5">
    <div class="container">
        
        <form id="examForm" action="{{ route('internship.exam.submit', $attempt) }}" method="POST">
            @csrf
            
            <div class="row g-4">
                {{-- Sidebar --}}
                <div class="col-lg-3 order-2 order-lg-1">
                    <div class="q-nav-box">
                        <h6 class="mb-3" style="color:var(--text-secondary); font-size:0.85rem; text-transform:uppercase; letter-spacing:1px;">Question Navigator</h6>
                        <div class="q-pills" id="qPills">
                            @foreach($examAnswers as $index => $answer)
                            <div class="q-pill {{ $index == 0 ? 'active' : '' }} {{ $answer->selected_option ? 'answered' : '' }}" onclick="goToQuestion({{ $index }})" id="pill_{{ $index }}">
                                {{ $index + 1 }}
                            </div>
                            @endforeach
                        </div>
                        
                        <hr style="border-color:var(--border-color); margin: 24px 0;">
                        
                        <div class="d-flex flex-column gap-2 text-muted" style="font-size:0.8rem">
                            <div class="d-flex align-items-center gap-2"><div style="width:12px;height:12px;background:#f05223;border-radius:2px"></div> Current</div>
                            <div class="d-flex align-items-center gap-2"><div style="width:12px;height:12px;background:rgba(59,130,246,0.1);border:1px solid #3b82f6;border-radius:2px"></div> Answered</div>
                            <div class="d-flex align-items-center gap-2"><div style="width:12px;height:12px;background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:2px"></div> Unanswered</div>
                        </div>
                    </div>
                </div>
                
                {{-- Question Area --}}
                <div class="col-lg-9 order-1 order-lg-2">
                    
                    @foreach($examAnswers as $index => $answer)
                    @php $q = $answer->question; @endphp
                    <div class="q-card {{ $index == 0 ? 'active' : '' }}" id="qCard_{{ $index }}">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span style="color:#f05223; font-weight:700; font-size:0.9rem">Question {{ $index + 1 }} of {{ $examAnswers->count() }}</span>
                        </div>
                        
                        <div class="q-text">{{ $q->question_text }}</div>
                        
                        <div class="options">
                            @foreach(['a', 'b', 'c', 'd'] as $optChar)
                            <div>
                                <input type="radio" name="answers[{{ $q->id }}]" id="q{{ $index }}_{{ $optChar }}" value="{{ $optChar }}" class="d-none option-input" onchange="markAnswered({{ $index }})" {{ $answer->selected_option == $optChar ? 'checked' : '' }}>
                                <label for="q{{ $index }}_{{ $optChar }}" class="option-label">
                                    <span class="opt-char">{{ strtoupper($optChar) }}</span>
                                    <span>{{ $q->{'option_'.$optChar} }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="d-flex justify-content-between mt-5 pt-4 border-top" style="border-color:rgba(255,255,255,0.05)!important">
                            <button type="button" class="btn-exam outline" onclick="goToQuestion({{ $index - 1 }})" {{ $index == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-arrow-left"></i> Previous
                            </button>
                            
                            @if($index < $examAnswers->count() - 1)
                                <button type="button" class="btn-exam primary" onclick="goToQuestion({{ $index + 1 }})">
                                    Next <i class="fas fa-arrow-right"></i>
                                </button>
                            @else
                                <button type="button" class="btn-exam success" onclick="submitExam()">
                                    <i class="fas fa-check-circle"></i> Final Submit
                                </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
            
        </form>
    </div>
</main>

{{-- Terminated Overlay --}}
<div class="terminated-overlay" id="terminatedOverlay">
    <div class="term-box">
        <div class="term-icon"><i class="fas fa-ban"></i></div>
        <h3 style="font-family:'Outfit';font-weight:800;color:var(--text-primary);margin-bottom:16px;">Exam Terminated</h3>
        <p style="color:var(--text-secondary);font-size:1rem;margin-bottom:30px;">
            Your exam was terminated because our system detected a violation of the rules (tab switching, window minimizing, or focus loss).
        </p>
        <a href="{{ route('internship.landing') }}" class="btn" style="background:#dc2626;color:#fff;padding:12px 30px;font-weight:700;border-radius:50px">
            Return to Home
        </a>
    </div>
</div>

{{-- Warning Overlay --}}
<div class="terminated-overlay" id="warningOverlay" style="display: none; background: rgba(2,6,23,0.85);">
    <div class="term-box" style="border-color: #f59e0b; box-shadow: 0 30px 80px rgba(245,158,11,0.2);">
        <div class="term-icon" style="color: #f59e0b;"><i class="fas fa-exclamation-triangle"></i></div>
        <h3 style="font-family:'Outfit';font-weight:800;color:var(--text-primary);margin-bottom:16px;">Final Warning!</h3>
        <p style="color:var(--text-secondary);font-size:1rem;margin-bottom:30px;">
            Our system detected that you switched tabs or minimized the window. <strong>One more violation</strong> will result in immediate automatic submission of your exam.
        </p>
        <button type="button" class="btn" onclick="closeWarning()" style="background:#f59e0b;color:#fff;padding:12px 30px;font-weight:700;border-radius:50px">
            I Understand, Continue Exam
        </button>
    </div>
</div>

<script>
    // ── Navigation ──
    const totalQs = {{ $examAnswers->count() }};
    let currentQ = 0;
    
    function goToQuestion(index) {
        if (index < 0 || index >= totalQs) return;
        
        document.querySelectorAll('.q-card').forEach(c => c.classList.remove('active'));
        document.querySelector(`#qCard_${index}`).classList.add('active');
        
        document.querySelectorAll('.q-pill').forEach(p => p.classList.remove('active'));
        document.querySelector(`#pill_${index}`).classList.add('active');
        
        currentQ = index;
        window.scrollTo(0,0);
    }
    
    function markAnswered(index) {
        document.querySelector(`#pill_${index}`).classList.add('answered');
        
        // Auto advance after short delay if not last question
        if (index < totalQs - 1) {
            setTimeout(() => goToQuestion(index + 1), 400);
        }
    }
    
    function submitExam() {
        if (confirm('Are you sure you want to submit your exam? You cannot change your answers after submitting.')) {
            isTerminated = true; // Disable anti-cheat to allow form submission redirect
            document.getElementById('examForm').submit();
        }
    }

    // ── Timer Logic ──
    let timeRemaining = {{ $timeRemainingSeconds }}; // in seconds from server
    const timerBox = document.getElementById('timerBox');
    const timeDisp = document.getElementById('timeDisplay');
    
    const timerInterval = setInterval(() => {
        timeRemaining--;
        
        if (timeRemaining <= 0) {
            clearInterval(timerInterval);
            timeDisp.textContent = "00:00";
            isTerminated = true;
            document.getElementById('examForm').submit();
            return;
        }
        
        const m = Math.floor(timeRemaining / 60).toString().padStart(2, '0');
        const s = (timeRemaining % 60).toString().padStart(2, '0');
        timeDisp.textContent = `${m}:${s}`;
        
        if (timeRemaining < 300) { // last 5 mins
            timerBox.classList.add('danger');
        }
    }, 1000);
    
    // ── Anti-Cheat Engine ──
    const ATTEMPT_ID = {{ $attempt->id }};
    const TERMINATE_URL = '{{ route("internship.exam.terminate", $attempt) }}';
    let isTerminated = false;
    let violationCount = 0;
    
    function triggerTermination(reason) {
        if (isTerminated) return;
        
        if (violationCount === 0) {
            violationCount++;
            showWarning();
            return;
        }

        isTerminated = true;
        clearInterval(timerInterval);
        
        // Report final violation and auto-submit
        document.getElementById('examForm').submit();
    }

    function showWarning() {
        document.getElementById('warningOverlay').style.display = 'flex';
    }

    function closeWarning() {
        document.getElementById('warningOverlay').style.display = 'none';
    }
    
    // 1. Page Visibility API (Tab Switch)
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'hidden' && !isTerminated) {
            triggerTermination('visibility_hidden');
        }
    });
    
    // 2. Window Blur (Alt-Tab, minimize, clicking other monitor)
    window.addEventListener('blur', () => {
        if (!isTerminated) triggerTermination('blur');
    });
    
    // 3. Disable Print Screen / Inspect Shortcuts
    document.addEventListener('keydown', e => {
        if (
            (e.ctrlKey && ['c', 'v', 'p', 's', 'u', 'i', 't', 'w', 'n', 'Tab'].includes(e.key.toLowerCase())) ||
            e.key === 'F5' || e.key === 'F12' || e.altKey || e.metaKey || e.key === 'PrintScreen'
        ) {
            e.preventDefault();
            // Don't auto-terminate on accidental keypress, just block it
        }
    });
    
    // 4. Disable Right Click
    document.addEventListener('contextmenu', e => e.preventDefault());
    
    // Warn before unload (if they try to close tab)
    window.addEventListener('beforeunload', (e) => {
        if (!isTerminated) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

</script>
</body>
</html>
