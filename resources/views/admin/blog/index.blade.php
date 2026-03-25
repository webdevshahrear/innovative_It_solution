@extends('layouts.admin')

@use('Illuminate\Support\Str')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Broadcast Center</h1>
        <p class="page-subtitle">Manage and publish your digital transmissions to the outer world.</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" class="btn-tech-primary">
        <i class="fas fa-plus me-2"></i> Write New Post
    </a>
</div>

<div class="tech-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th>PREVIEW</th>
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
                            <div class="project-preview-v2" style="background-image: url('{{ $displayUrl }}')"></div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold text-white">{{ Str::limit($post->title, 40) }}</span>
                                @if($post->is_featured)
                                    <span class="badge-v2 indigo" style="font-size: 0.55rem;">PRIORITY</span>
                                @endif
                            </div>
                            <div class="small text-muted">{{ $post->slug }}</div>
                        </td>
                        <td><span class="badge-v2 turquoise">{{ $post->category }}</span></td>
                        <td>
                            <span class="status-glow {{ $post->status === 'published' ? 'active' : 'inactive' }}">
                                {{ strtoupper($post->status) }}
                            </span>
                        </td>
                        <td><span class="small text-muted">{{ $post->created_at->format('M d, Y') }}</span></td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.blog.edit', $post) }}" class="action-btn-v2 edit" title="Edit Content">
                                    <i class="fas fa-pen-nib"></i>
                                </a>
                                <form action="{{ route('admin.blog.duplicate', $post->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn-v2 duplicate" title="Duplicate Article">
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
                            <div class="opacity-50">
                                <i class="fas fa-newspaper fs-1 mb-3"></i>
                                <p>No transmissions detected in archives.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-v2 mt-4">
    {{ $posts->links('pagination::bootstrap-5') }}
</div>

<style>
    .table-v2 { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-v2 th {
        background: rgba(255, 255, 255, 0.02);
        padding: 1.25rem 1.5rem;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.1rem;
        color: var(--v2-text-muted);
        border-bottom: 1px solid var(--v2-border);
    }
    .table-v2 td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--v2-border);
        background: transparent;
        transition: background 0.3s;
    }
    .table-v2 tr:hover td { background: rgba(255, 255, 255, 0.01); }
    .table-v2 tr:last-child td { border-bottom: none; }

    .project-preview-v2 {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background-size: cover;
        background-position: center;
        border: 2px solid var(--v2-border);
    }

    .badge-v2 {
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-v2.turquoise { background: rgba(6, 182, 212, 0.1); color: #06b6d4; border: 1px solid rgba(6, 182, 212, 0.2); }
    .badge-v2.indigo { background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.2); }

    .status-glow {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 0.35rem 0.75rem;
        border-radius: 100px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .status-glow::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    .status-glow.active { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .status-glow.active::before { background: #10b981; box-shadow: 0 0 8px #10b981; }
    .status-glow.inactive { background: rgba(148, 163, 184, 0.1); color: #94a3b8; }
    .status-glow.inactive::before { background: #94a3b8; }

    .action-btn-v2 {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--v2-border);
        background: rgba(255, 255, 255, 0.03);
        color: var(--v2-text-muted);
        transition: all 0.3s;
        text-decoration: none !important;
    }
    .action-btn-v2:hover { transform: translateY(-2px); border-color: var(--v2-primary); color: var(--v2-primary); }
    .action-btn-v2.duplicate:hover { border-color: #3b82f6; color: #3b82f6; }
    .action-btn-v2.delete:hover { border-color: #ef4444; color: #ef4444; }

    .pagination-v2 .pagination { margin-bottom: 0; }
    .pagination-v2 .page-link { background: rgba(255,255,255,0.03); border: 1px solid var(--v2-border); color: var(--v2-text-muted); border-radius: 8px; margin: 0 3px; }
    .pagination-v2 .page-item.active .page-link { background: var(--v2-primary); border-color: transparent; color: white; }
</style>
@endsection
