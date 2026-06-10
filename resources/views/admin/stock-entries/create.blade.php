@extends('layouts.admin')

@section('title', 'New Stock Entry')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">New Stock Entry</h2>
    <a href="{{ route('admin.stock-entries.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i> Back to Entries
    </a>
</div>

<form action="{{ route('admin.stock-entries.store') }}" method="POST" id="stockEntryForm">
    @csrf
    
    <div class="row g-4">
        <!-- Entry Details -->
        <div class="col-lg-4">
            <div class="glass-card p-4 h-100">
                <h5 class="mb-4 fw-semibold border-bottom pb-2">Entry Details</h5>
                
                <div class="mb-4">
                    <label for="supplier_id" class="form-label fw-semibold">Supplier</label>
                    <select class="form-select form-control-custom @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id">
                        <option value="">Select Supplier (Optional)</option>
                        @foreach($suppliers ?? [] as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="reference" class="form-label fw-semibold">Reference Number</label>
                    <input type="text" class="form-control form-control-custom @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ old('reference') }}" placeholder="Invoice or PO number">
                    @error('reference')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="notes" class="form-label fw-semibold">Notes</label>
                    <textarea class="form-control form-control-custom @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4" placeholder="Any additional information...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Items -->
        <div class="col-lg-8">
            <div class="glass-card p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
                    <h5 class="mb-0 fw-semibold">Items to Restock</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addItemBtn">
                        <i class="bi bi-plus-circle me-1"></i> Add Item
                    </button>
                </div>
                
                <div class="table-responsive flex-grow-1">
                    <table class="table" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th width="45%">Product <span class="text-danger">*</span></th>
                                <th width="20%">Quantity <span class="text-danger">*</span></th>
                                <th width="25%">Unit Cost</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemsContainer">
                            <!-- Template Row (Hidden) -->
                            <tr class="item-row template d-none">
                                <td>
                                    <select class="form-select product-select" disabled>
                                        <option value="">Select Product...</option>
                                        @foreach($products ?? [] as $product)
                                            <option value="{{ $product->id }}" data-sku="{{ $product->sku }}" data-supplier="{{ $product->supplier_id }}">
                                                {{ $product->name }} ({{ $product->sku }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" min="1" class="form-control qty-input" placeholder="Qty" disabled>
                                </td>
                                <td>
                                    <input type="number" step="0.01" min="0" class="form-control cost-input" placeholder="Cost" disabled>
                                </td>
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- First Row (Visible) -->
                            <tr class="item-row">
                                <td>
                                    <select class="form-select product-select" name="items[0][product_id]" required>
                                        <option value="">Select Product...</option>
                                        @foreach($products ?? [] as $product)
                                            <option value="{{ $product->id }}" data-supplier="{{ $product->supplier_id }}">
                                                {{ $product->name }} ({{ $product->sku }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" min="1" class="form-control qty-input" name="items[0][quantity]" placeholder="Qty" required>
                                </td>
                                <td>
                                    <input type="number" step="0.01" min="0" class="form-control cost-input" name="items[0][unit_cost]" placeholder="Cost (Optional)">
                                </td>
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-item" disabled>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @error('items')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light border shadow-sm px-4" onclick="window.history.back()">Cancel</button>
                    <button type="submit" class="btn btn-gradient px-5 shadow-sm">
                        <i class="bi bi-send me-2"></i> Submit Stock Entry
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let itemCount = 1;
        const container = document.getElementById('itemsContainer');
        const template = document.querySelector('.item-row.template');
        const addItemBtn = document.getElementById('addItemBtn');

        addItemBtn.addEventListener('click', function() {
            const newRow = template.cloneNode(true);
            newRow.classList.remove('template', 'd-none');
            
            // Update names and enable inputs
            const select = newRow.querySelector('.product-select');
            select.name = `items[${itemCount}][product_id]`;
            select.disabled = false;
            select.required = true;

            const qty = newRow.querySelector('.qty-input');
            qty.name = `items[${itemCount}][quantity]`;
            qty.disabled = false;
            qty.required = true;

            const cost = newRow.querySelector('.cost-input');
            cost.name = `items[${itemCount}][unit_cost]`;
            cost.disabled = false;

            // Enable delete button
            const delBtn = newRow.querySelector('.remove-item');
            delBtn.disabled = false;

            container.appendChild(newRow);
            itemCount++;
            
            updateRemoveButtons();
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-item')) {
                const row = e.target.closest('.item-row');
                // Only allow removal if it's not the last visible row
                if (container.querySelectorAll('.item-row:not(.template)').length > 1) {
                    row.remove();
                    updateRemoveButtons();
                }
            }
        });

        function updateRemoveButtons() {
            const visibleRows = container.querySelectorAll('.item-row:not(.template)');
            const disableDelete = visibleRows.length === 1;
            
            visibleRows.forEach(row => {
                const btn = row.querySelector('.remove-item');
                if(btn) btn.disabled = disableDelete;
            });
        }

        // Supplier filtering
        const supplierSelect = document.getElementById('supplier_id');
        function filterProductsBySupplier() {
            const supplierId = supplierSelect.value;
            
            document.querySelectorAll('.product-select').forEach(select => {
                const currentVal = select.value;
                let hasValidCurrentVal = false;
                
                Array.from(select.options).forEach(option => {
                    if (option.value === "") return; // Skip placeholder
                    const optionSupplier = option.getAttribute('data-supplier');
                    
                    if (!supplierId || optionSupplier === supplierId || !optionSupplier) {
                        option.hidden = false;
                        if (option.value === currentVal) hasValidCurrentVal = true;
                    } else {
                        option.hidden = true;
                    }
                });
                
                if (!hasValidCurrentVal && currentVal !== "") {
                    select.value = "";
                }
            });
        }

        supplierSelect.addEventListener('change', filterProductsBySupplier);
        // Initial run
        filterProductsBySupplier();
    });
</script>
@endsection
