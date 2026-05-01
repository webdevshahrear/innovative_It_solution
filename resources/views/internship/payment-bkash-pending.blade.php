@extends('layouts.frontend')
@section('title', 'Payment Verification Pending')

@section('content')
<style>
    .pending-card {
        background: var(--card-bg, rgba(30, 41, 59, 0.8)); 
        backdrop-filter: blur(20px); 
        border-radius: 24px; 
        border: 1px solid var(--border) !important;
        transition: all 0.3s;
    }
    
    body.light-mode .pending-card {
        background: #ffffff;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05) !important;
    }
    
    .pending-box {
        background: rgba(245, 158, 11, 0.1); 
        border: 1px solid rgba(245, 158, 11, 0.2); 
    }
    
    body.light-mode .pending-box {
        background: rgba(245, 158, 11, 0.05);
    }
    
    .btn-outline-custom {
        border: 1px solid var(--border);
        color: var(--text-main);
        transition: all 0.3s;
    }
    
    .btn-outline-custom:hover {
        background: var(--bg-secondary);
        color: var(--text-main);
    }
</style>
<div class="container py-5 text-center" style="min-height: 80vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <div class="card pending-card shadow-lg p-5 text-center" style="max-width: 600px;">
        <div style="font-size: 5rem; color: #f59e0b; margin-bottom: 20px;">
            <i class="fas fa-clock"></i>
        </div>
        <h2 class="fw-bold mb-3" style="color: var(--text-main)">Verification Pending</h2>
        <p style="color: var(--text-muted); font-size: 1.1rem; line-height: 1.6;">
            Your bKash payment details have been successfully submitted! Our team is currently verifying the transaction manually. 
        </p>
        <div class="mt-4 p-4 rounded-3 pending-box text-start">
            <h6 class="text-warning fw-bold mb-2"><i class="fas fa-info-circle me-2"></i> What happens next?</h6>
            <ul style="color: var(--text-main); margin-bottom: 0; padding-left: 1.2rem; font-size: 0.95rem;">
                <li class="mb-2">Admin will review your TrxID.</li>
                <li class="mb-2">Once approved, you will receive an email with a secure link.</li>
                <li>You will use that link to create your intern account and access your dashboard.</li>
            </ul>
        </div>
        <p class="mt-4 small" style="color: var(--text-muted)">
            If you do not receive a confirmation within 24 hours, please contact support. You can refresh this page to check your status.
        </p>
        <div class="mt-4 d-flex justify-content-center gap-3">
            <a href="{{ route('internship.payment.bkash-pending', $attempt) }}" class="btn-v2-primary px-4 py-2 rounded-pill text-decoration-none shadow-lg"><i class="fas fa-sync-alt me-2"></i> Refresh Status</a>
            <a href="{{ route('home') }}" class="btn-outline-custom px-4 py-2 rounded-pill text-decoration-none">Return to Home</a>
        </div>
    </div>
</div>
@endsection
