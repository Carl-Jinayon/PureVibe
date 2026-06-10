<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.inventory.index', compact('products'));
    }

    public function movements(Request $request)
    {
        $query = InventoryMovement::with(['product', 'user']);

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $movements = $query->latest()->paginate(15)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('admin.inventory.movements', compact('movements', 'products'));
    }

    public function lowStock(Request $request)
    {
        $query = Product::with(['category', 'supplier'])->lowStock();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('current_stock')->paginate(15)->withQueryString();

        return view('admin.inventory.low-stock', compact('products'));
    }

    public function adjustForm(Request $request)
    {
        $query = Product::with('category')->orderBy('name');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }
        
        $products = $query->paginate(20)->withQueryString();
        
        return view('admin.inventory.adjust', compact('products'));
    }

    public function adjust(Request $request, Product $product)
    {
        $validated = $request->validate([
            'current_stock' => 'required|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        $oldStock = $product->current_stock;
        $newStock = $validated['current_stock'];
        $diff = $newStock - $oldStock;

        if ($diff != 0) {
            $product->update(['current_stock' => $newStock]);

            InventoryMovement::create([
                'product_id' => $product->id,
                'type' => InventoryMovement::TYPE_ADJUSTMENT,
                'quantity' => $diff,
                'before_stock' => $oldStock,
                'after_stock' => $newStock,
                'notes' => $validated['notes'] ?? 'Manual quick adjustment',
                'user_id' => auth()->id(),
            ]);

            \App\Models\AuditLog::log('Adjusted stock via Quick Control', $product, ['current_stock' => $oldStock], ['current_stock' => $newStock]);
        }

        return back()->with('success', "Stock for {$product->name} updated successfully.");
    }
}
