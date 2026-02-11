@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Hero Sequence</h1>
        <p class="page-subtitle">Configure high-impact visual banners for the primary site uplink.</p>
    </div>
    <a href="{{ route('admin.hero-slides.create') }}" class="btn-tech-primary">
        <i class="fas fa-plus me-2"></i> Initialize Slide
    </a>
</div>

<div class="tech-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v3 mb-0">
            <thead>
                <tr>
                    <th style="width: 150px;">VISUAL ASSET</th>
                    <th>SLIDE IDENTIFIER</th>
                    <th>SEQUENCE</th>
                    <th>STATUS</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($slides as $slide)
                <tr>
                    <td>
                        <div class="banner-preview-v3">
                            @php
                                $imgPath = $slide->image_path;
                                $displayUrl = 'https://via.placeholder.com/120x60?text=No+Asset';
                                
                                if (filter_var($imgPath, FILTER_VALIDATE_URL)) {
                                    $displayUrl = $imgPath;
                                } elseif (file_exists(public_path('uploads/slider/'.$imgPath)) && $imgPath) {
                                    $displayUrl = asset('uploads/slider/'.$imgPath);
                                } elseif (file_exists(public_path('storage/hero-slides/'.$imgPath)) && $imgPath) {
                                    $displayUrl = asset('storage/hero-slides/'.$imgPath);
                                } elseif (file_exists(public_path('assets/images/hero/'.$imgPath)) && $imgPath) {
                                    $displayUrl = asset('assets/images/hero/'.$imgPath);
                                }
                            @endphp
                            <img src="{{ $displayUrl }}" alt="Preview">
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold text-white">{{ $slide->title }}</div>
                        <div class="small text-v3-muted">{{ Str::limit($slide->subtitle, 40) }}</div>
                    </td>
                    <td><span class="fw-bold text-v3-accent">{{ $slide->display_order }}</span></td>
                    <td>
                        <span class="status-glow {{ $slide->status === 'active' ? 'active' : 'inactive' }}">
                            {{ strtoupper($slide->status) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="action-btn-v3 edit" title="Modify Logic">
                                <i class="fas fa-sliders-h"></i>
                            </a>
                            <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" class="d-inline" onsubmit="return confirm('Decommission slide component?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-v3 delete" title="Purge">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="opacity-50">
                            <i class="fas fa-images fs-1 mb-3"></i>
                            <p>No visual assets detected in the primary sequence.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .banner-preview-v3 { width: 120px; height: 60px; border-radius: 8px; border: 1px solid var(--v3-border); overflow: hidden; background: rgba(0,0,0,0.2); }
    .banner-preview-v3 img { width: 100%; height: 100%; object-fit: cover; opacity: 0.8; transition: 0.3s; }
    .banner-preview-v3:hover img { opacity: 1; transform: scale(1.05); }

    .table-v3 { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-v3 th { background: rgba(255, 255, 255, 0.02); padding: 1.25rem 1.5rem; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v3-text-muted); border-bottom: 1px solid var(--v3-border); }
    .table-v3 td { padding: 1.25rem 1.5rem; vertical-align: middle; border-bottom: 1px solid var(--v3-border); background: transparent; transition: background 0.3s; }
    .table-v3 tr:hover td { background: rgba(255, 255, 255, 0.01); }

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
