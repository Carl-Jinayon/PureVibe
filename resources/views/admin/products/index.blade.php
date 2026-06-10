@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Products</h2>
    
    @if(!(method_exists(auth()->user(), 'isAuditor') ? auth()->user()->isAuditor() : auth()->user()->role === 'auditor'))
    <a href="{{ route('admin.products.create') }}" class="btn btn-gradient rounded-pill px-4 shadow-sm">
        <i class="bi bi-plus-circle me-2"></i> Add Product
    </a>
    @endif
</div>

<div class="glass-card mb-4">
    <div class="p-4 border-bottom border-light bg-light bg-opacity-50">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by name, SKU, barcode..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="category_id" class="form-select form-control-custom">
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="supplier_id" class="form-select form-control-custom">
                    <option value="">All Suppliers</option>
                    @foreach($suppliers ?? [] as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="stock_status" class="form-select form-control-custom">
                    <option value="">All Stock Status</option>
                    <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary" title="Clear Filters"><i class="bi bi-arrow-clockwise"></i></a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th width="8%">Image</th>
                    <th width="20%">Name & SKU</th>
                    <th width="12%">Category</th>
                    <th width="10%">Price</th>
                    <th width="15%">Stock</th>
                    <th width="10%">Status</th>
                    <th width="15%" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products ?? [] as $product)
                <tr>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded shadow-sm" width="50" height="50" style="object-fit: cover;">
                        @else
                            <div class="rounded bg-light d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $product->name }}</div>
                        <div class="small text-muted">{{ $product->sku }}</div>
                    </td>
                    <td>
                        <span class="badge bg-secondary bg-opacity-25 text-dark border badge-custom">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td class="fw-bold">₱{{ number_format($product->price, 2) }}</td>
                    <td>
                        @php
                            $isLow = $product->current_stock <= $product->low_stock_threshold;
                            $isOut = $product->current_stock == 0;
                            $stockClass = $isOut ? 'text-danger' : ($isLow ? 'text-warning' : 'text-success');
                        @endphp
                        <div class="d-flex align-items-center gap-2">
                            <div class="fw-bold {{ $stockClass }}">{{ $product->current_stock }} {{ $product->unit ?? 'pcs' }}</div>
                            @if($isOut)
                                <i class="bi bi-exclamation-circle-fill text-danger" title="Out of Stock"></i>
                            @elseif($isLow)
                                <i class="bi bi-exclamation-triangle-fill text-warning" title="Low Stock"></i>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($product->is_active ?? true)
                            <span class="badge bg-success badge-custom">Active</span>
                        @else
                            <span class="badge bg-danger badge-custom">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            
                            @if(!(method_exists(auth()->user(), 'isAuditor') ? auth()->user()->isAuditor() : auth()->user()->role === 'auditor'))
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete('Are you sure you want to delete this product?');">
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
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-box-seam fs-1 d-block mb-3"></i>
                            <p class="mb-0">No products found matching your criteria.</p>
                        </div>
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
