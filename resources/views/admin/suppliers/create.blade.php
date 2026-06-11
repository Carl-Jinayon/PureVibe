@extends('layouts.admin')

@section('title', 'Add Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Add Supplier</h2>
    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i> Back to Suppliers
    </a>
</div>

<form action="{{ route('admin.suppliers.store') }}" method="POST" id="supplierForm">
    @csrf

    <div class="row g-4">
        {{-- Left column: supplier info --}}
        <div class="col-lg-7">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-building me-2 text-primary"></i>Supplier Information</h5>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="name" class="form-label fw-semibold">Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-custom @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="contact_person" class="form-label fw-semibold">Contact Person</label>
                        <input type="text" class="form-control form-control-custom @error('contact_person') is-invalid @enderror" id="contact_person" name="contact_person" value="{{ old('contact_person') }}">
                        @error('contact_person')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold">Phone Number</label>
                        <input type="text" class="form-control form-control-custom @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="address" class="form-label fw-semibold">Address</label>
                    <textarea class="form-control form-control-custom @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label fs-6 mt-1 ms-2" for="is_active">Supplier is Active</label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right column: product picker --}}
        <div class="col-lg-5">
            <div class="glass-card p-4 h-100 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Products Offered</h5>
                    <span class="badge bg-primary bg-opacity-15 text-primary border border-primary badge-custom" id="selectedCount">0 selected</span>
                </div>
                <p class="text-muted small mb-3">Select the products this supplier provides. You can change this later.</p>

                {{-- Search box --}}
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="productSearch" class="form-control form-control-custom border-start-0 ps-0" placeholder="Search products…">
                    </div>
                </div>

                {{-- Select / Deselect All --}}
                <div class="d-flex gap-2 mb-3">
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" id="selectAllBtn">
                        <i class="bi bi-check2-all me-1"></i> Select All Visible
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="clearAllBtn">
                        <i class="bi bi-x-circle me-1"></i> Clear All
                    </button>
                </div>

                {{-- Product list --}}
                <div id="productListContainer" style="max-height: 380px; overflow-y: auto; border: 1px solid rgba(0,0,0,.1); border-radius: .5rem;">
                    @forelse ($allProducts as $product)
                        <label class="product-item d-flex align-items-center gap-3 px-3 py-2 border-bottom border-light cursor-pointer {{ in_array($product->id, old('product_ids', [])) ? 'selected-item' : '' }}"
                               data-name="{{ strtolower($product->name) }}"
                               data-sku="{{ strtolower($product->sku ?? '') }}"
                               data-cat="{{ strtolower($product->category->name ?? '') }}"
                               for="product_{{ $product->id }}">
                            <input type="checkbox"
                                   class="form-check-input product-checkbox flex-shrink-0 mt-0"
                                   name="product_ids[]"
                                   id="product_{{ $product->id }}"
                                   value="{{ $product->id }}"
                                   {{ in_array($product->id, old('product_ids', [])) ? 'checked' : '' }}>
                            <div class="flex-grow-1 min-w-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold text-truncate">{{ $product->name }}</div>
                                    <div class="small text-muted d-flex gap-2 flex-wrap">
                                        <span><i class="bi bi-upc me-1"></i>{{ $product->sku ?? '-' }}</span>
                                        @if($product->category)
                                            <span><i class="bi bi-tag me-1"></i>{{ $product->category->name }}</span>
                                        @endif
                                        <span><i class="bi bi-currency-exchange me-1"></i>Sell: ₱{{ number_format($product->unit_price, 2) }}</span>
                                    </div>
                                </div>
                                <div class="price-input-wrapper {{ in_array($product->id, old('product_ids', [])) ? '' : 'd-none' }}" style="width: 120px;" onclick="event.preventDefault(); event.stopPropagation();">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-muted">₱</span>
                                        <input type="number" step="0.01" min="0" class="form-control text-end" name="product_costs[{{ $product->id }}]" value="{{ old('product_costs.'.$product->id, $product->cost_price) }}" placeholder="Cost">
                                    </div>
                                </div>
                            </div>
                        </label>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-box-seam fs-2 d-block mb-2"></i>
                            No products found.
                        </div>
                    @endforelse
                </div>

                @error('product_ids')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <hr class="my-4 border-light">

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-light border shadow-sm px-4">Cancel</a>
        <button type="submit" class="btn btn-gradient px-4 shadow-sm">
            <i class="bi bi-check-circle me-2"></i> Save Supplier
        </button>
    </div>
</form>

<style>
    .product-item {
        cursor: pointer;
        transition: background 0.15s;
        user-select: none;
    }
    .product-item:hover {
        background: rgba(var(--bs-primary-rgb), 0.05);
    }
    .product-item.selected-item {
        background: rgba(var(--bs-primary-rgb), 0.08);
    }
    .product-item:last-child {
        border-bottom: none !important;
    }
    .product-item.d-none + .product-item.d-none ~ .no-results-msg { display: block !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const selectedCountBadge = document.getElementById('selectedCount');
    const searchInput = document.getElementById('productSearch');
    const productItems = document.querySelectorAll('.product-item');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const clearAllBtn = document.getElementById('clearAllBtn');

    function updateCount() {
        const count = document.querySelectorAll('.product-checkbox:checked').length;
        selectedCountBadge.textContent = count + ' selected';
    }

    function toggleSelected(label) {
        const cb = label.querySelector('.product-checkbox');
        const priceInput = label.querySelector('.price-input-wrapper');
        if (cb.checked) {
            label.classList.add('selected-item');
            if(priceInput) priceInput.classList.remove('d-none');
        } else {
            label.classList.remove('selected-item');
            if(priceInput) priceInput.classList.add('d-none');
        }
        updateCount();
    }

    // Checkbox change
    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => toggleSelected(cb.closest('.product-item')));
    });

    // Search filter
    searchInput.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        let visibleCount = 0;
        productItems.forEach(item => {
            const matches = !q
                || item.dataset.name.includes(q)
                || item.dataset.sku.includes(q)
                || item.dataset.cat.includes(q);
            item.classList.toggle('d-none', !matches);
            if (matches) visibleCount++;
        });

        // Show/hide no-results message
        let noMsg = document.getElementById('noResultsMsg');
        if (visibleCount === 0) {
            if (!noMsg) {
                noMsg = document.createElement('div');
                noMsg.id = 'noResultsMsg';
                noMsg.className = 'text-center text-muted py-4 small';
                noMsg.innerHTML = '<i class="bi bi-search d-block fs-4 mb-1"></i>No products match your search.';
                document.getElementById('productListContainer').appendChild(noMsg);
            }
            noMsg.style.display = 'block';
        } else if (noMsg) {
            noMsg.style.display = 'none';
        }
    });

    // Select all visible
    selectAllBtn.addEventListener('click', function () {
        productItems.forEach(item => {
            if (!item.classList.contains('d-none')) {
                item.querySelector('.product-checkbox').checked = true;
                item.classList.add('selected-item');
            }
        });
        updateCount();
    });

    // Clear all
    clearAllBtn.addEventListener('click', function () {
        checkboxes.forEach(cb => {
            cb.checked = false;
            cb.closest('.product-item').classList.remove('selected-item');
        });
        updateCount();
    });

    // Init count
    updateCount();
});
</script>
@endsection
