@extends('layouts.admin')

@section('content')
<div class="v2-page-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="badge-tech mb-2"><i class="fas fa-tags me-2"></i> TAXONOMY</div>
            <h2 class="v2-page-title m-0">Portfolio Categories</h2>
            <p class="v2-page-subtitle mt-1 mb-0">Manage classifications for your project archive.</p>
        </div>
        <div>
            <a href="{{ route('admin.project-categories.create') }}" class="btn-tech-primary shadow-glow">
                <i class="fas fa-plus me-2"></i> Create Category
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-cyber-success mb-4">
    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
</div>
@endif

<div class="tech-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th class="ps-4">ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Mapped Projects</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="ps-4 text-v2-muted">#{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="fw-bold text-white">{{ $category->name }}</td>
                    <td class="font-monospace text-v2-info"><span class="badge-cyber badge-sm">{{ $category->slug }}</span></td>
                    <td>
                        <div class="status-glow active">
                            <i class="fas fa-layer-group me-1"></i> {{ $category->projects_count }} Assigned
                        </div>
                    </td>
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.project-categories.edit', $category->id) }}" class="action-btn-v2 edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.project-categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('WARNING: Are you sure you want to delete this category? This might orphan related projects.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-v2 delete" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 border-0">
                        <div class="empty-state-glass p-5 mx-auto" style="max-width: 400px;">
                            <i class="fas fa-tags empty-icon mb-3" style="font-size: 3rem; color: rgba(255,255,255,0.2);"></i>
                            <h5 class="text-white mt-2">No Categories Found</h5>
                            <p class="text-v2-muted mb-4 small">Start organizing your portfolio by adding the first category.</p>
                            <a href="{{ route('admin.project-categories.create') }}" class="btn-tech-primary btn-sm px-4">Create Category</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-v2 mt-4">
    {{ $categories->links() }}
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
    .action-btn-v2.edit:hover { border-color: #3b82f6; color: #3b82f6; }
    .action-btn-v2.delete:hover { border-color: #ef4444; color: #ef4444; }

    .status-glow {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 0.35rem 0.75rem;
        border-radius: 100px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .status-glow.active { 
        background: rgba(16, 185, 129, 0.1); 
        color: #10b981; 
        box-shadow: 0 0 15px rgba(16, 185, 129, 0.1);
    }

    .alert-cyber-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #34d399;
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .badge-sm { font-size: 0.7rem; padding: 0.2rem 0.5rem; }
    
    .badge-tech {
        display: inline-flex; align-items: center;
        padding: 0.3rem 0.8rem;
        background: rgba(240, 82, 35, 0.1);
        border: 1px solid rgba(240, 82, 35, 0.3);
        color: #f05223;
        border-radius: 100px;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.1rem;
        text-transform: uppercase;
        box-shadow: 0 0 10px rgba(240, 82, 35, 0.2);
    }
</style>
@endsection
