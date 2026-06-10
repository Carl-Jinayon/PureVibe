@extends('layouts.admin')

@section('title', 'Quick Stock Control')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Quick Stock Control</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i> Back to Inventory
        </a>
    </div>
</div>

<div class="glass-card mb-4">
    <div class="p-4 border-bottom border-light bg-light bg-opacity-50">
        <form action="{{ route('admin.inventory.adjust-form') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search product or SKU..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
                <a href="{{ route('admin.inventory.adjust-form') }}" class="btn btn-outline-secondary" title="Clear Filters"><i class="bi bi-arrow-clockwise"></i></a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th width="30%">Product & SKU</th>
                    <th width="15%">Category</th>
                    <th width="15%" class="text-center">Current Stock</th>
                    <th width="40%">Quick Adjust</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products ?? [] as $product)
                <tr>
                    <td>
                        <div class="fw-semibold text-dark">{{ $product->name }}</div>
                        <div class="small text-muted">SKU: {{ $product->sku }}</div>
                    </td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td class="text-center">
                        <span class="fs-5 fw-bold {{ $product->current_stock <= $product->low_stock_threshold ? 'text-danger' : 'text-success' }}">
                            {{ $product->current_stock }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.inventory.adjust', $product->id) }}" method="POST" class="d-flex align-items-center gap-2 m-0 p-0">
                            @csrf
                            @method('PUT')
                            <div style="width: 120px;">
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary px-2" type="button" onclick="this.nextElementSibling.stepDown()">-</button>
                                    <input type="number" name="current_stock" class="form-control text-center px-1" value="{{ $product->current_stock }}" min="0" required>
                                    <button class="btn btn-outline-secondary px-2" type="button" onclick="this.previousElementSibling.stepUp()">+</button>
                                </div>
                            </div>
                            <input type="text" name="notes" class="form-control form-control-sm" placeholder="Notes (Optional)" style="max-width: 150px;">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-box-seam fs-1 d-block mb-3"></i>
                            <p class="mb-0">No products found.</p>
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
