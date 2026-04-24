@extends('layouts.admin')

@push('styles')
<style>
    .cyber-header {
        position: relative; padding: 60px 50px; border-radius: 36px;
        background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.08);
        margin-bottom: 50px; overflow: hidden; backdrop-filter: blur(24px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.1);
    }
    .cyber-header::before {
        content: ''; position: absolute; inset: -50%; 
        background: radial-gradient(circle at 70% 30%, rgba(16, 185, 129, 0.15), transparent 50%),
                    radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.12), transparent 50%);
        animation: rotateGlow 20s linear infinite; pointer-events: none; z-index: 0;
    }
    .cyber-header > * { position: relative; z-index: 1; }
    @keyframes rotateGlow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    .obsidian-form-card {
        background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 36px; padding: 50px; backdrop-filter: blur(30px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.5);
    }
    
    .status-interface {
        background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.05);
        border-radius: 24px; padding: 30px; box-shadow: inset 0 5px 20px rgba(0,0,0,0.3);
    }
</style>
@endpush

@section('content')
<div class="cyber-header d-flex justify-content-between align-items-center" data-aos="fade-down">
    <div>
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="pulse-ai" style="width:12px;height:12px;background:#10b981;border-radius:50%; box-shadow: 0 0 15px #10b981;"></span>
            <span class="text-uppercase fw-bold" style="color:#10b981; font-size:0.8rem; letter-spacing:3px">Synthetic Intelligence Active</span>
        </div>
        <h1 class="text-white m-0" style="font-size: 3.5rem; font-weight: 900; font-family: 'Outfit'; letter-spacing: -0.04em;">Question <span style="background: linear-gradient(135deg, #10b981, #34d399); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Architecture</span></h1>
        <p class="text-v2-muted mt-3 mb-0" style="font-size: 1.2rem; max-width: 650px; line-height: 1.6;">Leverage Google Gemini-Pro to synthetically architect high-precision MCQ assets for the intelligence bank.</p>
    </div>
    <a href="{{ route('admin.internship.questions.index') }}" class="btn-neo-glass py-3 px-5" style="border-radius: 20px; font-weight: 800;">
        <i class="fas fa-arrow-left me-2 text-primary"></i> Back to Bank
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10" data-aos="fade-up">
        <div class="obsidian-form-card">
            <form id="aiGeneratorForm">
                <div class="mb-5">
                    <label class="form-label text-v2-muted text-uppercase fw-bold small letter-spacing-2 mb-3">Target Intelligence Domain</label>
                    <select id="genCategory" class="form-select v2-admin-input form-select-lg p-4" style="border-radius: 20px; font-weight: 600;" required>
                        <option value="">-- Choose High-Level Specialization --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-v2-muted d-block mt-3 opacity-75"><i class="fas fa-info-circle me-1"></i> The transformer logic will be calibrated specifically for this technical vertical.</small>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <label class="form-label text-v2-muted text-uppercase fw-bold small letter-spacing-2 mb-3">Cognitive Complexity</label>
                        <select id="genDifficulty" class="form-select v2-admin-input py-3" style="border-radius: 15px;" required>
                            <option value="easy">Foundational (Entry Level)</option>
                            <option value="medium" selected>Operational (Intermediate Level)</option>
                            <option value="hard">Strategic (Advanced Scenario Level)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-v2-muted text-uppercase fw-bold small letter-spacing-2 mb-3">Batch Asset Volume</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--v2-border); border-radius: 15px 0 0 15px;"><i class="fas fa-layer-group text-v2-muted"></i></span>
                            <input type="number" id="genCount" class="form-control v2-admin-input py-3 border-start-0" style="border-radius: 0 15px 15px 0;" min="5" max="30" value="10" required>
                        </div>
                    </div>
                </div>

                <button type="submit" id="generateBtn" class="btn-v2-primary w-100 py-4 shadow-lg mb-0" style="border-radius:24px; font-weight:900; font-size:1.2rem; background: linear-gradient(135deg, #10b981, #059669); border:none; letter-spacing: 1px;">
                    <span id="btnText"><i class="fas fa-microchip me-2"></i> INITIATE SYNTHETIC GENERATION</span>
                </button>
            </form>

            {{-- Status Interface --}}
            <div id="statusBox" class="mt-5 status-interface d-none" data-aos="zoom-in">
                <div class="d-flex align-items-center gap-4">
                    <div id="statusIcon" class="flex-shrink-0"></div>
                    <div class="flex-grow-1">
                        <h4 id="statusTitle" class="mb-1 fw-900"></h4>
                        <p id="statusMsg" class="mb-0 text-v2-muted fw-500"></p>
                    </div>
                    <div id="statusAction">
                         <a href="{{ route('admin.internship.questions.index') }}?source=gemini&approved=0" id="reviewLink" class="btn-v2-primary py-3 px-4 d-none" style="border-radius:15px; font-size: 0.9rem;">
                            REVIEW ASSETS <i class="fas fa-arrow-right ms-2"></i>
                         </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('aiGeneratorForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const catId = document.getElementById('genCategory').value;
    const diff = document.getElementById('genDifficulty').value;
    const count = document.getElementById('genCount').value;
    
    if (!catId) return;
    
    const btn = document.getElementById('generateBtn');
    const span = document.getElementById('btnText');
    const statusBox = document.getElementById('statusBox');
    
    btn.disabled = true;
    btn.style.opacity = '0.7';
    span.innerHTML = `<i class="fas fa-atom fa-spin me-2"></i> SYNCHRONIZING WITH NEURAL ENGINE...`;
    
    statusBox.classList.remove('d-none');
    statusBox.style.borderColor = 'rgba(245, 158, 11, 0.3)';
    document.getElementById('statusIcon').innerHTML = '<div class="spinner-border text-warning" style="width: 3rem; height: 3rem; border-width: 0.25em;"></div>';
    document.getElementById('statusTitle').innerText = 'NEURAL PROCESSING ACTIVE';
    document.getElementById('statusTitle').style.color = '#f59e0b';
    document.getElementById('statusMsg').innerText = `Constructing ${count} high-precision ${diff} assessment segments. System will finalize in roughly 20s.`;
    document.getElementById('reviewLink').classList.add('d-none');
    
    try {
        const response = await fetch('{{ route("admin.internship.questions.generate-ai") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ category_id: catId, difficulty: diff, count: count })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            statusBox.style.borderColor = 'rgba(16, 185, 129, 0.4)';
            document.getElementById('statusIcon').innerHTML = '<i class="fas fa-check-circle text-success" style="font-size: 3.5rem"></i>';
            document.getElementById('statusTitle').innerText = 'DOMAINS SUCCESSFULLY SYNTHESIZED';
            document.getElementById('statusTitle').style.color = '#10b981';
            document.getElementById('statusMsg').innerText = data.message;
            document.getElementById('reviewLink').classList.remove('d-none');
        } else {
            throw new Error(data.error || data.message || 'Quantum interface interruption');
        }
        
    } catch (error) {
        statusBox.style.borderColor = 'rgba(239, 68, 68, 0.4)';
        document.getElementById('statusIcon').innerHTML = '<i class="fas fa-circle-exclamation text-danger" style="font-size: 3.5rem"></i>';
        document.getElementById('statusTitle').innerText = 'GENERATION SEQUENCE ABORTED';
        document.getElementById('statusTitle').style.color = '#ef4444';
        document.getElementById('statusMsg').innerText = error.message;
    } finally {
        btn.disabled = false;
        btn.style.opacity = '1';
        span.innerHTML = `<i class="fas fa-microchip me-2"></i> INITIATE SYNTHETIC GENERATION`;
    }
});
</script>
@endsection
