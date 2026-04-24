@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title text-white">Visual archives (Gallery)</h1>
        <p class="page-subtitle text-v2-muted">Manage the agency life, office workspace, and high-impact visual assets.</p>
    </div>
    <a href="{{ route('admin.gallery-items.create') }}" class="btn-v2-primary">
        <i class="fas fa-camera me-2"></i> Index Visual Asset
    </a>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0 text-center">
            <thead>
                <tr>
                    <th style="width: 150px;">ASSET PREVIEW</th>
                    <th>IDENTIFIER</th>
                    <th>CATEGORY</th>
                    <th>ORDER</th>
                    <th>STATUS</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>
                        <div class="gallery-preview-v2 mx-auto">
                            <img src="{{ asset('uploads/gallery/' . $item->image_path) }}" alt="{{ $item->title }}" style="width: 100px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid var(--v2-border);">
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold text-white">{{ $item->title ?: 'Untranslated Asset' }}</div>
                    </td>
                    <td><span class="badge bg-secondary text-uppercase">{{ $item->category ?: 'General' }}</span></td>
                    <td><span class="text-v2-primary fw-bold">#{{ $item->display_order }}</span></td>
                    <td>
                        <span class="status-glow-v2 {{ $item->status === 'active' ? 'active' : 'inactive' }}">
                            <span class="status-dot"></span>
                            {{ strtoupper($item->status) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.gallery-items.edit', $item->id) }}" class="action-btn-v2" title="Modify">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.gallery-items.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Purge asset from archives?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-v2 delete" title="Purge">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="opacity-30">
                            <i class="fas fa-images fs-1 mb-3 text-v2-muted"></i>
                            <p class="text-v2-muted">No visual assets indexed in the current node.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
