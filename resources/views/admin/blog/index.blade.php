@extends('layouts.admin')

@use('Illuminate\Support\Str')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Broadcast Center</h1>
        <p class="page-subtitle text-v2-muted">Manage and publish your digital transmissions to the outer world.</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" class="btn-v2-primary">
        <i class="fas fa-plus me-2"></i> Write New Post
    </a>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="width: 100px;">PREVIEW</th>
                    <th>ARTICLE IDENTITY</th>
                    <th>SECTOR</th>
                    <th>SIGNAL STATUS</th>
                    <th>TIMESTAMP</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @if($posts->count() > 0)
                    @foreach($posts as $post)
                    <tr>
                        <td>
                             @php
                                $imgPath = $post->image;
                                $displayUrl = 'https://via.placeholder.com/50?text=Article';
                                
                                if (filter_var($imgPath, FILTER_VALIDATE_URL)) {
                                    $displayUrl = $imgPath;
                                } elseif (file_exists(public_path('uploads/blog/'.$imgPath)) && $imgPath) {
                                    $displayUrl = asset('uploads/blog/'.$imgPath);
                                } elseif (file_exists(public_path('storage/blog/'.$imgPath)) && $imgPath) {
                                    $displayUrl = asset('storage/blog/'.$imgPath);
                                }
                            @endphp
                            <div class="post-preview-v2" style="background-image: url('{{ $displayUrl }}')"></div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold text-v2-main">{{ Str::limit($post->title, 40) }}</span>
                                @if($post->is_featured)
                                    <span class="badge-v2 indigo" style="font-size: 0.6rem;">PRIORITY</span>
                                @endif
                            </div>
                            <div class="small text-v2-muted text-truncate" style="max-width: 250px;">{{ $post->slug }}</div>
                        </td>
                        <td><span class="badge-v2 turquoise">{{ $post->category }}</span></td>
                        <td>
                            <span class="status-glow-v2 {{ $post->status === 'published' ? 'active' : 'inactive' }}">
                                <span class="status-dot"></span>
                                {{ strtoupper($post->status) }}
                            </span>
                        </td>
                        <td><span class="small text-v2-muted">{{ $post->created_at->format('M d, Y') }}</span></td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.blog.edit', $post) }}" class="action-btn-v2" title="Edit Content">
                                    <i class="fas fa-pen-nib"></i>
                                </a>
                                <form action="{{ route('admin.blog.duplicate', $post->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn-v2" title="Duplicate Article">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Initiate article deletion sequence?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn-v2 delete" title="Terminate Article">
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
                                <i class="fas fa-newspaper fs-1 mb-3 text-v2-muted"></i>
                                <p class="text-v2-muted">No transmissions detected in archives.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-v2 mt-4 d-flex justify-content-center">
    {{ $posts->links('pagination::bootstrap-5') }}
</div>

<style>
    .post-preview-v2 {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background-size: cover;
        background-position: center;
        border: 2px solid var(--v2-border);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        transition: .3s;
    }
    .post-preview-v2:hover { transform: scale(1.1); border-color: var(--v2-primary); }
</style>

@endsection
