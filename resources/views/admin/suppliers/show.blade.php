@extends('layouts.admin')

@section('title', 'Supplier Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Supplier Details</h2>
    <div class="d-flex gap-2">
        @if(!(method_exists(auth()->user(), 'isAuditor') ? auth()->user()->isAuditor() : auth()->user()->role === 'auditor'))
        <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-pencil me-2"></i> Edit Supplier
        </a>
        @endif
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Supplier Info -->
    <div class="col-lg-4">
        <div class="glass-card p-4 mb-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold fs-3 text-white" style="width: 64px; height: 64px; background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
                    {{ substr($supplier->name, 0, 1) }}
                </div>
                <div>
                    <h4 class="fw-bold mb-1">{{ $supplier->name }}</h4>
                    @if($supplier->is_active ?? true)
                        <span class="badge bg-success badge-custom">Active</span>
                    @else
                        <span class="badge bg-danger badge-custom">Inactive</span>
                    @endif
                </div>
            </div>

            <ul class="list-group list-group-flush bg-transparent">
                <li class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center py-3 border-bottom">
                    <span class="text-muted d-flex align-items-center gap-2"><i class="bi bi-person"></i> Contact Person</span>
                    <span class="fw-semibold">{{ $supplier->contact_person ?? '-' }}</span>
                </li>
                <li class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center py-3 border-bottom">
                    <span class="text-muted d-flex align-items-center gap-2"><i class="bi bi-telephone"></i> Phone</span>
                    <span class="fw-semibold">{{ $supplier->phone ?? '-' }}</span>
                </li>
                <li class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center py-3 border-bottom">
                    <span class="text-muted d-flex align-items-center gap-2"><i class="bi bi-envelope"></i> Email</span>
                    <span class="fw-semibold">{{ $supplier->email ?? '-' }}</span>
                </li>
                <li class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center py-3 border-bottom">
                    <span class="text-muted d-flex align-items-center gap-2"><i class="bi bi-box-seam"></i> Total Products</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary badge-custom fs-6">{{ $supplier->products_count }}</span>
                </li>
                <li class="list-group-item bg-transparent px-0 py-3">
                    <span class="text-muted d-flex align-items-center gap-2 mb-2"><i class="bi bi-geo-alt"></i> Address</span>
                    <p class="mb-0 fw-semibold">{{ $supplier->address ?? 'No address provided.' }}</p>
                </li>
            </ul>
        </div>
    </div>

    <!-- Products from this Supplier -->
    <div class="col-lg-8">
        <div class="glass-card">
            <div class="card-header-gradient d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Products from this Supplier</h5>
                <span class="badge bg-white bg-opacity-25 text-white">{{ $products->count() }} Products</span>
            </div>
            <div class="p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th width="10%">Image</th>
                                <th width="30%">Name & SKU</th>
                                <th width="15%">Category</th>
                                <th width="15%">Price</th>
                                <th width="15%">Stock</th>
                                <th width="15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded shadow-sm" width="45" height="45" style="object-fit: cover;">
                                    @else
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="fw-semibold text-dark text-decoration-none">{{ $product->name }}</a>
                                    <div class="small text-muted">{{ $product->sku }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-25 text-dark badge-custom">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="fw-bold">₱{{ number_format($product->unit_price, 2) }}</td>
                                <td>
                                    @php
                                        $isLow = $product->current_stock <= $product->low_stock_threshold;
                                        $isOut = $product->current_stock == 0;
                                        $stockClass = $isOut ? 'text-danger' : ($isLow ? 'text-warning' : 'text-success');
                                    @endphp
                                    <span class="fw-bold {{ $stockClass }}">{{ $product->current_stock }}</span>
                                </td>
                                <td>
                                    @if($product->is_active ?? true)
                                        <span class="badge bg-success badge-custom">Active</span>
                                    @else
                                        <span class="badge bg-danger badge-custom">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-box-seam fs-1 d-block mb-3"></i>
                                    <p class="mb-0">No products from this supplier yet.</p>
                                </td>
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
