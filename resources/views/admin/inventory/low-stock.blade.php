@extends('layouts.admin')

@section('title', 'Low Stock Alerts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
            <i class="bi bi-exclamation-triangle-fill fs-4"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0">Low Stock Alerts</h2>
            <p class="text-muted mb-0">Products that have reached or fallen below their minimum stock threshold.</p>
        </div>
    </div>
    
    @if(!(method_exists(auth()->user(), 'isAuditor') ? auth()->user()->isAuditor() : auth()->user()->role === 'auditor'))
    <a href="{{ route('admin.stock-entries.create') }}" class="btn btn-gradient rounded-pill px-4 shadow-sm">
        <i class="bi bi-plus-circle me-2"></i> Create Restock Entry
    </a>
    @endif
</div>

<div class="glass-card mb-4">
    <div class="p-4 border-bottom border-danger border-opacity-25 bg-danger bg-opacity-10 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-danger fw-semibold">Action Required ({{ count($products ?? []) }})</h5>
        <a href="{{ route('admin.reports.low-stock') }}" class="btn btn-sm btn-outline-danger">
            <i class="bi bi-printer me-1"></i> Print Report
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th width="25%">Product</th>
                    <th width="15%">Category</th>
                    <th width="15%">Supplier</th>
                    <th width="15%">Current Stock</th>
                    <th width="15%">Threshold</th>
                    <th width="15%">Deficit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products ?? [] as $product)
                @php
                    $isOut = $product->current_stock == 0;
                    $deficit = $product->low_stock_threshold - $product->current_stock;
                @endphp
                <tr class="{{ $isOut ? 'table-danger' : '' }}">
                    <td>
                        <div class="fw-semibold text-dark">{{ $product->name }}</div>
                        <div class="small text-muted">SKU: {{ $product->sku }}</div>
                    </td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>{{ $product->supplier->name ?? 'No Primary Supplier' }}</td>
                    <td>
                        <div class="fw-bold {{ $isOut ? 'text-danger' : 'text-warning text-dark' }} fs-5">
                            {{ $product->current_stock }}
                        </div>
                        @if($isOut)
                            <span class="badge bg-danger badge-custom mt-1">Out of Stock</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $product->low_stock_threshold }}</td>
                    <td>
                        <span class="text-danger fw-bold">+{{ $deficit > 0 ? $deficit : 0 }}</span>
                        <small class="text-muted d-block">needed to reach threshold</small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-success mb-3">
                            <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="fw-semibold">All Good!</h4>
                        <p class="text-muted mb-0">There are currently no products low on stock.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($products) && method_exists($products, 'links'))
    <div class="p-3 border-top border-light d-flex justify-content-end">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
