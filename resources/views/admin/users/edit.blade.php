@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Edit User</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i> Back to Users
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="glass-card p-4">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-custom @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-custom @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="glass-card p-3 mb-4 bg-light bg-opacity-50">
                    <h6 class="fw-bold mb-3"><i class="bi bi-shield-lock me-2"></i>Change Password</h6>
                    <p class="text-muted small mb-3">Leave blank if you don't want to change the password.</p>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="password" class="form-label fw-semibold small">New Password</label>
                            <input type="password" class="form-control form-control-custom @error('password') is-invalid @enderror" id="password" name="password" minlength="8">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold small">Confirm New Password</label>
                            <input type="password" class="form-control form-control-custom" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="role" class="form-label fw-semibold">User Role <span class="text-danger">*</span></label>
                        <select class="form-select form-control-custom @error('role') is-invalid @enderror" id="role" name="role" required {{ auth()->id() == $user->id ? 'disabled' : '' }}>
                            @foreach($roles ?? ['admin' => 'Administrator', 'staff' => 'Staff', 'auditor' => 'Auditor'] as $value => $label)
                                <option value="{{ $value }}" {{ old('role', $user->role) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if(auth()->id() == $user->id)
                            <input type="hidden" name="role" value="{{ $user->role }}">
                            <small class="text-muted">You cannot change your own role.</small>
                        @endif
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 d-flex align-items-end pb-2">
                        <div class="form-check form-switch fs-5">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }} {{ auth()->id() == $user->id ? 'disabled' : '' }}>
                            <label class="form-check-label fs-6 mt-1 ms-2" for="is_active">User is Active</label>
                            @if(auth()->id() == $user->id)
                                <input type="hidden" name="is_active" value="1">
                            @endif
                        </div>
                    </div>
                </div>

                <hr class="my-4 border-light">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light border shadow-sm px-4">Cancel</a>
                    <button type="submit" class="btn btn-gradient px-4 shadow-sm">
                        <i class="bi bi-check-circle me-2"></i> Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
