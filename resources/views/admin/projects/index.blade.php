@extends('layouts.admin')

@use('Illuminate\Support\Str')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Portfolio Hub</h1>
        <p class="page-subtitle">Manage and deploy your creative projects from one central command.</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn-tech-primary">
        <i class="fas fa-plus me-2"></i> Deploy New Project
    </a>
</div>

<div class="tech-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th>IMAGE</th>
                    <th>PROJECT IDENTITY</th>
                    <th>CLIENT</th>
                    <th>CAPABILITIES</th>
                    <th>DEPLOYMENT</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @if($projects->count() > 0)
                    @foreach($projects as $project)
                    <tr>
                        <td>
                             @php
                                $imgPath = $project->desktop_image;
                                $displayUrl = 'https://via.placeholder.com/50?text=Project';
                                
                                if (filter_var($imgPath, FILTER_VALIDATE_URL)) {
                                    $displayUrl = $imgPath;
                                } elseif (file_exists(public_path('uploads/projects/'.$imgPath)) && $imgPath) {
                                    $displayUrl = asset('uploads/projects/'.$imgPath);
                                } elseif (file_exists(public_path('storage/projects/'.$imgPath)) && $imgPath) {
                                    $displayUrl = asset('storage/projects/'.$imgPath);
                                }
                            @endphp
                            <div class="project-preview-v2" style="background-image: url('{{ $displayUrl }}')"></div>
                        </td>
                        <td>
                            <div class="fw-bold text-white">{{ $project->title }}</div>
                            <div class="small text-v2-muted">{{ Str::limit($project->short_description, 40) }}</div>
                        </td>
                        <td>
                            <div class="text-white fw-bold">{{ $project->client_name }}</div>
                            @if($project->completion_date)
                            <div class="small text-v2-muted cursor-pointer" title="Completion cycle">
                                <i class="far fa-calendar-alt me-1"></i>{{ Carbon\Carbon::parse($project->completion_date)->format('M d, Y') }}
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                @if($project->categories)
                                    @foreach($project->categories as $category)
                                        <span class="badge-v2 turquoise">{{ $category->name }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="status-glow {{ $project->status === 'published' ? 'active' : 'inactive' }}">
                                {{ strtoupper($project->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="action-btn-v2 edit" title="Modify Parameters">
                                    <i class="fas fa-code-branch"></i>
                                </a>
                                <form action="{{ route('admin.projects.duplicate', $project->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn-v2 duplicate" title="Duplicate Entity">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Purge project construct?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn-v2 delete" title="Terminate">
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
                            <i class="fas fa-ghost fs-1 mb-3"></i>
                            <p>No projects detected in local matrix.</p>
                        </div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-v2 mt-4">
    {{ $projects->links('pagination::bootstrap-5') }}
</div>

<style>
    .table-v2 {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
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
    .table-v2 tr:hover td {
        background: rgba(255, 255, 255, 0.01);
    }
    .table-v2 tr:last-child td { border-bottom: none; }

    .project-preview-v2 {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background-size: cover;
        background-position: center;
        border: 2px solid var(--v2-border);
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .badge-v2 {
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-v2.turquoise { background: rgba(6, 182, 212, 0.1); color: #06b6d4; border: 1px solid rgba(6, 182, 212, 0.2); }

    .status-glow {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 0.35rem 0.75rem;
        border-radius: 100px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .status-glow::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    .status-glow.active { 
        background: rgba(16, 185, 129, 0.1); 
        color: #10b981; 
        box-shadow: 0 0 15px rgba(16, 185, 129, 0.1);
    }
    .status-glow.active::before { background: #10b981; box-shadow: 0 0 8px #10b981; }
    
    .status-glow.inactive { 
        background: rgba(148, 163, 184, 0.1); 
        color: #94a3b8; 
    }
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
    .pagination-v2 .page-link { 
        background: var(--v2-card); border: 1px solid var(--v2-border); color: var(--v2-text-muted); 
        border-radius: 8px; margin: 0 3px; 
    }
    .pagination-v2 .page-item.active .page-link { 
        background: var(--v2-gradient); border-color: transparent; color: white;
        box-shadow: 0 4px 15px var(--v2-primary-glow);
    }
</style>
@endsection
