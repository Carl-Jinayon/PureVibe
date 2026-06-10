@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Users Management</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-gradient rounded-pill px-4 shadow-sm">
        <i class="bi bi-person-plus me-2"></i> Add User
    </a>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th width="20%">Name</th>
                    <th width="15%">Username</th>
                    <th width="25%">Email</th>
                    <th width="15%">Role</th>
                    <th width="10%">Status</th>
                    <th width="15%" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users ?? [] as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="fw-semibold text-dark">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-muted">{{ $user->username ?? '-' }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @php $roleName = $user->role?->name ?? ''; @endphp
                        @if($roleName == 'admin')
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger badge-custom">Administrator</span>
                        @elseif($roleName == 'auditor')
                            <span class="badge bg-info bg-opacity-10 text-info border border-info badge-custom">Auditor</span>
                        @elseif($roleName == 'inventory_manager')
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning badge-custom">Inventory Manager</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary badge-custom">{{ ucfirst($roleName ?: 'Staff') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($user->is_active ?? true)
                            <span class="badge bg-success badge-custom">Active</span>
                        @else
                            <span class="badge bg-danger badge-custom">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if(auth()->id() != $user->id)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($users) && method_exists($users, 'links'))
    <div class="p-3 border-top border-light d-flex justify-content-end">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
