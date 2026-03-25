@extends('layouts.admin')

@section('content')
<div class="bento-grid">
    <!-- Hero Bento: Welcome Area (Span 4) -->
    <div class="bento-item hero-bento">
        <div class="hero-content">
            <div class="badge-tech mb-3"><i class="fas fa-satellite me-2 pulse-anim"></i> UPLINK ESTABLISHED</div>
            <div class="d-flex align-items-center mb-1">
                <h1 class="hero-title mb-0 me-3">Command Center <span class="wave">👋</span></h1>
                <div class="live-clock badge-glow-info" id="liveClock">00:00:00</div>
            </div>
            <p class="hero-subtitle">System core is operating at maximum efficiency. Accessing comprehensive overview for {{ date('l, F d') }}.</p>
            <div class="hero-actions mt-4 d-flex gap-3">
                <a href="{{ route('admin.projects.create') }}" class="btn-tech-primary shadow-glow">
                    <i class="fas fa-rocket me-2"></i> Deploy New Project
                </a>
                <a href="#" class="btn-tech-outline text-white" style="border-color: rgba(255,255,255,0.2);">
                    <i class="fas fa-terminal me-2"></i> System Diagnostics
                </a>
            </div>
        </div>
        <div class="hero-decoration">
            <div class="glow-orb orb-1"></div>
            <div class="glow-orb orb-2"></div>
            <div class="grid-overlay"></div>
        </div>
    </div>

    <!-- Security Radar Bento (Span 2) -->
    <div class="bento-item radar-bento d-flex flex-column align-items-center justify-content-center text-center">
        <h5 class="bento-title w-100 text-start mb-0" style="position: absolute; top: 1.5rem; left: 1.5rem;"><i class="fas fa-satellite-dish me-2 text-v2-success"></i> Perimeter Security</h5>
        <div class="radar">
            <div class="sweep"></div>
            <div class="radar-dot pulse-anim" style="top: 30%; left: 40%;"></div>
            <div class="radar-dot pulse-anim" style="top: 70%; left: 60%; animation-delay: 1s;"></div>
            <div class="radar-dot pulse-anim" style="top: 50%; left: 80%; animation-delay: 0.5s;"></div>
        </div>
        <div class="mt-3">
            <span class="badge-glow-success px-3 py-1 rounded-pill" style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3);">
                <i class="fas fa-shield-alt me-1"></i> No Threats Detected
            </span>
        </div>
    </div>

    <!-- Stats Bento Grid (Span 2 each) -->
    <div class="bento-item stat-bento purple">
        <div class="stat-bg-glow"></div>
        <div class="bento-label">Active Deployments</div>
        <div class="bento-value display-font">{{ $stats['projects'] }}</div>
        <div class="mini-sparkline mb-3">
            <div class="spark-bar" style="height: 40%"></div><div class="spark-bar" style="height: 60%"></div><div class="spark-bar" style="height: 35%"></div><div class="spark-bar" style="height: 80%"></div><div class="spark-bar" style="height: 100%; background: #8b5cf6;"></div><div class="spark-bar" style="height: 50%"></div>
        </div>
        <div class="bento-footer">
            <span class="badge-glow-success"><i class="fas fa-arrow-up me-1"></i> Peak</span>
            <span class="ms-auto stat-icon"><i class="fas fa-layer-group"></i></span>
        </div>
    </div>

    <div class="bento-item stat-bento teal">
        <div class="stat-bg-glow"></div>
        <div class="bento-label">Incoming Signals</div>
        <div class="bento-value display-font">{{ $stats['new_inquiries'] }}</div>
        <div class="mini-sparkline mb-3">
            <div class="spark-bar" style="height: 20%"></div><div class="spark-bar" style="height: 80%"></div><div class="spark-bar" style="height: 40%"></div><div class="spark-bar" style="height: 90%; background: #06b6d4;"></div><div class="spark-bar" style="height: 60%"></div><div class="spark-bar" style="height: 30%"></div>
        </div>
        <div class="bento-footer">
             <span class="badge-glow-warning"><i class="fas fa-radar me-1"></i> Scanning</span>
            <span class="ms-auto stat-icon"><i class="fas fa-envelope-open-text"></i></span>
        </div>
    </div>

    <div class="bento-item stat-bento indigo">
        <div class="stat-bg-glow"></div>
        <div class="bento-label">Core Team Unit</div>
        <div class="bento-value display-font">{{ $stats['team'] }}</div>
        <div class="mini-sparkline mb-3">
            <div class="spark-bar" style="height: 100%; background: #6366f1;"></div><div class="spark-bar" style="height: 100%"></div><div class="spark-bar" style="height: 100%"></div><div class="spark-bar" style="height: 100%"></div><div class="spark-bar" style="height: 100%"></div><div class="spark-bar" style="height: 100%"></div>
        </div>
        <div class="bento-footer">
            <span class="badge-glow-info"><i class="fas fa-shield-check me-1"></i> Secure</span>
            <span class="ms-auto stat-icon"><i class="fas fa-users-cog"></i></span>
        </div>
    </div>

    <!-- Traffic Chart Bento (Span 4) -->
    <div class="bento-item chart-bento position-relative">
        <div class="bento-header mb-0 position-relative z-index-2">
            <h5 class="bento-title"><i class="fas fa-chart-line me-2 text-v2-primary"></i> System Traffic Trends</h5>
            <span class="badge-cyber text-v2-success border-success">Live Updates</span>
        </div>
        <div class="chart-container" style="position: relative; height: 180px; width: 100%; margin-top: 1rem;">
            <canvas id="trafficChart"></canvas>
        </div>
    </div>

    <!-- Storage Capacity Gauge (Span 2) -->
    <div class="bento-item cap-bento d-flex flex-column align-items-center justify-content-center">
        <h5 class="bento-title w-100 text-start mb-0" style="position: absolute; top: 1.5rem; left: 1.5rem;"><i class="fas fa-server me-2 text-v2-secondary"></i> Storage Node Alpha</h5>
        <div class="capacity-gauge mt-4">
            <svg viewBox="0 0 36 36" class="circular-chart text-v2-secondary">
                <path class="circle-bg"
                d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"
                />
                <path class="circle"
                stroke-dasharray="72, 100"
                d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"
                />
                <text x="18" y="20.35" class="percentage">72%</text>
            </svg>
        </div>
        <div class="mt-3 text-center">
            <div class="text-v2-muted fw-bold" style="font-size: 0.75rem;">1.2TB / 1.6TB USED</div>
        </div>
    </div>

    <!-- Quick Activity Bento (Span 3) -->
    <div class="bento-item activity-bento-span-3">
        <div class="bento-header">
            <h5 class="bento-title"><i class="fas fa-broadcast-tower me-2 text-v2-primary live-pulse"></i> Live Transmissions</h5>
            <a href="{{ route('admin.inquiries.index') }}" class="btn-link-glow">Open Terminal <i class="fas fa-external-link-alt ms-1"></i></a>
        </div>
        <div class="activity-list">
            @if($recent_inquiries->count() > 0)
                @foreach($recent_inquiries->take(4) as $msg)
                <div class="activity-item glass-panel p-3">
                    <div class="item-icon-wrapper">
                        <div class="item-icon">{{ substr($msg->name, 0, 1) }}</div>
                    </div>
                    <div class="item-info">
                        <div class="item-name text-white">{{ $msg->name }}</div>
                        <div class="item-desc text-truncate text-v2-muted" style="max-width: 180px;">{{ $msg->subject }}</div>
                    </div>
                    <div class="item-time ms-auto badge-cyber">{{ $msg->created_at->diffForHumans(null, true) }}</div>
                </div>
                @endforeach
            @else
                <div class="empty-state-glass py-4">
                    <i class="fas fa-space-shuttle empty-icon"></i>
                    <p>No incoming signals detected.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Deployments Bento (Span 3) -->
    <div class="bento-item deploy-bento">
        <div class="bento-header">
            <h5 class="bento-title"><i class="fas fa-rocket me-2" style="color: #f59e0b;"></i> Recent Deployments</h5>
            <a href="{{ route('admin.projects.index') }}" class="btn-link-glow">View Grid <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="deploy-list">
            @if($recent_projects->count() > 0)
                @foreach($recent_projects->take(4) as $project)
                <div class="activity-item glass-panel p-3 mb-2">
                    <div class="item-icon-wrapper p-1 border-0" style="background: transparent;">
                        @if($project->thumbnail)
                            <img src="{{ asset('uploads/projects/' . $project->thumbnail) }}" alt="{{ $project->title }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <div class="item-icon" style="background: rgba(245, 158, 11, 0.2); color: #f59e0b; width: 40px; height: 40px;"><i class="fas fa-image"></i></div>
                        @endif
                    </div>
                    <div class="item-info ms-3">
                        <div class="item-name text-white">{{ $project->title }}</div>
                        <div class="item-desc text-v2-muted" style="font-size: 0.70rem;">{{ $project->category->name ?? 'Uncategorized' }}</div>
                    </div>
                    <div class="ms-auto" style="font-size: 0.75rem; color: #10b981; font-weight: bold;"><i class="fas fa-check-circle me-1"></i> Deployed</div>
                </div>
                @endforeach
            @else
                <div class="empty-state-glass py-4">
                    <p>No successful deployments logged.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Portfolio Matrix Bento (Span 3) -->
    <div class="bento-item matrix-bento-span-3">
        <div class="bento-header">
            <h5 class="bento-title"><i class="fas fa-cubes me-2 text-v2-secondary"></i> System Matrix</h5>
        </div>
        <div class="matrix-grid mt-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            @foreach($category_stats->take(4) as $cat)
            <div class="matrix-cell glass-panel p-3">
                <div class="d-flex justify-content-between align-items-end mb-2">
                    <div class="cell-label text-v2-muted fw-bold text-uppercase text-truncate me-2" style="font-size: 0.65rem; letter-spacing: 0.1em; max-width: 70%;">{{ $cat->name }}</div>
                    <div class="cell-count text-white fw-bold">{{ str_pad($cat->projects_count, 2, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="cell-progress mt-2" style="height: 4px;">
                    <div class="progress-bar progress-glow" style="width: {{ min(($cat->projects_count / 10) * 100, 100) }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Diagnostics Bento (Span 3) -->
    <div class="bento-item diag-bento-span-3">
        <div class="bento-header">
            <h5 class="bento-title"><i class="fas fa-microchip me-2 text-v2-warning"></i> Node Diagnostics</h5>
        </div>
        <div class="diag-list mt-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="diag-item flex-column align-items-start glass-panel p-3 border-0">
                <span class="mb-1" style="font-size: 0.7rem; color: var(--v2-text-muted); text-transform: uppercase;">Infrastructure</span>
                <span class="status-indicator fs-6">
                    <span class="pulse-dot bg-success"></span> Online
                </span>
            </div>
            <div class="diag-item flex-column align-items-start glass-panel p-3 border-0">
                <span class="mb-1" style="font-size: 0.7rem; color: var(--v2-text-muted); text-transform: uppercase;">Runtime Phase</span>
                <span class="text-v2-secondary fw-bold fs-6" style="text-shadow: 0 0 10px rgba(6, 182, 212, 0.5);">PHP 8.2</span>
            </div>
            <div class="diag-item flex-column align-items-start glass-panel p-3 border-0">
                <span class="mb-1" style="font-size: 0.7rem; color: var(--v2-text-muted); text-transform: uppercase;">Network Latency</span>
                <span class="text-white font-monospace fs-6">12ms</span>
            </div>
            <div class="diag-item flex-column align-items-start glass-panel p-3 border-0">
                <span class="mb-1" style="font-size: 0.7rem; color: var(--v2-text-muted); text-transform: uppercase;">Security Protocol</span>
                <span class="badge-glow-warning rounded-pill px-2 py-1 fs-6 mt-1" style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3);"><i class="fas fa-shield-check me-1"></i> Shielded</span>
            </div>
        </div>
    </div>

    <!-- Live System Ticker (Span 10) -->
    <div class="bento-item ticker-bento-span-10 p-0 overflow-hidden" style="height: 50px; grid-column: span 10;">
        <div class="ticker-wrap d-flex align-items-center h-100">
            <div class="ticker-label text-v2-primary fw-bold text-uppercase px-4 py-2 border-end border-secondary" style="font-size: 0.75rem; letter-spacing: 0.1em; background: rgba(0,0,0,0.2);">
                <i class="fas fa-terminal me-2 pulse-anim"></i> SYS_LOG
            </div>
            <div class="ticker-content ms-3 overflow-hidden" style="flex: 1; white-space: nowrap;">
                <div class="ticker-text d-inline-block text-v2-muted" style="font-size: 0.85rem; font-family: 'SFMono-Regular', Menlo, Monaco, Consolas, monospace;">
                    <span class="text-white me-3">[SYSTEM]</span> Authentication module active and secure. <span class="mx-4 text-v2-primary">|</span> 
                    <span class="text-white me-3">[NETWORK]</span> Uplink established. Latency at 12ms. <span class="mx-4 text-v2-primary">|</span> 
                    <span class="text-white me-3">[STORAGE]</span> Node Alpha operating at normal capacity. <span class="mx-4 text-v2-primary">|</span> 
                    <span class="text-v2-success me-3">[SCANNER]</span> Background security sweep completed. 0 anomalies detected. <span class="mx-4 text-v2-primary">|</span>
                    <span class="text-white me-3">[DEPLOY]</span> Ready for new project deployment command.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Live Clock Functionality
        const clockEl = document.getElementById('liveClock');
        setInterval(() => {
            const now = new Date();
            clockEl.textContent = now.toLocaleTimeString('en-US', { hour12: false });
        }, 1000);

        const ctx = document.getElementById('trafficChart').getContext('2d');
        
        // Gradient for chart line
        let gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(240, 82, 35, 0.8)');   
        gradient.addColorStop(1, 'rgba(240, 82, 35, 0.0)');

        const trafficChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '24:00'],
                datasets: [{
                    label: 'Network Load',
                    data: [12, 19, 15, 25, 22, 30, 20],
                    borderColor: '#f05223',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#f05223',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#cbd5e1',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255,255,255,0.05)', drawBorder: false },
                        ticks: { color: 'rgba(255,255,255,0.4)', padding: 10 }
                    },
                    x: {
                        grid: { color: 'rgba(255,255,255,0.05)', drawBorder: false },
                        ticks: { color: 'rgba(255,255,255,0.4)', padding: 10 }
                    }
                }
            }
        });

        // Dynamic Theme Updater for Chart
        const updateChartTheme = () => {
            const isLight = document.documentElement.getAttribute('data-theme') === 'light';
            const gridColor = isLight ? 'rgba(0, 0, 0, 0.06)' : 'rgba(255,255,255,0.05)';
            const tickColor = isLight ? 'rgba(15, 23, 42, 0.5)' : 'rgba(255,255,255,0.4)';
            const tooltipBg = isLight ? 'rgba(255, 255, 255, 0.95)' : 'rgba(15, 23, 42, 0.9)';
            const tooltipText = isLight ? '#0f172a' : '#fff';
            const tooltipDesc = isLight ? '#475569' : '#cbd5e1';
            const tooltipBorder = isLight ? 'rgba(0,0,0,0.1)' : 'rgba(255,255,255,0.1)';
            
            trafficChart.options.scales.x.grid.color = gridColor;
            trafficChart.options.scales.y.grid.color = gridColor;
            trafficChart.options.scales.x.ticks.color = tickColor;
            trafficChart.options.scales.y.ticks.color = tickColor;
            
            trafficChart.options.plugins.tooltip.backgroundColor = tooltipBg;
            trafficChart.options.plugins.tooltip.titleColor = tooltipText;
            trafficChart.options.plugins.tooltip.bodyColor = tooltipDesc;
            trafficChart.options.plugins.tooltip.borderColor = tooltipBorder;
            
            trafficChart.update();
        };

        // Listen for Theme Toggle Clicks
        const themeToggle = document.querySelector('.theme-toggle');
        if(themeToggle) {
            themeToggle.addEventListener('click', () => {
                setTimeout(updateChartTheme, 50); // Brief delay to ensure HTML attribute updates
            });
        }
        
        // Ensure chart starts with correct theme
        updateChartTheme();
    });
</script>

<style>
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(10, 1fr);
        grid-template-rows: auto;
        gap: 1.5rem;
    }

    .bento-item {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 28px;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.1);
        transform: perspective(1000px) rotateX(0deg) rotateY(0deg);
    }

    .bento-item::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.08), transparent);
        transform: skewX(-25deg);
        z-index: 2;
        pointer-events: none;
    }

    .bento-item:hover::before {
        animation: shine 1.2s ease-out;
    }

    @keyframes shine {
        0% { left: -100%; }
        100% { left: 200%; }
    }

    .bento-item:hover {
        border-color: rgba(255, 255, 255, 0.2);
        transform: perspective(1000px) rotateX(2deg) rotateY(-2deg) translateY(-8px) scale(1.02);
        box-shadow: -10px 30px 60px -15px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    /* Ticker Styling */
    .ticker-text { animation: tickerScroll 20s linear infinite; }
    @keyframes tickerScroll {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }

    /* Live Clock */
    .live-clock {
        font-family: 'Space Grotesk', monospace;
        font-size: 1.25rem; font-weight: 800;
        background: rgba(0,0,0,0.3); border-radius: 8px; padding: 0.25rem 0.75rem;
        border: 1px solid rgba(255,255,255,0.1);
    }

    /* Stat Bento Enhancements */
    .stat-bento {
        grid-column: span 3;
        display: flex; flex-direction: column; justify-content: space-between; height: 220px;
    }
    .stat-bento.teal {
        grid-column: span 4;
    }
    
    .stat-bg-glow {
        position: absolute; bottom: 0; left: 0; right: 0; height: 100px;
        filter: blur(40px); opacity: 0.15; z-index: 0; transition: all 0.5s;
    }
    
    .stat-bento:hover .stat-bg-glow { opacity: 0.4; transform: scale(1.1); }
    
    .stat-bento > * { position: relative; z-index: 1; }
    
    .stat-bento.purple .stat-bg-glow { background: #8b5cf6; }
    .stat-bento.teal .stat-bg-glow { background: #06b6d4; }
    .stat-bento.indigo .stat-bg-glow { background: #6366f1; }

    .stat-bento.purple { border-bottom: 4px solid #8b5cf6; }
    .stat-bento.teal { border-bottom: 4px solid #06b6d4; }
    .stat-bento.indigo { border-bottom: 4px solid #6366f1; }

    .stat-bento.purple:hover { border-color: rgba(139, 92, 246, 0.6); box-shadow: 0 20px 40px -10px rgba(139, 92, 246, 0.3), inset 0 0 20px rgba(139, 92, 246, 0.1); }
    .stat-bento.teal:hover { border-color: rgba(6, 182, 212, 0.6); box-shadow: 0 20px 40px -10px rgba(6, 182, 212, 0.3), inset 0 0 20px rgba(6, 182, 212, 0.1); }
    .stat-bento.indigo:hover { border-color: rgba(99, 102, 241, 0.6); box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 0.3), inset 0 0 20px rgba(99, 102, 241, 0.1); }

    .display-font { font-family: 'Space Grotesk', system-ui, sans-serif; letter-spacing: -0.05em; font-size: 3.5rem; font-weight: 800; color: white; margin: 0.5rem 0 1rem 0; line-height: 1; }
    .bento-label { font-size: 0.75rem; font-weight: 800; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.15rem; }
    .bento-footer { display: flex; align-items: center; font-size: 0.85rem; font-weight: 600; margin-top: auto; }
    .stat-icon { font-size: 1.5rem; opacity: 0.2; }
    
    /* Mini Sparklines */
    .mini-sparkline { display: flex; align-items: flex-end; gap: 4px; height: 30px; opacity: 0.8; }
    .spark-bar { width: 8px; background: rgba(255,255,255,0.2); border-radius: 2px; transition: height 0.5s ease; }
    .mini-sparkline:hover .spark-bar { background: rgba(255,255,255,0.4); } 

    /* Hero Bento Styling */
    .hero-bento {
        grid-column: span 7;
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.95));
        display: flex;
        align-items: center;
        border: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    .hero-bento::after {
        content: ''; position: absolute; inset: 0;
        background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=') repeat;
        opacity: 0.5; z-index: 0; pointer-events: none;
    }
    
    .hero-bento:hover {
        border-color: rgba(99, 102, 241, 0.6);
        box-shadow: 0 30px 60px -10px rgba(0, 0, 0, 0.8), 0 0 40px rgba(99, 102, 241, 0.2), inset 0 0 30px rgba(99, 102, 241, 0.1);
    }

    .hero-content { position: relative; z-index: 2; width: 100%; }
    .hero-title { font-size: 2.8rem; font-weight: 800; color: white; margin-bottom: 0.5rem; letter-spacing: -0.02em; }
    .hero-subtitle { color: var(--v2-text-muted); font-size: 1.15rem; max-width: 550px; line-height: 1.6; }

    .badge-tech {
        display: inline-flex; align-items: center;
        padding: 0.4rem 1rem;
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #34d399;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.1rem;
        text-transform: uppercase;
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.2);
    }
    
    .pulse-anim { animation: pulse 2s infinite; }
    @keyframes pulse { 0% { opacity: 1; transform: scale(1); } 50% { opacity: 0.7; transform: scale(1.1); } 100% { opacity: 1; transform: scale(1); } }

    .btn-tech-primary.shadow-glow { box-shadow: 0 10px 25px -5px rgba(240, 82, 35, 0.5), inset 0 1px 1px rgba(255,255,255,0.4); }
    .btn-tech-primary.shadow-glow:hover { box-shadow: 0 15px 35px -5px rgba(240, 82, 35, 0.7), inset 0 1px 1px rgba(255,255,255,0.4); }

    .hero-decoration .glow-orb { position: absolute; border-radius: 50%; filter: blur(60px); opacity: 0.6; z-index: 1; }
    .hero-decoration .orb-1 {
        right: -10%; top: -20%; width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(240, 82, 35, 0.3) 0%, transparent 60%);
        animation: float 10s infinite alternate ease-in-out;
    }
    .hero-decoration .orb-2 {
        right: 15%; bottom: -30%; width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.3) 0%, transparent 60%);
        animation: float 12s infinite alternate-reverse ease-in-out;
    }
    
    @keyframes float { 0% { transform: translateY(0) scale(1); } 100% { transform: translateY(-30px) scale(1.1); } }

    /* Radar Bento Styling */
    .radar-bento { grid-column: span 3; position: relative; overflow: hidden; }
    .radar {
        width: 150px; height: 150px;
        border-radius: 50%;
        border: 2px solid rgba(16, 185, 129, 0.3);
        background: radial-gradient(circle, rgba(16, 185, 129, 0) 40%, rgba(16, 185, 129, 0.1) 100%);
        position: relative;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
    }
    .radar::before, .radar::after {
        content: ''; position: absolute; background: rgba(16, 185, 129, 0.2);
    }
    .radar::before { top: 50%; left: 0; width: 100%; height: 1px; }
    .radar::after { top: 0; left: 50%; width: 1px; height: 100%; }
    .sweep {
        position: absolute; top: 0; left: 50%; width: 50%; height: 50%;
        background: linear-gradient(to right, rgba(16, 185, 129, 0) 0%, rgba(16, 185, 129, 0.8) 100%);
        transform-origin: bottom left;
        animation: spin 3s linear infinite;
    }
    @keyframes spin { 100% { transform: rotate(360deg); } }
    .radar-dot {
        position: absolute; width: 6px; height: 6px;
        background: #10b981; border-radius: 50%;
        box-shadow: 0 0 5px #10b981;
    }

    /* Chart / Capacity Bento */
    .chart-bento { grid-column: span 7; display: flex; flex-direction: column; justify-content: space-between; }
    .cap-bento { grid-column: span 3; }

    .capacity-gauge {
        width: 140px; height: 140px; display: block; margin: 0 auto;
    }
    .circular-chart { display: block; margin: 0 auto; max-width: 100%; max-height: 250px; }
    .circle-bg { fill: none; stroke: rgba(255,255,255,0.05); stroke-width: 3.8; }
    .circle { 
        fill: none; stroke-width: 2.8; stroke-linecap: round;
        stroke: var(--v2-secondary, #06b6d4);
        box-shadow: 0 0 20px rgba(6, 182, 212, 0.8);
        animation: progress 2s ease-out forwards;
    }
    .percentage { fill: white; font-family: 'Space Grotesk', sans-serif; font-weight: 800; font-size: 0.5em; text-anchor: middle; text-shadow: 0 0 10px rgba(255,255,255,0.5); }
    @keyframes progress { 0% { stroke-dasharray: 0 100; } }

    /* Span Half Bentos */
    .activity-bento-span-3 { grid-column: span 5; }
    .deploy-bento { grid-column: span 5; }
    .matrix-bento-span-3 { grid-column: span 5; }
    .diag-bento-span-3 { grid-column: span 5; }

    .bento-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; position: relative; z-index: 2; }
    .bento-title { font-size: 1.25rem; font-weight: 800; margin: 0; color: white; letter-spacing: -0.02em; }
    
    .btn-link-glow { 
        color: var(--v2-primary); text-decoration: none; font-size: 0.85rem; font-weight: 700; 
        transition: 0.3s; padding: 0.4rem 0.8rem; border-radius: 8px; background: rgba(240, 82, 35, 0.05);
    }
    .btn-link-glow:hover { background: rgba(240, 82, 35, 0.1); color: white; box-shadow: 0 0 15px rgba(240, 82, 35, 0.3); }

    .live-pulse { animation: livePulse 2s infinite; }
    @keyframes livePulse { 0% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.2); opacity: 0.7; } 100% { transform: scale(1); opacity: 1; } }

    .activity-list, .deploy-list { display: flex; flex-direction: column; gap: 0.75rem; position: relative; z-index: 2; }
    .glass-panel { 
        padding: 1.25rem; background: rgba(0,0,0,0.2); backdrop-filter: blur(10px);
        border-radius: 16px; border: 1px solid rgba(255,255,255,0.03); transition: 0.3s;
    }
    
    .activity-item { display: flex; align-items: center; }
    .activity-item:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); transform: translateX(5px); }
    
    .item-icon-wrapper { padding: 4px; background: rgba(255,255,255,0.05); border-radius: 12px; }
    .item-icon { 
        width: 36px; height: 36px; background: var(--v2-gradient); border-radius: 10px;
        display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem; color: white;
        box-shadow: 0 4px 10px rgba(240, 82, 35, 0.3);
    }
    .item-info { margin-left: 1.25rem; }
    .item-name { font-weight: 700; font-size: 1rem; }
    
    .badge-cyber { 
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); 
        padding: 0.25rem 0.75rem; border-radius: 100px; font-size: 0.7rem; font-weight: 600; color: rgba(255,255,255,0.7);
    }

    .empty-state-glass { 
        text-align: center; color: rgba(255,255,255,0.4); font-weight: 600; 
        background: rgba(0,0,0,0.2); border-radius: 16px; border: 1px dashed rgba(255,255,255,0.1); 
    }
    .empty-icon { font-size: 2rem; margin-bottom: 1rem; opacity: 0.5; }

    .matrix-cell.glass-panel:hover { border-color: rgba(6, 182, 212, 0.3); background: rgba(6, 182, 212, 0.05); }
    
    .cell-progress { height: 6px; background: rgba(0,0,0,0.5); border-radius: 10px; overflow: hidden; box-shadow: inset 0 1px 3px rgba(0,0,0,0.5); }
    .progress-glow { background: linear-gradient(90deg, #06b6d4, #3b82f6); box-shadow: 0 0 10px rgba(6, 182, 212, 0.8); border-radius: 10px; position: relative; }
    .progress-glow::after { content: ''; position: absolute; top:0; left:0; right:0; bottom:0; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); animation: progressShine 2s infinite linear; }
    @keyframes progressShine { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }

    .status-indicator { display: flex; align-items: center; gap: 0.5rem; color: #10b981; font-weight: 700; text-shadow: 0 0 10px rgba(16, 185, 129, 0.5); }
    .pulse-dot { width: 8px; height: 8px; border-radius: 50%; box-shadow: 0 0 10pxcurrentColor; animation: pulse 2s infinite; }
    
    .badge-glow-success { color: #10b981; text-shadow: 0 0 10px rgba(16, 185, 129, 0.4); }
    .badge-glow-warning { color: #f59e0b; text-shadow: 0 0 10px rgba(245, 158, 11, 0.4); }
    .badge-glow-info { color: #0ea5e9; text-shadow: 0 0 10px rgba(14, 165, 233, 0.4); }

    .wave { display: inline-block; animation: wave-anim 2.5s infinite; transform-origin: 70% 70%; }
    @keyframes wave-anim {
        0%, 100% { transform: rotate(0deg); }
        20% { transform: rotate(-10deg); }
        40% { transform: rotate(10deg); }
        60% { transform: rotate(-10deg); }
        80% { transform: rotate(10deg); }
    }

    @media (max-width: 1400px) {
        .bento-item { padding: 1.5rem; }
        .hero-title { font-size: 2.3rem; }
    }

    @media (max-width: 1200px) {
        .bento-grid { grid-template-columns: repeat(2, 1fr); }
        .hero-bento, .chart-bento { grid-column: span 2; }
        .radar-bento, .cap-bento { grid-column: span 1; }
        .stat-bento { grid-column: span 1 !important; }
        .activity-bento-span-3, .deploy-bento, .matrix-bento-span-3, .diag-bento-span-3 { grid-column: span 2; }
    }

    @media (max-width: 768px) {
        .bento-grid { grid-template-columns: 1fr; }
        .bento-item, .hero-bento, .chart-bento, .radar-bento, .cap-bento, 
        .activity-bento-span-3, .deploy-bento, .matrix-bento-span-3, .diag-bento-span-3,
        .stat-bento { grid-column: span 1 !important; }
        .hero-title { font-size: 1.8rem; }
        .diag-list, .matrix-grid { grid-template-columns: 1fr !important; }
    }

    /* =========================================
       LIGHT MODE BENTO OVERRIDES 2.0
       ========================================= */
       
    [data-theme="light"] .bento-item {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(40px);
        -webkit-backdrop-filter: blur(40px);
        border: 1px solid rgba(255, 255, 255, 1);
        box-shadow: 0 20px 50px rgba(100, 116, 139, 0.08), inset 0 2px 0 rgba(255,255,255,0.8);
    }
    
    [data-theme="light"] .bento-item:hover {
        border-color: rgba(240, 82, 35, 0.4);
        box-shadow: -10px 30px 60px rgba(240, 82, 35, 0.15), inset 0 2px 0 rgba(255, 255, 255, 1);
        transform: perspective(1000px) rotateX(2deg) rotateY(-2deg) translateY(-8px) scale(1.02);
    }
    
    [data-theme="light"] .hero-bento {
        background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(248,250,252,0.8));
        box-shadow: 0 30px 60px rgba(99, 102, 241, 0.05), inset 0 2px 0 rgba(255,255,255,1);
    }
    [data-theme="light"] .hero-bento:hover {
        box-shadow: -10px 40px 80px rgba(99, 102, 241, 0.12), inset 0 2px 0 rgba(255,255,255,1);
    }
    
    [data-theme="light"] .live-clock {
        background: rgba(15, 23, 42, 0.05);
        color: #0f172a !important;
        border: 1px solid rgba(0,0,0,0.1);
    }
    
    [data-theme="light"] .ticker-label {
        background: #f1f5f9 !important;
        border-right: 1px solid #e2e8f0 !important;
    }
    
    [data-theme="light"] .spark-bar {
        background: rgba(15, 23, 42, 0.1);
    }
    [data-theme="light"] .mini-sparkline:hover .spark-bar {
        background: rgba(15, 23, 42, 0.2);
    }
    
    [data-theme="light"] .hero-title,
    [data-theme="light"] .bento-title,
    [data-theme="light"] .display-font,
    [data-theme="light"] .item-name,
    [data-theme="light"] .cell-count {
        color: #0f172a !important;
    }
    
    [data-theme="light"] .bento-label,
    [data-theme="light"] .hero-subtitle,
    [data-theme="light"] .percentage {
        color: #64748b !important;
    }
    [data-theme="light"] .percentage { text-shadow: none; }
    
    [data-theme="light"] .glass-panel {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }
    
    [data-theme="light"] .activity-item:hover {
        background: rgba(255, 255, 255, 0.95);
        border-color: rgba(240, 82, 35, 0.4);
        box-shadow: 0 15px 35px rgba(240, 82, 35, 0.1);
    }
    
    [data-theme="light"] .badge-cyber {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(226, 232, 240, 0.8);
        color: #475569;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }
    
    [data-theme="light"] .radar {
        border-color: rgba(16, 185, 129, 0.3);
        background: radial-gradient(circle, rgba(16, 185, 129, 0) 40%, rgba(16, 185, 129, 0.08) 100%);
        box-shadow: 0 0 30px rgba(16, 185, 129, 0.15);
    }

    [data-theme="light"] .empty-state-glass {
        background: rgba(255, 255, 255, 0.5);
        border-color: rgba(203, 213, 225, 0.8);
        color: #64748b;
    }
    
    [data-theme="light"] .stat-bento.purple { border-bottom: 4px solid rgba(139, 92, 246, 0.8); }
    [data-theme="light"] .stat-bento.teal { border-bottom: 4px solid rgba(6, 182, 212, 0.8); }
    [data-theme="light"] .stat-bento.indigo { border-bottom: 4px solid rgba(99, 102, 241, 0.8); }
</style>
@endsection
