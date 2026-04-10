@extends('layouts.admin')

@section('content')

{{-- ===== TOP WELCOME BANNER (NEO-GLASS UPGRADE) ===== --}}
<div class="dash-welcome mb-4">
    <div class="welcome-mesh-wrap">
        <div class="welcome-mesh"></div>
    </div>
    <div class="welcome-left">
        <div class="welcome-badge-v2">
            <span class="status-glow"></span>
            <span class="pulse-dot bg-success me-2"></span>
            ALL SYSTEMS OPERATIONAL
        </div>
        <h1 class="welcome-heading">Welcome back, <span class="text-gradient-neo">{{ auth()->user()->name ?? 'Admin' }}</span> 👋</h1>
        <p class="welcome-sub">{{ date('l, F j, Y') }} — Here's your agency overview at a glance.</p>
        
        <div class="welcome-actions mt-4">
            <a href="{{ route('admin.projects.create') }}" class="btn-neo-glass primary">
                <i class="fas fa-plus"></i><span>New Project</span>
            </a>
            <a href="{{ route('admin.inquiries.index') }}" class="btn-neo-glass">
                <i class="fas fa-inbox"></i><span>Inquiries</span>
                @if($quick['unread_msgs'] > 0)<span class="notif-dot-v2">{{ $quick['unread_msgs'] }}</span>@endif
            </a>
            <a href="{{ route('admin.blog.create') }}" class="btn-neo-glass">
                <i class="fas fa-pen-nib"></i><span>New Post</span>
            </a>
        </div>
    </div>
    <div class="welcome-right">
        <div class="time-capsule">
            <div class="capsule-glass"></div>
            <div class="capsule-content">
                <div class="capsule-label">Local Time</div>
                <div class="clock-time-v2" id="liveClock">00:00:00</div>
                <div class="clock-date-v2">{{ date('D, d M Y') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ===== KPI STAT CARDS ===== --}}
<div class="kpi-grid mb-4">
    @php
    $kpis = [
        ['label'=>'Pipeline Value','value'=>'$'.number_format($stats['pipeline_value'],0),'icon'=>'fa-hand-holding-usd','color'=>'orange','trend'=>number_format($stats['conversion_rate'],1).'% Conv.'],
        ['label'=>'Active Clients','value'=>$stats['clients'],'icon'=>'fa-user-tie','color'=>'blue','trend'=>'Connected'],
        ['label'=>'Total Projects','value'=>$stats['projects'],'icon'=>'fa-layer-group','color'=>'purple','trend'=>'+12%'],
        ['label'=>'New Inquiries','value'=>$stats['new_inquiries'],'icon'=>'fa-envelope-open-text','color'=>'orange','trend'=>'Awaiting'],
        ['label'=>'Subscribers','value'=>$stats['subscribers'],'icon'=>'fa-bell','color'=>'teal','trend'=>'Growing'],
        ['label'=>'Active Services','value'=>$stats['services'],'icon'=>'fa-concierge-bell','color'=>'indigo','trend'=>'+5%'],
        ['label'=>'Blog Posts','value'=>$stats['blog_posts'],'icon'=>'fa-newspaper','color'=>'rose','trend'=>'Published'],
        ['label'=>'Team Members','value'=>$stats['team'],'icon'=>'fa-users','color'=>'indigo','trend'=>'Stable'],
    ];
    @endphp
    @foreach($kpis as $kpi)
    <div class="kpi-card kpi-{{ $kpi['color'] }}">
        <div class="kpi-glow"></div>
        <div class="kpi-top">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpi['icon'] }}"></i></div>
            <span class="kpi-trend">{{ $kpi['trend'] }}</span>
        </div>
        <div class="kpi-value">{{ $kpi['value'] }}</div>
        <div class="kpi-label">{{ $kpi['label'] }}</div>
    </div>
    @endforeach
</div>

{{-- ===== STRATEGIC ACTION CENTER (PAHSE 5 REMINDERS) ===== --}}
@if($quick['upcoming_reminders']->count() > 0)
<div class="dash-card action-center mb-4">
    <div class="card-header-row mb-3">
        <h5 class="card-title"><i class="fas fa-bullseye me-2 text-v2-primary"></i>Strategic Action Center</h5>
        <span class="badge-v2 indigo">{{ $quick['upcoming_reminders']->count() }} PENDING FOLLOW-UPS</span>
    </div>
    <div class="reminder-grid">
        @foreach($quick['upcoming_reminders'] as $rem)
        <div class="reminder-item">
            <div class="reminder-time">
                <div class="rem-day">{{ $rem->remind_at->format('d') }}</div>
                <div class="rem-month">{{ $rem->remind_at->format('M') }}</div>
            </div>
            <div class="reminder-content">
                <div class="rem-name text-white fw-bold">{{ $rem->name }}</div>
                <div class="rem-subject text-v2-muted small">{{ Str::limit($rem->subject, 30) }}</div>
            </div>
            <div class="reminder-actions">
                <span class="badge-v2 {{ $rem->priority == 'high' ? 'rose' : ($rem->priority == 'medium' ? 'indigo' : 'turquoise') }} me-2">
                    {{ strtoupper($rem->priority) }}
                </span>
                <a href="{{ route('admin.inquiries.show', $rem->id) }}" class="action-btn-v2">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
.reminder-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem; }
.reminder-item { display: flex; align-items: center; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 1rem; transition: .3s; }
.reminder-item:hover { transform: scale(1.02); border-color: var(--v2-primary); background: rgba(240,82,35,0.05); }
.reminder-time { width: 50px; text-align: center; border-right: 1px solid rgba(255,255,255,0.1); margin-right: 1rem; padding-right: 1rem; flex-shrink: 0; }
.rem-day { font-size: 1.2rem; font-weight: 800; color: var(--v2-primary); line-height: 1; }
.rem-month { font-size: 0.7rem; font-weight: 800; color: #fff; text-transform: uppercase; }
.reminder-content { flex: 1; min-width: 0; }
.reminder-actions { display: flex; align-items: center; }
[data-theme="light"] .reminder-item { background: #f8fafc; border-color: #e2e8f0; }
[data-theme="light"] .rem-month { color: #0f172a; }
</style>
@endif

{{-- ===== ELITE CHARTS ROW (NEO-GLASS DESIGN) ===== --}}
<div class="charts-elite-row mb-4">
    {{-- Elite Growth Pulse Chart --}}
    <div class="elite-card growth-card">
        <div class="elite-header">
            <div>
                <h5 class="elite-title"><div class="elite-icon bg-v2-primary"><i class="fas fa-wave-square"></i></div>Growth Pulse</h5>
                <p class="elite-sub">Inquiries vs. Projects (6 Months)</p>
            </div>
            <div class="elite-legend">
                <div class="elite-legend-item"><span class="legend-pip bg-primary-glow"></span>Inquiries</div>
                <div class="elite-legend-item"><span class="legend-pip bg-purple-glow"></span>Projects</div>
            </div>
        </div>
        <div class="elite-chart-wrapper"><canvas id="growthChart"></canvas></div>
    </div>

    {{-- Elite Categories Ring --}}
    <div class="elite-card donut-card">
        <div class="elite-header">
            <h5 class="elite-title"><div class="elite-icon bg-info"><i class="fas fa-meteor"></i></div>Sector Scan</h5>
        </div>
        <div class="donut-wrapper">
            <canvas id="donutChart"></canvas>
            <div class="donut-center-text">
                <span class="donut-total">{{ $stats['projects'] }}</span>
                <span class="donut-label">Total</span>
            </div>
        </div>
        <div class="donut-legend-grid" id="donutLegend"></div>
    </div>
</div>

{{-- ===== ACTIVITY ROW ===== --}}
<div class="activity-row mb-4">
    {{-- Recent Inquiries --}}
    <div class="dash-card flex-card">
        <div class="card-header-row">
            <h5 class="card-title"><i class="fas fa-inbox me-2" style="color:#f59e0b;"></i>Recent Inquiries</h5>
            <a href="{{ route('admin.inquiries.index') }}" class="see-all-link">See All <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="inquiry-list">
            @forelse($recent_inquiries->take(5) as $inq)
            <div class="inq-item">
                <div class="inq-avatar">{{ strtoupper(substr($inq->name,0,1)) }}</div>
                <div class="inq-info">
                    <div class="inq-name">{{ $inq->name }}</div>
                    <div class="inq-sub">{{ \Illuminate\Support\Str::limit($inq->subject,40) }}</div>
                </div>
                <div class="inq-meta">
                    @php
                        $statusColors = [
                            'new' => '#3b82f6',
                            'contacted' => '#f59e0b',
                            'qualified' => '#8b5cf6',
                            'proposal_sent' => '#06b6d4',
                            'won' => '#10b981',
                            'lost' => '#ef4444'
                        ];
                        $sColor = $statusColors[$inq->status] ?? '#94a3b8';
                    @endphp
                    <span class="inq-status" style="background: {{ $sColor }}20; color: {{ $sColor }}; border: 1px solid {{ $sColor }}30;">{{ strtoupper($inq->status) }}</span>
                    <span class="inq-time">{{ $inq->created_at->diffForHumans(null,true) }}</span>
                </div>
            </div>
            @empty
            <div class="empty-dash"><i class="fas fa-inbox-in"></i><p>No inquiries yet</p></div>
            @endforelse
        </div>
    </div>

    {{-- Recent Projects --}}
    <div class="dash-card flex-card">
        <div class="card-header-row">
            <h5 class="card-title"><i class="fas fa-rocket me-2" style="color:#8b5cf6;"></i>Recent Projects</h5>
            <a href="{{ route('admin.projects.index') }}" class="see-all-link">See All <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="project-list">
            @forelse($recent_projects->take(5) as $proj)
            <div class="proj-item">
                <div class="proj-thumb">
                    @if($proj->thumbnail)
                        <img src="{{ asset('uploads/projects/'.$proj->thumbnail) }}" alt="{{ $proj->title }}">
                    @else
                        <div class="proj-thumb-fallback"><i class="fas fa-image"></i></div>
                    @endif
                </div>
                <div class="proj-info">
                    <div class="proj-title">{{ $proj->title }}</div>
                    <div class="proj-cat">{{ $proj->categories->first()->name ?? 'Uncategorized' }}</div>
                </div>
                <div class="proj-date">{{ $proj->created_at->format('d M') }}</div>
            </div>
            @empty
            <div class="empty-dash"><i class="fas fa-folder-open"></i><p>No projects yet</p></div>
            @endforelse
        </div>
    </div>
</div>

{{-- ===== BOTTOM ROW: Blog + Quick Links + System Health ===== --}}
<div class="bottom-row mb-4">
    {{-- Recent Blog Posts --}}
    <div class="dash-card">
        <div class="card-header-row">
            <h5 class="card-title"><i class="fas fa-newspaper me-2" style="color:#06b6d4;"></i>Latest Posts</h5>
            <a href="{{ route('admin.blog.index') }}" class="see-all-link">See All <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="blog-list">
            @forelse($recent_blog->take(4) as $post)
            <div class="blog-item">
                <div class="blog-dot"></div>
                <div class="blog-info">
                    <div class="blog-title">{{ \Illuminate\Support\Str::limit($post->title,45) }}</div>
                    <div class="blog-date">{{ $post->created_at->format('M d, Y') }}</div>
                </div>
                <a href="{{ route('admin.blog.edit',$post->id) }}" class="blog-edit-btn"><i class="fas fa-pen"></i></a>
            </div>
            @empty
            <div class="empty-dash"><i class="fas fa-pen-nib"></i><p>No posts yet</p></div>
            @endforelse
        </div>
    </div>

    {{-- Quick Links Panel --}}
    <div class="dash-card quick-links-card">
        <h5 class="card-title mb-4"><i class="fas fa-bolt me-2 text-v2-primary"></i>Quick Actions</h5>
        <div class="quick-grid">
            <a href="{{ route('admin.projects.create') }}" class="quick-link-btn"><i class="fas fa-plus-circle"></i><span>Add Project</span></a>
            <a href="{{ route('admin.services.create') }}" class="quick-link-btn"><i class="fas fa-concierge-bell"></i><span>Add Service</span></a>
            <a href="{{ route('admin.blog.create') }}" class="quick-link-btn"><i class="fas fa-pen-alt"></i><span>New Post</span></a>
            <a href="{{ route('admin.team.create') }}" class="quick-link-btn"><i class="fas fa-user-plus"></i><span>Add Member</span></a>
            <a href="{{ route('admin.testimonials.create') }}" class="quick-link-btn"><i class="fas fa-star"></i><span>Add Review</span></a>
            <a href="{{ route('admin.hero-slides.create') }}" class="quick-link-btn"><i class="fas fa-images"></i><span>New Slide</span></a>
            <a href="{{ route('admin.settings.index') }}" class="quick-link-btn"><i class="fas fa-cog"></i><span>Settings</span></a>
            <a href="{{ route('admin.subscribers.index') }}" class="quick-link-btn"><i class="fas fa-bell"></i><span>Subscribers</span></a>
        </div>
    </div>

    {{-- System Health --}}
    <div class="dash-card system-health-card">
        <h5 class="card-title mb-4"><i class="fas fa-heartbeat me-2" style="color:#10b981;"></i>System Health</h5>
        <div class="health-list">
            <div class="health-item">
                <span class="health-label">Web Server</span>
                <span class="health-status online"><span class="pulse-dot bg-success me-1"></span>Online</span>
            </div>
            <div class="health-item">
                <span class="health-label">Database</span>
                <span class="health-status online"><span class="pulse-dot bg-success me-1"></span>Connected</span>
            </div>
            <div class="health-item">
                <span class="health-label">PHP Runtime</span>
                <span class="health-val">{{ PHP_VERSION }}</span>
            </div>
            <div class="health-item">
                <span class="health-label">Laravel</span>
                <span class="health-val">v{{ app()->version() }}</span>
            </div>
            <div class="health-item">
                <span class="health-label">Environment</span>
                <span class="health-val">{{ ucfirst(app()->environment()) }}</span>
            </div>
            <div class="health-item">
                <span class="health-label">Cache Driver</span>
                <span class="health-val">{{ ucfirst(config('cache.default')) }}</span>
            </div>
            <div class="health-item">
                <span class="health-label">Security</span>
                <span class="health-status online"><span class="pulse-dot bg-success me-1"></span>Shielded</span>
            </div>
            <div class="health-item">
                <span class="health-label">Debug Mode</span>
                <span class="health-status {{ config('app.debug') ? 'warn' : 'online' }}">
                    <span class="pulse-dot {{ config('app.debug') ? 'bg-warning' : 'bg-success' }} me-1"></span>
                    {{ config('app.debug') ? 'ON' : 'OFF' }}
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ===== CATEGORY BREAKDOWN FULL ROW ===== --}}
<div class="dash-card mb-4">
    <div class="card-header-row">
        <h5 class="card-title"><i class="fas fa-cubes me-2" style="color:#06b6d4;"></i>Project Category Breakdown</h5>
        <a href="{{ route('admin.project-categories.index') }}" class="see-all-link">Manage <i class="fas fa-arrow-right ms-1"></i></a>
    </div>
    <div class="cat-grid mt-3">
        @forelse($category_stats as $cat)
        @php $pct = $cat->projects_count > 0 ? min(($cat->projects_count / max($category_stats->max('projects_count'),1)) * 100, 100) : 0; @endphp
        <div class="cat-item">
            <div class="cat-head">
                <span class="cat-name">{{ $cat->name }}</span>
                <span class="cat-count">{{ str_pad($cat->projects_count,2,'0',STR_PAD_LEFT) }}</span>
            </div>
            <div class="cat-bar-track"><div class="cat-bar-fill" style="width:{{ $pct }}%"></div></div>
        </div>
        @empty
        <div class="empty-dash col-span-all"><i class="fas fa-folder"></i><p>No categories yet</p></div>
        @endforelse
    </div>
</div>

{{-- ===== LIVE TICKER ===== --}}
<div class="sys-ticker mb-2">
    <div class="ticker-tag"><i class="fas fa-terminal me-2 pulse-anim"></i>SYS_LOG</div>
    <div class="ticker-track"><div class="ticker-scroll">
        <span class="text-v2-primary me-2">[SYSTEM]</span> Auth active &amp; secure.
        <span class="ticker-sep">|</span>
        <span class="text-v2-primary me-2">[CONTENT]</span> {{ $stats['projects'] }} projects deployed. {{ $stats['blog_posts'] }} blog posts published.
        <span class="ticker-sep">|</span>
        <span class="text-v2-primary me-2">[LEADS]</span> {{ $stats['total_inquiries'] }} total inquiries. {{ $stats['new_inquiries'] }} new unread.
        <span class="ticker-sep">|</span>
        <span class="text-success me-2">[TEAM]</span> {{ $stats['team'] }} active team members. {{ $stats['subscribers'] }} subscribers.
        <span class="ticker-sep">|</span>
        <span class="text-v2-primary me-2">[STATUS]</span> All systems nominal. Ready for new commands.
    </div></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live Clock
    const clockEl = document.getElementById('liveClock');
    const updateClock = () => { clockEl.textContent = new Date().toLocaleTimeString('en-US',{hour12:false}); };
    updateClock(); setInterval(updateClock, 1000);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isLight = () => document.documentElement.getAttribute('data-theme') === 'light';
    const gridColor = () => isLight() ? 'rgba(0,0,0,0.04)' : 'rgba(255,255,255,0.03)';
    const tickColor = () => isLight() ? 'rgba(15,23,42,0.4)' : 'rgba(255,255,255,0.4)';
    const tooltipBg = () => isLight() ? 'rgba(255,255,255,0.95)' : 'rgba(15,23,42,0.9)';
    const tooltipText = () => isLight() ? '#0f172a' : '#fff';

    // Elite Growth Chart
    const gCtx = document.getElementById('growthChart').getContext('2d');
    
    let gInqGrad = gCtx.createLinearGradient(0,0,0,350);
    gInqGrad.addColorStop(0,'rgba(240,82,35,0.5)');
    gInqGrad.addColorStop(1,'rgba(240,82,35,0.0)');
    
    let gProjGrad = gCtx.createLinearGradient(0,0,0,350);
    gProjGrad.addColorStop(0,'rgba(139,92,246,0.5)');
    gProjGrad.addColorStop(1,'rgba(139,92,246,0.0)');

    const growthChart = new Chart(gCtx, {
        type: 'line',
        data: {
            labels: @json($monthly_labels),
            datasets: [
                { 
                    label: 'Inquiries', 
                    data: @json($monthly_inquiries), 
                    borderColor: '#f05223', 
                    backgroundColor: gInqGrad, 
                    borderWidth: 4,
                    pointBackgroundColor: '#0f172a',
                    pointBorderColor: '#f05223',
                    pointBorderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.5
                },
                { 
                    label: 'Projects',  
                    data: @json($monthly_projects),  
                    borderColor: '#8b5cf6', 
                    backgroundColor: gProjGrad, 
                    borderWidth: 4,
                    pointBackgroundColor: '#0f172a',
                    pointBorderColor: '#8b5cf6',
                    pointBorderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.5
                }
            ]
        },
        options: {
            responsive: true, 
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: { 
                    backgroundColor: tooltipBg(), 
                    titleColor: tooltipText(), 
                    bodyColor: '#94a3b8', 
                    titleFont: { size: 14, family: "'Space Grotesk', sans-serif" },
                    padding: 14, 
                    cornerRadius: 16,
                    borderColor: 'rgba(255,255,255,0.08)',
                    borderWidth: 1,
                    boxPadding: 6,
                    usePointStyle: true,
                    boxWidth: 8,
                    boxHeight: 8
                }
            },
            scales: {
                x: { 
                    grid: { display: false, drawBorder: false }, 
                    ticks: { color: tickColor(), font: { size: 12, family: "'Space Grotesk', sans-serif" }, padding: 10 } 
                },
                y: { 
                    beginAtZero: true, 
                    grid: { color: gridColor(), drawBorder: false, borderDash: [6, 6] }, 
                    ticks: { color: tickColor(), font: { size: 12, family: "'Space Grotesk', sans-serif" }, padding: 15 } 
                }
            }
        }
    });

    // Elite Donut Chart
    const dCtx = document.getElementById('donutChart').getContext('2d');
    const catNames = @json($category_stats->pluck('name'));
    const catCounts = @json($category_stats->pluck('projects_count'));
    const donutColors = ['#f05223','#8b5cf6','#06b6d4','#10b981','#f59e0b','#ec4899'];
    
    // Add glowing drop shadow to canvas
    Chart.defaults.elements.arc.borderWidth = 0;
    
    const donutChart = new Chart(dCtx, {
        type: 'doughnut',
        data: { 
            labels: catNames, 
            datasets: [{ 
                data: catCounts.length ? catCounts : [1], 
                backgroundColor: catCounts.length ? donutColors.slice(0,catNames.length) : ['rgba(255,255,255,0.05)'], 
                hoverOffset: 10,
                borderRadius: 4
            }] 
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            cutout: '82%', 
            plugins: { 
                legend: { display: false }, 
                tooltip: { 
                    enabled: catCounts.length > 0, 
                    backgroundColor: tooltipBg(), 
                    titleColor: tooltipText(), 
                    bodyColor: '#94a3b8',
                    cornerRadius: 12,
                    padding: 12,
                    borderColor: 'rgba(255,255,255,0.08)',
                    borderWidth: 1
                } 
            } 
        }
    });

    // Elite Donut Legend Loop
    const legendEl = document.getElementById('donutLegend');
    catNames.forEach((n,i) => { 
        legendEl.innerHTML += `
        <div class="donut-legend-item">
            <span class="d-leg-color" style="background:${donutColors[i]||'#94a3b8'}; box-shadow: 0 0 10px ${donutColors[i]||'#94a3b8'};"></span>
            <span class="d-leg-name">${n}</span>
            <span class="d-leg-val">${catCounts[i]||0}</span>
        </div>`; 
    });

    // Theme toggle update
    const updateTheme = () => {
        const tBg=tooltipBg(), tTxt=tooltipText(), gc=gridColor(), tc=tickColor();
        [growthChart, donutChart].forEach(c => { 
            if(c.options.plugins.tooltip) { c.options.plugins.tooltip.backgroundColor = tBg; c.options.plugins.tooltip.titleColor = tTxt; } 
            c.update(); 
        });
        growthChart.options.scales.x.grid.color = gc; growthChart.options.scales.y.grid.color = gc;
        growthChart.options.scales.x.ticks.color = tc; growthChart.options.scales.y.ticks.color = tc;
        growthChart.update();
    };
    document.querySelector('.theme-toggle')?.addEventListener('click', () => setTimeout(updateTheme, 50));
    updateTheme();
});
</script>

<style>
/* Elite Charts Row */
.charts-elite-row { display: grid; grid-template-columns: 7fr 3fr; gap: 1.5rem; }
.elite-card { min-width: 0; background: rgba(15,23,42,0.4); border: 1px solid rgba(255,255,255,0.06); backdrop-filter: blur(24px); border-radius: 28px; padding: 1.75rem; display: flex; flex-direction: column; position: relative; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
.elite-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent); }
.elite-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 2rem; position: relative; z-index: 2; }
.elite-title { display: flex; align-items: center; gap: 0.75rem; font-size: 1.1rem; font-weight: 800; color: #fff; margin: 0; letter-spacing: -0.02em; }
.elite-icon { width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; color: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.3); flex-shrink: 0; }
.elite-sub { font-size: 0.75rem; color: rgba(255,255,255,0.4); margin: 0.25rem 0 0 2.8rem; flex-wrap: wrap;}
.elite-legend { display: flex; flex-wrap: wrap; gap: 0.75rem; background: rgba(0,0,0,0.2); padding: 0.5rem 1rem; border-radius: 100px; border: 1px solid rgba(255,255,255,0.03); }
.elite-legend-item { display: flex; align-items: center; gap: 0.5rem; font-size: 0.7rem; font-weight: 700; color: rgba(255,255,255,0.7); text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap; }
.legend-pip { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
.bg-primary-glow { background: #f05223; box-shadow: 0 0 10px #f05223; }
.bg-purple-glow { background: #8b5cf6; box-shadow: 0 0 10px #8b5cf6; }
.elite-chart-wrapper { position: relative; height: 260px; width: 100%; min-width: 0; z-index: 2; }

/* Donut Specifics */
.donut-card { align-items: center; justify-content: flex-start; }
.donut-card .elite-header { width: 100%; align-items: center; flex-direction: column; text-align: center; margin-bottom: 1.5rem; justify-content: center; }
.donut-wrapper { position: relative; width: 100%; max-width: 220px; aspect-ratio: 1/1; height: auto; display: flex; align-items: center; justify-content: center; margin: 0 auto; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.4)); }
.donut-center-text { position: absolute; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%; height: 100%; }
.donut-total { font-family: 'Space Grotesk', sans-serif; font-size: clamp(2rem, 5vw, 2.8rem); font-weight: 800; color: #fff; line-height: 1; margin-top: -0.5rem; }
.donut-label { font-size: 0.7rem; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.1em; margin-top: 0.25rem; font-weight: 700; }
.donut-legend-grid { margin-top: 1.5rem; width: 100%; display: grid; grid-template-columns: 1fr; gap: 0.5rem; max-height: 140px; overflow-y: auto; padding-right: 5px; }
.donut-legend-grid::-webkit-scrollbar { width: 4px; }
.donut-legend-grid::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
[data-theme="light"] .donut-legend-grid::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); }
.donut-legend-item { display: flex; align-items: center; background: rgba(0,0,0,0.15); border: 1px solid rgba(255,255,255,0.03); border-radius: 12px; padding: 0.4rem 0.6rem; gap: 0.5rem; }
.d-leg-color { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.d-leg-name { font-size: 0.65rem; color: rgba(255,255,255,0.6); font-weight: 600; text-transform: uppercase; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.d-leg-val { font-size: 0.85rem; font-weight: 800; color: #fff; font-family: 'Space Grotesk', sans-serif; }

<style>
:root{ --dash-radius:20px; --dash-pad:1.75rem; }

/* Welcome Banner (Neo-Glass) */
.dash-welcome {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 3.5rem 3rem;
    background: #0f172a;
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 32px;
    overflow: hidden;
    gap: 3rem;
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}

.welcome-mesh-wrap {
    position: absolute;
    inset: 0;
    z-index: 1;
    overflow: hidden;
    opacity: 0.8;
}

.welcome-mesh {
    position: absolute;
    width: 200%;
    height: 200%;
    top: -50%;
    left: -50%;
    background: 
        radial-gradient(circle at 70% 30%, rgba(240,82,35,0.15), transparent 40%),
        radial-gradient(circle at 20% 70%, rgba(139,92,246,0.15), transparent 40%),
        radial-gradient(circle at 80% 80%, rgba(6,182,212,0.1), transparent 40%);
    filter: blur(60px);
    animation: meshFlow 20s linear infinite;
}

@keyframes meshFlow {
    0% { transform: rotate(0deg) scale(1); }
    50% { transform: rotate(180deg) scale(1.1); }
    100% { transform: rotate(360deg) scale(1); }
}

.welcome-left, .welcome-right { position: relative; z-index: 2; }

.welcome-badge-v2 {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.25rem;
    background: rgba(16,185,129,0.08);
    border: 1px solid rgba(16,185,129,0.2);
    color: #10b981;
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.1rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}

.status-glow {
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(52,211,153,0.1), transparent);
    animation: statusSlide 3s ease-in-out infinite;
}

@keyframes statusSlide {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.welcome-heading { font-size: 3rem; font-weight: 900; color: #fff; letter-spacing: -0.04em; margin-bottom: 0.75rem; line-height: 1.1; }
.text-gradient-neo { background: linear-gradient(135deg, #fff 30%, #f05223 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

.welcome-sub { font-size: 1.1rem; color: rgba(255,255,255,0.4); font-weight: 500; }

/* Buttons */
.welcome-actions { display: flex; gap: 1rem; flex-wrap: wrap; }

.notif-dot-v2 {
    background: #ef4444;
    color: #fff;
    font-size: 0.65rem;
    padding: 2px 6px;
    border-radius: 6px;
    font-weight: 900;
    box-shadow: 0 0 10px rgba(239,68,68,0.4);
}


/* Time Capsule */
.time-capsule {
    width: 200px;
    height: 180px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 40px;
    overflow: hidden;
}

.capsule-glass {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 40px;
    box-shadow: inset 0 0 20px rgba(255,255,255,0.02);
}

.capsule-content { text-align: center; position: relative; z-index: 2; }
.capsule-label { font-size: 0.65rem; font-weight: 800; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 0.2rem; margin-bottom: 0.5rem; }
.clock-time-v2 { font-family: 'Space Grotesk', monospace; font-size: 2.8rem; font-weight: 800; color: #fff; letter-spacing: -0.02em; line-height: 1; }
.clock-date-v2 { font-size: 0.85rem; color: rgba(240,82,35,0.8); font-weight: 700; margin-top: 0.75rem; letter-spacing: 0.05em; }

/* KPI Grid */
.kpi-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:1.25rem;}
.kpi-card{border-radius:22px;padding:1.75rem;position:relative;overflow:hidden;cursor:default;transition:all .4s cubic-bezier(.25,1,.5,1);border:1px solid rgba(255,255,255,.06);background:rgba(15,23,42,.5);backdrop-filter:blur(20px);}
.kpi-card:hover{transform:translateY(-6px);border-color:rgba(255,255,255,.15);box-shadow:0 20px 50px rgba(0,0,0,.4);}
.kpi-glow{position:absolute;inset:0;opacity:.12;z-index:0;transition:.4s;}
.kpi-card:hover .kpi-glow{opacity:.3;}
.kpi-purple .kpi-glow,.kpi-purple{border-bottom:3px solid #8b5cf6;} .kpi-purple .kpi-glow{background:radial-gradient(circle at 30% 70%,#8b5cf6,transparent 70%);}
.kpi-blue  .kpi-glow,.kpi-blue  {border-bottom:3px solid #3b82f6;} .kpi-blue   .kpi-glow{background:radial-gradient(circle at 30% 70%,#3b82f6,transparent 70%);}
.kpi-indigo.kpi-glow,.kpi-indigo{border-bottom:3px solid #6366f1;} .kpi-indigo .kpi-glow{background:radial-gradient(circle at 30% 70%,#6366f1,transparent 70%);}
.kpi-orange.kpi-glow,.kpi-orange{border-bottom:3px solid #f05223;} .kpi-orange .kpi-glow{background:radial-gradient(circle at 30% 70%,#f05223,transparent 70%);}
.kpi-teal  .kpi-glow,.kpi-teal  {border-bottom:3px solid #06b6d4;} .kpi-teal   .kpi-glow{background:radial-gradient(circle at 30% 70%,#06b6d4,transparent 70%);}
.kpi-rose  .kpi-glow,.kpi-rose  {border-bottom:3px solid #ec4899;} .kpi-rose   .kpi-glow{background:radial-gradient(circle at 30% 70%,#ec4899,transparent 70%);}
.kpi-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;position:relative;z-index:1;}
.kpi-icon-wrap{width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,.06);display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:rgba(255,255,255,.7);}
.kpi-trend{font-size:.65rem;font-weight:800;color:rgba(255,255,255,.5);background:rgba(255,255,255,.06);border-radius:100px;padding:.2rem .65rem;letter-spacing:.05rem;}
.kpi-value{font-family:'Space Grotesk',sans-serif;font-size:2.8rem;font-weight:800;color:#fff;letter-spacing:-.04em;line-height:1;margin-bottom:.4rem;position:relative;z-index:1;}
.kpi-label{font-size:.7rem;font-weight:800;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.1rem;position:relative;z-index:1;}

/* Dash Card Base */

.card-header-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;}

.card-title{font-size:1.1rem;font-weight:800;color:#fff;margin:0;letter-spacing:-.02em;}
.card-sub{font-size:.78rem;color:rgba(255,255,255,.4);margin:.25rem 0 0;}
.see-all-link{font-size:.8rem;font-weight:700;color:var(--v2-primary,#f05223);text-decoration:none;padding:.3rem .8rem;border-radius:8px;background:rgba(240,82,35,.07);transition:.3s;}
.see-all-link:hover{background:rgba(240,82,35,.15);color:#fff;}
.chart-legend{display:flex;align-items:center;font-size:.75rem;color:rgba(255,255,255,.6);font-weight:600;}
.legend-dot{width:10px;height:10px;border-radius:50%;display:inline-block;margin-right:5px;}

/* Activity Row */
.activity-row{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;}
.flex-card{display:flex;flex-direction:column;}
.inq-item,.proj-item{display:flex;align-items:center;gap:1rem;padding:.9rem;border-radius:14px;border:1px solid rgba(255,255,255,.04);background:rgba(0,0,0,.15);margin-bottom:.6rem;transition:.3s;}
.inq-item:hover,.proj-item:hover{background:rgba(255,255,255,.04);border-color:rgba(255,255,255,.1);transform:translateX(4px);}
.inq-avatar{width:38px;height:38px;border-radius:12px;background:var(--v2-gradient);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1rem;color:#fff;flex-shrink:0;}
.inq-info{flex:1;min-width:0;}
.inq-name{font-weight:700;color:#fff;font-size:.9rem;}
.inq-sub{font-size:.75rem;color:rgba(255,255,255,.4);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.inq-meta{display:flex;flex-direction:column;align-items:flex-end;gap:.25rem;flex-shrink:0;}
.inq-status{font-size:.6rem;font-weight:800;padding:.2rem .6rem;border-radius:100px;letter-spacing:.06rem;}
.status-new{background:rgba(245,158,11,.12);color:#f59e0b;}
.status-read{background:rgba(148,163,184,.1);color:#94a3b8;}
.inq-time{font-size:.68rem;color:rgba(255,255,255,.35);font-weight:600;}
.proj-thumb{width:44px;height:44px;border-radius:12px;overflow:hidden;flex-shrink:0;}
.proj-thumb img{width:100%;height:100%;object-fit:cover;}
.proj-thumb-fallback{width:44px;height:44px;background:rgba(245,158,11,.1);color:#f59e0b;display:flex;align-items:center;justify-content:center;font-size:1.1rem;border-radius:12px;}
.proj-info{flex:1;}
.proj-title{font-weight:700;color:#fff;font-size:.9rem;}
.proj-cat{font-size:.73rem;color:rgba(255,255,255,.4);}
.proj-date{font-size:.72rem;color:rgba(255,255,255,.35);font-weight:600;flex-shrink:0;}

/* Bottom Row */
.bottom-row{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1.25rem;}
.blog-item{display:flex;align-items:center;gap:.9rem;padding:.75rem 0;border-bottom:1px solid rgba(255,255,255,.05);}
.blog-item:last-child{border-bottom:none;}
.blog-dot{width:8px;height:8px;border-radius:50%;background:var(--v2-gradient);flex-shrink:0;}
.blog-info{flex:1;}
.blog-title{font-size:.85rem;font-weight:600;color:rgba(255,255,255,.85);}
.blog-date{font-size:.7rem;color:rgba(255,255,255,.35);margin-top:.15rem;}
.blog-edit-btn{width:30px;height:30px;border-radius:8px;border:1px solid rgba(255,255,255,.08);background:rgba(255,255,255,.03);color:rgba(255,255,255,.5);display:flex;align-items:center;justify-content:center;font-size:.75rem;text-decoration:none;transition:.3s;flex-shrink:0;}
.blog-edit-btn:hover{border-color:var(--v2-primary);color:var(--v2-primary);}
.quick-links-card .quick-grid{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;}
.quick-link-btn{display:flex;align-items:center;gap:.75rem;padding:.85rem 1rem;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);border-radius:14px;color:rgba(255,255,255,.75);text-decoration:none;font-size:.82rem;font-weight:700;transition:.3s;}
.quick-link-btn:hover{background:rgba(240,82,35,.1);border-color:rgba(240,82,35,.4);color:#fff;transform:translateY(-2px);}
.quick-link-btn i{font-size:1rem;color:var(--v2-primary,#f05223);width:20px;text-align:center;}
.health-list{display:flex;flex-direction:column;gap:.65rem;}
.health-item{display:flex;align-items:center;justify-content:space-between;padding:.6rem .9rem;background:rgba(0,0,0,.15);border-radius:10px;border:1px solid rgba(255,255,255,.04);}
.health-label{font-size:.75rem;color:rgba(255,255,255,.5);font-weight:600;}
.health-val{font-size:.75rem;color:rgba(255,255,255,.75);font-weight:700;font-family:monospace;}
.health-status{font-size:.72rem;font-weight:800;display:flex;align-items:center;}
.health-status.online{color:#10b981;}
.health-status.warn{color:#f59e0b;}

/* Category Grid */
.cat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1rem;}
.cat-item{background:rgba(0,0,0,.2);border-radius:14px;padding:1rem 1.25rem;border:1px solid rgba(255,255,255,.05);transition:.3s;}
.cat-item:hover{border-color:rgba(6,182,212,.3);background:rgba(6,182,212,.05);}
.cat-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem;}
.cat-name{font-size:.8rem;font-weight:700;color:rgba(255,255,255,.8);text-transform:uppercase;letter-spacing:.05rem;}
.cat-count{font-family:'Space Grotesk',sans-serif;font-size:1.4rem;font-weight:800;color:#fff;}
.cat-bar-track{height:5px;background:rgba(255,255,255,.05);border-radius:10px;overflow:hidden;}
.cat-bar-fill{height:100%;background:linear-gradient(90deg,#06b6d4,#3b82f6);border-radius:10px;box-shadow:0 0 8px rgba(6,182,212,.5);transition:width 1s ease;}

/* Ticker */
.sys-ticker{display:flex;align-items:center;background:rgba(15,23,42,.6);border:1px solid rgba(255,255,255,.06);border-radius:14px;overflow:hidden;height:44px;}
.ticker-tag{padding:.5rem 1.25rem;background:rgba(0,0,0,.3);font-size:.7rem;font-weight:800;color:var(--v2-primary,#f05223);letter-spacing:.1rem;text-transform:uppercase;white-space:nowrap;border-right:1px solid rgba(255,255,255,.06);}
.ticker-track{flex:1;overflow:hidden;}
.ticker-scroll{white-space:nowrap;display:inline-block;animation:ticker 30s linear infinite;font-size:.8rem;color:rgba(255,255,255,.55);font-family:'SFMono-Regular',monospace;padding:.25rem .5rem;}
.ticker-sep{margin:0 1.5rem;color:var(--v2-primary,#f05223);opacity:.5;}
@keyframes ticker{0%{transform:translateX(100%);}100%{transform:translateX(-100%);}}
.pulse-anim{animation:pulseAnim 2s infinite;}
@keyframes pulseAnim{0%,100%{opacity:1;}50%{opacity:.5;}}
.pulse-dot{display:inline-block;width:7px;height:7px;border-radius:50%;animation:pulseAnim 2s infinite;}
.empty-dash{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem;color:rgba(255,255,255,.25);font-size:.85rem;gap:.5rem;}
.empty-dash i{font-size:1.75rem;}

/* ---- LIGHT MODE OVERRIDES ---- */
[data-theme="light"] .dash-welcome{background:linear-gradient(135deg,rgba(255,255,255,.95),rgba(248,250,252,.9));border-color:rgba(99,102,241,.2);}
[data-theme="light"] .welcome-heading,[data-theme="light"] .clock-time-v2{color:#0f172a;}
[data-theme="light"] .welcome-sub{color:#64748b;}
[data-theme="light"] .clock-date-v2{color:#64748b;}
[data-theme="light"] .capsule-glass{background:rgba(0,0,0,.04);border-color:rgba(0,0,0,.08);}
[data-theme="light"] .kpi-card{background:rgba(255,255,255,.8);border-color:rgba(0,0,0,.06);}
[data-theme="light"] .kpi-value{color:#0f172a;}
[data-theme="light"] .kpi-label{color:#64748b;}
[data-theme="light"] .kpi-icon-wrap{background:rgba(0,0,0,.05);}
[data-theme="light"] .kpi-trend{color:#475569;background:rgba(0,0,0,.05);}

/* Elite Cards Light Mode */
[data-theme="light"] .elite-card { background: rgba(255, 255, 255, 0.8) !important; border-color: rgba(0, 0, 0, 0.07) !important; box-shadow: 0 10px 30px rgba(0,0,0,0.04) !important; }
[data-theme="light"] .elite-title { color: #0f172a !important; }
[data-theme="light"] .elite-sub { color: #64748b !important; }
[data-theme="light"] .elite-legend { background: rgba(0, 0, 0, 0.03) !important; border-color: rgba(0, 0, 0, 0.06) !important; }
[data-theme="light"] .elite-legend-item { color: #475569 !important; }
[data-theme="light"] .donut-total { color: #0f172a !important; }
[data-theme="light"] .donut-label { color: #64748b !important; }
[data-theme="light"] .donut-legend-item { background: rgba(0, 0, 0, 0.03) !important; border-color: rgba(0, 0, 0, 0.06) !important; }
[data-theme="light"] .d-leg-name { color: #475569 !important; }
[data-theme="light"] .d-leg-val { color: #0f172a !important; }

[data-theme="light"] .dash-card{background:rgba(255,255,255,.75);border-color:rgba(0,0,0,.06);box-shadow:0 8px 30px rgba(0,0,0,.07);}
[data-theme="light"] .card-title{color:#0f172a;}
[data-theme="light"] .inq-name,.proj-title,.blog-title{color:#0f172a !important;}
[data-theme="light"] .inq-item,[data-theme="light"] .proj-item{background:rgba(0,0,0,.03);border-color:rgba(0,0,0,.06);}
[data-theme="light"] .health-item{background:rgba(0,0,0,.03);border-color:rgba(0,0,0,.06);}
[data-theme="light"] .health-label{color:#475569;}
[data-theme="light"] .health-val{color:#0f172a;}
[data-theme="light"] .cat-item{background:rgba(0,0,0,.03);border-color:rgba(0,0,0,.06);}
[data-theme="light"] .cat-name{color:#475569;}
[data-theme="light"] .cat-count{color:#0f172a;}
[data-theme="light"] .quick-link-btn{background:rgba(0,0,0,.03);border-color:rgba(0,0,0,.08);color:#475569;}
[data-theme="light"] .quick-link-btn:hover{background:rgba(240,82,35,.08);border-color:rgba(240,82,35,.3);color:#0f172a;}
[data-theme="light"] .sys-ticker{background:rgba(0,0,0,.04);border-color:rgba(0,0,0,.07);}
[data-theme="light"] .ticker-scroll{color:#475569;}
[data-theme="light"] .ticker-tag{background:rgba(0,0,0,.06);}
[data-theme="light"] .mini-stat{background:rgba(0,0,0,.04);border-color:rgba(0,0,0,.06);}
[data-theme="light"] .mini-val{color:#0f172a;}
[data-theme="light"] .mini-lab{color:#64748b;}
[data-theme="light"] .blog-title{color:#1e293b;}
[data-theme="light"] .blog-date{color:#94a3b8;}
[data-theme="light"] .inq-time,.proj-date{color:#94a3b8 !important;}

/* ---- RESPONSIVE ---- */
    @media(max-width:1500px){
        .kpi-grid{grid-template-columns:repeat(3,1fr);}
    }
    @media(max-width:1200px){
        .charts-elite-row{grid-template-columns:1fr; gap: 1.25rem;}
        .donut-card{max-width: 100%;}
        .charts-row{grid-template-columns:1fr;}
        .charts-col-right{flex-direction:row;gap:1.25rem;}
        .mini-stat-card{flex:1;}
        .bottom-row{grid-template-columns:1fr 1fr;}
        .system-health-card{grid-column:span 2;}
    }
    @media(max-width:992px){
        .bottom-row{grid-template-columns:1fr;}
        .system-health-card{grid-column:auto;}
        .activity-row{grid-template-columns:1fr;}
        .welcome-right{display:none;}
        .kpi-grid{grid-template-columns:repeat(2,1fr);}
    }
@media(max-width:576px){
    .kpi-grid{grid-template-columns:1fr 1fr;}
    .dash-welcome{padding:1.5rem;}
    .welcome-heading{font-size:1.8rem;}
    .quick-links-card .quick-grid{grid-template-columns:1fr 1fr;}
}
</style>
@endsection
