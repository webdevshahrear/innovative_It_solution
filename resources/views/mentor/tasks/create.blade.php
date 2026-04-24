@extends('layouts.dashboard')
@section('title', 'Assign Task')
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
<div class="mb-4">
    <a href="{{ route('mentor.tasks.index') }}" class="btn-premium-outline mb-3" style="padding:8px 20px; font-size:0.9rem;">
        <i class="fas fa-arrow-left me-2"></i>Back to Tasks
    </a>
    <h3 style="font-family:'Outfit';font-weight:700;margin:0">Assign New Task</h3>
</div>

<div class="stat-card" style="max-width:800px">
    <form action="{{ route('mentor.tasks.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Select Intern *</label>
            <select name="intern_account_id" class="form-select bg-white bg-opacity-5 text-white border-secondary rounded-3 p-3" required>
                <option value="" class="bg-dark">-- Choose Intern --</option>
                @foreach($interns as $intern)
                <option value="{{ $intern->id }}" class="bg-dark">{{ $intern->application->full_name }} ({{ $intern->category->name }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Task Title *</label>
            <input type="text" name="title" class="form-control bg-white bg-opacity-5 text-white border-secondary rounded-3 p-3" placeholder="e.g. Build Homepage UI" required>
        </div>

        <div class="mb-4">
            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Task Details / Instructions *</label>
            <textarea name="description" class="form-control bg-white bg-opacity-5 text-white border-secondary rounded-3 p-3" rows="5" required placeholder="Provide clear instructions..."></textarea>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Deadline *</label>
                <input type="datetime-local" name="deadline" class="form-control bg-white bg-opacity-5 text-white border-secondary rounded-3 p-3" required>
            </div>
            <div class="col-md-6">
                <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Priority *</label>
                <select name="priority" class="form-select bg-white bg-opacity-5 text-white border-secondary rounded-3 p-3" required>
                    <option value="low" class="bg-dark">Low</option>
                    <option value="medium" class="bg-dark" selected>Medium</option>
                    <option value="high" class="bg-dark">High</option>
                    <option value="urgent" class="bg-dark">Urgent</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-1">Resources / Links (Optional)</label>
            <textarea name="resources" class="form-control bg-white bg-opacity-5 text-white border-secondary rounded-3 p-3" rows="2" placeholder="Figma links, docs, etc."></textarea>
        </div>
        
        <button type="submit" class="btn-premium px-5 py-3">
            <i class="fas fa-paper-plane me-2"></i>Assign Task
        </button>
    </form>
</div>
@endsection
