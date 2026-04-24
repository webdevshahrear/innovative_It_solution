@extends('layouts.admin')

@push('styles')
<style>
    /* ════ ULTRA-PREMIUM CYBER-OBSIDIAN REDESIGN ════ */
    :root {
        --glass-bg: rgba(15, 23, 42, 0.6);
        --glass-border: rgba(255, 255, 255, 0.08);
        --cyber-accent: #f05223;
        --neural-purple: #a78bfa;
        --glow-shadow: 0 20px 50px rgba(0,0,0,0.4);
    }

    [data-theme="light"] :root {
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(0, 0, 0, 0.06);
        --glow-shadow: 0 15px 40px rgba(0,0,0,0.06);
    }

    /* ── 1. Cyber Header Dashboard ── */
    .cyber-header {
        position: relative; padding: 70px 50px; border-radius: 36px;
        background: var(--glass-bg); border: 1px solid var(--glass-border);
        margin-bottom: 50px; overflow: hidden; backdrop-filter: blur(24px);
        box-shadow: var(--glow-shadow), inset 0 1px 0 rgba(255,255,255,0.1);
    }
    .cyber-header::before {
        content: ''; position: absolute; inset: -50%; 
        background: radial-gradient(circle at 70% 30%, rgba(240, 82, 35, 0.15), transparent 50%),
                    radial-gradient(circle at 20% 80%, rgba(167, 139, 250, 0.12), transparent 50%);
        animation: rotateGlow 20s linear infinite; pointer-events: none; z-index: 0;
    }
    .cyber-header > * { position: relative; z-index: 1; }
    @keyframes rotateGlow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* ── 2. The Dashboard Metrics ── */
    .neural-stat-card {
        background: var(--glass-bg); border: 1px solid var(--glass-border);
        border-radius: 28px; padding: 30px; transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex; flex-direction: column; gap: 20px; position: relative;
        backdrop-filter: blur(24px); box-shadow: inset 0 1px 1px rgba(255,255,255,0.05);
        overflow: hidden; cursor: default;
    }
    .neural-stat-card::after {
        content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 5px;
        background: var(--stat-color, #fff); opacity: 0.6; transition: 0.5s;
    }
    .neural-stat-card:hover { transform: translateY(-10px); box-shadow: var(--glow-shadow); border-color: rgba(255,255,255,0.15); }
    .neural-stat-card:hover::after { opacity: 1; box-shadow: 0 -5px 20px var(--stat-color); }
    
    .neural-stat-card .icon-box {
        width: 65px; height: 65px; border-radius: 20px; display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); font-size: 1.75rem;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2); transition: 0.5s;
    }
    .neural-stat-card:hover .icon-box { transform: scale(1.1) rotate(5deg); }
    .stat-val { font-family: 'Space Grotesk', 'Outfit', sans-serif; font-size: 3rem; font-weight: 900; line-height: 1; letter-spacing: -0.05em; margin: 5px 0; }

    /* ── 3. Filters ── */
    .cyber-filter {
        background: var(--glass-bg); border: 1px solid var(--glass-border);
        border-radius: 28px; padding: 35px; margin-bottom: 50px; backdrop-filter: blur(20px);
        box-shadow: var(--glow-shadow);
    }

    /* ── 4. Obsidian Question Tile (Redesigned) ── */
    .obsidian-card {
        background: var(--glass-bg); border: 1px solid var(--glass-border);
        border-radius: 28px; padding: 35px; margin-bottom: 30px; transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: grid; grid-template-columns: 1fr 260px; gap: 35px; position: relative;
        backdrop-filter: blur(30px); box-shadow: var(--glow-shadow);
        overflow: hidden;
    }
    .obsidian-card::before {
        content: ''; position: absolute; top: 0; left: 0; width: 6px; height: 100%;
        background: linear-gradient(to bottom, rgba(255,255,255,0.1), transparent);
        transition: 0.5s;
    }
    .obsidian-card:hover { transform: translateY(-5px); border-color: rgba(255,255,255,0.15); box-shadow: 0 30px 60px rgba(0,0,0,0.5); }
    .obsidian-card:hover::before { background: linear-gradient(to bottom, var(--cyber-accent), transparent); box-shadow: 0 0 20px var(--cyber-accent); }
    .obsidian-card.verified::before { background: linear-gradient(to bottom, #10b981, transparent); box-shadow: 0 0 20px #10b981; }
    
    @media (max-width: 1400px) {
        .obsidian-card { grid-template-columns: 1fr 240px; gap: 25px; padding: 30px; }
        .q-text-premium { font-size: 1.35rem; margin-bottom: 25px; }
    }
    @media (max-width: 1200px) {
        .obsidian-card { grid-template-columns: 1fr; gap: 25px; padding: 25px; }
    }

    .q-meta { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; flex-wrap: wrap; }
    .q-text-premium { 
        font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 800; color: var(--v2-text-main);
        line-height: 1.5; letter-spacing: -0.01em; margin-bottom: 40px; text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    /* Options Redesign */
    .cyber-opt-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
    .cyber-opt-item {
        background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px; padding: 22px 28px; display: flex; align-items: center; gap: 20px;
        transition: all 0.4s; position: relative; overflow: hidden;
    }
    .cyber-opt-item:hover { background: rgba(255, 255, 255, 0.06); transform: translateX(5px); }
    .cyber-opt-item.is-correct {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
        border-color: rgba(16, 185, 129, 0.4); color: #10b981; font-weight: 700;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.15);
        transform: translateX(10px);
    }
    .cyber-opt-tag {
        width: 36px; height: 36px; border-radius: 12px; background: rgba(255,255,255,0.08);
        display: flex; align-items: center; justify-content: center; font-size: 0.9rem; 
        font-weight: 900; color: var(--v2-text-muted); box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
    }
    .cyber-opt-item.is-correct .cyber-opt-tag { background: #10b981; color: #fff; box-shadow: 0 0 15px rgba(16,185,129,0.5); }

    /* Control Hub */
    .control-hub {
        background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border);
        border-radius: 28px; padding: 35px; display: flex; flex-direction: column; justify-content: space-between;
        box-shadow: inset 0 5px 20px rgba(0,0,0,0.3);
    }
    .btn-cyber-action {
        width: 100%; padding: 14px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.05); color: var(--v2-text-muted); transition: .3s;
        display: flex; align-items: center; justify-content: center; gap: 10px; font-weight: 800; font-size: 0.85rem;
    }
    .btn-cyber-action:hover { border-color: var(--v2-primary); color: #fff; background: var(--v2-primary); box-shadow: 0 10px 25px rgba(240, 82, 35, 0.3); transform: translateY(-3px); }
    .btn-cyber-delete:hover { border-color: #ef4444; color: #fff; background: #ef4444; box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3); }

    .neural-badge {
        padding: 6px 18px; border-radius: 100px; font-size: 0.7rem; font-weight: 900;
        text-transform: uppercase; letter-spacing: 1.5px; border: 1px solid rgba(255,255,255,0.15);
        backdrop-filter: blur(10px); box-shadow: 0 4px 10px rgba(0,0,0,0.2); display: inline-flex; align-items: center;
    }

    /* Explanation card – always dark */
    .cyber-explanation-card {
        background: rgba(255,255,255,0.04) !important;
        border: 1px solid rgba(255,255,255,0.08) !important;
        border-left: 4px solid var(--v2-primary) !important;
        backdrop-filter: blur(10px);
        border-radius: 16px; padding: 20px 24px; margin-top: 25px;
    }
    .cyber-explanation-card .exp-title { color: #f0eeff; font-weight: 800; margin-bottom: 8px; display: flex; align-items: center; gap: 10px; }
    .cyber-explanation-card .exp-body { color: #94a3b8; font-size: 0.9rem; line-height: 1.7; margin: 0; }

    /* Pagination dark override */
    .pagination-wrapper {
        background: rgba(255,255,255,0.04) !important;
        border: 1px solid rgba(255,255,255,0.08) !important;
        border-radius: 28px; padding: 20px 30px;
        backdrop-filter: blur(20px); margin-top: 40px;
    }
    .pagination-wrapper .page-link {
        background: rgba(255,255,255,0.05) !important; border-color: rgba(255,255,255,0.1) !important;
        color: #94a3b8 !important; border-radius: 10px !important; margin: 0 3px;
    }
    .pagination-wrapper .page-item.active .page-link {
        background: var(--v2-primary) !important; border-color: var(--v2-primary) !important; color: #fff !important;
        box-shadow: 0 5px 15px rgba(240,82,35,0.4);
    }
    .pagination-wrapper .page-link:hover { background: rgba(240,82,35,0.15) !important; color: #fff !important; }

    /* LIGHT MODE OVERRIDES */
    [data-theme="light"] .cyber-header { background: linear-gradient(135deg, #ffffff, #f8fafc); border-color: #cbd5e1; }
    [data-theme="light"] .neural-stat-card { background: #ffffff; border-color: #e2e8f0; }
    [data-theme="light"] .cyber-filter { background: #ffffff; border-color: #e2e8f0; }
    [data-theme="light"] .obsidian-card { background: #ffffff; border-color: #e2e8f0; }
    [data-theme="light"] .cyber-opt-item { background: #f8fafc; border-color: #e2e8f0; color: #334155; }
    [data-theme="light"] .cyber-opt-tag { background: #e2e8f0; color: #475569; }
    [data-theme="light"] .control-hub { background: #f1f5f9; border-color: #e2e8f0; }
    [data-theme="light"] .btn-cyber-action { background: #ffffff; border-color: #cbd5e1; color: #64748b; }
    [data-theme="light"] .q-meta .bg-white { background-color: #f1f5f9 !important; color: #334155 !important; }
    [data-theme="light"] .stat-val { color: #0f172a; }
    [data-theme="light"] .cyber-explanation-card { background: #f8fafc !important; border-color: #cbd5e1 !important; }
    [data-theme="light"] .cyber-explanation-card .exp-title { color: #0f172a; }
    [data-theme="light"] .cyber-explanation-card .exp-body { color: #475569; }
    [data-theme="light"] .pagination-wrapper { background: #ffffff !important; border-color: #e2e8f0 !important; }
</style>
@endpush

@section('content')
{{-- Cyber Header --}}
<div class="cyber-header" data-aos="fade-down">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-2 mb-4">
                <span class="pulse-ai" style="width:12px;height:12px;background:var(--neural-purple);border-radius:50%; box-shadow: 0 0 15px var(--neural-purple);"></span>
                <span class="text-uppercase fw-bold" style="color:var(--neural-purple); font-size:0.8rem; letter-spacing:3px">Neural Intelligence Active</span>
            </div>
            <h1 class="text-white m-0 d-flex align-items-center gap-3" style="font-size: 4.5rem; font-weight: 900; font-family: 'Outfit', sans-serif; letter-spacing: -0.04em;">
                Exam <span style="background: linear-gradient(135deg, #f05223, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; filter: drop-shadow(0 10px 20px rgba(240,82,35,0.3));">Questions</span>
            </h1>
            <p class="text-v2-muted mt-4 mb-0" style="font-size: 1.25rem; max-width: 700px; line-height: 1.7; font-weight: 500;">
                Curating the next generation of assessment assets for the intelligence bank. Leverage high-fidelity synthetic data or human expertise.
            </p>
        </div>
        <div class="col-lg-4 text-center text-lg-end mt-5 mt-lg-0">
            <div class="d-flex flex-column gap-3 align-items-lg-end">
                <a href="{{ route('admin.internship.questions.generate') }}" class="btn-v2-primary py-4 px-5 w-100 w-lg-auto shadow-lg" style="border-radius: 24px; font-size: 1.1rem; font-weight: 800;">
                    <i class="fas fa-microchip me-2"></i> Deploy AI Generator
                </a>
                <a href="{{ route('admin.internship.questions.create') }}" class="btn-neo-glass py-4 px-5 w-100 w-lg-auto" style="border-radius: 24px; font-size: 1.1rem; font-weight: 800;">
                    <i class="fas fa-plus-circle me-2"></i> Manual Curriculum
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Dynamic Metrics Dashboard --}}
<div class="row g-4 mb-5" data-aos="fade-up" data-aos-delay="100">
    @php
        $stats = [
            ['label' => 'Total Assets', 'value' => $questions->total(), 'icon' => 'fa-database', 'color' => '#3b82f6'],
            ['label' => 'Verified Quality', 'value' => $questions->where('is_approved', 1)->count(), 'icon' => 'fa-shield-check', 'color' => '#10b981'],
            ['label' => 'AI Generated', 'value' => $questions->where('generated_by', 'gemini')->count(), 'icon' => 'fa-brain-circuit', 'color' => '#a78bfa'],
            ['label' => 'Manual Entry', 'value' => $questions->where('generated_by', 'manual')->count(), 'icon' => 'fa-user-pen', 'color' => '#f59e0b'],
        ];
    @endphp
    @foreach($stats as $stat)
    <div class="col-md-3">
        <div class="neural-stat-card" style="--stat-color: {{ $stat['color'] }};">
            <div class="d-flex align-items-start justify-content-between">
                <div class="icon-box" style="color: {{ $stat['color'] }}; background: {{ $stat['color'] }}15; border-color: {{ $stat['color'] }}30;">
                    <i class="fas {{ $stat['icon'] }}"></i>
                </div>
                <span class="badge" style="background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.5); border-radius: 10px; padding: 5px 10px;"><i class="fas fa-chart-line"></i></span>
            </div>
            <div class="mt-2">
                <div class="stat-val text-white">{{ $stat['value'] }}</div>
                <div class="text-v2-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">{{ $stat['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Integrated Filters --}}
<div class="cyber-filter" data-aos="fade-up" data-aos-delay="200">
    <form action="{{ route('admin.internship.questions.index') }}" method="GET" class="row g-4">
        <div class="col-md-3">
            <label class="form-label text-v2-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">Assessment Domain</label>
            <select name="category" class="v2-admin-input w-100">
                <option value="">All Domains</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label text-v2-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">Protocol Status</label>
            <select name="approved" class="v2-admin-input w-100">
                <option value="">All States</option>
                <option value="1" {{ request('approved') == '1' ? 'selected' : '' }}>Verified Assets</option>
                <option value="0" {{ request('approved') == '0' ? 'selected' : '' }}>Pending Protocol</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label text-v2-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">Intelligence Source</label>
            <select name="source" class="v2-admin-input w-100">
                <option value="">All Sources</option>
                <option value="manual" {{ request('source') == 'manual' ? 'selected' : '' }}>Human Expert</option>
                <option value="gemini" {{ request('source') == 'gemini' ? 'selected' : '' }}>Gemini Neural</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn-v2-primary w-100 py-3" style="border-radius:18px; font-weight: 800;">
                <i class="fas fa-filter me-2"></i> Execute Filter
            </button>
        </div>
    </form>
</div>

{{-- Question Assets --}}
<div class="assets-container">
    @forelse($questions as $q)
    <div class="obsidian-card {{ $q->is_approved ? 'verified' : '' }}" data-aos="fade-up">
        <div class="q-content-hub">
            <div class="q-meta">
                <span class="neural-badge" style="background: rgba(255,255,255,0.05); color: #fff; border-color: rgba(255,255,255,0.1)">{{ $q->category?->name ?? 'General Domain' }}</span>
                
                @php
                    $diffClass = ['easy' => 'text-success', 'medium' => 'text-warning', 'hard' => 'text-danger'][$q->difficulty];
                    $diffIcon = ['easy' => 'fa-signal-1', 'medium' => 'fa-signal-2', 'hard' => 'fa-signal-3'][$q->difficulty];
                @endphp
                <span class="{{ $diffClass }} small fw-bold" style="letter-spacing: 1px;"><i class="fas {{ $diffIcon }} me-1"></i> {{ strtoupper($q->difficulty) }}</span>
                
                @if($q->generated_by == 'gemini')
                    <span class="neural-badge" style="background:rgba(167,139,250,0.1); color:#a78bfa; border-color:rgba(167,139,250,0.3)">
                        <i class="fas fa-robot me-1"></i> AI SYNTHETIC
                    </span>
                @else
                    <span class="neural-badge" style="background:rgba(59,130,246,0.1); color:#3b82f6; border-color:rgba(59,130,246,0.3)">
                        <i class="fas fa-user-tie me-1"></i> HUMAN VALIDATED
                    </span>
                @endif
            </div>

            <h3 class="q-text-premium">{{ $q->question_text }}</h3>

            <div class="cyber-opt-grid">
                @foreach(['a', 'b', 'c', 'd'] as $opt)
                <div class="cyber-opt-item {{ $q->correct_option == $opt ? 'is-correct' : '' }}">
                    <div class="cyber-opt-tag">{{ strtoupper($opt) }}</div>
                    <div class="small fw-500">{{ $q->{'option_'.$opt} }}</div>
                    @if($q->correct_option == $opt) <i class="fas fa-check-circle ms-auto" style="font-size: 1.2rem;"></i> @endif
                </div>
                @endforeach
            </div>

            @if($q->explanation)
            <div class="cyber-explanation-card">
                <div class="exp-title"><i class="fas fa-lightbulb text-warning"></i> Intelligence Feedback</div>
                <div class="exp-body">{{ $q->explanation }}</div>
            </div>
            @endif
        </div>

        <div class="control-hub shadow-inner">
            <div class="hub-section">
                <div class="text-v2-muted small text-uppercase fw-bold mb-3" style="font-size:0.65rem; letter-spacing:2px; opacity: 0.6;">Validation Status</div>
                <form action="{{ route('admin.internship.questions.approve', $q) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn w-100 {{ $q->is_approved ? 'btn-outline-success' : 'btn-v2-primary' }} shadow-lg" style="border-radius: 18px; padding: 15px; font-weight: 900; border-width: 2px;">
                        @if($q->is_approved)
                            <i class="fas fa-check-double me-2"></i> VERIFIED
                        @else
                            <i class="fas fa-shield-check me-2"></i> AUTHORIZE
                        @endif
                    </button>
                </form>
            </div>

            <div class="hub-section mt-auto pt-4 border-top border-white border-opacity-5">
                <div class="text-v2-muted small text-uppercase fw-bold mb-3" style="font-size:0.65rem; letter-spacing:2px; opacity: 0.6;">Management</div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.internship.questions.edit', $q) }}" class="btn-cyber-action flex-grow-1">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.internship.questions.destroy', $q) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Archiving this asset is irreversible. Proceed?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-cyber-action btn-cyber-delete w-100">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="cyber-header text-center py-5">
        <div class="opacity-10 mb-4"><i class="fas fa-database" style="font-size:5rem"></i></div>
        <h2 class="text-white fw-900">Neural Bank Empty</h2>
        <p class="text-v2-muted">No assessment assets matched your current filtration protocol. Try adjusting your parameters.</p>
    </div>
    @endforelse
</div>

{{-- Premium Pagination --}}
@if($questions->hasPages())
<div class="pagination-wrapper d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="text-v2-muted small fw-bold">Active Pool: <span class="text-white">{{ $questions->firstItem() }}–{{ $questions->lastItem() }}</span> of <span class="text-white">{{ $questions->total() }}</span> assets</div>
    <div>{{ $questions->links('pagination::bootstrap-5') }}</div>
</div>
@endif

@endsection
