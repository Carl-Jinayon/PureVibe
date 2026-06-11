@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Edit Product</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-eye me-2"></i> View Detail
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i> Back to Products
        </a>
    </div>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card p-4 mb-4">
                <h5 class="mb-4 fw-semibold border-bottom pb-2">Basic Information</h5>
                
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control form-control-custom @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="category_id" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select class="form-select form-control-custom @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="supplier_id" class="form-label fw-semibold">Supplier</label>
                        <select class="form-select form-control-custom @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id">
                            <option value="">Select Supplier (Optional)</option>
                            @foreach($suppliers ?? [] as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="glass-card p-4">
                <h5 class="mb-4 fw-semibold border-bottom pb-2">Inventory & Pricing</h5>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="sku" class="form-label fw-semibold">SKU (Stock Keeping Unit)</label>
                        <input type="text" class="form-control form-control-custom @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="barcode" class="form-label fw-semibold">Barcode</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-upc-scan"></i></span>
                            <input type="text" class="form-control form-control-custom @error('barcode') is-invalid @enderror" id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}">
                            <button class="btn btn-outline-secondary" type="button" id="generateBarcode">Generate</button>
                        </div>
                        <small class="text-muted">Leave empty to auto-generate</small>
                        @error('barcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="cost_price" class="form-label fw-semibold">Supplier Cost (&#8369;)</label>
                        <input type="number" step="0.01" min="0"
                               class="form-control form-control-custom @error('cost_price') is-invalid @enderror"
                               id="cost_price" name="cost_price"
                               value="{{ old('cost_price', $product->cost_price) }}"
                               placeholder="0.00" oninput="recalcSellingPrice()">
                        @error('cost_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">What you pay the supplier.</small>
                    </div>
                    <div class="col-md-4">
                        <label for="markup_percentage" class="form-label fw-semibold">Markup % <span class="text-muted fw-normal small">(optional)</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0"
                                   class="form-control form-control-custom @error('markup_percentage') is-invalid @enderror"
                                   id="markup_percentage" name="markup_percentage"
                                   value="{{ old('markup_percentage', $product->markup_percentage) }}"
                                   placeholder="{{ $globalMarkup ?? 0 }}"
                                   oninput="recalcSellingPrice()">
                            <span class="input-group-text">%</span>
                        </div>
                        @error('markup_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Blank = global ({{ $globalMarkup ?? 0 }}%).</small>
                    </div>
                    <div class="col-md-4">
                        <label for="unit_price" class="form-label fw-semibold">Selling Price (&#8369;) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0"
                               class="form-control form-control-custom @error('unit_price') is-invalid @enderror"
                               id="unit_price" name="unit_price"
                               value="{{ old('unit_price', $product->unit_price) }}" required>
                        @error('unit_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted" id="priceHint">Calculated or enter manually.</small>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="unit" class="form-label fw-semibold">Unit Type</label>
                        <select class="form-select form-control-custom @error('unit') is-invalid @enderror" id="unit" name="unit">
                            @foreach(['piece', 'can', 'bottle', 'pack', 'bag', 'box', 'carton', 'tin', 'roll', 'tub'] as $u)
                                <option value="{{ $u }}" {{ old('unit', $product->unit) == $u ? 'selected' : '' }}>{{ ucfirst($u) }}</option>
                            @endforeach
                        </select>
                        @error('unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="low_stock_threshold" class="form-label fw-semibold">Low Stock Threshold</label>
                        <input type="number" min="0" class="form-control form-control-custom @error('low_stock_threshold') is-invalid @enderror" id="low_stock_threshold" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}">
                        @error('low_stock_threshold')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Current Stock: <strong>{{ $product->current_stock }}</strong> (Use Stock Entries to update stock)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card p-4 mb-4">
                <h5 class="mb-4 fw-semibold border-bottom pb-2">Product Image</h5>
                
                <div class="mb-3 text-center">
                    <div class="border rounded bg-light d-flex align-items-center justify-content-center overflow-hidden mx-auto mb-3" style="width: 200px; height: 200px; border-style: dashed !important;" id="imagePreviewContainer">
                        @if($product->image)
                            <img id="imagePreview" src="{{ asset('storage/' . $product->image) }}" alt="Preview" style="display: block; width: 100%; height: 100%; object-fit: cover;">
                            <i class="bi bi-image text-muted fs-1" id="imageIcon" style="display: none;"></i>
                        @else
                            <img id="imagePreview" src="#" alt="Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                            <i class="bi bi-image text-muted fs-1" id="imageIcon"></i>
                        @endif
                    </div>
                    
                    <label for="image" class="btn btn-outline-primary w-100">
                        <i class="bi bi-upload me-2"></i> Change Image
                    </label>
                    <input type="file" class="d-none" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                    @error('image')
                        <div class="text-danger small mt-2 d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted d-block mt-2">Recommended: 800x800px, max 2MB</small>
                </div>
            </div>

            <div class="glass-card p-4 mb-4">
                <h5 class="mb-4 fw-semibold border-bottom pb-2">Visibility</h5>
                
                <div class="mb-3">
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fs-6 mt-1 ms-2" for="is_active">Product is Active</label>
                    </div>
                    <small class="text-muted d-block mt-2">Inactive products won't be visible in the self-checkout terminal.</small>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-gradient btn-lg shadow-sm">
                    <i class="bi bi-check-circle me-2"></i> Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light border shadow-sm">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            // Check file size (max 2MB)
            if (input.files[0].size > 2 * 1024 * 1024) {
                alert('File is too large. Maximum size is 2MB.');
                input.value = '';
                document.getElementById('imagePreview').style.display = 'none';
                document.getElementById('imageIcon').style.display = 'block';
                return;
            }

            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('imagePreview').setAttribute('src', e.target.result);
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('imageIcon').style.display = 'none';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('generateBarcode').addEventListener('click', function() {
        // Generate a 12-digit barcode
        let barcode = '';
        for (let i = 0; i < 12; i++) {
            barcode += Math.floor(Math.random() * 10);
        }
        document.getElementById('barcode').value = barcode;
    });

    // Auto-calculate selling price from cost + markup
    window.recalcSellingPrice = function() {
        const cost   = parseFloat(document.getElementById('cost_price').value) || 0;
        const mkpRaw = document.getElementById('markup_percentage').value;
        const globalMarkup = {{ $globalMarkup ?? 20 }};
        const markup = mkpRaw !== '' ? parseFloat(mkpRaw) : globalMarkup;

        if (cost > 0) {
            const selling = cost * (1 + markup / 100);
            document.getElementById('unit_price').value = selling.toFixed(2);
            document.getElementById('priceHint').textContent =
                '₱' + cost.toFixed(2) + ' × ' + (1 + markup/100).toFixed(4) + ' = ₱' + selling.toFixed(2);
        }
    };
</script>
@endsection
