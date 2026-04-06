@extends('layouts.admin')

@use('Illuminate\Support\Str')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title text-white">Hero Sequence</h1>
        <p class="page-subtitle text-v2-muted">Configure high-impact visual banners for the primary site uplink.</p>
    </div>
    <a href="{{ route('admin.hero-slides.create') }}" class="btn-v2-primary">
        <i class="fas fa-plus me-2"></i> Initialize Slide
    </a>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
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
                @if($slides->count() > 0)
                    @foreach($slides as $slide)
                    <tr>
                        <td>
                            <div class="banner-preview-v2">
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
                            <div class="small text-v2-muted">{{ Str::limit($slide->subtitle, 40) }}</div>
                        </td>
                        <td><span class="fw-bold text-v2-primary">{{ $slide->display_order }}</span></td>
                        <td>
                            <span class="status-glow-v2 {{ $slide->status === 'active' ? 'active' : 'inactive' }}">
                                <span class="status-dot"></span>
                                {{ strtoupper($slide->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="action-btn-v2" title="Modify Logic">
                                    <i class="fas fa-sliders-h"></i>
                                </a>
                                <form action="{{ route('admin.hero-slides.duplicate', $slide) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn-v2" title="Duplicate Signal">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" class="d-inline" onsubmit="return confirm('Decommission slide component?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn-v2 delete" title="Purge">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="opacity-30">
                                <i class="fas fa-images fs-1 mb-3 text-v2-muted"></i>
                                <p class="text-v2-muted">No visual assets detected in the primary sequence.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<style>
    .banner-preview-v2 { width: 140px; height: 70px; border-radius: 12px; border: 1px solid var(--v2-border); overflow: hidden; background: rgba(0,0,0,0.3); box-shadow: 0 8px 16px rgba(0,0,0,0.2); }
    .banner-preview-v2 img { width: 100%; height: 100%; object-fit: cover; opacity: 0.85; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    .banner-preview-v2:hover img { opacity: 1; transform: scale(1.1) rotate(1deg); }
</style>
@endsection
