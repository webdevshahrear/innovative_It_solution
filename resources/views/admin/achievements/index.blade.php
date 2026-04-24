@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title text-white">Agency achievements</h1>
        <p class="page-subtitle text-v2-muted">Manage awards, recognitions, and major milestones for display on the portal.</p>
    </div>
    <a href="{{ route('admin.achievements.create') }}" class="btn-v2-primary">
        <i class="fas fa-plus me-2"></i> Add Achievement
    </a>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="width: 100px;">VISUAL</th>
                    <th>TITLE & DESCRIPTION</th>
                    <th>ORDER</th>
                    <th>STATUS</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($achievements as $achievement)
                <tr>
                    <td class="text-center">
                        @if($achievement->image)
                            <img src="{{ asset('uploads/achievements/' . $achievement->image) }}" alt="" style="width: 50px; height: 50px; object-fit: contain; border-radius: 8px;">
                        @else
                            <div class="metric-icon-v2 mx-auto">
                                <i class="{{ $achievement->icon_class ?: 'fas fa-award' }}"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-bold text-white">{{ $achievement->title }}</div>
                        <div class="small text-v2-muted text-truncate" style="max-width: 300px;">{{ $achievement->description }}</div>
                    </td>
                    <td><span class="badge bg-dark text-v2-primary">#{{ $achievement->display_order }}</span></td>
                    <td>
                        <span class="status-glow-v2 {{ $achievement->status === 'active' ? 'active' : 'inactive' }}">
                            <span class="status-dot"></span>
                            {{ strtoupper($achievement->status) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.achievements.edit', $achievement->id) }}" class="action-btn-v2" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.achievements.destroy', $achievement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Purge achievement record?');">
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
                            <i class="fas fa-trophy fs-1 mb-3 text-v2-muted"></i>
                            <p class="text-v2-muted">No achievement records detected.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
