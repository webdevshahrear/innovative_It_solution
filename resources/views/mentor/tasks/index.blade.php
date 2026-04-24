@extends('layouts.dashboard')
@section('title', 'Intern Tasks')
@section('panel_type', 'Mentor Panel')

@section('sidebar')
    <a href="{{ route('mentor.dashboard') }}" class="nav-link">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('mentor.tasks.index') }}" class="nav-link active">
        <i class="fas fa-tasks"></i> Task Reviews
    </a>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 style="font-family:'Outfit';font-weight:700;margin:0">Task Management</h3>
    <a href="{{ route('mentor.tasks.create') }}" class="btn-premium">
        <i class="fas fa-plus me-2"></i>Assign New Task
    </a>
</div>

<div class="stat-card" style="padding:0; overflow:hidden;">
    <div class="table-responsive">
        <table class="table table-dark mb-0 table-hover">
            <thead>
                <tr>
                    <th>Task Info</th>
                    <th>Assigned Intern</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr>
                    <td>
                        <strong class="d-block text-white">{{ $task->title }}</strong>
                        <div style="font-size:0.8rem;color:var(--text-secondary)">
                            <span class="badge border border-secondary text-secondary me-1 px-2" style="text-transform:uppercase; font-size:0.65rem; letter-spacing:0.05em">{{ $task->priority }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2 text-white">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($task->internAccount->application->full_name) }}&background=3b82f6&color=fff" class="rounded-circle border border-secondary" style="width:32px;height:32px">
                            {{ $task->internAccount->application->full_name }}
                        </div>
                    </td>
                    <td>
                        <span class="{{ \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status == 'pending' ? 'text-danger fw-bold' : 'text-v2-muted' }}">
                            {{ \Carbon\Carbon::parse($task->deadline)->format('d M, Y') }}
                        </span>
                    </td>
                    <td>
                        @if($task->status === 'pending') <span class="badge bg-warning text-dark px-2">Pending</span>
                        @elseif($task->status === 'submitted') <span class="badge bg-info text-dark px-2">Review Required</span>
                        @elseif($task->status === 'approved') <span class="badge bg-success px-2">Approved ({{ $task->score }}%)</span>
                        @else <span class="badge bg-danger px-2">Rejected</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('mentor.tasks.show', $task) }}" class="btn-premium-outline" style="padding:6px 14px; font-size:0.8rem;">
                            @if($task->status === 'submitted') Manage Review @else Details @endif
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-v2-muted py-5">No tasks assigned yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-5">No tasks assigned yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $tasks->links() }}
</div>
@endsection
