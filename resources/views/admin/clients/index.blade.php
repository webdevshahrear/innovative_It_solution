@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title text-white">Client Database</h1>
        <p class="page-subtitle text-v2-muted">Consolidated record of converted leads and permanent agency partners.</p>
    </div>
</div>

<div class="tech-card-v2 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-v2 mb-0">
            <thead>
                <tr>
                    <th>CLIENT IDENTITY</th>
                    <th>COMPANY</th>
                    <th>RELATIONSHIP LINKS</th>
                    <th>PROJECTS</th>
                    <th>REVENUE</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr>
                    <td>
                        <div class="fw-bold text-white">{{ $client->name }}</div>
                        <div class="small text-v2-muted">{{ $client->email }}</div>
                    </td>
                    <td><div class="text-white">{{ $client->company_name ?? '-- Private Individual --' }}</div></td>
                    <td>
                        <div class="d-flex gap-2">
                            @if($client->linkedin_url)
                                <a href="{{ $client->linkedin_url }}" target="_blank" class="action-btn-v2" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            @endif
                            @if($client->website_url)
                                <a href="{{ $client->website_url }}" target="_blank" class="action-btn-v2" title="Website"><i class="fas fa-globe"></i></a>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge-v2 indigo">{{ $client->projects->count() }} ACTIVE</span>
                    </td>
                    <td><div class="fw-bold text-v2-primary">${{ number_format($client->total_revenue, 2) }}</div></td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.clients.show', $client->id) }}" class="action-btn-v2" title="Open Dossier"><i class="fas fa-folder-open"></i></a>
                            <a href="{{ route('admin.clients.edit', $client->id) }}" class="action-btn-v2" title="Update Profile"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Erase client record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-v2 delete" title="Purge"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="opacity-30">
                            <i class="fas fa-users-slash fs-1 mb-3 text-v2-muted"></i>
                            <p class="text-v2-muted">No clients registered in the database yet.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($clients->hasPages())
<div class="pagination-v2 mt-4 d-flex justify-content-center">
    {{ $clients->links('pagination::bootstrap-5') }}
</div>
@endif
@endsection
