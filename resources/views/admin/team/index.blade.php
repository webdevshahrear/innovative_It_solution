@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title text-white">Elite Operatives</h1>
        <p class="page-subtitle text-v2-muted">Manage the high-performance units driving your digital ecosystem.</p>
    </div>
    <a href="{{ route('admin.team.create') }}" class="btn-v2-primary">
        <i class="fas fa-plus me-2"></i> Recruit Member
    </a>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th style="width: 100px;">OPERATIVE</th>
                    <th>IDENTITY</th>
                    <th>FUNCTION / ROLE</th>
                    <th>STATUS</th>
                    <th>PRIORITY</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @if($members->count() > 0)
                    @foreach($members as $member)
                    <tr>
                        <td>
                            @php
                                $imgPath = $member->image;
                                if (filter_var($imgPath, FILTER_VALIDATE_URL)) {
                                    $displayUrl = $imgPath;
                                } elseif ($imgPath) {
                                    $displayUrl = asset('uploads/team/' . $imgPath);
                                } else {
                                    $displayUrl = 'https://via.placeholder.com/50/10101f/ffffff?text=' . urlencode(mb_substr($member->name, 0, 1));
                                }
                            @endphp
                            <div class="operative-avatar-v2" style="background-image: url('{{ $displayUrl }}')"></div>
                        </td>
                        <td>
                            <div class="fw-bold text-white">{{ $member->name }}</div>
                            <div class="small text-v2-muted">ID: #0{{ $member->id }}</div>
                        </td>
                        <td><span class="badge-v2 turquoise">{{ $member->position }}</span></td>
                        <td>
                            <span class="status-glow-v2 {{ $member->status === 'active' ? 'active' : 'inactive' }}">
                                <span class="status-dot"></span>
                                {{ strtoupper($member->status) }}
                            </span>
                        </td>
                        <td><span class="fw-bold text-v2-primary">{{ $member->display_order }}</span></td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.team.edit', $member) }}" class="action-btn-v2" title="Modify Parameters">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <form action="{{ route('admin.team.duplicate', $member->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn-v2" title="Duplicate Profile">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Terminate operative contract?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn-v2 delete" title="Decommission">
                                        <i class="fas fa-user-slash"></i>
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
                                <i class="fas fa-users-slash fs-1 mb-3 text-v2-muted"></i>
                                <p class="text-v2-muted">No operatives detected in active duty.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<style>
    .operative-avatar-v2 {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        border: 2px solid var(--v2-border);
        box-shadow: 0 0 15px rgba(240, 82, 35, 0.15);
        transition: .3s;
    }
    .operative-avatar-v2:hover { transform: scale(1.1); border-color: var(--v2-primary); }
</style>

@endsection
