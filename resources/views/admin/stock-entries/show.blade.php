@extends('layouts.admin')

@section('title', 'Stock Entry Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Stock Entry #{{ str_pad($entry->id, 6, '0', STR_PAD_LEFT) }}</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.stock-entries.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="glass-card p-0 h-100">
            <div class="card-header-gradient d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Entry Information</h5>
                @if($entry->status == 'pending')
                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Pending</span>
                @elseif($entry->status == 'approved')
                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Approved</span>
                @elseif($entry->status == 'rejected')
                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Rejected</span>
                @endif
            </div>
            <div class="p-4">
                <ul class="list-group list-group-flush bg-transparent">
                    <li class="list-group-item bg-transparent px-0">
                        <span class="text-muted d-block small fw-semibold text-uppercase">Supplier</span>
                        <span class="fw-medium fs-5">{{ $entry->supplier->name ?? 'No Supplier Specified' }}</span>
                    </li>
                    <li class="list-group-item bg-transparent px-0">
                        <span class="text-muted d-block small fw-semibold text-uppercase">Reference</span>
                        <span class="fw-medium">{{ $entry->reference ?? '-' }}</span>
                    </li>
                    <li class="list-group-item bg-transparent px-0">
                        <span class="text-muted d-block small fw-semibold text-uppercase">Created By</span>
                        <span class="fw-medium">{{ $entry->user->name ?? 'System' }}</span>
                    </li>
                    <li class="list-group-item bg-transparent px-0">
                        <span class="text-muted d-block small fw-semibold text-uppercase">Date Created</span>
                        <span class="fw-medium">{{ \Carbon\Carbon::parse($entry->created_at)->format('M d, Y h:i A') }}</span>
                    </li>
                </ul>

                @if($entry->notes)
                <div class="mt-4 p-3 bg-light rounded border border-light">
                    <span class="text-muted d-block small fw-semibold text-uppercase mb-1">Notes</span>
                    <p class="mb-0 small">{{ $entry->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="glass-card p-0 h-100">
            <div class="card-header-gradient bg-secondary bg-gradient">
                <h5 class="mb-0">Items Included ({{ $entry->items->count() ?? 0 }})</h5>
            </div>
            <div class="p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Quantity</th>
                                <th>Unit Cost</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @forelse($entry->items ?? [] as $item)
                            @php 
                                $total = $item->quantity * ($item->unit_cost ?? 0);
                                $grandTotal += $total;
                            @endphp
                            <tr>
                                <td class="fw-medium">{{ $item->product->name ?? 'Unknown Product' }}</td>
                                <td class="text-muted">{{ $item->product->sku ?? '-' }}</td>
                                <td class="fw-bold">{{ $item->quantity }}</td>
                                <td>{{ $item->unit_cost ? '₱' . number_format($item->unit_cost, 2) : '-' }}</td>
                                <td class="fw-semibold">{{ $total > 0 ? '₱' . number_format($total, 2) : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No items found in this entry.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($grandTotal > 0)
                        <tfoot class="table-light border-top-2">
                            <tr>
                                <td colspan="4" class="text-end fw-bold text-uppercase py-3">Estimated Total Value:</td>
                                <td class="fw-bold fs-5 text-primary py-3">₱{{ number_format($grandTotal, 2) }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if($entry->status == 'pending' && !(method_exists(auth()->user(), 'isAuditor') ? auth()->user()->isAuditor() : auth()->user()->role === 'auditor'))
<div class="glass-card p-4 text-center">
    <h5 class="mb-3">Action Required</h5>
    <p class="text-muted mb-4">Review the items above. Approving this entry will automatically update the inventory stock levels.</p>
    
    <div class="d-flex justify-content-center gap-3">
        <form action="{{ route('admin.stock-entries.reject', $entry->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-outline-danger px-4" onclick="return confirm('Are you sure you want to reject this entry?');">
                <i class="bi bi-x-circle me-2"></i> Reject Entry
            </button>
        </form>

        <form action="{{ route('admin.stock-entries.approve', $entry->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success px-5 shadow" onclick="return confirm('Approve entry and update inventory stock?');">
                <i class="bi bi-check-circle me-2"></i> Approve & Restock
            </button>
        </form>
    </div>
</div>
@endif
@endsection
