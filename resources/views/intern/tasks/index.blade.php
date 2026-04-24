@extends('layouts.dashboard')
@section('title', 'Intern Tasks')
@section('panel_type', 'Intern Panel')

@section('sidebar')
    <a href="{{ route('intern.dashboard') }}" class="nav-link {{ request()->routeIs('intern.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('intern.tasks.index') }}" class="nav-link {{ request()->routeIs('intern.tasks.*') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> My Tasks
    </a>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 style="font-family:'Outfit';font-weight:700;margin:0">Assigned Tasks</h3>
</div>

<div class="stat-card" style="padding:0; overflow:hidden;">
    <table class="table table-dark mb-0">
        <thead>
            <tr>
                <th>Title</th>
                <th>Priority</th>
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
                    <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                </td>
                <td>
                    @if($task->priority == 'urgent') <span class="badge bg-danger">Urgent</span>
                    @elseif($task->priority == 'high') <span class="badge bg-warning text-dark">High</span>
                    @elseif($task->priority == 'medium') <span class="badge bg-info text-dark">Medium</span>
                    @else <span class="badge bg-secondary">Low</span>
                    @endif
                </td>
                <td>
                    <span class="{{ \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status == 'pending' ? 'text-danger fw-bold' : 'text-white' }}">
                        {{ \Carbon\Carbon::parse($task->deadline)->format('d M, Y h:i A') }}
                    </span>
                </td>
                <td>
                    @if($task->status === 'pending') <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($task->status === 'submitted') <span class="badge bg-info text-dark">Under Review</span>
                    @elseif($task->status === 'approved') <span class="badge bg-success">Approved ({{ $task->score }}%)</span>
                    @else <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('intern.tasks.show', $task) }}" class="btn-premium-outline" style="padding:6px 16px; font-size:0.85rem;">View Details</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-5">
                    <i class="fas fa-box-open fs-2 mb-3"></i><br>
                    You have no tasks assigned yet.<br>Wait for your mentor to assign your first task.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $tasks->links() }}
</div>
@endsection
