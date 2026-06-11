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
                    <p class="mb-0 fw-semibold text-wrap text-break">{{ $supplier->address ?? 'No address provided.' }}</p>
                </li>
            </ul>
        </div>
    </div>

    <!-- Right Side (Tabs) -->
    <div class="col-lg-8">
        <div class="glass-card mb-4">
            <ul class="nav nav-tabs nav-tabs-custom border-bottom-0" id="supplierTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold d-flex align-items-center gap-2" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab" aria-selected="true">
                        <i class="bi bi-box-seam"></i> Products
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold d-flex align-items-center gap-2" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-clock-history"></i> Price History
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="supplierTabContent">
            <!-- Products Tab -->
            <div class="tab-pane fade show active" id="products" role="tabpanel">
                <div class="glass-card overflow-hidden">
                    <div class="card-header-gradient d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Assigned Products</h5>
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

    <!-- Price History Tab -->
            <div class="tab-pane fade" id="history" role="tabpanel">
                <div class="glass-card overflow-hidden">
                    <div class="card-header-gradient d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Price History</h5>
                    </div>
                    <div class="p-0">
                        <div class="table-responsive">
                            <table class="table table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th width="20%">Date</th>
                                        <th width="25%">Product</th>
                                        <th width="15%">Cost Price</th>
                                        <th width="10%">Markup</th>
                                        <th width="15%">Selling Price</th>
                                        <th width="15%">Recorded By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($priceHistory as $history)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $history->created_at->format('M d, Y') }}</div>
                                            <div class="small text-muted">{{ $history->created_at->format('h:i A') }}</div>
                                        </td>
                                        <td>
                                            @if($history->product)
                                                <a href="{{ route('admin.products.show', $history->product_id) }}" class="fw-semibold text-dark text-decoration-none">{{ $history->product->name }}</a>
                                                <div class="small text-muted">{{ $history->product->sku }}</div>
                                            @else
                                                <span class="text-muted fst-italic">Product deleted</span>
                                            @endif
                                        </td>
                                        <td class="fw-semibold text-primary">₱{{ number_format($history->cost_price, 2) }}</td>
                                        <td>{{ number_format($history->markup_percentage, 0) }}%</td>
                                        <td class="fw-bold">₱{{ number_format($history->selling_price, 2) }}</td>
                                        <td>
                                            @if($history->recordedBy)
                                                {{ $history->recordedBy->name }}
                                            @else
                                                <span class="text-muted">System</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($history->reason)
                                    <tr class="bg-light">
                                        <td colspan="6" class="py-2 px-4 small text-muted border-top-0">
                                            <i class="bi bi-arrow-return-right me-2"></i>{{ $history->reason }}
                                        </td>
                                    </tr>
                                    @endif
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-clock fs-1 d-block mb-3 text-secondary opacity-50"></i>
                                            <p class="mb-0">No price history recorded yet.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($priceHistory->hasPages())
                            <div class="p-3 border-top">
                                {{ $priceHistory->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Persist tab across page reloads (especially for pagination)
        const tabKey = 'supplier_active_tab_' + {{ $supplier->id }};
        
        // Check if there's a saved tab or if we have a hash in URL
        let activeTab = sessionStorage.getItem(tabKey);
        const hash = window.location.hash;
        
        if (hash && (hash === '#products' || hash === '#history')) {
            activeTab = hash;
        } else if (window.location.search.includes('page=')) {
            // If paginating, it's the history tab since products aren't paginated here
            activeTab = '#history';
        }
        
        if (activeTab) {
            const tabBtn = document.querySelector(`button[data-bs-target="${activeTab}"]`);
            if (tabBtn) {
                const tab = new bootstrap.Tab(tabBtn);
                tab.show();
            }
        }
        
        // Save tab on click
        const tabBtns = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabBtns.forEach(btn => {
            btn.addEventListener('shown.bs.tab', function(e) {
                sessionStorage.setItem(tabKey, e.target.getAttribute('data-bs-target'));
                // Update URL hash without jumping
                history.replaceState(null, null, ' ' + e.target.getAttribute('data-bs-target'));
            });
        });
    });
</script>
@endsection
