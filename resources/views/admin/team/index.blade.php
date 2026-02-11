@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Elite Operatives</h1>
        <p class="page-subtitle">Manage the high-performance units driving your digital ecosystem.</p>
    </div>
    <a href="{{ route('admin.team.create') }}" class="btn-tech-primary">
        <i class="fas fa-plus me-2"></i> Recruit Member
    </a>
</div>

<div class="tech-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v3 mb-0">
            <thead>
                <tr>
                    <th>OPERATIVE</th>
                    <th>IDENTITY</th>
                    <th>FUNCTION / ROLE</th>
                    <th>STATUS</th>
                    <th>PRIORITY</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td>
                        @php
                            $imgPath = $member->image;
                            $displayUrl = 'https://via.placeholder.com/50?text=Member';
                            
                            if (filter_var($imgPath, FILTER_VALIDATE_URL)) {
                                $displayUrl = $imgPath;
                            } elseif (file_exists(public_path('uploads/team/'.$imgPath)) && $imgPath) {
                                $displayUrl = asset('uploads/team/'.$imgPath);
                            } elseif (file_exists(public_path('storage/team/'.$imgPath)) && $imgPath) {
                                $displayUrl = asset('storage/team/'.$imgPath);
                            } elseif (file_exists(public_path('assets/images/team/'.$imgPath)) && $imgPath) {
                                $displayUrl = asset('assets/images/team/'.$imgPath);
                            }
                        @endphp
                        <div class="operative-avatar-v3" style="background-image: url('{{ $displayUrl }}')"></div>
                    </td>
                    <td>
                        <div class="fw-bold text-white">{{ $member->name }}</div>
                        <div class="small text-muted">ID: #0{{ $member->id }}</div>
                    </td>
                    <td><span class="badge-v3 turquoise">{{ $member->role }}</span></td>
                    <td>
                        <span class="status-glow {{ $member->status === 'active' ? 'active' : 'inactive' }}">
                            {{ strtoupper($member->status) }}
                        </span>
                    </td>
                    <td><span class="fw-bold text-v3-accent">{{ $member->display_order }}</span></td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.team.edit', $member) }}" class="action-btn-v3 edit" title="Modify Parameters">
                                <i class="fas fa-user-edit"></i>
                            </a>
                            <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Terminate operative contract?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-v3 delete" title="Decommission">
                                    <i class="fas fa-user-slash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="opacity-50">
                            <i class="fas fa-users-slash fs-1 mb-3"></i>
                            <p>No operatives detected in active duty.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .operative-avatar-v3 {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        border: 2px solid var(--v3-border);
        box-shadow: 0 0 10px rgba(99, 102, 241, 0.1);
    }
    .table-v3 { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-v3 th { background: rgba(255, 255, 255, 0.02); padding: 1.25rem 1.5rem; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v3-text-muted); border-bottom: 1px solid var(--v3-border); }
    .table-v3 td { padding: 1.25rem 1.5rem; vertical-align: middle; border-bottom: 1px solid var(--v3-border); background: transparent; transition: background 0.3s; }
    .table-v3 tr:hover td { background: rgba(255, 255, 255, 0.01); }

    .badge-v3 { padding: 0.25rem 0.6rem; border-radius: 6px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; }
    .badge-v3.turquoise { background: rgba(6, 182, 212, 0.1); color: #06b6d4; border: 1px solid rgba(6, 182, 212, 0.2); }

    .status-glow { font-size: 0.65rem; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 100px; display: inline-flex; align-items: center; gap: 0.5rem; }
    .status-glow::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    .status-glow.active { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .status-glow.active::before { background: #10b981; box-shadow: 0 0 8px #10b981; }
    .status-glow.inactive { background: rgba(148, 163, 184, 0.1); color: #94a3b8; }
    .status-glow.inactive::before { background: #94a3b8; }

    .action-btn-v3 { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--v3-border); background: rgba(255, 255, 255, 0.03); color: var(--v3-text-muted); transition: all 0.3s; text-decoration: none !important; }
    .action-btn-v3:hover { transform: translateY(-2px); border-color: var(--v3-accent); color: var(--v3-accent); }
    .action-btn-v3.delete:hover { border-color: #ef4444; color: #ef4444; }
</style>
@endsection
