@extends('layouts.admin')

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
        <table class="table table-v3 mb-0">
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
                @forelse($projects as $project)
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
                        <div class="project-preview-v3" style="background-image: url('{{ $displayUrl }}')"></div>
                    </td>
                    <td>
                        <div class="fw-bold text-white">{{ $project->title }}</div>
                        <div class="small text-muted">{{ $project->slug }}</div>
                    </td>
                    <td><span class="text-muted">{{ $project->client_name }}</span></td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($project->categories as $category)
                                <span class="badge-v3 turquoise">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <span class="status-glow {{ $project->status === 'active' ? 'active' : 'inactive' }}">
                            {{ strtoupper($project->status) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="action-btn-v3 edit" title="Edit Infrastructure">
                                <i class="fas fa-terminal"></i>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Initiate project deletion sequence?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-v3 delete" title="Terminate Project">
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
                            <i class="fas fa-ghost fs-1 mb-3"></i>
                            <p>No projects detected in local matrix.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-v3 mt-4">
    {{ $projects->links('pagination::bootstrap-5') }}
</div>

<style>
    .table-v3 {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-v3 th {
        background: rgba(255, 255, 255, 0.02);
        padding: 1.25rem 1.5rem;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.1rem;
        color: var(--v3-text-muted);
        border-bottom: 1px solid var(--v3-border);
    }
    .table-v3 td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--v3-border);
        background: transparent;
        transition: background 0.3s;
    }
    .table-v3 tr:hover td {
        background: rgba(255, 255, 255, 0.01);
    }
    .table-v3 tr:last-child td { border-bottom: none; }

    .project-preview-v3 {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background-size: cover;
        background-position: center;
        border: 2px solid var(--v3-border);
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .badge-v3 {
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-v3.turquoise { background: rgba(6, 182, 212, 0.1); color: #06b6d4; border: 1px solid rgba(6, 182, 212, 0.2); }

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

    .action-btn-v3 {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--v3-border);
        background: rgba(255, 255, 255, 0.03);
        color: var(--v3-text-muted);
        transition: all 0.3s;
        text-decoration: none !important;
    }
    .action-btn-v3:hover { transform: translateY(-2px); border-color: var(--v3-accent); color: var(--v3-accent); }
    .action-btn-v3.delete:hover { border-color: #ef4444; color: #ef4444; }

    .pagination-v3 .pagination { margin-bottom: 0; }
    .pagination-v3 .page-link { 
        background: var(--v3-card); border: 1px solid var(--v3-border); color: var(--v3-text-muted); 
        border-radius: 8px; margin: 0 3px; 
    }
    .pagination-v3 .page-item.active .page-link { 
        background: var(--v3-gradient); border-color: transparent; color: white;
        box-shadow: 0 4px 15px var(--v3-accent-glow);
    }
</style>
@endsection
