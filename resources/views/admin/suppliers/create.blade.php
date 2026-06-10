@extends('layouts.admin')

@section('title', 'Add Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Add Supplier</h2>
    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i> Back to Suppliers
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="glass-card p-4">
            <form action="{{ route('admin.suppliers.store') }}" method="POST">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="name" class="form-label fw-semibold">Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-custom @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="contact_person" class="form-label fw-semibold">Contact Person</label>
                        <input type="text" class="form-control form-control-custom @error('contact_person') is-invalid @enderror" id="contact_person" name="contact_person" value="{{ old('contact_person') }}">
                        @error('contact_person')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold">Phone Number</label>
                        <input type="text" class="form-control form-control-custom @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="address" class="form-label fw-semibold">Address</label>
                    <textarea class="form-control form-control-custom @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label fs-6 mt-1 ms-2" for="is_active">Supplier is Active</label>
                    </div>
                </div>

                <hr class="my-4 border-light">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-light border shadow-sm px-4">Cancel</a>
                    <button type="submit" class="btn btn-gradient px-4 shadow-sm">
                        <i class="bi bi-check-circle me-2"></i> Save Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
