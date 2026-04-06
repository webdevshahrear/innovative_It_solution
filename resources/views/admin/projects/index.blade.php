@extends('layouts.admin')

@use('Illuminate\Support\Str')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title text-white">Portfolio Hub</h1>
        <p class="page-subtitle text-v2-muted">Manage and deploy your creative projects from one central command.</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn-v2-primary">
        <i class="fas fa-plus me-2"></i> Deploy New Project
    </a>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="width: 100px;">IMAGE</th>
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
                            <div class="small text-v2-muted text-truncate" style="max-width: 200px;">{{ $project->short_description }}</div>
                        </td>
                        <td>
                            <div class="text-white fw-bold">{{ $project->client_name }}</div>
                            @if($project->completion_date)
                            <div class="small text-v2-muted" title="Completion cycle">
                                <i class="far fa-calendar-alt me-1"></i>{{ Carbon\Carbon::parse($project->completion_date)->format('M d, Y') }}
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2 flex-wrap">
                                @if($project->categories)
                                    @foreach($project->categories as $category)
                                        <span class="badge-v2 turquoise">{{ $category->name }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="status-glow-v2 {{ $project->status === 'published' ? 'active' : 'inactive' }}">
                                <span class="status-dot"></span>
                                {{ strtoupper($project->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="action-btn-v2" title="Modify Parameters">
                                    <i class="fas fa-code-branch"></i>
                                </a>
                                <form action="{{ route('admin.projects.duplicate', $project->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn-v2" title="Duplicate Entity">
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
                        <div class="opacity-30">
                            <i class="fas fa-atom fs-1 mb-3 text-v2-muted"></i>
                            <p class="text-v2-muted">No projects detected in local matrix.</p>
                        </div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-v2 mt-4 d-flex justify-content-center">
    {{ $projects->links('pagination::bootstrap-5') }}
</div>

<style>
    .project-preview-v2 {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background-size: cover;
        background-position: center;
        border: 2px solid var(--v2-border);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        transition: .3s;
    }
    .project-preview-v2:hover { transform: scale(1.1); border-color: var(--v2-primary); }
</style>

@endsection
