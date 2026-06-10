@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Product Details</h2>
    <div class="d-flex gap-2">
        @if(!(method_exists(auth()->user(), 'isAuditor') ? auth()->user()->isAuditor() : auth()->user()->role === 'auditor'))
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-pencil me-2"></i> Edit Product
        </a>
        @endif
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Product Info -->
    <div class="col-lg-4">
        <div class="glass-card p-4 mb-4 text-center">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm mb-3" style="max-height: 250px; object-fit: cover;">
            @else
                <div class="rounded bg-light d-flex align-items-center justify-content-center shadow-sm mx-auto mb-3" style="width: 200px; height: 200px;">
                    <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                </div>
            @endif
            
            <h4 class="fw-bold">{{ $product->name }}</h4>
            <p class="text-muted mb-2">{{ $product->sku }}</p>
            
            <div class="mb-3">
                @if($product->is_active ?? true)
                    <span class="badge bg-success badge-custom fs-6 px-3 py-2">Active</span>
                @else
                    <span class="badge bg-danger badge-custom fs-6 px-3 py-2">Inactive</span>
                @endif
            </div>

            <h3 class="fw-bold text-primary mb-0">₱{{ number_format($product->price, 2) }}</h3>
            <small class="text-muted">per {{ $product->unit ?? 'piece' }}</small>
        </div>

        <div class="glass-card p-0">
            <div class="card-header-gradient bg-info bg-gradient" style="background: linear-gradient(135deg, #0dcaf0, #0d6efd);">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Details</h5>
            </div>
            <div class="p-4">
                <ul class="list-group list-group-flush bg-transparent">
                    <li class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center">
                        <span class="text-muted">Category</span>
                        <span class="fw-semibold">{{ $product->category->name ?? 'None' }}</span>
                    </li>
                    <li class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center">
                        <span class="text-muted">Supplier</span>
                        <span class="fw-semibold">{{ $product->supplier->name ?? 'None' }}</span>
                    </li>
                    <li class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center">
                        <span class="text-muted">Barcode</span>
                        <span class="fw-semibold">{{ $product->barcode ?? '-' }}</span>
                    </li>
                    <li class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center">
                        <span class="text-muted">Created On</span>
                        <span class="fw-semibold">{{ \Carbon\Carbon::parse($product->created_at)->format('M d, Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Inventory & Movements -->
    <div class="col-lg-8">
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="glass-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-semibold mb-0">Current Stock</h5>
                        <i class="bi bi-box-seam fs-3 text-primary"></i>
                    </div>
                    
                    @php
                        $isLow = $product->current_stock <= $product->low_stock_threshold;
                        $isOut = $product->current_stock == 0;
                        $stockClass = $isOut ? 'text-danger' : ($isLow ? 'text-warning' : 'text-success');
                        $progressColor = $isOut ? 'bg-danger' : ($isLow ? 'bg-warning' : 'bg-success');
                        $percent = $product->low_stock_threshold > 0 ? min(100, ($product->current_stock / ($product->low_stock_threshold * 3)) * 100) : 100;
                    @endphp

                    <h1 class="display-4 fw-bold {{ $stockClass }} mb-0">{{ $product->current_stock }}</h1>
                    <p class="text-muted">units available</p>

                    <div class="progress mt-3 mb-2" style="height: 8px;">
                        <div class="progress-bar {{ $progressColor }}" role="progressbar" style="width: {{ $percent }}%"></div>
                    </div>
                    <small class="text-muted">Low stock threshold: <strong>{{ $product->low_stock_threshold }}</strong></small>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-semibold mb-3">Description</h5>
                    @if($product->description)
                        <p class="text-muted">{{ $product->description }}</p>
                    @else
                        <p class="text-muted font-italic">No description provided.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="glass-card">
            <div class="card-header-gradient d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Stock Movements</h5>
                <a href="{{ route('admin.inventory.movements', ['product_id' => $product->id]) }}" class="btn btn-sm btn-outline-light border-0">View All</a>
            </div>
            <div class="p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Before <span class="text-muted small px-1">→</span> After</th>
                                <th>Reference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product->movements()->latest()->take(5)->get() ?? [] as $movement)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($movement->created_at)->format('M d, Y H:i') }}</td>
                                <td>
                                    @if($movement->type == 'in')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success badge-custom"><i class="bi bi-arrow-down-left me-1"></i> Stock In</span>
                                    @elseif($movement->type == 'out')
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger badge-custom"><i class="bi bi-arrow-up-right me-1"></i> Stock Out</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning badge-custom"><i class="bi bi-arrow-left-right me-1"></i> Adjustment</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold {{ $movement->type == 'in' ? 'text-success' : ($movement->type == 'out' ? 'text-danger' : '') }}">
                                        {{ $movement->type == 'in' ? '+' : ($movement->type == 'out' ? '-' : '') }}{{ $movement->quantity }}
                                    </span>
                                </td>
                                <td><span class="text-muted">{{ $movement->before_stock }}</span> <span class="text-muted small">→</span> <span class="fw-semibold">{{ $movement->after_stock }}</span></td>
                                <td>{{ $movement->reference ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No stock movements recorded yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
