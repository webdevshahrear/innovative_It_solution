@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">Add Testimonial</h1>
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-left me-2"></i> Back to Testimonials
    </a>
</div>

<div class="card-glass">
    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="client_name" class="form-label">Client Name</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" value="{{ old('client_name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="client_position" class="form-label">Position / Company</label>
                    <input type="text" class="form-control" id="client_position" name="client_position" value="{{ old('client_position') }}">
                </div>
                
                <div class="mb-3">
                    <label for="content" class="form-label">Testimonial Content</label>
                    <textarea class="form-control" id="content" name="content" rows="4" required>{{ old('content') }}</textarea>
                </div>
            </div>
            
            <div class="col-md-4">
                 <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select form-control" id="status" name="status">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                 <div class="mb-3">
                    <label for="rating" class="form-label">Rating (1-5)</label>
                    <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" value="{{ old('rating', 5) }}">
                </div>

                <div class="mb-3">
                    <label for="display_order" class="form-label">Display Order</label>
                    <input type="number" class="form-control" id="display_order" name="display_order" value="{{ old('display_order', 0) }}">
                </div>

                <div class="mb-3">
                    <label for="client_image" class="form-label">Client Image</label>
                    <input type="file" class="form-control" id="client_image" name="client_image">
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary px-4">Save Testimonial</button>
        </div>
    </form>
</div>
@endsection
