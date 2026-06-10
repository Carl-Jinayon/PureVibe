@extends('layouts.admin')

@section('title', 'Inventory Valuation Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Inventory Valuation</h2>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary rounded-pill px-4" onclick="window.print()">
            <i class="bi bi-printer me-2"></i> Print
        </button>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i> Back to Reports
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="glass-card p-4 text-center h-100">
            <h6 class="text-muted text-uppercase fw-semibold mb-2">Total Products</h6>
            <h2 class="fw-bold text-dark mb-0">{{ number_format($totalProducts ?? 0) }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card p-4 text-center h-100">
            <h6 class="text-muted text-uppercase fw-semibold mb-2">Total Units in Stock</h6>
            <h2 class="fw-bold text-primary mb-0">{{ number_format($totalUnits ?? 0) }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card p-4 text-center h-100 border-top border-4 border-success">
            <h6 class="text-muted text-uppercase fw-semibold mb-2">Total Estimated Value</h6>
            <h2 class="fw-bold text-success mb-0">₱{{ number_format($totalValue ?? 0, 2) }}</h2>
            <small class="text-muted">Based on current unit prices</small>
        </div>
    </div>
</div>

<div class="glass-card">
    <div class="card-header-gradient bg-info bg-gradient d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Current Inventory Value by Product</h5>
        <span class="badge bg-light text-dark shadow-sm">As of {{ \Carbon\Carbon::now()->format('M d, Y H:i') }}</span>
    </div>
    <div class="p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th width="30%">Product</th>
                        <th width="15%">Category</th>
                        <th width="15%" class="text-center">Current Stock</th>
                        <th width="20%" class="text-end">Unit Price</th>
                        <th width="20%" class="text-end">Total Value</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products ?? [] as $product)
                    @php $value = $product->current_stock * $product->price; @endphp
                    <tr>
                        <td>
                            <div class="fw-semibold text-dark">{{ $product->name }}</div>
                            <div class="small text-muted">SKU: {{ $product->sku }}</div>
                        </td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td class="text-center fw-bold {{ $product->current_stock == 0 ? 'text-danger' : '' }}">{{ $product->current_stock }}</td>
                        <td class="text-end">₱{{ number_format($product->price, 2) }}</td>
                        <td class="text-end fw-bold text-success">₱{{ number_format($value, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">No inventory records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
