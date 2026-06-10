@extends('layouts.admin')

@section('title', 'Audit Logs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Audit Logs</h2>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary rounded-pill px-4" onclick="window.print()">
            <i class="bi bi-printer me-2"></i> Print Log
        </button>
    </div>
</div>

<div class="glass-card mb-4 d-print-none">
    <div class="p-4 border-bottom border-light bg-light bg-opacity-50">
        <form action="{{ route('admin.audit-logs.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="user_id" class="form-select form-control-custom">
                    <option value="">All Users</option>
                    @foreach($users ?? [] as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ ucfirst($user->role?->name ?? 'Staff') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="action" class="form-select form-control-custom">
                    <option value="">All Actions</option>
                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                    <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                </select>
            </div>
            <div class="col-md-5">
                <div class="input-group">
                    <input type="date" name="date_from" class="form-control form-control-custom" value="{{ request('date_from') }}" placeholder="From">
                    <span class="input-group-text border-0 bg-transparent">to</span>
                    <input type="date" name="date_to" class="form-control form-control-custom" value="{{ request('date_to') }}" placeholder="To">
                </div>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline-secondary" title="Clear Filters"><i class="bi bi-arrow-clockwise"></i></a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th width="15%">Date & Time</th>
                    <th width="15%">User</th>
                    <th width="10%">Action</th>
                    <th width="15%">Module / Model</th>
                    <th width="35%">Details</th>
                    <th width="10%">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs ?? [] as $log)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y H:i:s') }}</td>
                    <td>
                        <div class="fw-semibold">{{ $log->user->name ?? 'System' }}</div>
                        <div class="small text-muted">{{ ucfirst($log->user?->role?->name ?? '-') }}</div>
                    </td>
                    <td>
                        @php $actionLower = strtolower($log->action); @endphp
                        @if(str_contains($actionLower, 'created') || str_contains($actionLower, 'login') || str_contains($actionLower, 'approved'))
                            <span class="badge bg-success bg-opacity-10 text-success border border-success badge-custom px-3">{{ ucfirst($log->action) }}</span>
                        @elseif(str_contains($actionLower, 'updated'))
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary badge-custom px-3">{{ ucfirst($log->action) }}</span>
                        @elseif(str_contains($actionLower, 'deleted') || str_contains($actionLower, 'logout') || str_contains($actionLower, 'rejected'))
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger badge-custom px-3">{{ ucfirst($log->action) }}</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary badge-custom px-3">{{ ucfirst($log->action) }}</span>
                        @endif
                    </td>
                    <td class="fw-medium text-dark">{{ class_basename($log->model_type ?? '-') }}</td>
                    <td class="small text-wrap text-muted" style="max-width: 300px;">
                        @if($log->old_values || $log->new_values)
                            <button type="button" class="btn btn-sm btn-outline-secondary py-0" data-bs-toggle="collapse" data-bs-target="#logDetails{{ $log->id }}">
                                View Data
                            </button>
                            <div class="collapse mt-2" id="logDetails{{ $log->id }}">
                                <div class="p-2 bg-light rounded" style="font-size: 0.75rem; overflow-x: auto;">
                                    @if($log->old_values)
                                        <strong>Old:</strong> <pre class="mb-1">{{ json_encode($log->old_values) }}</pre>
                                    @endif
                                    @if($log->new_values)
                                        <strong>New:</strong> <pre class="mb-0">{{ json_encode($log->new_values) }}</pre>
                                    @endif
                                </div>
                            </div>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-muted small">{{ $log->ip_address ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-journal-x fs-1 d-block mb-3"></i>
                            <p class="mb-0">No audit logs found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($logs) && method_exists($logs, 'links'))
    <div class="p-3 border-top border-light d-flex justify-content-end d-print-none">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
