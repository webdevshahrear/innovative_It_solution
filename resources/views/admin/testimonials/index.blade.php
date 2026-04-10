@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Feedback Matrix</h1>
        <p class="page-subtitle text-v2-muted">Analyze and manage client transmission logs and performance endorsements.</p>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn-v2-primary">
        <i class="fas fa-plus me-2"></i> Register Testimony
    </a>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="width: 100px;">SOURCE / CLIENT</th>
                    <th>DESIGNATION</th>
                    <th>SATISFACTION LEVEL</th>
                    <th>STATUS</th>
                    <th>PRIORITY</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @if($testimonials->count() > 0)
                    @foreach($testimonials as $testimonial)
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
                                } elseif (file_exists(public_path('assets/images/testimonials/'.$imgPath)) && $imgPath) {
                                    $displayUrl = asset('assets/images/testimonials/'.$imgPath);
                                }
                            @endphp
                            <div class="operative-avatar-v2 me-3" style="background-image: url('{{ $displayUrl }}')"></div>
                                <div>
                                    <div class="fw-bold text-v2-main">{{ $testimonial->client_name }}</div>
                                    <div class="small text-v2-muted">Verified Signal</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge-v2 turquoise">{{ $testimonial->client_position }}</span></td>
                        <td>
                            <div class="rating-glow-v2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? 'active' : '' }}"></i>
                                @endfor
                            </div>
                        </td>
                        <td>
                            <span class="status-glow-v2 {{ $testimonial->status === 'active' ? 'active' : 'inactive' }}">
                                <span class="status-dot"></span>
                                {{ strtoupper($testimonial->status) }}
                            </span>
                        </td>
                        <td><span class="fw-bold text-v2-primary">{{ $testimonial->display_order }}</span></td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="action-btn-v2" title="Modify Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.testimonials.duplicate', $testimonial->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn-v2" title="Duplicate Feedback">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline" onsubmit="return confirm('Purge testimonial record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn-v2 delete" title="Decommission">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="opacity-30">
                                <i class="fas fa-comment-slash fs-1 mb-3 text-v2-muted"></i>
                                <p class="text-v2-muted">No feedback transmissions detected in history.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<style>
    .rating-glow-v2 { display: flex; gap: 4px; }
    .rating-glow-v2 i { font-size: 0.8rem; color: rgba(255,255,255,0.05); }
    .rating-glow-v2 i.active { color: #f59e0b; text-shadow: 0 0 10px rgba(245, 158, 11, 0.6); }
</style>
@endsection
