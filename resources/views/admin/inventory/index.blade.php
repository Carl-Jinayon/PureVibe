@extends('layouts.admin')

@section('title', 'Stock Levels')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Stock Levels</h2>
    
    <div class="d-flex gap-2">
        <a href="{{ route('admin.inventory.low-stock') }}" class="btn btn-outline-danger rounded-pill px-4">
            <i class="bi bi-exclamation-triangle me-2"></i> Low Stock Alerts
        </a>
        @if(!(method_exists(auth()->user(), 'isAuditor') ? auth()->user()->isAuditor() : auth()->user()->role === 'auditor'))
        <a href="{{ route('admin.stock-entries.create') }}" class="btn btn-gradient rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Add Stock Entry
        </a>
        @endif
    </div>
</div>

<div class="glass-card mb-4">
    <div class="p-4 border-bottom border-light bg-light bg-opacity-50">
        <form action="{{ route('admin.inventory.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search product or SKU..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select form-control-custom">
                    <option value="">All Categories</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-control-custom">
                    <option value="">All Statuses</option>
                    <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary" title="Clear Filters"><i class="bi bi-arrow-clockwise"></i></a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th width="30%">Product & SKU</th>
                    <th width="15%">Category</th>
                    <th width="15%">Current Stock</th>
                    <th width="15%">Threshold</th>
                    <th width="15%">Status</th>
                    <th width="10%" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products ?? [] as $product)
                @php
                    $isLow = $product->current_stock <= $product->low_stock_threshold;
                    $isOut = $product->current_stock == 0;
                    $stockClass = $isOut ? 'text-danger fw-bold' : ($isLow ? 'text-warning fw-bold' : 'text-success fw-bold');
                @endphp
                <tr>
                    <td>
                        <div class="fw-semibold text-dark">{{ $product->name }}</div>
                        <div class="small text-muted">SKU: {{ $product->sku }}</div>
                    </td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td class="{{ $stockClass }}">
                        {{ $product->current_stock }} {{ $product->unit ?? 'units' }}
                    </td>
                    <td>{{ $product->low_stock_threshold }}</td>
                    <td>
                        @if($isOut)
                            <span class="badge bg-danger badge-custom"><i class="bi bi-x-circle me-1"></i> Out of Stock</span>
                        @elseif($isLow)
                            <span class="badge bg-warning text-dark badge-custom"><i class="bi bi-exclamation-triangle me-1"></i> Low Stock</span>
                        @else
                            <span class="badge bg-success badge-custom"><i class="bi bi-check-circle me-1"></i> In Stock</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.inventory.movements', ['product_id' => $product->id]) }}" class="btn btn-sm btn-outline-info" title="View Movements">
                            <i class="bi bi-clock-history"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-clipboard-data fs-1 d-block mb-3"></i>
                            <p class="mb-0">No inventory records found.</p>
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
