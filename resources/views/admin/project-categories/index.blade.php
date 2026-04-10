@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Portfolio Categories</h1>
        <p class="page-subtitle text-v2-muted">Manage classifications for your project archive.</p>
    </div>
    <a href="{{ route('admin.project-categories.create') }}" class="btn-v2-primary">
        <i class="fas fa-plus me-2"></i> Create Category
    </a>
</div>

@if(session('success'))
<div class="alert alert-cyber-success mb-4">
    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
</div>
@endif

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th class="ps-4" style="width: 100px;">ID</th>
                    <th>NAME</th>
                    <th>SLUG</th>
                    <th>MAPPED PROJECTS</th>
                    <th class="text-end pe-4">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="ps-4 text-v2-muted">#{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="fw-bold text-v2-main">{{ $category->name }}</td>
                    <td class="font-monospace"><span class="badge-v2 turquoise">{{ $category->slug }}</span></td>
                    <td>
                        <span class="status-glow-v2 active">
                            <span class="status-dot"></span>
                            {{ $category->projects_count }} ASSIGNED
                        </span>
                    </td>
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.project-categories.edit', $category->id) }}" class="action-btn-v2" title="Edit">
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
                    <td colspan="5" class="text-center py-5">
                        <div class="opacity-30">
                            <i class="fas fa-tags fs-1 mb-3 text-v2-muted"></i>
                            <h5 class="text-v2-main">No Categories Found</h5>
                            <p class="text-v2-muted small">Start organizing your portfolio by adding the first category.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-v2 mt-4 d-flex justify-content-center">
    {{ $categories->links('pagination::bootstrap-5') }}
</div>

@endsection
