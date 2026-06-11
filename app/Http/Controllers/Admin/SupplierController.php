<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\SupplierProductPrice;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $suppliers = $query->latest()->paginate(15)->withQueryString();

        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        $allProducts = Product::with('category')->orderBy('name')->get();
        return view('admin.suppliers.create', compact('allProducts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $productIds = $request->input('product_ids', []);
        $productCosts = $request->input('product_costs', []);

        $supplier = Supplier::create($validated);

        // Assign selected products to this supplier and update their costs
        if (!empty($productIds)) {
            $globalMarkup = (float) (Setting::where('key', 'default_markup_percentage')->value('value') ?? 20);
            
            foreach ($productIds as $pid) {
                $product = Product::find($pid);
                if ($product) {
                    $newCost = isset($productCosts[$pid]) && $productCosts[$pid] !== '' ? (float) $productCosts[$pid] : null;
                    
                    $product->supplier_id = $supplier->id;
                    
                    if ($newCost !== null && $newCost >= 0) {
                        $oldCost = (float) $product->cost_price;
                        if (abs($newCost - $oldCost) > 0.0001) {
                            $product->cost_price = $newCost;
                            $calculated = $product->calculateSellingPrice($newCost);
                            if ($calculated) {
                                $product->unit_price = $calculated;
                            }
                            
                            $markupUsed = (float) ($product->markup_percentage ?? $globalMarkup);
                            SupplierProductPrice::create([
                                'supplier_id'       => $supplier->id,
                                'product_id'        => $product->id,
                                'cost_price'        => $newCost,
                                'selling_price'     => $product->unit_price,
                                'markup_percentage' => $markupUsed,
                                'reason'            => 'Supplier creation manual cost update',
                                'recorded_by'       => auth()->id(),
                            ]);
                        }
                    }
                    $product->save();
                }
            }
        }

        AuditLog::log('Created supplier', $supplier, null, $supplier->toArray());

        return redirect()->route('admin.suppliers.show', $supplier->id)
            ->with('success', 'Supplier created successfully.');
    }

    public function show(Supplier $supplier)
    {
        $supplier->loadCount('products');
        $products = $supplier->products()->with('category')->latest()->get();
        $priceHistory = $supplier->productPrices()->with(['product', 'recordedBy'])->latest()->paginate(15);
        return view('admin.suppliers.show', compact('supplier', 'products', 'priceHistory'));
    }

    public function edit(Supplier $supplier)
    {
        $allProducts = Product::with('category')->orderBy('name')->get();
        $supplierProductIds = $supplier->products()->pluck('id')->toArray();
        return view('admin.suppliers.edit', compact('supplier', 'allProducts', 'supplierProductIds'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $newProductIds = $request->input('product_ids', []);
        $productCosts = $request->input('product_costs', []);

        $oldValues = $supplier->toArray();
        $supplier->update($validated);

        $oldProductIds = $supplier->products()->pluck('id')->toArray();
        $globalMarkup = (float) (Setting::where('key', 'default_markup_percentage')->value('value') ?? 20);

        // Detach products that were previously assigned but are now unchecked
        $toDetach = array_diff($oldProductIds, $newProductIds);
        if (!empty($toDetach)) {
            Product::whereIn('id', $toDetach)->update(['supplier_id' => null]);
        }

        // Attach new and update costs for all selected products
        foreach ($newProductIds as $pid) {
            $product = Product::find($pid);
            if ($product) {
                $newCost = isset($productCosts[$pid]) && $productCosts[$pid] !== '' ? (float) $productCosts[$pid] : null;
                $isNewlyAttached = !in_array($pid, $oldProductIds);
                
                if ($isNewlyAttached) {
                    $product->supplier_id = $supplier->id;
                }
                
                if ($newCost !== null && $newCost >= 0) {
                    $oldCost = (float) $product->cost_price;
                    if (abs($newCost - $oldCost) > 0.0001) {
                        $product->cost_price = $newCost;
                        $calculated = $product->calculateSellingPrice($newCost);
                        if ($calculated) {
                            $product->unit_price = $calculated;
                        }
                        
                        $markupUsed = (float) ($product->markup_percentage ?? $globalMarkup);
                        SupplierProductPrice::create([
                            'supplier_id'       => $supplier->id,
                            'product_id'        => $product->id,
                            'cost_price'        => $newCost,
                            'selling_price'     => $product->unit_price,
                            'markup_percentage' => $markupUsed,
                            'reason'            => 'Supplier edit manual cost update',
                            'recorded_by'       => auth()->id(),
                        ]);
                    }
                }
                $product->save();
            }
        }

        AuditLog::log('Updated supplier', $supplier, $oldValues, $supplier->toArray());

        return redirect()->route('admin.suppliers.show', $supplier->id)
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->products()->count() > 0) {
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'Cannot delete supplier because they have products associated with them.');
        }

        if ($supplier->stockEntries()->count() > 0) {
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'Cannot delete supplier because they have stock entries associated with them.');
        }

        $oldValues = $supplier->toArray();
        $supplier->delete();

        AuditLog::log('Deleted supplier', $supplier, $oldValues, null);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }
}
