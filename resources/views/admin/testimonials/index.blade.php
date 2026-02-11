@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Feedback Matrix</h1>
        <p class="page-subtitle">Analyze and manage client transmission logs and performance endorsements.</p>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn-tech-primary">
        <i class="fas fa-plus me-2"></i> Register Testimony
    </a>
</div>

<div class="tech-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v3 mb-0">
            <thead>
                <tr>
                    <th>SOURCE / CLIENT</th>
                    <th>DESIGNATION</th>
                    <th>SATISFACTION LEVEL</th>
                    <th>STATUS</th>
                    <th>PRIORITY</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $testimonial)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                        @php
                            $imgPath = $testimonial->client_image;
                            $displayUrl = 'https://via.placeholder.com/50?text=Client';
                            
                            if (filter_var($imgPath, FILTER_VALIDATE_URL)) {
                                $displayUrl = $imgPath;
                            } elseif (file_exists(public_path('uploads/testimonials/'.$imgPath)) && $imgPath) {
                                $displayUrl = asset('uploads/testimonials/'.$imgPath);
                            } elseif (file_exists(public_path('storage/testimonials/'.$imgPath)) && $imgPath) {
                                $displayUrl = asset('storage/testimonials/'.$imgPath);
                            }
                        @endphp
                        <div class="operative-avatar-v3 me-3" style="background-image: url('{{ $displayUrl }}')"></div>
                            <div>
                                <div class="fw-bold text-white">{{ $testimonial->client_name }}</div>
                                <div class="small text-v3-muted">Verified Signal</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge-v3 turquoise">{{ $testimonial->client_position }}</span></td>
                    <td>
                        <div class="rating-glow-v3">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $testimonial->rating ? 'active' : '' }}"></i>
                            @endfor
                        </div>
                    </td>
                    <td>
                        <span class="status-glow {{ $testimonial->status === 'active' ? 'active' : 'inactive' }}">
                            {{ strtoupper($testimonial->status) }}
                        </span>
                    </td>
                    <td><span class="fw-bold text-v3-accent">{{ $testimonial->display_order }}</span></td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="action-btn-v3 edit" title="Modify Data">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline" onsubmit="return confirm('Purge testimonial record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-v3 delete" title="Decommission">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="opacity-50">
                            <i class="fas fa-comment-slash fs-1 mb-3"></i>
                            <p>No feedback transmissions detected in history.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .client-avatar-v3 { width: 42px; height: 42px; border-radius: 50%; background-size: cover; background-position: center; border: 2px solid var(--v3-border); box-shadow: 0 0 10px rgba(99, 102, 241, 0.1); }
    .table-v3 { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-v3 th { background: rgba(255, 255, 255, 0.02); padding: 1.25rem 1.5rem; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v3-text-muted); border-bottom: 1px solid var(--v3-border); }
    .table-v3 td { padding: 1.25rem 1.5rem; vertical-align: middle; border-bottom: 1px solid var(--v3-border); background: transparent; transition: background 0.3s; }
    .table-v3 tr:hover td { background: rgba(255, 255, 255, 0.01); }

    .badge-v3 { padding: 0.25rem 0.6rem; border-radius: 6px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; }
    .badge-v3.turquoise { background: rgba(6, 182, 212, 0.1); color: #06b6d4; border: 1px solid rgba(6, 182, 212, 0.2); }

    .rating-glow-v3 { display: flex; gap: 4px; }
    .rating-glow-v3 i { font-size: 0.75rem; color: rgba(255,255,255,0.1); }
    .rating-glow-v3 i.active { color: #f59e0b; text-shadow: 0 0 10px rgba(245, 158, 11, 0.5); }

    .status-glow { font-size: 0.65rem; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 100px; display: inline-flex; align-items: center; gap: 0.5rem; }
    .status-glow::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    .status-glow.active { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .status-glow.active::before { background: #10b981; box-shadow: 0 0 8px #10b981; }
    .status-glow.inactive { background: rgba(148, 163, 184, 0.1); color: #94a3b8; }
    .status-glow.inactive::before { background: #94a3b8; }

    .action-btn-v3 { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--v3-border); background: rgba(255, 255, 255, 0.03); color: var(--v3-text-muted); transition: all 0.3s; text-decoration: none !important; }
    .action-btn-v3:hover { transform: translateY(-2px); border-color: var(--v3-accent); color: var(--v3-accent); }
    .action-btn-v3.delete:hover { border-color: #ef4444; color: #ef4444; }
    .text-v3-muted { color: rgba(255,255,255,0.4); font-size: 0.85rem; }
</style>
@endsection
