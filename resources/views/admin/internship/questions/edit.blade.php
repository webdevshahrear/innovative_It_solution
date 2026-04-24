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
        background: radial-gradient(circle at 70% 30%, rgba(240, 82, 35, 0.12), transparent 50%),
                    radial-gradient(circle at 20% 80%, rgba(167, 139, 250, 0.1), transparent 50%);
        animation: rotateGlow 20s linear infinite; pointer-events: none; z-index: 0;
    }
    .cyber-header > * { position: relative; z-index: 1; }
    @keyframes rotateGlow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    .obsidian-form-card {
        background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 36px; padding: 50px; backdrop-filter: blur(30px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.5);
    }
</style>
@endpush

@section('content')
<div class="cyber-header d-flex justify-content-between align-items-center" data-aos="fade-down">
    <div>
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="pulse-ai" style="width:10px;height:10px;background:var(--neural-purple);border-radius:50%; box-shadow: 0 0 10px var(--neural-purple);"></span>
            <span class="text-uppercase fw-bold" style="color:var(--neural-purple); font-size:0.75rem; letter-spacing:2px">Refinement Sequence Active</span>
        </div>
        <h1 class="text-white m-0" style="font-size: 3rem; font-weight: 900; font-family: 'Outfit'; letter-spacing: -0.03em;">Asset <span style="background: linear-gradient(135deg, #a78bfa, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Refinement</span></h1>
        <p class="text-v2-muted mt-2 mb-0" style="font-size: 1.1rem; max-width: 600px;">Optimizing MCQ asset #{{ $question->id }} within the central intelligence bank.</p>
    </div>
    <a href="{{ route('admin.internship.questions.index') }}" class="btn-neo-glass py-3 px-4" style="border-radius: 20px;">
        <i class="fas fa-arrow-left me-2 text-primary"></i> Back to Bank
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10" data-aos="fade-up">
        <div class="obsidian-form-card">
            <form action="{{ route('admin.internship.questions.update', $question) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-2">Knowledge Domain</label>
                        <select name="category_id" class="form-select v2-admin-input py-3" style="border-radius: 15px;" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $question->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-2">Difficulty Scale</label>
                        <select name="difficulty" class="form-select v2-admin-input py-3" style="border-radius: 15px;" required>
                            <option value="easy" {{ $question->difficulty == 'easy' ? 'selected' : '' }}>Level Entry (Foundational)</option>
                            <option value="medium" {{ $question->difficulty == 'medium' ? 'selected' : '' }}>Level Intermediate (Operational)</option>
                            <option value="hard" {{ $question->difficulty == 'hard' ? 'selected' : '' }}>Level Advanced (Strategic)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-2">Assessment Prompt</label>
                    <textarea name="question_text" class="form-control v2-admin-input p-4" rows="4" style="border-radius: 20px; font-size: 1.1rem;" required>{{ $question->question_text }}</textarea>
                </div>

                <div class="row g-4 mb-5">
                    @foreach(['a' => 'Alpha', 'b' => 'Beta', 'c' => 'Gamma', 'd' => 'Delta'] as $key => $label)
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-5">
                            <label class="form-label text-v2-muted small text-uppercase fw-bold mb-3">Response {{ $label }} ({{ strtoupper($key) }})</label>
                            <input type="text" name="option_{{ $key }}" class="form-control v2-admin-input py-3" value="{{ $question->{'option_'.$key} }}" style="border-radius: 12px;" required>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mb-5 p-4 rounded-4" style="background:rgba(167, 139, 250, 0.05); border:1px solid rgba(167, 139, 250, 0.2)">
                    <label class="form-label text-v2-primary small text-uppercase fw-bold letter-spacing-2" style="color: var(--neural-purple) !important;">Definitive Truth Vector (Correct Option)</label>
                    <select name="correct_option" class="form-select v2-admin-input py-3" style="border-color: rgba(167, 139, 250, 0.4) !important; border-radius: 15px;" required>
                        <option value="a" {{ $question->correct_option == 'a' ? 'selected' : '' }}>Response Alpha (A)</option>
                        <option value="b" {{ $question->correct_option == 'b' ? 'selected' : '' }}>Response Beta (B)</option>
                        <option value="c" {{ $question->correct_option == 'c' ? 'selected' : '' }}>Response Gamma (C)</option>
                        <option value="d" {{ $question->correct_option == 'd' ? 'selected' : '' }}>Response Delta (D)</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label class="form-label text-v2-muted small text-uppercase fw-bold letter-spacing-2">Intelligence Feedback / Explanation</label>
                    <textarea name="explanation" class="form-control v2-admin-input p-4" rows="3" style="border-radius: 20px;">{{ $question->explanation }}</textarea>
                </div>

                <div class="mb-5">
                    <div class="d-flex align-items-center gap-4 p-4 rounded-4" style="background:rgba(255,255,255,0.02); border: 1px solid var(--v2-border)">
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="is_approved" value="1" id="is_approved" {{ $question->is_approved ? 'checked' : '' }} style="cursor:pointer; width:45px; height:22px">
                        </div>
                        <div>
                            <label class="form-check-label text-white fw-bold d-block m-0" for="is_approved" style="cursor:pointer">Asset Verified</label>
                            <small class="text-v2-muted">Authorize this asset for immediate deployment in the production environment.</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-4 mt-5">
                    <a href="{{ route('admin.internship.questions.index') }}" class="btn-neo-glass flex-grow-1 text-center py-4 shadow-sm" style="border-radius: 20px; font-weight: 800;">Discard Changes</a>
                    <button type="submit" class="btn-v2-primary flex-grow-2 py-4 px-5 shadow-lg" style="border-radius: 20px; font-weight: 900; font-size: 1.1rem; background: var(--v2-gradient);"><i class="fas fa-save me-2"></i> Synchronize Asset Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
