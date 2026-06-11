@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">My Profile</h2>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="glass-card p-4">

            {{-- Avatar display --}}
            <div class="text-center mb-4">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold"
                    style="width:80px;height:80px;font-size:2rem;background:linear-gradient(135deg,var(--primary-color),var(--accent-color));">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <p class="mt-2 mb-0 fw-semibold fs-5">{{ $user->name }}</p>
                <small class="text-muted">{{ ucfirst($user->role->name ?? 'User') }}</small>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-custom @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-custom @error('username') is-invalid @enderror"
                            id="username" name="username" value="{{ old('username', $user->username) }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control form-control-custom @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="glass-card p-3 mb-4 bg-light bg-opacity-50">
                    <h6 class="fw-bold mb-3"><i class="bi bi-shield-lock me-2"></i>Change Password</h6>
                    <p class="text-muted small mb-3">Leave blank if you don't want to change your password.</p>

                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="password" class="form-label fw-semibold small">New Password</label>
                            <input type="password" class="form-control form-control-custom @error('password') is-invalid @enderror"
                                id="password" name="password" minlength="8" autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold small">Confirm New Password</label>
                            <input type="password" class="form-control form-control-custom"
                                id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <hr class="my-4 border-light">

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-gradient px-5 shadow-sm">
                        <i class="bi bi-check-circle me-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
