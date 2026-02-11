@extends('layouts.admin')

@section('content')
<div class="bento-grid">
    <!-- Hero Bento: Welcome Area -->
    <div class="bento-item hero-bento">
        <div class="hero-content">
            <div class="badge-tech mb-3"><i class="fas fa-bolt me-2"></i> SYSTEM OPERATIONAL</div>
            <h1 class="hero-title">Welcome, admin <span class="wave">👋</span></h1>
            <p class="hero-subtitle">Your digital empire is running at peak performance. Here's your overview for {{ date('l, F d') }}.</p>
            <div class="hero-actions mt-4">
                <a href="{{ route('admin.projects.create') }}" class="btn-tech-primary"><i class="fas fa-plus me-2"></i> Deploy New Project</a>
            </div>
        </div>
        <div class="hero-decoration">
            <div class="orb-1"></div>
            <div class="orb-2"></div>
        </div>
    </div>

    <!-- Stats Bento Grid -->
    <div class="bento-item stat-bento purple">
        <div class="bento-label">ACTIVE PROJECTS</div>
        <div class="bento-value">{{ $stats['projects'] }}</div>
        <div class="bento-footer">
            <span class="text-success"><i class="fas fa-arrow-up me-1"></i> +12%</span>
            <span class="ms-auto opacity-50"><i class="fas fa-briefcase"></i></span>
        </div>
    </div>

    <div class="bento-item stat-bento teal">
        <div class="bento-label">NEW INQUIRIES</div>
        <div class="bento-value">{{ $stats['new_inquiries'] }}</div>
        <div class="bento-footer">
            <span class="text-warning"><i class="fas fa-clock me-1"></i> Pending</span>
            <span class="ms-auto opacity-50"><i class="fas fa-envelope"></i></span>
        </div>
    </div>

    <div class="bento-item stat-bento indigo">
        <div class="bento-label">TEAM STRENGTH</div>
        <div class="bento-value">{{ $stats['team'] }}</div>
        <div class="bento-footer">
            <span class="text-white opacity-75">Core Members</span>
            <span class="ms-auto opacity-50"><i class="fas fa-users-shield"></i></span>
        </div>
    </div>

    <!-- Quick Activity Bento -->
    <div class="bento-item activity-bento">
        <div class="bento-header">
            <h5 class="bento-title"><i class="fas fa-satellite-dish me-2 text-primary"></i> Live Inquiries</h5>
            <a href="{{ route('admin.inquiries.index') }}" class="btn-link">Terminal <i class="fas fa-external-link-alt ms-1"></i></a>
        </div>
        <div class="activity-list">
            @forelse($recent_inquiries as $msg)
            <div class="activity-item">
                <div class="item-icon">{{ substr($msg->name, 0, 1) }}</div>
                <div class="item-info">
                    <div class="item-name">{{ $msg->name }}</div>
                    <div class="item-desc text-truncate" style="max-width: 180px;">{{ $msg->subject }}</div>
                </div>
                <div class="item-time ms-auto">{{ $msg->created_at->diffForHumans(null, true) }}</div>
            </div>
            @empty
            <div class="text-center py-4 opacity-50">No incoming signals detected.</div>
            @endforelse
        </div>
    </div>

    <!-- Portfolio Matrix Bento -->
    <div class="bento-item matrix-bento">
        <div class="bento-header">
            <h5 class="bento-title"><i class="fas fa-atom me-2 text-info"></i> Portfolio Matrix</h5>
        </div>
        <div class="matrix-grid mt-3">
            @foreach($category_stats as $cat)
            <div class="matrix-cell">
                <div class="cell-count">{{ $cat->projects_count }}</div>
                <div class="cell-label">{{ $cat->name }}</div>
                <div class="cell-progress">
                    <div class="progress-bar" style="width: {{ min(($cat->projects_count / 10) * 100, 100) }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Diagnostics Bento -->
    <div class="bento-item diag-bento">
        <div class="bento-header">
            <h5 class="bento-title"><i class="fas fa-microchip me-2 text-warning"></i> Diagnostics</h5>
        </div>
        <div class="diag-list mt-3">
            <div class="diag-item">
                <span>Infrastructure</span>
                <span class="text-success fw-bold">Online</span>
            </div>
            <div class="diag-item">
                <span>Environment</span>
                <span class="text-info fw-bold">PHP 8.2</span>
            </div>
            <div class="diag-item">
                <span>Latency</span>
                <span class="text-white">12ms</span>
            </div>
            <div class="diag-item border-0">
                <span>Security</span>
                <span class="text-warning fw-bold">Shielded</span>
            </div>
        </div>
    </div>
</div>

<style>
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: auto auto;
        gap: 1.5rem;
    }

    .bento-item {
        background: var(--v3-card);
        border: 1px solid var(--v3-border);
        border-radius: 24px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .bento-item:hover {
        border-color: rgba(99, 102, 241, 0.3);
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.5);
    }

    /* Hero Bento Styling */
    .hero-bento {
        grid-column: span 3;
        background: radial-gradient(circle at top right, #1e293b, #0f172a);
        display: flex;
        align-items: center;
        border: 1px solid rgba(99, 102, 241, 0.2);
    }

    .hero-title { font-size: 2.5rem; font-weight: 800; color: white; margin-bottom: 0.5rem; }
    .hero-subtitle { color: var(--v3-text-muted); font-size: 1.1rem; max-width: 500px; }

    .badge-tech {
        display: inline-flex;
        padding: 0.4rem 1rem;
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05rem;
    }

    .btn-tech-primary {
        display: inline-flex;
        padding: 0.8rem 1.5rem;
        background: var(--v3-gradient);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        transition: 0.3s;
    }

    .btn-tech-primary:hover { transform: scale(1.05); color: white; filter: brightness(1.1); }

    .hero-decoration .orb-1 {
        position: absolute; right: -50px; top: -50px; width: 250px; height: 250px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, transparent 70%);
        filter: blur(40px);
    }

    .hero-decoration .orb-2 {
        position: absolute; right: 100px; bottom: -80px; width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(168, 85, 247, 0.2) 0%, transparent 70%);
        filter: blur(40px);
    }

    /* Stat Bento Styling */
    .stat-bento { grid-column: span 1; display: flex; flex-direction: column; justify-content: space-between; height: 200px; }
    .bento-label { font-size: 0.75rem; font-weight: 700; color: var(--v3-text-muted); text-transform: uppercase; letter-spacing: 0.1rem; }
    .bento-value { font-size: 3rem; font-weight: 800; color: white; margin: 0.5rem 0; }
    .bento-footer { display: flex; align-items: center; font-size: 0.85rem; font-weight: 600; margin-top: auto; }

    .stat-bento.purple { border-bottom: 4px solid #8b5cf6; }
    .stat-bento.teal { border-bottom: 4px solid #06b6d4; }
    .stat-bento.indigo { border-bottom: 4px solid #6366f1; }

    /* Activity Bento Styling */
    .activity-bento { grid-column: span 2; grid-row: span 2; }
    .bento-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .bento-title { font-size: 1.1rem; font-weight: 700; margin: 0; color: white; }
    .btn-link { color: var(--v3-accent); text-decoration: none; font-size: 0.85rem; font-weight: 600; }

    .activity-list { display: flex; flex-direction: column; gap: 1rem; }
    .activity-item { 
        display: flex; align-items: center; padding: 1rem; background: rgba(255,255,255,0.02);
        border-radius: 16px; transition: 0.3s; border: 1px solid transparent;
    }
    .activity-item:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.05); }
    .item-icon { 
        width: 32px; height: 32px; background: var(--v3-gradient); border-radius: 8px;
        display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem;
    }
    .item-info { margin-left: 1rem; }
    .item-name { font-weight: 700; font-size: 0.9rem; color: white; }
    .item-desc { font-size: 0.75rem; color: var(--v3-text-muted); }
    .item-time { font-size: 0.7rem; color: #475569; font-weight: 600; }

    /* Matrix Bento Styling */
    .matrix-bento { grid-column: span 1; }
    .matrix-grid { display: flex; flex-direction: column; gap: 1rem; }
    .matrix-cell { background: rgba(255,255,255,0.03); padding: 1rem; border-radius: 16px; }
    .cell-count { font-size: 1.25rem; font-weight: 800; color: white; }
    .cell-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; color: var(--v3-text-muted); opacity: 0.7; }
    .cell-progress { height: 4px; background: rgba(255,255,255,0.05); border-radius: 10px; margin-top: 0.5rem; overflow: hidden; }
    .cell-progress .progress-bar { height: 100%; background: var(--v3-accent); border-radius: 10px; }

    /* Diag Bento Styling */
    .diag-bento { grid-column: span 1; }
    .diag-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .diag-item { 
        display: flex; justify-content: space-between; align-items: center; 
        padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.05);
        font-size: 0.85rem; color: var(--v3-text-muted);
    }

    .wave { display: inline-block; animation: wave-anim 2.5s infinite; transform-origin: 70% 70%; }
    @keyframes wave-anim {
        0%, 100% { transform: rotate(0deg); }
        20% { transform: rotate(-10deg); }
        40% { transform: rotate(10deg); }
        60% { transform: rotate(-10deg); }
        80% { transform: rotate(10deg); }
    }

    @media (max-width: 1200px) {
        .bento-grid { grid-template-columns: repeat(2, 1fr); }
        .hero-bento { grid-column: span 2; }
        .activity-bento { grid-column: span 2; }
    }

    @media (max-width: 768px) {
        .bento-grid { grid-template-columns: 1fr; }
        .hero-bento, .activity-bento, .matrix-bento, .diag-bento, .stat-bento { grid-column: span 1; }
        .hero-title { font-size: 1.8rem; }
    }
</style>
@endsection
