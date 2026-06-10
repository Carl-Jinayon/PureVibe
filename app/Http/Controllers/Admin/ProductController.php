<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low_stock') {
                $query->lowStock();
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('current_stock', '<=', 0);
            } elseif ($request->stock_status === 'in_stock') {
                $query->inStock();
            }
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::active()->get();
        $suppliers = Supplier::active()->get();

        return view('admin.products.index', compact('products', 'categories', 'suppliers'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $suppliers = Supplier::active()->get();
        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|image|max:2048',
            'sku' => 'nullable|string|max:50|unique:products',
            'barcode' => 'nullable|string|max:50|unique:products',
            'unit_price' => 'required|numeric|min:0',
            'current_stock' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if (empty($validated['sku'])) {
            $validated['sku'] = 'PRD-' . strtoupper(Str::random(8));
        }
        
        if (empty($validated['barcode'])) {
            // Generate a 12-digit barcode if none is provided
            $validated['barcode'] = mt_rand(100000000000, 999999999999);
        }

        \Log::info('Image upload debug', [
            'has_file' => $request->hasFile('image'),
            'file_keys' => array_keys($_FILES),
            'image_error' => isset($_FILES['image']) ? $_FILES['image']['error'] : 'not_set',
            'files_count' => count($_FILES),
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        if ($product->current_stock > 0) {
            InventoryMovement::create([
                'product_id' => $product->id,
                'type' => InventoryMovement::TYPE_IN,
                'quantity' => $product->current_stock,
                'before_stock' => 0,
                'after_stock' => $product->current_stock,
                'notes' => 'Initial stock on product creation',
                'user_id' => auth()->id(),
            ]);
        }

        AuditLog::log('Created product', $product, null, $product->toArray());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'supplier']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $suppliers = Supplier::active()->get();
        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|image|max:2048',
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:50|unique:products,barcode,' . $product->id,
            'unit_price' => 'required|numeric|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if (empty($validated['barcode'])) {
            $validated['barcode'] = mt_rand(100000000000, 999999999999);
        }

        \Log::info('Image upload info update', [
            'has_file' => $request->hasFile('image'), 
            'file' => $request->file('image'),
            'all_files' => $request->allFiles()
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $oldValues = $product->toArray();
        
        $product->update($validated);

        AuditLog::log('Updated product', $product, $oldValues, $product->toArray());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->transactionItems()->count() > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Cannot delete product because it has been used in transactions.');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $oldValues = $product->toArray();
        $product->delete();

        AuditLog::log('Deleted product', $product, $oldValues, null);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
