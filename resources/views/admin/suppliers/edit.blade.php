@extends('layouts.admin')

@section('title', 'Edit Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Edit Supplier</h2>
    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i> Back to Suppliers
    </a>
</div>

<form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST" id="supplierForm">
    @csrf
    @method('PUT')

    <div class="row g-4">
        {{-- Left column: supplier info --}}
        <div class="col-lg-7">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-building me-2 text-primary"></i>Supplier Information</h5>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="name" class="form-label fw-semibold">Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-custom @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="contact_person" class="form-label fw-semibold">Contact Person</label>
                        <input type="text" class="form-control form-control-custom @error('contact_person') is-invalid @enderror" id="contact_person" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}">
                        @error('contact_person')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold">Phone Number</label>
                        <input type="text" class="form-control form-control-custom @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $supplier->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="address" class="form-label fw-semibold">Address</label>
                    <textarea class="form-control form-control-custom @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $supplier->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $supplier->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fs-6 mt-1 ms-2" for="is_active">Supplier is Active</label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right column: product management --}}
        <div class="col-lg-5">
            <div class="glass-card p-4 h-100 d-flex flex-column">
                <h5 class="fw-bold mb-3"><i class="bi bi-box-seam me-2 text-primary"></i>Manage Products</h5>
                
                {{-- Add New Product Section --}}
                <div class="mb-4 bg-light p-3 rounded border">
                    <label class="form-label fw-semibold mb-2">Add Product to Supplier</label>
                    <div class="input-group">
                        <select class="form-select" id="newProductSelect">
                            <option value="">-- Select a product to add --</option>
                            @foreach ($allProducts as $p)
                                @if(!in_array($p->id, old('product_ids', $supplierProductIds)))
                                    <option value="{{ $p->id }}" data-name="{{ $p->name }}" data-sku="{{ $p->sku ?? '-' }}" data-cost="{{ $p->cost_price ?? '' }}">
                                        {{ $p->name }} ({{ $p->sku ?? 'No SKU' }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <button class="btn btn-primary" type="button" id="addProductBtn">
                            <i class="bi bi-plus-circle me-1"></i> Add
                        </button>
                    </div>
                </div>

                {{-- Current Products List --}}
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0">Current Products</h6>
                    <span class="badge bg-primary bg-opacity-15 text-primary border border-primary badge-custom" id="selectedCount">0</span>
                </div>
                
                <div class="table-responsive border rounded" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover table-sm mb-0 align-middle" id="currentProductsTable">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Product</th>
                                <th style="width: 120px;">Unit Cost (₱)</th>
                                <th class="text-center" style="width: 60px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="productTableBody">
                            @php
                                $currentIds = old('product_ids', $supplierProductIds);
                                // Gather current products
                                $currentProducts = $allProducts->whereIn('id', $currentIds);
                            @endphp
                            @forelse($currentProducts as $product)
                            <tr class="product-row" data-id="{{ $product->id }}">
                                <td>
                                    <div class="fw-semibold text-truncate">{{ $product->name }}</div>
                                    <div class="small text-muted">{{ $product->sku ?? '-' }}</div>
                                    <input type="hidden" name="product_ids[]" value="{{ $product->id }}">
                                </td>
                                <td>
                                    <input type="number" step="0.01" min="0" class="form-control form-control-sm text-end cost-input" name="product_costs[{{ $product->id }}]" value="{{ old('product_costs.'.$product->id, $product->cost_price) }}" placeholder="Cost">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-product-btn" title="Remove">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="3" class="text-center text-muted py-4">No products currently offered.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
            <i class="bi bi-check-circle me-2"></i> Update Supplier
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
</style>

<template id="productRowTemplate">
    <tr class="product-row" data-id="{id}">
        <td>
            <div class="fw-semibold text-truncate">{name}</div>
            <div class="small text-muted">{sku}</div>
            <input type="hidden" name="product_ids[]" value="{id}">
        </td>
        <td>
            <input type="number" step="0.01" min="0" class="form-control form-control-sm text-end cost-input" name="product_costs[{id}]" value="{cost}" placeholder="Cost">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger remove-product-btn" title="Remove">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>
</template>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('newProductSelect');
        const addBtn = document.getElementById('addProductBtn');
        const tbody = document.getElementById('productTableBody');
        const template = document.getElementById('productRowTemplate').innerHTML;
        const countBadge = document.getElementById('selectedCount');

        function updateCount() {
            const count = tbody.querySelectorAll('.product-row').length;
            countBadge.textContent = count;
            const emptyRow = document.getElementById('emptyRow');
            if (count === 0 && !emptyRow) {
                tbody.innerHTML = '<tr id="emptyRow"><td colspan="3" class="text-center text-muted py-4">No products currently offered.</td></tr>';
            } else if (count > 0 && emptyRow) {
                emptyRow.remove();
            }
        }
        
        updateCount();

        addBtn.addEventListener('click', function() {
            const option = select.options[select.selectedIndex];
            if (!option.value) return;

            const id = option.value;
            const name = option.getAttribute('data-name');
            const sku = option.getAttribute('data-sku');
            const cost = option.getAttribute('data-cost') || '';

            let html = template.replace(/{id}/g, id)
                               .replace(/{name}/g, name)
                               .replace(/{sku}/g, sku)
                               .replace(/{cost}/g, cost);
            
            // Remove empty row if exists
            const emptyRow = document.getElementById('emptyRow');
            if (emptyRow) emptyRow.remove();

            // Insert new row
            tbody.insertAdjacentHTML('beforeend', html);

            // Remove option from select
            option.remove();
            select.value = "";
            
            updateCount();
        });

        tbody.addEventListener('click', function(e) {
            const btn = e.target.closest('.remove-product-btn');
            if (btn) {
                const row = btn.closest('.product-row');
                const id = row.getAttribute('data-id');
                const name = row.querySelector('.fw-semibold').textContent;
                const sku = row.querySelector('.small.text-muted').textContent;

                // Add back to select
                const option = document.createElement('option');
                option.value = id;
                option.setAttribute('data-name', name);
                option.setAttribute('data-sku', sku);
                option.textContent = `${name} (${sku})`;
                select.appendChild(option);

                // Sort options alphabetically by text
                const options = Array.from(select.options);
                options.sort((a, b) => {
                    if (a.value === "") return -1;
                    if (b.value === "") return 1;
                    return a.text.localeCompare(b.text);
                });
                select.innerHTML = '';
                options.forEach(opt => select.appendChild(opt));

                row.remove();
                updateCount();
            }
        });
    });
</script>
@endsection
