@extends('layouts.admin')

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="page-title text-white">Lead Detail: {{ $inquiry->name }}</h1>
        <p class="page-subtitle text-v2-muted">Manage relationship and track conversion pipeline for this operative.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.inquiries.index') }}" class="btn-neo-glass">
            <i class="fas fa-arrow-left me-2"></i> All Leads
        </a>
        @if(!$inquiry->convertedClient)
        <form action="{{ route('admin.inquiries.convert-client', $inquiry->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-v2-primary py-2 px-3">
                <i class="fas fa-user-plus me-2"></i> Convert to Client
            </button>
        </form>
        @else
        <a href="{{ route('admin.clients.show', $inquiry->convertedClient->id) }}" class="btn-v2-primary py-2 px-3" style="background: var(--v2-success); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
            <i class="fas fa-check-circle me-2"></i> View Client Profile
        </a>
        @endif
    </div>
</div>

<div class="row g-4">
    <!-- Main Info & Status -->
    <div class="col-lg-8">
        <div class="tech-card mb-4">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-v2">
                <h5 class="fw-bold mb-0 text-white">Lead Workspace</h5>
                <form action="{{ route('admin.inquiries.update-status', $inquiry->id) }}" method="POST" id="statusForm" class="d-flex align-items-center gap-3">
                    @csrf
                    <div style="width: 180px;">
                        <select name="status" class="form-select v2-admin-input py-1" onchange="this.form.submit()">
                            @foreach(['new', 'contacted', 'qualified', 'proposal_sent', 'won', 'lost'] as $st)
                                <option value="{{ $st }}" {{ $inquiry->status === $st ? 'selected' : '' }}>{{ strtoupper(str_replace('_', ' ', $st)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="v2-form-label">Subject of Interest</label>
                    <div class="v2-static-info fw-bold">{{ $inquiry->subject }}</div>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('admin.inquiries.update-status', $inquiry->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="{{ $inquiry->status }}">
                        <label class="v2-form-label">Mission Accountability</label>
                        <select name="assigned_to" class="v2-admin-input w-100 mb-3" onchange="document.getElementById('assignLeadForm').submit()">
                            <option value="">-- Unassigned --</option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id }}" {{ $inquiry->assigned_to == $admin->id ? 'selected' : '' }}>
                                    Assign to: {{ $admin->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <form action="{{ route('admin.inquiries.assign', $inquiry->id) }}" method="POST" id="assignLeadForm" class="d-none">@csrf</form>

                    <form action="{{ route('admin.inquiries.update-status', $inquiry->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="{{ $inquiry->status }}">
                        <label class="v2-form-label">Estimated Deal Value ($)</label>
                        <div class="input-group">
                            <input type="number" name="lead_value" step="0.01" class="v2-admin-input flex-grow-1" value="{{ $inquiry->lead_value }}" placeholder="0.00">
                            <button type="submit" class="btn-v2-primary py-2"><i class="fas fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mb-4">
                <label class="v2-form-label">Lead Message</label>
                <div class="v2-message-box">
                    {{ $inquiry->message }}
                </div>
            </div>

            <a href="mailto:{{ $inquiry->email }}" class="btn-tech-primary px-4 py-2 w-100 justify-content-center">
                <i class="fas fa-reply me-2"></i> Launch Email Reply
            </a>
        </div>

        <!-- Interaction Timeline -->
        <div class="tech-card">
            <h5 class="fw-bold mb-4 text-white">Interaction Log</h5>
            
            <form action="{{ route('admin.inquiries.add-note', $inquiry->id) }}" method="POST" enctype="multipart/form-data" class="mb-5 p-4" style="background: rgba(255,255,255,0.02); border-radius: 15px; border: 1px solid var(--v2-border);">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <select name="type" class="v2-admin-input w-100">
                            <option value="note">Internal Note</option>
                            <option value="call">Phone Call</option>
                            <option value="email">Email Sent</option>
                            <option value="meeting">Meeting Held</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="content" class="v2-admin-input w-100" placeholder="Summarize interaction..." required>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="d-flex align-items-center gap-3">
                            <input type="file" name="attachment" class="form-control v2-admin-input py-1" style="font-size: 0.75rem;">
                            <button type="submit" class="btn-v2-primary text-nowrap">LOG ACTIVITY</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="timeline-v2">
                @php
                    $timeline = collect();
                    foreach($inquiry->notes as $n) { $timeline->push(['date' => $n->created_at, 'type' => 'manual', 'data' => $n]); }
                    foreach($inquiry->activities as $a) { $timeline->push(['date' => $a->created_at, 'type' => 'system', 'data' => $a]); }
                    $timeline = $timeline->sortByDesc('date');
                @endphp

                @forelse($timeline as $item)
                    @if($item['type'] == 'manual')
                        <?php $note = $item['data']; ?>
                        <div class="timeline-item flex-column gap-1 mb-4 pb-4 border-bottom border-v2">
                            <div class="d-flex justify-content-between mb-1">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge-v2 {{ $note->type === 'note' ? 'indigo' : 'turquoise' }}">{{ strtoupper($note->type) }}</span>
                                    <span class="text-white fw-bold">{{ $note->admin->name }}</span>
                                </div>
                                <span class="text-v2-muted small">{{ $note->created_at->format('M d, H:i') }}</span>
                            </div>
                            <p class="text-white opacity-75 mb-1">{{ $note->content }}</p>
                            @if($note->file_path)
                                <a href="{{ asset('storage/'.$note->file_path) }}" target="_blank" class="small text-v2-primary text-decoration-none">
                                    <i class="fas fa-paperclip me-1"></i> {{ $note->file_name }}
                                </a>
                            @endif
                        </div>
                    @else
                        <?php $activity = $item['data']; ?>
                        <div class="timeline-item mb-4 pb-4 border-bottom border-v2" style="border-left: 2px solid rgba(240, 82, 35, 0.2); padding-left: 1rem;">
                            <div class="d-flex justify-content-between">
                                <span class="small fw-bold text-v2-primary"><i class="fas fa-robot me-1"></i> {{ strtoupper($activity->type) }}</span>
                                <span class="text-v2-muted small">{{ $activity->created_at->format('M d, H:i') }}</span>
                            </div>
                            <div class="text-v2-muted small">{{ $activity->description }}</div>
                        </div>
                    @endif
                @empty
                    <div class="text-center py-4 opacity-30">
                        <i class="fas fa-history fs-2 mb-3"></i>
                        <p>No logged interactions yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Sidebar Metadata -->
    <div class="col-lg-4">
        <div class="tech-card mb-4">
            <h5 class="fw-bold mb-4 text-white">Lead Metadata</h5>
            
            <div class="d-flex align-items-center mb-5">
                <div class="operative-avatar-v2 text-uppercase d-flex align-items-center justify-content-center fw-bold fs-4 text-v2-primary" style="background: rgba(240, 82, 35, 0.1);">
                    {{ substr($inquiry->name, 0, 1) }}
                </div>
                <div class="ms-3">
                    <div class="fw-bold text-white fs-5">{{ $inquiry->name }}</div>
                    <div class="text-v2-muted small">Potential Client</div>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="mb-4 pb-3 border-bottom border-v2">
                    <label class="v2-form-label">IDENTITY (EMAIL)</label>
                    <a href="mailto:{{ $inquiry->email }}" class="text-decoration-none fw-bold text-v2-primary d-flex align-items-center">
                        <i class="far fa-envelope me-2"></i> {{ $inquiry->email }}
                    </a>
                </div>
                <div class="mb-4 pb-3 border-bottom border-v2">
                    <label class="v2-form-label">DIGITAL FOOTPRINT (LINKS)</label>
                    <div class="d-flex gap-2 mt-2">
                        @if($inquiry->linkedin_url)
                            <a href="{{ $inquiry->linkedin_url }}" target="_blank" class="btn-neo-glass py-2" style="flex: 1;"><i class="fab fa-linkedin me-2 text-info"></i>LinkedIn</a>
                        @endif
                        @if($inquiry->website_url)
                            <a href="{{ $inquiry->website_url }}" target="_blank" class="btn-neo-glass py-2" style="flex: 1;"><i class="fas fa-globe me-2 text-success"></i>Website</a>
                        @endif
                        @if(!$inquiry->linkedin_url && !$inquiry->website_url)
                            <span class="text-v2-muted small">No social/web links provided.</span>
                        @endif
                    </div>
                </div>
                <div class="mb-4">
                    <label class="v2-form-label">DEVICE/ORIGIN</label>
                    <div class="small text-v2-muted">
                        <i class="fas fa-network-wired me-2"></i> {{ $inquiry->ip_address }}<br>
                        <i class="fas fa-info-circle me-2"></i> {{ Str::limit($inquiry->user_agent, 40) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="tech-card mb-4">
            <h5 class="fw-bold mb-4 text-white"><i class="fas fa-clock text-v2-primary me-2"></i> Strategic Follow-up</h5>
            @if($inquiry->remind_at)
                <div class="p-3 mb-3" style="background: rgba(240, 82, 35, 0.05); border: 1px solid var(--v2-primary); border-radius: 12px;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small text-v2-muted fw-bold">SCHEDULED REMINDER</span>
                        <span class="badge-v2 {{ $inquiry->priority == 'high' ? 'rose' : 'indigo' }}">{{ strtoupper($inquiry->priority) }}</span>
                    </div>
                    <div class="text-white fw-bold">{{ \Carbon\Carbon::parse($inquiry->remind_at)->format('M d, Y @ H:i') }}</div>
                </div>
            @endif

            <form action="{{ route('admin.inquiries.set-reminder', $inquiry->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="v2-form-label">Remind Me On</label>
                    <input type="datetime-local" name="remind_at" class="v2-admin-input w-100" required min="{{ date('Y-m-d\TH:i') }}">
                </div>
                <div class="mb-3">
                    <label class="v2-form-label">Mission Priority</label>
                    <div class="d-flex gap-2">
                        @foreach(['low', 'medium', 'high'] as $p)
                            <label class="flex-grow-1">
                                <input type="radio" name="priority" value="{{ $p }}" {{ ($inquiry->priority ?? 'medium') == $p ? 'checked' : '' }} class="btn-check">
                                <div class="btn btn-outline-secondary w-100 py-1 small border-v2" style="font-size: 0.7rem;">{{ strtoupper($p) }}</div>
                            </label>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn-v2-primary w-100 justify-content-center">
                    <i class="fas fa-bell me-2"></i> {{ $inquiry->remind_at ? 'UPDATE REMINDER' : 'SET REMINDER' }}
                </button>
            </form>
        </div>

        <div class="tech-card border-danger border-opacity-20 d-flex flex-column gap-3">
            <h6 class="text-danger fw-bold"><i class="fas fa-radiation me-2"></i> Danger Zone</h6>
            <p class="small text-v2-muted">Destroying this lead packet is a permanent action and cannot be reversed.</p>
            <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Purge lead history?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger w-100 border-v2 py-2 text-danger opacity-75 hover-opacity-100">
                    <i class="fas fa-trash-alt me-2"></i> PURGE LEAD DATA
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .border-v2 { border-color: var(--v2-border) !important; }
    .v2-form-label { display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v2-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; }
    .v2-static-info { background: rgba(255,255,255,0.03); border: 1px solid var(--v2-border); border-radius: 10px; padding: 0.75rem 1rem; color: white; }
    .v2-message-box { background: rgba(255,255,255,0.03); border: 1px solid var(--v2-border); border-radius: 12px; padding: 1.5rem; color: #e2e8f0; line-height: 1.8; white-space: pre-wrap; font-size: 0.95rem; }
    .operative-avatar-v2 { width: 56px; height: 56px; border-radius: 50%; border: 2px solid var(--v2-border); box-shadow: 0 0 15px rgba(240, 82, 35, 0.1); }
    .btn-tech-outline { display: inline-flex; padding: 0.6rem 1.2rem; background: transparent; border: 1px solid var(--v2-border); color: var(--v2-text-muted); text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; transition: 0.3s; cursor: pointer; }
    .btn-tech-outline:hover { border-color: white; color: white; background: rgba(255,255,255,0.05); }
    .hover-opacity-100:hover { opacity: 1 !important; background: rgba(239, 68, 68, 0.1) !important; }
</style>
@endsection
