@extends('layouts.admin')

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="page-title text-white">Client Dossier: {{ $client->name }}</h1>
        <p class="page-subtitle text-v2-muted">Historical and project records for this converted agency partner.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.clients.index') }}" class="btn-neo-glass">
            <i class="fas fa-arrow-left me-2"></i> All Clients
        </a>
        <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn-v2-primary">
            <i class="fas fa-edit me-2"></i> Update Profile
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Client Summary & Projects -->
    <div class="col-lg-8">
        <div class="tech-card mb-4">
            <h5 class="fw-bold mb-4 text-white">Project History</h5>
            <div class="table-responsive">
                <table class="table table-v2 table-hover mb-0">
                    <thead>
                        <tr>
                            <th>PROJECT</th>
                            <th>STATUS</th>
                            <th>LINK</th>
                            <th class="text-end">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($client->projects as $project)
                        <tr>
                            <td><div class="fw-bold text-white">{{ $project->title }}</div></td>
                            <td>
                                <span class="status-glow-v2 {{ $project->status === 'active' ? 'active' : 'inactive' }}">
                                    <span class="status-dot"></span>
                                    {{ strtoupper($project->status) }}
                                </span>
                            </td>
                            <td>
                                @if($project->project_url)
                                    <a href="{{ $project->project_url }}" target="_blank" class="small text-v2-primary"><i class="fas fa-external-link-alt me-1"></i> Live View</a>
                                @else
                                    <span class="text-v2-muted small">-- No URL --</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="action-btn-v2" title="Edit"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-v2-muted opacity-30">No project blueprints associated with this client.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.projects.create', ['client_id' => $client->id]) }}" class="btn-tech-outline w-100 justify-content-center">
                    <i class="fas fa-plus-circle me-2"></i> INITIATE NEW PROJECT FOR CLIENT
                </a>
            </div>
        </div>

        @if($client->sourceInquiry)
        <div class="tech-card">
            <h5 class="fw-bold mb-4 text-white">Source Inquiry Data</h5>
            <div class="v2-static-info mb-3">
                <label class="v2-form-label">ORIGINAL SUBJECT</label>
                <div class="text-white fw-bold">{{ $client->sourceInquiry->subject }}</div>
            </div>
            <div class="v2-message-box small">
                {{ $client->sourceInquiry->message }}
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.inquiries.show', $client->sourceInquiry->id) }}" class="text-v2-primary small text-decoration-none">
                    <i class="fas fa-history me-1"></i> View Full Interaction Archive
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Contact & Stats Sidebar -->
    <div class="col-lg-4">
        <div class="tech-card mb-4 text-center">
            <div class="operative-avatar-v2 mx-auto mb-3 text-v2-primary fs-2" style="width: 80px; height: 80px; background: rgba(240, 82, 35, 0.1);">
                 {{ substr($client->name, 0, 1) }}
            </div>
            <h4 class="text-white fw-bold mb-1">{{ $client->name }}</h4>
            <div class="text-v2-primary fw-bold mb-4">{{ $client->company_name ?? 'Individual Identity' }}</div>
            
            <div class="row g-2 mb-4">
                <div class="col-6">
                    <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid var(--v2-border);">
                        <div class="small text-v2-muted mb-1">TOTAL LTV</div>
                        <div class="fw-bold text-white">${{ number_format($client->total_revenue, 0) }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid var(--v2-border);">
                        <div class="small text-v2-muted mb-1">PROJECTS</div>
                        <div class="fw-bold text-white">{{ $client->projects->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="space-y-3 text-start">
                <div class="mb-3">
                    <label class="v2-form-label">IDENTITY UPLINK</label>
                    <a href="mailto:{{ $client->email }}" class="btn-neo-glass w-100 justify-content-start text-white"><i class="far fa-envelope me-3"></i> {{ $client->email }}</a>
                </div>
                @if($client->phone)
                <div class="mb-3">
                    <label class="v2-form-label">VOICE COMMS</label>
                    <a href="tel:{{ $client->phone }}" class="btn-neo-glass w-100 justify-content-start text-white"><i class="fas fa-phone-alt me-3"></i> {{ $client->phone }}</a>
                </div>
                @endif
                <div class="mb-3">
                    <label class="v2-form-label">NETWORK LINKS</label>
                    <div class="d-flex gap-2">
                        @if($client->linkedin_url)
                            <a href="{{ $client->linkedin_url }}" target="_blank" class="btn-neo-glass flex-fill"><i class="fab fa-linkedin"></i></a>
                        @endif
                        @if($client->website_url)
                            <a href="{{ $client->website_url }}" target="_blank" class="btn-neo-glass flex-fill"><i class="fas fa-globe"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .v2-form-label { display: block; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1rem; color: var(--v2-text-muted); margin-bottom: 0.75rem; text-transform: uppercase; }
    .v2-static-info { background: rgba(255,255,255,0.03); border: 1px solid var(--v2-border); border-radius: 10px; padding: 0.75rem 1rem; color: white; }
    .v2-message-box { background: rgba(255,255,255,0.03); border: 1px solid var(--v2-border); border-radius: 12px; padding: 1rem; color: #e2e8f0; line-height: 1.6; font-size: 0.85rem; }
    .operative-avatar-v2 { border-radius: 20px; border: 2px solid var(--v2-border); display: flex; align-items: center; justify-content: center; font-weight: 800; }
</style>
@endsection
