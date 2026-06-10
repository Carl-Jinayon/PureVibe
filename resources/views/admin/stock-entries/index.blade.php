@extends('layouts.admin')

@section('title', 'Stock Entries')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Stock Entries</h2>
    
    @if(!(method_exists(auth()->user(), 'isAuditor') ? auth()->user()->isAuditor() : auth()->user()->role === 'auditor'))
    <a href="{{ route('admin.stock-entries.create') }}" class="btn btn-gradient rounded-pill px-4 shadow-sm">
        <i class="bi bi-plus-circle me-2"></i> New Stock Entry
    </a>
    @endif
</div>

<div class="glass-card mb-4">
    <div class="p-4 border-bottom border-light bg-light bg-opacity-50">
        <form action="{{ route('admin.stock-entries.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control form-control-custom" placeholder="Search entry #..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="supplier_id" class="form-select form-control-custom">
                    <option value="">All Suppliers</option>
                    @if(isset($suppliers))
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-control-custom">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('admin.stock-entries.index') }}" class="btn btn-outline-secondary" title="Clear Filters"><i class="bi bi-arrow-clockwise"></i></a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Entry #</th>
                    <th>Supplier</th>
                    <th>Items Count</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stockEntries ?? [] as $entry)
                <tr>
                    <td><span class="fw-bold">#{{ str_pad($entry->id, 6, '0', STR_PAD_LEFT) }}</span></td>
                    <td>{{ $entry->supplier->name ?? 'N/A' }}</td>
                    <td><span class="badge bg-secondary badge-custom">{{ $entry->items_count ?? $entry->items->count() ?? 0 }} items</span></td>
                    <td>
                        @if($entry->status == 'pending')
                            <span class="badge bg-warning text-dark badge-custom"><i class="bi bi-hourglass-split me-1"></i> Pending</span>
                        @elseif($entry->status == 'approved')
                            <span class="badge bg-success badge-custom"><i class="bi bi-check-circle me-1"></i> Approved</span>
                        @elseif($entry->status == 'rejected')
                            <span class="badge bg-danger badge-custom"><i class="bi bi-x-circle me-1"></i> Rejected</span>
                        @endif
                    </td>
                    <td>{{ $entry->user->name ?? 'System' }}</td>
                    <td>{{ \Carbon\Carbon::parse($entry->created_at)->format('M d, Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.stock-entries.show', $entry->id) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                            <i class="bi bi-eye"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-inboxes fs-1 d-block mb-3"></i>
                            <p class="mb-0">No stock entries found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($stockEntries) && method_exists($stockEntries, 'links'))
    <div class="p-3 border-top border-light d-flex justify-content-end">
        {{ $stockEntries->links() }}
    </div>
    @endif
</div>
@endsection
